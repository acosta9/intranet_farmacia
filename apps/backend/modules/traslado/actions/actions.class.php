<?php

require_once dirname(__FILE__).'/../lib/trasladoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/trasladoGeneratorHelper.class.php';

/**
 * traslado actions.
 *
 * @package    ired.localhost
 * @subpackage traslado
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class trasladoActions extends autoTrasladoActions
{
  
  
  public function executeResult(sfWebRequest $request){
  }

  public function executeGetProductos(sfWebRequest $request){
    $search=$request->getParameter('search');
    $did=$request->getParameter('did');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.nombre LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial, i.cantidad as qty
    FROM inventario as i
    LEFT JOIN producto as p ON i.producto_id=p.id
    WHERE $sql && i.deposito_id='$did'    
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"]." [".$result["serial"]."] (".$result["qty"].")";
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executeGetProductos2(sfWebRequest $request){
    $search=$request->getParameter('search');
    $did=$request->getParameter('did');

    $words=explode(" ",$search);
    $i=0; $sql="(i.deposito_id=$did)";
    if($search=="**") {
      $sql=$sql." && (p.nombre LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql." && (p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT i.id as iid, p.id as pid, p.nombre as pname, p.serial as serial, FORMAT(REPLACE(p.costo_usd_1, ' ', ''), 4, 'de_DE') as p01,
    i.cantidad as tope
    FROM producto p LEFT JOIN inventario i ON p.id = i.producto_id where $sql
    GROUP BY pid ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $precio=0;
      if(!empty($result["p01"])) {
        $precio=$result["p01"];
      }
      $arreglo[$result["iid"]]=$result["pname"]." [".$result["serial"]."]|".$precio."|".$result["pid"]."|".$result["tope"];
    }
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executePrefijo(sfWebRequest $request){
    $search=$request->getParameter('search');
    $arr=explode("|",$search);
    $exit="";
    foreach ($arr as $det) {
      if(strlen($det)>1) {
        list($qty, $iid, $pid)=explode(";",$det);
        $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $iid);
        $valor_aux=$inventario->getCantidad();
        $valor=$inventario->getCantidad();
        $valor-=$qty;
        if($valor<0) {
          $exit=$exit.$iid.";".$valor.";".$valor_aux."|";
        }
      }
    }
    
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($exit));
  }

  public function executeGuardar(sfWebRequest $request){

    $eida=$request->getParameter('eida');
    $eidb=$request->getParameter('eidb');
    $dida=$request->getParameter('dida');
    $didb=$request->getParameter('didb');
    $tasa=$request->getParameter('tasa');
    $totusd=$request->getParameter('totusd');
    $origen=explode("|",$request->getParameter('origen'));
    $destino=explode("|",$request->getParameter('destino'));
    $cat=date("Y-m-d H:i:s");
    $cby=$this->getUser()->getGuardUser()->getId();

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $query = $q->execute("SELECT CONCAT('$eida',IFNULL((SELECT INSERT(MAX(id), LOCATE('$eida', MAX(id)), CHAR_LENGTH('$eida'), '')+1 FROM traslado WHERE empresa_desde=$eida),1)) as id");
    $id="";
    foreach ($query as $item) {
      $id=$item["id"];
    }
    if(empty($id)) {
      die();
    }
    $insert="BEGIN; set foreign_key_checks=0; INSERT INTO traslado (id, empresa_desde, deposito_desde, empresa_hasta, deposito_hasta, estatus, tasa_cambio, monto, created_at, updated_at, created_by, updated_by) VALUES ";
    $insert=$insert." ($id, $eida, $dida, $eidb, $didb, 1, '$tasa', '$totusd', '$cat', '$cat', $cby, $cby); ";
    $insert=$insert." INSERT INTO traslado_det (traslado_id, producto_id, inventario_id, qty, prod_destino_id, inv_destino_id, qty_dest, price_unit, price_tot, descripcion) VALUES ";

    foreach ($origen as $key => $data) {
      if(strlen($data)>2) {
        $desc="";
        list($qty_origen,$inv_origen,$prod_origen,$punit,$ptot)=explode(";",$data);
        list($qty_dest,$inv_dest,$prod_dest,$desgl)=explode(";",$destino[$key]);

        $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_origen);
        $desc=$inventario->restarInventario($qty_origen); 

        $reglonesXLote = explode(";", $desc);

        foreach($reglonesXLote as $rkey => $rvalue){

          if (strlen($rvalue) > 2){

            //Recalcular todo

            $descNew = strval($rvalue) . ";";

            list($idItem, $undRestadas, $fechaVencimiento, $loteItem) = explode("|",$rvalue);
            
            $ptot =  floatval($punit) * intval($undRestadas);

            $undRestDest = $undRestadas;

            if($desgl > 0) {$undRestDest = $undRestadas * $desgl;}

            $insert=$insert." ($id, $prod_origen, $inv_origen, $undRestadas, $prod_dest, $inv_dest, $undRestDest, '$punit', '$ptot', '$descNew/$desgl'), ";
          }

        }
      }
    } 

    $insert=substr($insert, 0, -2);

    $insert= $insert . "; INSERT INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, fecha, cantidad, price_unit, price_tot, tipo, concepto) 
              SELECT CONCAT('TRDN-', t.traslado_id, '-', t.id, '-', ROW_NUMBER() OVER (ORDER BY (SELECT 1))) AS id, 
              $eida AS empresa_id, $dida AS deposito_id, t.producto_id AS producto_id, $cby AS user_id, 
              'Traslado' AS tabla, t.traslado_id AS tabla_id, '$cat' AS fecha, t.qty AS cantidad, 
              t.price_unit AS price_unit, t.price_tot AS price_tot, 2 AS tipo, 
              CONCAT('Traslado de Inventario #', t.traslado_id) AS concepto
              FROM traslado_det AS t 
              LEFT JOIN inventario AS i ON t.inv_destino_id = i.id 
              WHERE traslado_id = $id; COMMIT;";

    $error2 = $q->execute($insert);    
    $q->close();
        

    $this->getUser()->setFlash('notice','Traslado guardado exitosamente' . strval($eida) . "/" . strval($dida) . "/" . strval($cby) . "/" . strval($cat) . "/" . strval($id) );
    $this->redirect('traslado/show?id='.$id);
  }

  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'empresaOrigen':
        $sort[0] = 'e.nombre';
        break;
      case 'empresaDestino':
        $sort[0] = 'e2.nombre';
        break;
      case 'depositoOrigen':
        $sort[0] = 'id.nombre';
        break;
      case 'depositoDestino':
        $sort[0] = 'id2.nombre';
        break;
      case 'CreatedAtTxt':
        $sort[0] = 'created_at';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Traslado")->hasColumn($column) || $column == "empresaOrigen" || $column == "empresaDestino" || $column == "depositoOrigen" || $column == "depositoDestino" || $column == "CreatedAtTxt";
  }

  public function executeDepositoFilters(sfWebRequest $request){
  }

  public function executeDeposito1(sfWebRequest $request){
  }

  public function executeDeposito2(sfWebRequest $request){
  }

  public function executeInv(sfWebRequest $request){
  }

  public function executeInv2(sfWebRequest $request){
  }

  public function executeName(sfWebRequest $request){
  }

  public function executePrint(sfWebRequest $request){
  }

  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');

    if($card = Doctrine_Core::getTable('Traslado')->find($request->getParameter('id'))){
      $form = new TrasladoForm($card);
    }else{
      $form = new TrasladoForm(null);
    }

    $form->addDetalles($number);
    return $this->renderPartial('traslado/detalles',array('form' => $form, 'num' => $number, 'did' => $request->getParameter('did')));
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
   $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $traslado = $form->save();

        $dets = Doctrine_Core::getTable('TrasladoDet')
          ->createQuery('a')
          ->Where('traslado_id=?', $traslado->getId())
          ->execute();
        foreach($dets as $det) {
          if(!empty($det->getInvDestinoId())) {
            $items = explode(';', $det->getDescripcion());
            foreach ($items as $item) {
              if(strlen($item)>0) {
                list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
                $inv_id=$det->getInvDestinoId();
                $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
                $inventario->sumarLote($qty, $fvenc, $lote);
              }
            }
            $traslado->estatus=2;
            $traslado->save();
          } else {
            $inv_id=$det->getInventarioId();
            $fact_qty=floatval($det->getQty());
            $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
            $desc=$inventario->restarInventario($fact_qty);
            $det->descripcion=$desc;
            $det->save();
          }
        }
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $traslado)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');

        $this->redirect('@traslado_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeDelete(sfWebRequest $request) {
    $this->getUser()->setFlash('error','No puedes eliminar el traslado');
    $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));
  }

  public function executeAnular(sfWebRequest $request){
    $traslado = Doctrine_Core::getTable('Traslado')->findOneBy('id', $request->getParameter('id'));
    $this->getUser()->setFlash('error','No puedes anular el registro');
    $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));

    $fechaC=strtotime($traslado->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>72) {
      $this->getUser()->setFlash('error','No puede anular un traslado con mas de 72horas de haberlo creado');
      $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));
    }

    if($traslado->getEstatus()==2){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque el traslado ya ha sido procesado');
      $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));
    }

    if($traslado->getEstatus()==3){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque el traslado ya esta anulado');
      $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));
    }

    $dets = Doctrine_Core::getTable('TrasladoDet')
      ->createQuery('a')
      ->Where('traslado_id=?', $traslado->getId())
      ->execute();
    foreach($dets as $det) {
      $inv_id=$det->getInventarioId();
      $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
      $inventario->sumarDevolucion($det->getDescripcion());
    }

    $traslado->estatus = 3;
    $traslado->save();

    $this->getUser()->setFlash('notice','El traslado ha sido anulado correctamente');
    $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));
  }

  public function executeEdit(sfWebRequest $request) {
    $traslado = Doctrine_Core::getTable('Traslado')->findOneBy('id', $request->getParameter('id'));

    $this->getUser()->setFlash('error','No puedes editar el traslado');
    $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));
  }

  public function executeProcesar(sfWebRequest $request) {
    $traslado = Doctrine_Core::getTable('Traslado')->findOneBy('id', $request->getParameter('id'));
    $tid=$traslado->getId();

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    $userid=$this->getUser()->getGuardUser()->getId();
    $eid=$ename["srvid"];
    $results = $q->execute("SELECT e.id as eid, e.nombre as nombre, e.acronimo as acronimo 
      FROM empresa as e
      LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
      WHERE eu.user_id=$userid && e.id IN ($eid)
      ORDER BY e.nombre ASC");
    $cont=0;
    foreach ($results as $result) {
      if($result["eid"]==$traslado->getEmpresaHasta()) {
        $cont=1;
      }
    }

    if($cont==0) {
      $this->getUser()->setFlash('error','No puede procesar el traslado');
      $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));
    }

    if($traslado->getEstatus()==1) {
      $query = $q->execute("SELECT descripcion, qty_dest, inv_destino_id FROM traslado_det WHERE traslado_id=$tid");
      foreach($query as $det) {
        $arr = explode('/', $det["descripcion"]);
        $items = explode(';', $arr[0]);
        $inv_id=$det["inv_destino_id"];
        foreach ($items as $item) {
          if(strlen($item)>0) {
            list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
            $cantSumar=$det["qty_dest"];
            if($arr[1]>0) {
              $desgl=$arr[1];
              $cantSumar=$qty*$desgl;
            }
            $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
            $inventario->sumarLote($cantSumar, $fvenc, $lote);
          }
        }
      }
      $traslado->estatus=2;
      $traslado->save();

      $eidb = $traslado->getEmpresaHasta();
      $didb = $traslado->getDepositoHasta();
      $cat = $traslado->getCreatedAt();

      /*$insertk="INSERT INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, fecha, cantidad, price_unit, price_tot, tipo, concepto, lote, fvenc) 
                SELECT CONCAT('TRHN-', t.traslado_id, '-', t.id, '-', ROW_NUMBER() OVER (ORDER BY (SELECT 1))) AS id, 
                $eidb AS empresa_id, $didb AS deposito_id, t.producto_id AS producto_id, $userid AS user_id, 
                'Traslado' AS tabla, t.traslado_id AS tabla_id, '$cat' AS fecha, t.qty AS cantidad, 
                t.price_unit AS price_unit, t.price_tot AS price_tot, 1 AS tipo, 
                CONCAT('Traslado de Inventario #', t.traslado_id) AS concepto, ide.lote AS lote, ide.fecha_venc AS fvenc 
                FROM traslado_det AS t 
                LEFT JOIN inventario AS i ON t.inv_destino_id = i.id 
                LEFT JOIN inventario_det AS ide ON i.id = ide.inventario_id 
                WHERE traslado_id = ". $traslado->getId();*/

      $insertk = "INSERT INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, fecha, cantidad, price_unit, price_tot, tipo, concepto) 
      SELECT CONCAT('TRHN-', t.traslado_id, '-', t.id, '-', ROW_NUMBER() OVER (ORDER BY (SELECT 1))) AS id, 
      $eidb AS empresa_id, $didb AS deposito_id, t.prod_destino_id AS producto_id, $userid AS user_id, 
      'Traslado' AS tabla, t.traslado_id AS tabla_id, '$cat' AS fecha, t.qty_dest AS cantidad, 
      t.price_unit AS price_unit, t.price_tot AS price_tot, 1 AS tipo, 
      CONCAT('Traslado de Inventario #', t.traslado_id) AS concepto
      FROM traslado_det AS t 
      LEFT JOIN inventario AS i ON t.inv_destino_id = i.id 
      WHERE traslado_id = " . $traslado->getId();          
                
      $error2 = $q->execute($insertk);
      $q->close();

    }
    $this->getUser()->setFlash('notice','Traslado procesado exitosamente');
    $this->redirect(array('sf_route' => 'traslado_show', 'sf_subject' => $traslado));
  }

  public function executeSalida(sfWebRequest $request) {
  }
}
