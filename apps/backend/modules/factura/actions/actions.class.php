<?php

require_once dirname(__FILE__).'/../lib/facturaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/facturaGeneratorHelper.class.php';

/**
 * factura actions.
 *
 * @package    ired.localhost
 * @subpackage factura
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class facturaActions extends autoFacturaActions
{
  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');
    $codigo=$id;
    $dets = Doctrine_Core::getTable('Factura')
      ->createQuery('a')
      ->select('id as contador')
      ->Where("id LIKE '$id%'")
      ->orderby('id DESC')
      ->limit(1)
      ->execute();
    $count = 0;
    foreach ($dets as $det) {
      $count=$det["contador"];
      break;
    }
    if($count>0) {
      $count=substr($count, 4)."<br/>";
      $count = $id.$count+1;
    } else {
      $count=$id."1";
    }
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($count));
  }

  public function executeGetClientes(sfWebRequest $request){
  }

  public function executeHeader(sfWebRequest $request){
  }

  public function executeDeposito(sfWebRequest $request){
  }

  public function executeInv(sfWebRequest $request){
  }

  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeDetalles2(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');

    if($card = Doctrine_Core::getTable('Factura')->find($request->getParameter('id'))){
      $form = new FacturaForm($card);
    }else{
      $form = new FacturaForm(null);
    }

    $form->addDetalles($number);
    if($request->getParameter('tipo')==1) {
      return $this->renderPartial('factura/detalles',array('form' => $form, 'num' => $number, 'eid' => $request->getParameter('eid'), 'cid' => $request->getParameter('cid'), 'pid' => $request->getParameter('pid'), 'qty' => $request->getParameter('qty')));
    } else {
      return $this->renderPartial('factura/detalles2',array('form' => $form, 'num' => $number, 'eid' => $request->getParameter('eid'), 'did' => $request->getParameter('did'), 'cid' => $request->getParameter('cid'), 'pid' => $request->getParameter('pid'), 'qty' => $request->getParameter('qty')));
    }

  }

  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'nulo':
        $sort[0] = 'anulado';
        break;
      case 'num_factura':
        $sort[0] = 'COALESCE(num_factura, ndespacho)';
        break;
      case 'TotalCoin':
        $sort[0] = 'total';
        break;
      case 'date':
        $sort[0] = 'fecha';
        break;
      case 'PendienteCoin':
        $sort[0] = 'monto_pagado';
        break;
      case 'company':
        $sort[0] = 'e.acronimo';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Factura")->hasColumn($column) || $column == "TotalCoin" || $column == "nulo" || $column == "date" || $column == "PendienteCoin" || $column == "company" || $column == "num_factura";
  }

  public function executeEdit(sfWebRequest $request) {
    $this->getUser()->setFlash('error','No puedes editar la factura');
    $this->redirect(array('sf_route' => '$factura_show', 'sf_subject' => $factura));
  }

  public function executeDelete(sfWebRequest $request) {
    $factura = Doctrine::getTable('Factura')->find($request->getParameter('id'));

    if($factura->getMontoPagado()>0){
      $this->getUser()->setFlash('error','No puedes eliminar el registro, porque la factura tiene asociado un recibo de pago');
      $this->redirect(array('sf_route' => '$factura_show', 'sf_subject' => $factura));
    }

    if($factura->getAnulado()==1){
      $this->getUser()->setFlash('error','No puedes eliminar el registro, porque la factura esta anulada');
      $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura));
    }
    $request->checkCSRFProtection();
    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
    if ($this->getRoute()->getObject()->delete()) {
      $this->getUser()->setFlash('notice', 'El registro ha sido eliminado correctamente.');
    }
    $this->redirect('@$factura');
  }

  public function executeAnular(sfWebRequest $request){
    $factura = Doctrine_Core::getTable('Factura')->findOneBy('id', $request->getParameter('id'));

    if($factura->getMontoPagado()>0){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la factura tiene un pago asociado');
      $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura));
    }

    if($factura->getEstatus()==4){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la factura ya esta anulada');
      $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura));
    }

    $despacho = Doctrine_Core::getTable('AlmacenTransito')->findOneBy('factura_id', $factura->getId());
    if($despacho->getEstatus()==2 || $despacho->getEstatus()==3) {
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la factura ya ha sido embalada o despachada');
      $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura));
    }
    $dets = Doctrine_Core::getTable('FacturaDet')
      ->createQuery('a')
      ->Where('factura_id=?', $factura->getId())
      ->execute();
    foreach($dets as $det) {
      if(!empty($det->getInventarioId())) {
        $inv_id=$det->getInventarioId();
        $fact_qty=$det->getQty();
        $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
        $inventario->sumarDevolucion($det->getDescripcion());
      } else {
        $oferta_id=$det->getOfertaId();
        $fact_qty=$det->getQty();
        $oferta = Doctrine_Core::getTable('Oferta')->findOneBy('id', $oferta_id);
        $oferta->sumarDevolucion($det->getDescripcion());
      }
    }

    $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('factura_id', $factura->getId());
    $cuentas_cobrar->estatus = 4;
    $cuentas_cobrar->save();
    $factura->estatus = 4;
    $factura->save();
    if($factura->getNotaEntregaId()) {
      $nota_entrega = Doctrine_Core::getTable('NotaEntrega')->findOneBy('id', $factura->getNotaEntregaId());
      $nota_entrega->estatus = 4;
      $nota_entrega->save();
    }

    $despacho->estatus = 4;
    $despacho->save();

    $this->getUser()->setFlash('notice','La factura ha sido anulada correctamente');
    $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura));
  }

  public function executeBatchReportePendientes(sfWebRequest $request) {
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

    //maxPerPage
    if ($request->getParameter('maxPerPage')) {
      $this->setMaxPerPage($request->getParameter('maxPerPage'));
      $this->setPage(1);
    }

    // pager
    if ($request->getParameter('page')) {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    if ($request->isXmlHttpRequest()) {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));

      if ($request->hasParameter('search')){
        $partialSearch = $this->getPartial('factura/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('factura/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('factura/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->facturas=$this->pager->getResults();
  }

  public function executeBatchReportePrefacturados(sfWebRequest $request) {
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

    //maxPerPage
    if ($request->getParameter('maxPerPage')) {
      $this->setMaxPerPage($request->getParameter('maxPerPage'));
      $this->setPage(1);
    }

    // pager
    if ($request->getParameter('page')) {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    if ($request->isXmlHttpRequest()) {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));

      if ($request->hasParameter('search')){
        $partialSearch = $this->getPartial('factura/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('factura/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('factura/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->facturas=$this->pager->getResults();
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
   $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';

      try {
        $factura = $form->save();
        $factura->monto_faltante = $factura->getTotal();
        $factura->monto_pagado = "0.00";
        $factura->save();

        if(!empty($ocid=$factura->getOrdenCompraId())) {
          $orden_compra = Doctrine_Core::getTable('OrdenCompra')->findOneBy('id', $ocid);
          $orden_compra->orden_compra_estatus_id=2;
          $orden_compra->save();
        }

        $eid=$factura->getEmpresaId();
        $count_ccs = Doctrine_Core::getTable('CuentasCobrar')
          ->createQuery('a')
          ->select('COUNT(id) as contador')
          ->Where("id LIKE '$eid%'")
          ->limit(1)
          ->execute();
        $count = 0;
        foreach ($count_ccs as $count_cc) {
          $count=$count_cc["contador"];
          break;
        }
        $count = $eid.$count+1;
        $cuenta_cobrar = new CuentasCobrar();
        $cuenta_cobrar->id=$count;
        $cuenta_cobrar->fecha=$factura->getFecha();
        $cuenta_cobrar->dias_credito=$factura->getDiasCredito();
        $cuenta_cobrar->empresa_id=$factura->getEmpresaId();
        $cuenta_cobrar->cliente_id=$factura->getClienteId();
        $cuenta_cobrar->factura_id=$factura->getId();
        $cuenta_cobrar->total=$factura->getTotal();
        $cuenta_cobrar->monto_faltante=$factura->getMontoFaltante();
        $cuenta_cobrar->monto_pagado=$factura->getMontoPagado();
        $cuenta_cobrar->tasa_cambio=$factura->getTasaCambio();
        $cuenta_cobrar->save();

        $dets = Doctrine_Core::getTable('FacturaDet')
          ->createQuery('a')
          ->Where('factura_id=?', $factura->getId())
          ->execute();
        foreach($dets as $det) {
          if(!empty($det->getInventarioId())) {
            $inv_id=$det->getInventarioId();
            $fact_qty=$det->getQty();
            $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
            $desc=$inventario->restarInventario($fact_qty);
            $det->descripcion=$desc;
            $det->save();
          } else {
            $oferta_id=$det->getOfertaId();
            $fact_qty=$det->getQty();
            $oferta = Doctrine_Core::getTable('Oferta')->findOneBy('id', $oferta_id);
            $desc=$oferta->restarInventario($fact_qty);
            $det->descripcion=$desc;
            $det->save();
          }
        }
        $transito = new AlmacenTransito();
        $transito->crearNuevo($factura->getId(), 1);
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

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $factura)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');

        $this->redirect('@$factura_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executePrint(sfWebRequest $request){
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
        $partialSearch = $this->getPartial('factura/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('factura/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('factura/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->facturas=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }
}
