<?php

require_once dirname(__FILE__).'/../lib/proveedorGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/proveedorGeneratorHelper.class.php';

/**
 * proveedor actions.
 *
 * @package    ired.localhost
 * @subpackage proveedor
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class proveedorActions extends autoProveedorActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('proveedor');
    }

    $this->form = $this->configuration->getForm();
    $this->proveedor = $this->form->getObject();
  }

  public function executeEdit(sfWebRequest $request) { 
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('proveedor');
    }

    $this->proveedor = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->proveedor);
  }

  public function executeDelete(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('proveedor');
    }

    $request->checkCSRFProtection();
    $id=$request->getParameter('id');
    $cotizacion_compra=Doctrine_Core::getTable('CotizacionCompra')->findOneBy('proveedor_id', $id);
    if(!empty($cotizacion_compra)) {
      $proveedor=Doctrine_Core::getTable('Proveedor')->findOneBy('id', $id);
      $this->getUser()->setFlash('error','No puedes eliminar el registro, porque tiene asociado varias cotizaciones de compra');
      $this->redirect(array('sf_route' => 'proveedor_show', 'sf_subject' => $proveedor));
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
    if ($this->getRoute()->getObject()->delete()) {       
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@proveedor');
  }

  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'tipoTxt':
        $sort[0] = 'tipo';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }
    
  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Proveedor")->hasColumn($column) || $column == "tipoTxt";
  }
          
  public function executeBatchReporteProveedores(sfWebRequest $request) {
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
        $partialSearch = $this->getPartial('proveedor/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('proveedor/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('proveedor/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->proveedors=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }

}
