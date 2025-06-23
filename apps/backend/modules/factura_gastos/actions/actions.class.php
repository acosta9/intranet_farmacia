<?php

require_once dirname(__FILE__).'/../lib/factura_gastosGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/factura_gastosGeneratorHelper.class.php';

/**
 * factura_gastos actions.
 *
 * @package    ired.localhost
 * @subpackage factura_gastos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class factura_gastosActions extends autoFactura_gastosActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('factura_gastos');
    }

    $this->form = $this->configuration->getForm();
    $this->factura_gastos = $this->form->getObject();
  }

  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'date':
        $sort[0] = 'fecha';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("FacturaGastos")->hasColumn($column) || $column == "fecha";
  }
  public function executeGetProveedores(sfWebRequest $request){
  }

  public function executeHeader(sfWebRequest $request){
  }

  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');

    if($card = Doctrine_Core::getTable('FacturaGastos')->find($request->getParameter('id'))){
      $form = new FacturaGastosForm($card);
    }else{
      $form = new FacturaGastosForm(null);
    }

    $form->addDetalles($number);
    return $this->renderPartial('factura_gastos/detalles',array('form' => $form, 'num' => $number));
  }

  public function executeAnular(sfWebRequest $request){
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('factura_gastos');
    }

    $factura_gastos = Doctrine_Core::getTable('FacturaGastos')->findOneBy('id', $request->getParameter('id'));

    if($factura_gastos->getMontoPagado()>0){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la factura de gastos tiene un pago asociado');
      $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura_gastos));
    }

    if($factura_gastos->getEstatus()==4){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la factura de gastos ya esta anulada');
      $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura_gastos));
    }

    $fechaC=strtotime($factura_gastos->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>72) {
      $this->getUser()->setFlash('error','No puede anular este documento con mas de 72horas de haberla creado');
      $this->redirect(array('sf_route' => 'factura_gastos_show', 'sf_subject' => $factura_gastos));
    }

    if($cuentas_pagar = Doctrine_Core::getTable('CuentasPagar')->findOneBy('factura_gastos_id', $factura_gastos->getId())) {
      $cuentas_pagar->estatus = 4;
      $cuentas_pagar->save();
    }

    $factura_gastos->estatus=4;
    $factura_gastos->save();

    $this->getUser()->setFlash('notice','La factura de gastos ha sido anulada correctamente');
    $this->redirect(array('sf_route' => 'factura_gastos_show', 'sf_subject' => $factura_gastos));
  }

  public function executeDelete(sfWebRequest $request) {
    $factura_gastos = Doctrine_Core::getTable('FacturaGastos')->findOneBy('id', $request->getParameter('id'));
    
    $this->getUser()->setFlash('error','No puedes eliminar la factura de gastos');
    $this->redirect(array('sf_route' => 'factura_gastos_show', 'sf_subject' => $factura_gastos));
  }

  public function executeEdit(sfWebRequest $request) {
    $factura_gastos = Doctrine_Core::getTable('FacturaGastos')->findOneBy('id', $request->getParameter('id'));
    
    $this->getUser()->setFlash('error','No puedes editar la factura de gastos');
    $this->redirect(array('sf_route' => 'factura_gastos_show', 'sf_subject' => $factura_gastos));
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $factura_gastos = $form->save();
        $eid=$factura_gastos->getEmpresaId();
        $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$eid);
        /*$ncontrol=$empresa->getFactgasto()+1;
        $empresa->factgasto=$ncontrol;
        $empresa->save(); */
        //$factura_gastos->ncontrol=$ncontrol;
        $factura_gastos->monto_faltante = $factura_gastos->getTotal();
        $factura_gastos->monto_pagado = "0.00";
        $factura_gastos->save();

        $count_cps = Doctrine_Core::getTable('CuentasPagar')
          ->createQuery('a')
          ->select('COUNT(id) as contador')
          ->Where("id LIKE '$eid%'")
          ->limit(1)
          ->execute();
        $count = 0;
        foreach ($count_cps as $count_cc) {
          $count=$count_cc["contador"];
          break;
        }
        $conta = $eid.($count+1);
        $cuenta_pagar = new CuentasPagar();
        $cuenta_pagar->id=$conta;
        $cuenta_pagar->fecha=$factura_gastos->getFecha();
        $cuenta_pagar->fecha_recepcion=$factura_gastos->getFechaRecepcion();
        $cuenta_pagar->dias_credito=$factura_gastos->getDiasCredito();
        $cuenta_pagar->empresa_id=$factura_gastos->getEmpresaId();
        $cuenta_pagar->proveedor_id=$factura_gastos->getProveedorId();
        $cuenta_pagar->factura_gastos_id=$factura_gastos->getId();
        $cuenta_pagar->total=$factura_gastos->getTotal();
        $cuenta_pagar->monto_faltante=$factura_gastos->getMontoFaltante();
        $cuenta_pagar->monto_pagado=$factura_gastos->getMontoPagado();
        $cuenta_pagar->total_bs=$factura_gastos->getTotal2();
        $cuenta_pagar->monto_faltante_bs=$factura_gastos->getTotal2();
        $cuenta_pagar->monto_pagado_bs=$factura_gastos->getMontoPagado();
        $cuenta_pagar->tasa_cambio=$factura_gastos->getTasaCambio();
        $cuenta_pagar->save();

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
 
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $factura_gastos)));
 
      if ($request->hasParameter('_save_and_add')){
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@factura_gastos_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'factura_gastos_show', 'sf_subject' => $factura_gastos));
      }
    }else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }
  public function executeBatchReporteGastos(sfWebRequest $request) {
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
        $partialSearch = $this->getPartial('factura_gastos/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('factura_gastos/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('factura_gastos/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->factura_gastoss=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }
}
