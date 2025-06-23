<?php

require_once dirname(__FILE__).'/../lib/productoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/productoGeneratorHelper.class.php';

/**
 * producto actions.
 *
 * @package    ired.localhost
 * @subpackage producto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoActions extends autoProductoActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('producto');
    }

    $this->form = $this->configuration->getForm();
    $this->producto = $this->form->getObject();
  }

  public function executeEdit(sfWebRequest $request) { 
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('producto');
    }

    $this->producto = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->producto);
  }

  public function executeDelete(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('producto');
    }
    
    $request->checkCSRFProtection();        
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->delete()) {       
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@producto');
  }

  public function executeIndex(sfWebRequest $request) {
  }

  public function executeResult(sfWebRequest $request) {
  }

  public function executePrint(sfWebRequest $request) {

  }

  public function executeRedirectServicio(sfWebRequest $request) {
    $this->getUser()->setFlash('notice', $notice.' Se ha eliminado la imagen correctamente');
    $this->redirect('producto/edit?id='.$request->getParameter('id'));
  }

  public function executeDelServicio(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());

    $id=$request->getParameter('id');
    $num=$request->getParameter('num');

    $dets = Doctrine_Core::getTable('ProductoImg')
      ->createQuery('a')
      ->Where('producto_id=?', $id)
      ->execute();
    foreach($dets as $det) {
      if($det->getId()==$num) {
        unlink(sfConfig::get('sf_upload_dir').'/producto_img/'.$det->getUrlImagen());
        $det->delete();
      }
    }    
    return $this->renderText("success");
  }

  public function executeTasa(sfWebRequest $request){
    $id = $request->getParameter('id');
    $pcid = $request->getParameter('cat');

    $categoria = Doctrine_Core::getTable('ProdCategoria')->findOneBy('id', $pcid);
    $tasa="T02";
    if(substr($categoria->getCodigoFull(), 0, 2)=="01") {
      $tasa="T01";
    }
    $det = Doctrine_Query::create()
      ->select('FORMAT(REPLACE(valor, " ", ""), 4, "de_DE") as formatNumber')
      ->from('Otros o')
      ->Where("empresa_id =? ", $id)
      ->AndWhere('nombre = ?',$tasa)
      ->orderBy('id DESC')
      ->fetchOne();
    if(!empty($det)) {
      $numeroTasa=$det["formatNumber"];
    } else {
      $numeroTasa = 0;
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($numeroTasa));
  }

  public function executeTasa2(sfWebRequest $request){
    $id = $request->getParameter('id');
    $tasa = $request->getParameter('cat');

    $det = Doctrine_Query::create()
      ->select('FORMAT(REPLACE(valor, " ", ""), 4, "de_DE") as formatNumber')
      ->from('Otros o')
      ->Where("empresa_id =? ", $id)
      ->AndWhere('nombre = ?',$tasa)
      ->orderBy('id DESC')
      ->fetchOne();
    if(!empty($det)) {
      $numeroTasa=$det["formatNumber"];
    } else {
      $numeroTasa = 0;
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($numeroTasa));
  }

  public function executeGetSerial(sfWebRequest $request){
    $id = $request->getParameter('id');

    $cont=0;
    $producto = Doctrine_Core::getTable('Producto')->findOneBy('serial', $id);
    if(!empty($producto)) {
      $cont=1;
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($cont));
  }

  /*public function executeTasa(sfWebRequest $request){
    $id = $request->getParameter('id');
    $pcid = $request->getParameter('cat');

    $categoria = Doctrine_Core::getTable('ProdCategoria')->findOneBy('id', $pcid);
    $tasa="T02";
    if(substr($categoria->getCodigoFull(), 0, 2)=="01") {
      $tasa="T01";
    }
    $dets = Doctrine_Core::getTable('Otros')
      ->createQuery('a')
      ->select('valor')
      ->Where("empresa_id =? ", $id)
      ->AndWhere('nombre = ?',$tasa)
      ->orderBy('id DESC')
      ->limit(1)
      ->execute();
    $tasa = 0;
    foreach ($dets as $det) {
      $tasa=$det["valor"];
      break;
    }
    $this->tasa=$tasa;
  }*/

  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');

    $dets = Doctrine_Core::getTable('Producto')
      ->createQuery('a')
      ->select('COUNT(id) as contador')
      ->Where("codigo LIKE '$id%'")
      ->execute();
    $count = 0;
    foreach ($dets as $det) {
      $count=$det["contador"];
      break;
    }
    $count = str_pad($count+1, 8, '0', STR_PAD_LEFT);
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($count));
  }

  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'ProdUnidad':
        $sort[0] = 'pu.nombre';
        break;
      case 'ProdTipo':
        $sort[0] = 'tipo';
        break;
      case 'ProdLab':
        $sort[0] = 'plname';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Contrato")->hasColumn($column) || $column == "ProdUnidad" || $column == "ProdTipo";
  }

  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');

    if($card = Doctrine_Core::getTable('Producto')->find($request->getParameter('id'))){
      $form = new ProductoForm($card);
    }else{
      $form = new ProductoForm(null);
    }

    $form->addDetalles($number);
    return $this->renderPartial('producto/detalles',array('form' => $form, 'num' => $number));
  }

  public function executeBatchReporteProductos(sfWebRequest $request) {
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
        $partialSearch = $this->getPartial('productos/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('productos/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('productos/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->productos=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }

  public function executeBatchReporteProdFarma(sfWebRequest $request) {
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
        $partialSearch = $this->getPartial('productos/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('productos/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('productos/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->productos=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
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

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $producto = $form->save();
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
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $producto)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@producto_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'producto_show', 'sf_subject' => $producto));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }
}
