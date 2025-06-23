<?php

require_once dirname(__FILE__).'/../lib/ofertaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/ofertaGeneratorHelper.class.php';

/**
 * oferta actions.
 *
 * @package    ired.localhost
 * @subpackage oferta
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ofertaActions extends autoOfertaActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('oferta');
    }

    $this->form = $this->configuration->getForm();
    $this->oferta = $this->form->getObject();
  }

  public function executeEdit(sfWebRequest $request) {
		$this->redirect('oferta');
	}
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'EmpresaName':
        $sort[0] = 'e.acronimo';
        break;
      case 'DepositoName':
        $sort[0] = 'id.nombre';
        break;
      case 'Estatus':
        $sort[0] = 'activo';
        break;
      case 'precio':
        $sort[0] = 'precio_usd';
        break;
      case 'tipo':
        $sort[0] = 'tipo_oferta';
        break;
      case 'TipoTasa':
        $sort[0] = 'tasa';
        break;
        
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Oferta")->hasColumn($column) || $column == "EmpresaName" || $column == "DepositoName" || $column == "Estatus" || $column == "precio" || $column == "TipoTasa";
  }

  public function executeDepositoFilters(sfWebRequest $request){
  }

  public function executeContador(sfWebRequest $request){
    $did = $request->getParameter('did');
    $dets = Doctrine_Core::getTable('Oferta')
      ->createQuery('a')
      ->select('COUNT(id) as contador')
      ->Where("id LIKE '$did%'")
      ->limit(1)
      ->execute();
    $count = 0;
    foreach ($dets as $det) {
      $count=$det["contador"];
      break;
    }
    $count = $did.$count+1;
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($count));
  }

  public function executeDeposito(sfWebRequest $request){
  }

  public function executeTasa(sfWebRequest $request){
    $tasa="0";
    $empresa_id=$request->getParameter('id');
    $tipo_tasa=$request->getParameter('t');
    $results = Doctrine_Query::create()
      ->select('FORMAT(REPLACE(valor, " ", ""), 4, "de_DE") as formatNumber')
      ->from('Otros o')
      ->where('o.empresa_id = ?', $empresa_id)
      ->andWhere('o.nombre = ?', $tipo_tasa)
      ->orderBy('o.id DESC')
      ->limit(1)
      ->execute();
    foreach ($results as $result) {
      $tasa=$result["formatNumber"];
    }
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($tasa));
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
    $results = $q->execute("SELECT i.id as iid, p.id as pid, p.nombre as pname, p.serial as serial, i.cantidad as qty
    FROM producto p LEFT JOIN inventario i ON p.id = i.producto_id where $sql && (i.deposito_id = $did && i.activo = 1 && i.cantidad > 0)
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["iid"]]=$result["pname"]." [".$result["serial"]."] (".$result["qty"].")";
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }
/*

  public function executeGetProductos(sfWebRequest $request){
    $deposito=$request->getParameter('did');
    $search=$request->getParameter('search');

    $words=explode(" ",$search);
    $i=0; $sql="";
    foreach ($words as $word) {
      if($i==0){
        $sql="(p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
      } else {
        $sql=$sql." && (p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
      }
      $i++;
    }

    $results = Doctrine_Query::create()
      ->select('i.id as iid, i.cantidad as qty, p.id as pid, p.nombre as name, p.serial as serial, p.codigo as codi')
      ->from('Inventario i')
      ->leftJoin('i.Producto p')
      ->Where($sql)
      ->andWhere('i.deposito_id =?', $deposito)
      ->andWhere('i.activo =?', 1)
      ->andWhere('i.cantidad >0')
      ->orderBy('p.nombre ASC')
      ->limit(10)
      ->execute();
    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["iid"]]=$result["name"]." [".$result["serial"]."] (".$result["qty"].")";
    }
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }
*/
  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');

    if($card = Doctrine_Core::getTable('Oferta')->find($request->getParameter('id'))){
      $form = new OfertaForm($card);
    }else{
      $form = new OfertaForm(null);
    }

    $form->addDetalles($number);
    return $this->renderPartial('oferta/detalles',array('form' => $form, 'num' => $number, 'did' => $request->getParameter('did')));
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $oferta = $form->save();
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
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $oferta)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@oferta_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'oferta_show', 'sf_subject' => $oferta));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeAnular(sfWebRequest $request){
    $oferta = Doctrine_Core::getTable('Oferta')->findOneBy('id',$request->getParameter('id'));
    if($oferta->getActivo()==0) {
      $this->getUser()->setFlash('error','Oferta, ya se encuentra des-habilitada');
      $this->redirect(array('sf_route' => 'oferta_show', 'sf_subject' => $oferta));
    }
    $oferta->activo=0;
    $oferta->save();
    $this->getUser()->setFlash('notice','Oferta, des-habilitada correctamente');
    $this->redirect(array('sf_route' => 'oferta_show', 'sf_subject' => $oferta));
  }
  public function executeModificarf(sfWebRequest $request) {
    $oferta = Doctrine_Core::getTable('Oferta')->findOneBy('id',$request->getParameter('id'));
    $oferta->fecha_venc=$request->getParameter('fecha_venc');
    $oferta->save();

    $this->getUser()->setFlash('notice','Oferta, mofificada correctamente');
    $this->redirect(array('sf_route' => 'oferta_show', 'sf_subject' => $oferta));
  }
}
