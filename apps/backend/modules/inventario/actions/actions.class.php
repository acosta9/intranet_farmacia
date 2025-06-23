<?php

require_once dirname(__FILE__).'/../lib/inventarioGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/inventarioGeneratorHelper.class.php';

/**
 * inventario actions.
 *
 * @package    ired.localhost
 * @subpackage inventario
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inventarioActions extends autoInventarioActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('inventario');
    }

    $this->form = $this->configuration->getForm();
    $this->inventario = $this->form->getObject();
  }

  public function executeEdit(sfWebRequest $request) { 
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2 && $sf_user->getGuardUser()->getId() <> 1) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('inventario');
    }

    $this->inventario = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->inventario);
  }

  public function executeDelete(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('inventario');
    }
    
    $request->checkCSRFProtection();        
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->delete()) {       
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@inventario');
  }

  public function executeIncongruencia(sfWebRequest $request){
  }

  public function executeIndex(sfWebRequest $request){
  }

  public function executeResult(sfWebRequest $request){
  }

  public function executePrint(sfWebRequest $request){
  }

  /*public function executeIncongruenciaKardex(sfWebRequest $request){
  }*/

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
      case 'ProductoName':
        $sort[0] = 'p.nombre';
        break;
      case 'Estatus':
        $sort[0] = 'activo';
        break;
      case 'SerialName':
        $sort[0] = 'p.serial';
        break;
      case 'qty':
        $sort[0] = 'ABS(cantidad)';
        break;
      case 'limite':
        $sort[0] = 'limite_stock';
        break;
      case 'imagen':
        $sort[0] = 'p.url_imagen';
        break;
      case 'LabName':
        $sort[0] = 'pl.nombre';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Inventario")->hasColumn($column) || $column == "company" || $column == "DepositoName" || $column == "ProductoName" || $column == "Estatus" || $column == "qty" || $column == "limite" || $column == "imagen";
  }

  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');
    $did = $request->getParameter('did');
    $codigo=$id.$did;
    $dets = Doctrine_Core::getTable('Inventario')
      ->createQuery('a')
      ->select('id as contador')
      ->Where("id LIKE '$did%'")
      ->orderby('id DESC')
      ->limit(1)
      ->execute();
    $countt = 0;
    foreach ($dets as $det) {
      $countt=$det["contador"];
      break;
    }
    $count=substr($countt, 3)."<br/>";
    $count=$count+1;
    $count = $did.$count;
    
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($count));
  }

  public function executeDeposito(sfWebRequest $request){
  }

  public function executeDepositoFilters(sfWebRequest $request){
  }

  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');

    if($card = Doctrine_Core::getTable('Inventario')->find($request->getParameter('id'))){
      $form = new InventarioForm($card);
    }else{
      $form = new InventarioForm(null);
    }

    $form->addDetalles($number);
    return $this->renderPartial('inventario/detalles',array('form' => $form, 'num' => $number));
  }

  public function executeEstatus(sfWebRequest $request){
    $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $request->getParameter('id'));

    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
      $this->redirect(array('sf_route' => 'inventario_show', 'sf_subject' => $inventario));
    }

    if($inventario->getActivo()) {
      $inventario->activo = 0;
    } else {
      $inventario->activo = 1;
    }
    $inventario->save();

    $this->getUser()->setFlash('notice','El producto en el inventario seleccionado ha sido procesado correctamente');
    $this->redirect(array('sf_route' => 'inventario_show', 'sf_subject' => $inventario));
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
        $partialSearch = $this->getPartial('inventario/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('inventario/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('inventario/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->inventarios=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }
  
  public function executeBatchReporteSecond(sfWebRequest $request) {
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
        $partialSearch = $this->getPartial('inventario/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('inventario/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('inventario/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->inventarios=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }

  public function executeBatchReporteQty(sfWebRequest $request) {
    // filtering
    if ($request->getParameter('filters'))  {
      $this->setFilters($request->getParameter('filters'));
    }

    $this->setMaxPerPage("∞");
    $this->setPage(1);
    $this->pager = $this->getPager();
    $this->inventarios=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }

  public function executeBatchReporteMasVendidos(sfWebRequest $request) {
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
        $partialSearch = $this->getPartial('inventario/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('inventario/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('inventario/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->inventarios=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
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
    $i=0; $sql="(i.id IS NULL || i.deposito_id<>$did)";
    if($search=="**") {
      $sql=$sql." && (p.nombre LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."&& (p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial 
    FROM producto p LEFT JOIN inventario i ON p.id = i.producto_id where $sql
    GROUP BY pid ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"]." [".$result["serial"]."]";
    }
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
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
}
