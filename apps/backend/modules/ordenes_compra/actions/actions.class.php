<?php

require_once dirname(__FILE__).'/../lib/ordenes_compraGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/ordenes_compraGeneratorHelper.class.php';

/**
 * ordenes_compra actions.
 *
 * @package    ired.localhost
 * @subpackage ordenes_compra
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ordenes_compraActions extends autoOrdenes_compraActions
{
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'ncontrol':
        $sort[0] = 'ninteger';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Factura")->hasColumn($column) || $column == "ncontrol";
  }

  public function executeIndex(sfWebRequest $request) {
    $producto="";
    if(!empty($this->getFilters()["proveedor"])) {
      $arr=$this->getFilters()["proveedor"];
      $prov=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$arr);
      $producto= $prov->getId()."|".$prov->getFullName()." [".$prov->getDocId()."];";
    }

    $compuesto="";
    if(!empty($this->getFilters()["cotizacion_id"])) {
      $arr=$this->getFilters()["cotizacion_id"];
      foreach ($arr as $index) {
        $cc=Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id',$index);
        $compuesto= $compuesto.$cc->getId()."|".$cc->getNcontrol().";";
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

    if ($request->isXmlHttpRequest()) {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));
      
      if ($request->hasParameter('search')) {
        $partialSearch = $this->getPartial('ordenes_compra/search', array('configuration' => $this->configuration));
      }
      
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('ordenes_compra/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      
      $partialList = $this->getPartial('ordenes_compra/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
  }

  public function executePrefijo(sfWebRequest $request){
    $cid=$request->getParameter('search');

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT count(oc.id) as contador
    FROM ordenes_compra oc WHERE oc.cotizacion_compra_id = $cid AND oc.estatus<>5");

    $arreglo="";
    foreach ($results as $result) {
      $arreglo=$result["contador"];
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executeGetProveedor(sfWebRequest $request){
    $search=$request->getParameter('search');
    $eid=$request->getParameter('eid');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.full_name LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.full_name LIKE '%".$word."%' || p.doc_id LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.full_name LIKE '%".$word."%' || p.doc_id LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.full_name as pname, p.doc_id as docid 
    FROM proveedor p WHERE $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"]." [".$result["docid"]."]";
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executeGetCotizacion(sfWebRequest $request){
    $search=$request->getParameter('search');
    $eid=$request->getParameter('eid');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.ncontrol LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.ncontrol LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.ncontrol LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.ncontrol as pname, p.doc_id as docid 
    FROM cotizacion_compra p WHERE $sql AND p.empresa_id IN ($eid)
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"];
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }
  
  public function executeGetProductos2(sfWebRequest $request){
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
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial, FORMAT(REPLACE(p.costo_usd_1, ' ', ''), 4, 'de_DE') as p01 
    FROM producto p where $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $precio="0.0000";
      if($result["p01"]!="0,0000") {
        $precio=$result["p01"];
      }
      $arreglo[$result["pid"]]=$result["pname"]." [".$result["serial"]."]|".$precio;
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
      $this->redirect('ordenes_compra');
    }

    if(empty($request->getParameter('id'))) {
      $this->getUser()->setFlash('error','Debe de crear primero una cotizacion');
      $this->redirect(array('sf_route' => 'cotizacion_compra'));
    }

    $id=$request->getParameter('id');
    $cotizacion_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $id);

    if($cotizacion_compra->getEstatus()==2 || $cotizacion_compra->getEstatus()==3 || $cotizacion_compra->getEstatus()==4){
      $this->getUser()->setFlash('error','La cotizacion ya tiene asociada una orden de compra');
      $this->redirect(array('sf_route' => 'cotizacion_compra_show', 'sf_subject' => $cotizacion_compra));
    }

    if($cotizacion_compra->getEstatus()==5){
      $this->getUser()->setFlash('error','No puedes generar una orden de compra, porque la cotizacion ya esta anulada');
      $this->redirect(array('sf_route' => 'cotizacion_compra_show', 'sf_subject' => $cotizacion_compra));
    }

    $this->form = $this->configuration->getForm();
    $this->ordenes_compra = $this->form->getObject();
  }
  
  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');
    $ccdid = "";
    if(!empty($request->getParameter('ccdid'))) {
      $ccdid = $request->getParameter('ccdid');
    }

    if($card = Doctrine_Core::getTable('OrdenesCompra')->find($request->getParameter('id'))){
      $form = new OrdenesCompraForm($card);
    }else{
      $form = new OrdenesCompraForm(null);
    }

    $form->addDetalles($number);
    return $this->renderPartial('ordenes_compra/detalles',array('form' => $form, 'num' => $number, 'ccdid' => $ccdid));
  }

  public function executeDelete(sfWebRequest $request) {
    $ordenes_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $request->getParameter('id'));
    
    $this->getUser()->setFlash('error','No puedes eliminar la orden de compra');
    $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
  }

  public function executeEdit(sfWebRequest $request) {
    $ordenes_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $request->getParameter('id'));
    
    $this->getUser()->setFlash('error','No puedes editar la orden de compra');
    $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $ordenes_compra = $form->save();
        $eid=$ordenes_compra->getEmpresaId();
        $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$eid);
        $ncontrol=$empresa->getOrdencompra()+1;
        $empresa->ordencompra=$ncontrol;
        $empresa->save();
        $ordenes_compra->ncontrol=$ncontrol;
        $ordenes_compra->estatus=2;
        $ordenes_compra->save();

        $cc=Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id',$ordenes_compra->getCotizacionCompraId());
        $cc->estatus=2;
        $cc->save();

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

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $ordenes_compra)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@ordenes_compra_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeAnular(sfWebRequest $request){
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
      $this->redirect('ordenes_compra');
    }

    $ordenes_compra = Doctrine_Core::getTable('OrdenesCompra')->findOneBy('id', $request->getParameter('id'));

    if($ordenes_compra->getEstatus()==3 || $ordenes_compra->getEstatus()==4){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la orden tiene asociada una factura de compra');
      $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
    }

    if($ordenes_compra->getEstatus()==5){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la orden ya esta anulada');
      $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
    }

    /*$fechaC=strtotime($cotizacion_compra->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>48) {
      $this->getUser()->setFlash('error','No puede anular este documento con mas de 48horas de haberla creado');
      $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
    }*/

    $cotizacion_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $ordenes_compra->getCotizacionCompraId());
    $cotizacion_compra->estatus=1;
    $cotizacion_compra->save();

    $ordenes_compra->estatus=5;
    $ordenes_compra->save();

    $this->getUser()->setFlash('notice','La orden de compra ha sido anulada correctamente');
    $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
  }

  public function executeCerrar(sfWebRequest $request){
    $ordenes_compra = Doctrine_Core::getTable('OrdenesCompra')->findOneBy('id', $request->getParameter('id'));

    if($ordenes_compra->getEstatus()==3){
      $cotizacion_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $ordenes_compra->getCotizacionCompraId());
      $cotizacion_compra->estatus=4;
      $cotizacion_compra->save();

      $ordenes_compra->estatus=4;
      $ordenes_compra->save();
    } else {
      $this->getUser()->setFlash('error','No puedes cerrar la OC');
      $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
    }


    $this->getUser()->setFlash('notice','La orden de compra ha sido cerrada correctamente');
    $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
  }
}
