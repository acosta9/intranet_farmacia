<?php

require_once dirname(__FILE__).'/../lib/nota_entregaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/nota_entregaGeneratorHelper.class.php';

/**
 * nota_entrega actions.
 *
 * @package    ired.localhost
 * @subpackage nota_entrega
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class nota_entregaActions extends autoNota_entregaActions
{
  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');
    $codigo=$id;
    $dets = Doctrine_Core::getTable('NotaEntrega')
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

    if($card = Doctrine_Core::getTable('NotaEntrega')->find($request->getParameter('id'))){
      $form = new NotaEntregaForm($card);
    }else{
      $form = new NotaEntregaForm(null);
    }

    $form->addDetalles($number);
    if($request->getParameter('tipo')==1) {
      return $this->renderPartial('nota_entrega/detalles',array('form' => $form, 'num' => $number, 'eid' => $request->getParameter('eid'), 'cid' => $request->getParameter('cid')));
    } else {
      return $this->renderPartial('nota_entrega/detalles2',array('form' => $form, 'num' => $number, 'eid' => $request->getParameter('eid'), 'did' => $request->getParameter('did'), 'cid' => $request->getParameter('cid')));
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
      case 'fact':
        $sort[0] = 'f.num_factura';
        break;
      case 'TotalCoin':
        $sort[0] = 'total';
        break;
      case 'date':
        $sort[0] = 'fecha';
        break;
      case 'PendienteCoin':
        $sort[0] = 'monto_faltante';
        break;
      case 'company':
        $sort[0] = 'e.acronimo';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("NotaEntrega")->hasColumn($column) || $column == "TotalCoin" || $column == "date" || $column == "PendienteCoin" || $column == "fact" || $column == "company";
  }

  public function executeEdit(sfWebRequest $request) {
    $this->getUser()->setFlash('error','No puedes editar la nota de entrega');
    $this->redirect(array('sf_route' => 'nota_entrega_show', 'sf_subject' => $nota_entrega));
  }

  public function executeDelete(sfWebRequest $request) {
    $this->getUser()->setFlash('error','No puedes eliminar la nota de entrega');
    $this->redirect(array('sf_route' => 'nota_entrega_show', 'sf_subject' => $nota_entrega));
  }

  public function executeConvertir(sfWebRequest $request){
    $nota_entrega = Doctrine_Core::getTable('NotaEntrega')->findOneBy('id', $request->getParameter('id'));
    if(!$nota_entrega) {
      $this->redirect(array('sf_route' => 'nota_entrega'));
    }

    if($nota_entrega->getEstatus()==4){
      $this->getUser()->setFlash('error','No puedes convertir la nota de entrega porque está se encuentra anulada');
      $this->redirect(array('sf_route' => 'nota_entrega_show', 'sf_subject' => $nota_entrega));
    }

    if(Doctrine_Core::getTable('Factura')->findOneBy('nota_entrega_id', $request->getParameter('id'))) {
      $this->getUser()->setFlash('error','No puedes convertir la nota de entrega porque está ya posee una factura asociada');
      $this->redirect(array('sf_route' => 'nota_entrega_show', 'sf_subject' => $nota_entrega));
    }

    $eid=$nota_entrega->getEmpresaId();
    $empresa = Doctrine_Core::getTable('Empresa')->findOneBy('id', $eid);
    $empresa->ncontrol=$empresa->getNuevoNcontrol();
    $empresa->nfactura=$empresa->getNuevoNFactura();
    $empresa->save();

    $dets = Doctrine_Core::getTable('Factura')
      ->createQuery('a')
      ->select('id')
      ->Where("id LIKE '$eid%'")
      ->limit(1)
      ->orderby("id DESC")
      ->execute();
    $count = 0;
    foreach ($dets as $det) {
      $count=str_replace($eid,"",$det["id"]);
      break;
    }

    if($count>0) {
      $count = $eid.$count+1;
    } else {
      $count=$eid."1";
    }

    $factura = new Factura();
    $factura->id=$count;
    $factura->fecha=$nota_entrega->getFecha();
    $factura->dias_credito=$nota_entrega->getDiasCredito();
    $factura->empresa_id=$eid;
    $factura->deposito_id=$nota_entrega->getDepositoId();
    $factura->cliente_id=$nota_entrega->getClienteId();
    $factura->nota_entrega_id=$nota_entrega->getId();
    $factura->razon_social=$nota_entrega->getRazonSocial();
    $factura->doc_id=$nota_entrega->getDocId();
    $factura->telf=$nota_entrega->getTelf();
    $factura->direccion=$nota_entrega->getDireccion();
    $factura->direccion_entrega=$nota_entrega->getDireccionEntrega();
    $factura->ncontrol=$empresa->getNcontrol();
    $factura->num_factura=$empresa->getNFactura();
    $factura->forma_pago=$nota_entrega->getFormaPago();
    $factura->tasa_cambio=$nota_entrega->getTasaCambio();
    $factura->subtotal=$nota_entrega->getSubtotal();
    $factura->subtotal_desc=$nota_entrega->getSubtotalDesc();
    $factura->iva=$nota_entrega->getIva();
    $factura->base_imponible=$nota_entrega->getBaseImponible();
    $factura->iva_monto=$nota_entrega->getIvaMonto();
    $factura->total=$nota_entrega->getTotal();
    $factura->descuento=$nota_entrega->getDescuento();
    $factura->monto_faltante=$nota_entrega->getMontoFaltante();
    $factura->monto_pagado=$nota_entrega->getMontoPagado();
    $factura->has_invoice=1;
    $factura->estatus=$nota_entrega->getEstatus();
    $factura->save();

    $transito = new AlmacenTransito();
    $transito->crearNuevo($factura->getId(), 1);

    $dets = Doctrine_Core::getTable('NotaEntregaDet')
      ->createQuery('a')
      ->Where('nota_entrega_id=?', $nota_entrega->getId())
      ->execute();
    foreach($dets as $det) {
      $factura_det = new FacturaDet();
      $factura_det->factura_id=$factura->getId();
      $factura_det->qty=$det->getQty();
      $factura_det->price_unit=$det->getPriceUnit();
      $factura_det->price_tot=$det->getPriceTot();
      $factura_det->inventario_id=$det->getInventarioId();
      $factura_det->oferta_id=$det->getOfertaId();
      $factura_det->descripcion=$det->getDescripcion();
      $factura_det->exento=$det->getExento();
      $factura_det->save();
    }
    $cuenta_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('nota_entrega_id', $nota_entrega->getId());
    $cuenta_cobrar->factura_id=$factura->getId();
    $cuenta_cobrar->nota_entrega_id=NULL;
    $cuenta_cobrar->save();

    $this->getUser()->setFlash('notice','La nota de entrega ha sido convertida ha factura correctamente');
    $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura));
  }

  public function executeAnular(sfWebRequest $request){
    $nota_entrega = Doctrine_Core::getTable('NotaEntrega')->findOneBy('id', $request->getParameter('id'));

    if($nota_entrega->getMontoPagado()>0){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la nota de entrega tiene un pago asociado');
      $this->redirect(array('sf_route' => 'nota_entrega_show', 'sf_subject' => $nota_entrega));
    }

    if($nota_entrega->getEstatus()==4){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la nota de entrega ya esta anulada');
      $this->redirect(array('sf_route' => 'nota_entrega_show', 'sf_subject' => $nota_entrega));
    }

    if($factura = Doctrine_Core::getTable('Factura')->findOneBy('nota_entrega_id', $nota_entrega->getId())) {
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la nota de entrega tiene una factura asociada');
      $this->redirect(array('sf_route' => 'nota_entrega_show', 'sf_subject' => $nota_entrega));
    }

    $dets = Doctrine_Core::getTable('NotaEntregaDet')
      ->createQuery('a')
      ->Where('nota_entrega_id=?', $nota_entrega->getId())
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

    $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('nota_entrega_id', $nota_entrega->getId());
    $cuentas_cobrar->estatus = 4;
    $cuentas_cobrar->save();
    $nota_entrega->estatus = 4;
    $nota_entrega->save();


    $this->getUser()->setFlash('notice','La nota de entrega ha sido anulada correctamente');
    $this->redirect(array('sf_route' => 'nota_entrega_show', 'sf_subject' => $nota_entrega));
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
   $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';

      try {
        $nota_entrega = $form->save();
        $nota_entrega->monto_faltante = $nota_entrega->getTotal();
        $nota_entrega->monto_pagado = "0.00";
        $nota_entrega->save();

        $eid=$nota_entrega->getEmpresaId();
        $count_ccs = Doctrine_Core::getTable('CuentasCobrar')
          ->createQuery('a')
          ->select('id')
          ->Where("id LIKE '$eid%'")
          ->limit(1)
          ->orderby("id DESC")
          ->execute();
        $count = 0;
        foreach ($count_ccs as $count_cc) {
          $count=str_replace($eid,"",$count_cc["id"]);
          break;
        }
        $count = $eid.$count+1;
        $cuenta_cobrar = new CuentasCobrar();
        $cuenta_cobrar->id=$count;
        $cuenta_cobrar->fecha=$nota_entrega->getFecha();
        $cuenta_cobrar->dias_credito=$nota_entrega->getDiasCredito();
        $cuenta_cobrar->empresa_id=$nota_entrega->getEmpresaId();
        $cuenta_cobrar->cliente_id=$nota_entrega->getClienteId();
        $cuenta_cobrar->nota_entrega_id=$nota_entrega->getId();
        $cuenta_cobrar->total=$nota_entrega->getTotal();
        $cuenta_cobrar->monto_faltante=$nota_entrega->getMontoFaltante();
        $cuenta_cobrar->monto_pagado=$nota_entrega->getMontoPagado();
        $cuenta_cobrar->tasa_cambio=$nota_entrega->getTasaCambio();
        $cuenta_cobrar->save();

        $dets = Doctrine_Core::getTable('NotaEntregaDet')
          ->createQuery('a')
          ->Where('nota_entrega_id=?', $nota_entrega->getId())
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

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $nota_entrega)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');

        $this->redirect('@nota_entrega_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);

        $this->redirect(array('sf_route' => 'nota_entrega_show', 'sf_subject' => $nota_entrega));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executePrint(sfWebRequest $request){
  }

  public function executePrint2(sfWebRequest $request){
  }
}
