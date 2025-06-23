<?php

require_once dirname(__FILE__).'/../lib/inv_salidaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/inv_salidaGeneratorHelper.class.php';

/**
 * inv_salida actions.
 *
 * @package    ired.localhost
 * @subpackage inv_salida
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inv_salidaActions extends autoInv_salidaActions
{
  public function executeEdit(sfWebRequest $request) { 
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    $eid=$ename["srvid"];

    $id=$request->getParameter('id');
    $InvSalida=Doctrine_Core::getTable('InvSalida')->findOneBy('id', $id);

    $results = $q->execute("SELECT e.id as eid, e.nombre as nombre, e.acronimo as acronimo 
      FROM empresa as e
      LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
      WHERE e.id IN ($eid)
      ORDER BY e.nombre ASC");
    $i=0;
    foreach ($results as $result) {
      if($result["eid"]==$InvSalida["empresa_id"]) {
        $i++;
      }
    }

    if($i==0) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
      $this->redirect('inv_salida');
    }

    $this->inv_salida = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->inv_salida);
  }

  public function executeShow(sfWebRequest $request) {   
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    $eid=$ename["srvid"];

    $id=$request->getParameter('id');
    $InvSalida=Doctrine_Core::getTable('InvSalida')->findOneBy('id', $id);

    $results = $q->execute("SELECT e.id as eid, e.nombre as nombre, e.acronimo as acronimo 
      FROM empresa as e
      LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
      WHERE e.id IN ($eid)
      ORDER BY e.nombre ASC");
    $i=0;
    foreach ($results as $result) {
      if($result["eid"]==$InvSalida["empresa_id"]) {
        $i++;
      }
    }

    if($i==0) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
      $this->redirect('inv_salida');
    }

	  $this->inv_salida = Doctrine::getTable('InvSalida')->find($request->getParameter('id'));
	  $this->forward404Unless($this->inv_salida);
	  $this->form = $this->configuration->getForm($this->inv_salida);
	}

  public function executeDelete(sfWebRequest $request) {
    $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
    $this->redirect('inv_salida');
  }

  public function executeIndex(sfWebRequest $request) {
    $producto="";
    if(!empty($this->getFilters()["producto"])) {
      $arr=$this->getFilters()["producto"];
      foreach ($arr as $index) {
        $prod=Doctrine_Core::getTable('Producto')->findOneBy('id',$index);
        $producto= $producto.$prod->getId()."|".$prod->getNombre()." [".$prod->getSerial()."];";
      }
    }

    $compuesto="";
    if(!empty($this->getFilters()["compuesto_id"])) {
      $arr=$this->getFilters()["compuesto_id"];
      foreach ($arr as $index) {
        $comp=Doctrine_Core::getTable('Compuesto')->findOneBy('id',$index);
        $compuesto= $compuesto.$comp->getId()."|".$comp->getNombre().";";
      }
    }

    $laboratorio="";
    if(!empty($this->getFilters()["laboratorio_id"])) {
      $arr=$this->getFilters()["laboratorio_id"];
      foreach ($arr as $index) {
        $lab=Doctrine_Core::getTable('ProdLaboratorio')->findOneBy('id',$index);
        $laboratorio= $laboratorio.$lab->getId()."|".$lab->getNombre().";";
      }
    }

    if ($request->hasParameter('search')) {
      $this->setSearch($request->getParameter('search'));
      $request->setParameter('page', 1);
    }
  
    if ($request->getParameter('filters')) {
      $this->setFilters($request->getParameter('filters'));
    }
    
    if ($request->getParameter('sort')) {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    if ($request->getParameter('maxPerPage')) {
      $this->setMaxPerPage($request->getParameter('maxPerPage'));
      $this->setPage(1);
    }
	
    if ($request->getParameter('page')) {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
    $this->prods = $producto;
    $this->comps = $compuesto;
    $this->labs = $laboratorio;

    if ($request->isXmlHttpRequest()) {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));
      
      if ($request->hasParameter('search')) {
        $partialSearch = $this->getPartial('inv_salida/search', array('configuration' => $this->configuration));
      }
      
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('inv_salida/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      
      $partialList = $this->getPartial('inv_salida/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
  }

  public function executeGetCompuestos(sfWebRequest $request){
    $search=$request->getParameter('search');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.nombre LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.nombre LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.nombre LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname
    FROM compuesto p where $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"];
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executeGetLaboratorios(sfWebRequest $request){
    $search=$request->getParameter('search');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.nombre LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.nombre LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.nombre LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname
    FROM prod_laboratorio p where $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"];
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }
  
  public function executeGetProductos(sfWebRequest $request){
    $search=$request->getParameter('search');

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
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial 
    FROM producto p where $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"]." [".$result["serial"]."]";
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
    $results = $q->execute("SELECT i.id as iid, p.id as pid, p.nombre as pname, p.serial as serial, FORMAT(REPLACE(p.precio_usd_1, ' ', ''), 4) as p01 
    FROM producto p LEFT JOIN inventario i ON p.id = i.producto_id where $sql
    GROUP BY pid ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $precio=0;
      if(!empty($result["p01"])) {
        $precio=$result["p01"];
      }
      $arreglo[$result["iid"]]=$result["pname"]." [".$result["serial"]."]|".$precio;
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
        list($iid, $qty)=explode(";",$det);
        $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $iid);
        $valor=$inventario->getCantidad();
        $valor-=$qty;
        if($valor<0) {
          $exit=$exit.$iid.";".$valor."|";
        }
      }
    }
    
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($exit));
  }
  
  public function executeQty(sfWebRequest $request){
  }

  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'company':
        $sort[0] = 'e.acronimo';
        break;
      case 'DepositoName':
        $sort[0] = 'id.nombre';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("InvSalida")->hasColumn($column) || $column == "company" || $column == "DepositoName";
  }
  
  public function executeDeposito(sfWebRequest $request){
  }

  public function executeDepositoFilters(sfWebRequest $request){
  }

  public function executeInv(sfWebRequest $request){
  }
  
  public function executeDetalles(sfWebRequest $request) {
  }
  
  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');
  
    if($card = Doctrine_Core::getTable('InvSalida')->find($request->getParameter('id'))){
      $form = new InvSalidaForm($card);
    }else{
      $form = new InvSalidaForm(null);
    }
    $form->addDetalles($number);
    return $this->renderPartial('inv_salida/detalles',array('form' => $form, 'num' => $number));
  }

  public function executeAnular(sfWebRequest $request){
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    $eid=$ename["srvid"];

    $id=$request->getParameter('id');
    $InvSalida=Doctrine_Core::getTable('InvSalida')->findOneBy('id', $id);

    $results = $q->execute("SELECT e.id as eid, e.nombre as nombre, e.acronimo as acronimo 
      FROM empresa as e
      LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
      WHERE e.id IN ($eid)
      ORDER BY e.nombre ASC");
    $i=0;
    foreach ($results as $result) {
      if($result["eid"]==$InvSalida["empresa_id"]) {
        $i++;
      }
    }

    if($i==0) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
      $this->redirect('inv_salida');
    }
    
    $inv_salida = Doctrine_Core::getTable('InvSalida')->findOneBy('id',$request->getParameter('id'));
    if($inv_salida->getAnulado()) {
      $this->getUser()->setFlash('error','Documento, ya se encuentra anulado');
      $this->redirect(array('sf_route' => 'inv_salida_show', 'sf_subject' => $inv_salida));
    }

    $fechaC=strtotime($inv_salida->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>72) {
      $this->getUser()->setFlash('error','No puede anular este documento con mas de 72horas de haberla creado');
      $this->redirect(array('sf_route' => 'inv_salida_show', 'sf_subject' => $inv_salida));
    }

    $dets = Doctrine_Core::getTable('InvSalidaDet')
      ->createQuery('a')
      ->Where('inv_salida_id=?', $inv_salida->getId())
      ->execute();
    foreach($dets as $det) {
      $inv_id=$det->getInventarioId();
      $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
      $inventario->sumarDevolucion($det->getDevolucion());
    }

    $inv_salida->anulado=1;
    $inv_salida->save();

    $this->getUser()->setFlash('notice','Documento anulado correctamente');
    $this->redirect(array('sf_route' => 'inv_salida_show', 'sf_subject' => $inv_salida));
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
     if ($form->isValid())
     {
       $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
 
       try {
         $inv_salida = $form->save(); 
         $dets = Doctrine_Core::getTable('InvSalidaDet')
           ->createQuery('a')
           ->Where('inv_salida_id=?', $inv_salida->getId())
           ->execute();
         foreach($dets as $det) {
          $inv_id=$det->getInventarioId();
          $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
          $desc=$inventario->restarInventario($det->getQty());
          $det->devolucion=$desc;
          $det->save();
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
 
       $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $inv_salida)));
 
       if ($request->hasParameter('_save_and_add'))
       {
         $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
 
         $this->redirect('@inv_salida_new');
       }
       else
       {
         $this->getUser()->setFlash('notice', $notice);
 
         $this->redirect(array('sf_route' => 'inv_salida_show', 'sf_subject' => $inv_salida));
       }
     }
     else
     {
       $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
     }
  }

  public function executeBatchReporteFirst(sfWebRequest $request) {
    if ($request->hasParameter('search')) {
      $this->setSearch($request->getParameter('search'));
      $request->setParameter('page', 1);
    }

    // filtering
    if ($request->getParameter('filters'))  {
      $this->setFilters($request->getParameter('filters'));
    }

    // sorting
    if ($request->getParameter('sort')) {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    $this->setMaxPerPage("∞");
    $this->setPage(1);
    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    if ($request->isXmlHttpRequest()) {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));

      if ($request->hasParameter('search')){
        $partialSearch = $this->getPartial('inv_salida/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('inv_salida/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('inv_salida/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->inv_salidas=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }
}
