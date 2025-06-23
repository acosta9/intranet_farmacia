<?php

require_once dirname(__FILE__).'/../lib/cuentas_pagarGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/cuentas_pagarGeneratorHelper.class.php';

/**
 * cuentas_pagar actions.
 *
 * @package    ired.localhost
 * @subpackage cuentas_pagar
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuentas_pagarActions extends autoCuentas_pagarActions
{
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'empresaName':
        $sort[0] = 'e.acronimo';
        break;
      case 'proveedorName':
        $sort[0] = 'p.full_name';
        break;
      case 'forPagoCoin':
        $sort[0] = 'fp.acronimo';
        break;
      case 'doc':
        $sort[0] = 'f.num_factura';
        break;
      case 'CreatedAtTxt':
        $sort[0] = 'created_at';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Retenciones")->hasColumn($column) || $column == "EmpresaName" || $column == "proveedorName" || $column == "doc"  || $column == "forPagoCoin" || $column == "CreatedAtTxt";
  }
  public function executeNew(sfWebRequest $request) {
    if(empty($request->getParameter('id'))) {
      $this->getUser()->setFlash('error','Las cuentas por pagar se generan a traves de una factura de compra o de gasto');
      $this->redirect(array('sf_route' => 'cuentas_pagar'));
    }

    $this->form = $this->configuration->getForm();
    $this->factura_compra = $this->form->getObject();
  }
 /* public function executeBatchLibroCompras(sfWebRequest $request) {
    // filtering
    if ($request->getParameter('filters'))  {
      $this->setFilters($request->getParameter('filters'));
    }

    $this->setMaxPerPage("700");
    $this->setPage(1);
    $this->pager = $this->getPager();
    $this->cuentas_pagars=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }*/
    public function executeBatchSaldoProveedores(sfWebRequest $request) {
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
        $partialSearch = $this->getPartial('cuentas_pagar/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('cuentas_pagar/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('cuentas_pagar/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->cuentas_pagars=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }
}
