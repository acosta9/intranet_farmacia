<?php

require_once dirname(__FILE__).'/../lib/factura_compraGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/factura_compraGeneratorHelper.class.php';

/**
 * factura_compra actions.
 *
 * @package    ired.localhost
 * @subpackage factura_compra
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class factura_compraActions extends autoFactura_compraActions
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
      case 'date':
        $sort[0] = 'fecha';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Factura")->hasColumn($column) || $column == "ncontrol" || $column == "date";
  }

  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');
    $ielim = $request->getParameter('elim');
     
    $ocdid = "";
    if(!empty($request->getParameter('ocdid'))) {
      $ocdid = $request->getParameter('ocdid');
    } else {
      if($ielim>=1)
        $number = $number + $ielim;
    }
    
    $did = "";
    if(!empty($request->getParameter('did'))) {
      $did = $request->getParameter('did');
    }

    if($card = Doctrine_Core::getTable('FacturaCompra')->find($request->getParameter('id'))){
      $form = new FacturaCompraForm($card);
    }else{
      $form = new FacturaCompraForm(null);
    }

    $form->addDetalles($number);
    return $this->renderPartial('factura_compra/detalles',array('form' => $form, 'num' => $number,  'ocdid' => $ocdid, 'did' => $did));
  }

  public function executeEdit(sfWebRequest $request) {
    $factura_compra = Doctrine::getTable('FacturaCompra')->find($request->getParameter('id'));

    $this->getUser()->setFlash('error','No puedes editar la factura de compra');
    $this->redirect(array('sf_route' => 'factura_compra_show', 'sf_subject' => $factura_compra));
  }

  public function executeDelete(sfWebRequest $request) {
    $factura_compra = Doctrine::getTable('FacturaCompra')->find($request->getParameter('id'));

    $this->getUser()->setFlash('error','No puedes eliminar el registro');
    $this->redirect(array('sf_route' => 'factura_compra_show', 'sf_subject' => $factura_compra));
  }
  
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('factura_compra');
    }

    if(empty($request->getParameter('id'))) {
      $this->getUser()->setFlash('error','Debe de asociar la factura a una orden de compra');
      $this->redirect(array('sf_route' => 'ordenes_compra'));
    }

    $id=$request->getParameter('id');
    $ordenes_compra = Doctrine_Core::getTable('OrdenesCompra')->findOneBy('id', $id);

    if($ordenes_compra->getEstatus()==4){
      $this->getUser()->setFlash('error','La orden de compra ya ha sido cerrada');
      $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
    }

    if($ordenes_compra->getEstatus()==5){
      $this->getUser()->setFlash('error','No puedes generar una factura de compra, porque la orden ya esta anulada');
      $this->redirect(array('sf_route' => 'ordenes_compra_show', 'sf_subject' => $ordenes_compra));
    }

    $this->form = $this->configuration->getForm();
    $this->factura_compra = $this->form->getObject();
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $factura_compra = $form->save();
        $eid=$factura_compra->getEmpresaId();
        $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$eid);
        /*$ncontrol=$empresa->getFactcompra()+1;
        $empresa->factcompra=$ncontrol;
        $empresa->save();*/
        //$factura_compra->ncontrol=$ncontrol;
        $factura_compra->monto_faltante = $factura_compra->getTotal();
        $factura_compra->monto_pagado = "0.00";
        $factura_compra->save();

        $ocid=$factura_compra->getOrdenesCompraId();
        $ordenes_compra = Doctrine_Core::getTable('OrdenesCompra')->findOneBy('id', $ocid);
        $cotizacion_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $ordenes_compra->getCotizacionCompraId());
        if($factura_compra->getEstatusOc()==1) {
          $ordenes_compra->estatus=3;
          $cotizacion_compra->estatus=3;
        } else {
          $ordenes_compra->estatus=4;
          $cotizacion_compra->estatus=4;
        }

        $ordenes_compra->save();
        $cotizacion_compra->save();

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
        $cuenta_pagar->fecha=$factura_compra->getFecha();
        $cuenta_pagar->fecha_recepcion=$factura_compra->getFechaRecepcion();
        $cuenta_pagar->dias_credito=$factura_compra->getDiasCredito();
        $cuenta_pagar->empresa_id=$factura_compra->getEmpresaId();
        $cuenta_pagar->proveedor_id=$factura_compra->getProveedorId();
        $cuenta_pagar->factura_compra_id=$factura_compra->getId();
        $cuenta_pagar->total=$factura_compra->getTotal();
        $cuenta_pagar->monto_faltante=$factura_compra->getMontoFaltante();
        $cuenta_pagar->monto_pagado=$factura_compra->getMontoPagado();
        $cuenta_pagar->total_bs=$factura_compra->getTotal2();
        $cuenta_pagar->monto_faltante_bs=$factura_compra->getTotal2();
        $cuenta_pagar->monto_pagado_bs=$factura_compra->getMontoPagado();        
        $cuenta_pagar->tasa_cambio=$factura_compra->getTasaCambio();
        $cuenta_pagar->save();
         $nump=0;
        $dets = Doctrine_Core::getTable('FacturaCompraDet')
          ->createQuery('a')
          ->Where('factura_compra_id=?', $factura_compra->getId())
          ->execute();
         foreach($dets as $det) {
          $qtyd=0;
          $inv_id=$det->getInventarioId();
          $qty=$det->getQty();
          $qtyr=$det->getQtyr();
          
          if($qtyr<$qty){ // hay devolucion
            $qtyd=$qty-$qtyr;
            $qty=$qtyr;
            $nump++; // cantidad de productos a devolver
          }

          ////// Inserto en la tabla devolver_compra la primera vez ///////
          if($nump==1){ 
             $nump++;
             $date = date("Y-m-d");
             $devc = Doctrine_Core::getTable('DevolverCompra')
                ->createQuery('a')
                ->select('id as contador')
                ->Where("id LIKE '$eid%'")
                ->orderby('id DESC')
                ->limit(1)
                ->fetchOne();
                 $count = 0;$countdev="";
                 $count=$devc["contador"];
                 if($count>0) {
                 $count=substr($count, 2,6)."<br/>";
                 $count=$count+1;
                 $countdev = $eid.$count;
              } else {
                $countdev=$eid."1"; }
 

              $devolver_compra = new DevolverCompra();
              $devolver_compra->id=$countdev;
              $devolver_compra->empresa_id=$factura_compra->getEmpresaId();
              $devolver_compra->tasa_cambio=$factura_compra->getTasaCambio();
              $devolver_compra->factura_compra_id=$factura_compra->getId();
              $devolver_compra->proveedor_id=$factura_compra->getProveedorId();
              $devolver_compra->fecha=$date;
              $devolver_compra->save();
          }
          ///////////////////////////////////////////////////////////////

          $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
          $producto = Doctrine_Core::getTable('Producto')->findOneBy('id', $inventario->getProductoId());
          $det->price_unit_old=$producto["costo_usd_1"];
          $det->save();

          if($factura_compra->getSumarInv()==1) {
            $inventario->sumarLote($qty, $det->getFechaVenc(), $det->getLote());
          }
          if($det["tipo_precio"]<>1) {
            $producto->cambiarCosto($det["price_calculado"]);
          }

          // Si hay devolucion ahora voy insertando en la tabla devolver_compra_det ///////
          if($det->getQtyr()<$det->getQty()){

            $punit=$det->getPriceUnitBs()/$factura_compra->getTasaCambio();
         
            $devolver_det = new DevolverCompraDet();
            $devolver_det->devolver_compra_id=$countdev; 
            $devolver_det->qty=$qtyd;
            $devolver_det->price_unit=$punit;
            $devolver_det->price_tot=$punit*$qtyd;
            $devolver_det->inventario_id=$inv_id;
            $devolver_det->exento=$det["exento"];            
            $devolver_det->save(); }
          ///////////////////////////fin devolver compra///////////////////

        } //foreach
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
 
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $factura_compra)));
 
      if ($request->hasParameter('_save_and_add')){
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@factura_compra_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'factura_compra_show', 'sf_subject' => $factura_compra));
      }
    }else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeAnular(sfWebRequest $request){
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
      $this->redirect('factura_compra');
    }
    
    $factura_compra = Doctrine_Core::getTable('FacturaCompra')->findOneBy('id', $request->getParameter('id'));

    if($factura_compra->getMontoPagado()>0){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la factura de compra tiene un pago asociado');
      $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura_compra));
    }

    if($factura_compra->getEstatus()==4){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la factura de compra ya esta anulada');
      $this->redirect(array('sf_route' => 'factura_show', 'sf_subject' => $factura_compra));
    }

    $fechaC=strtotime($factura_compra->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>72) {
      $this->getUser()->setFlash('error','No puede anular este documento con mas de 72horas de haberla creado');
      $this->redirect(array('sf_route' => 'factura_compra_show', 'sf_subject' => $factura_compra));
    }


    $dets = Doctrine_Core::getTable('FacturaCompraDet')
      ->createQuery('a')
      ->Where('factura_compra_id=?', $factura_compra->getId())
      ->execute();
    foreach($dets as $det) {
      $inv_id=$det->getInventarioId();
      $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inv_id);
      $inventario->restarInventario($det->getQtyr());
    }

    if($cuentas_pagar = Doctrine_Core::getTable('CuentasPagar')->findOneBy('factura_compra_id', $factura_compra->getId())) {
      $cuentas_pagar->estatus = 4;
      $cuentas_pagar->save();
    }
    ///// verifico si tiene devolucion y si la tiene la anulo tambien //////
    if($devolver_compra = Doctrine_Core::getTable('DevolverCompra')->findOneBy('factura_compra_id', $factura_compra->getId())) {
      $devolver_compra->estatus = 3;
      $devolver_compra->save();
    }

    $factura_compra->estatus=4;
    $factura_compra->save();

    $dets = Doctrine_Core::getTable('FacturaCompra')
      ->createQuery('a')
      ->Where('ordenes_compra_id=?', $factura_compra->getOrdenesCompraId())
      ->andWhere('estatus<>4')
      ->execute();
    $k=0;
    foreach ($dets as $det) {
      $k++;
    }
    if($k==0) {
      $ordenes_compra = Doctrine_Core::getTable('OrdenesCompra')->findOneBy('id', $factura_compra->getOrdenesCompraId());
      $ordenes_compra->estatus=2;
      $ordenes_compra->save();

      $cotizacion_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $ordenes_compra->getCotizacionCompraId());
      $cotizacion_compra->estatus=2;
      $cotizacion_compra->save();
    }

    $this->getUser()->setFlash('notice','La factura de compra ha sido anulada correctamente');
    $this->redirect(array('sf_route' => 'factura_compra_show', 'sf_subject' => $factura_compra));
  }

  public function executeGetProductos2(sfWebRequest $request){
    $search=$request->getParameter('search');
    $did=$request->getParameter('did');

    $words=explode(" ",$search);
    $i=0; $sql="(i.deposito_id=$did)";
    if($search=="**") {
      $sql=" && (p.nombre LIKE '%')";
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
    $results = $q->execute("SELECT i.id as iid, p.id as pid, p.nombre as pname, p.serial as serial, 
    FORMAT(REPLACE(p.costo_usd_1, ' ', ''), 4, 'de_DE') as p01,
    FORMAT(REPLACE(p.util_usd_1, ' ', ''), 4, 'de_DE') as util01,
    FORMAT(REPLACE(p.util_usd_8, ' ', ''), 4, 'de_DE') as util08
    FROM inventario as i
    LEFT JOIN producto as p ON i.producto_id=p.id
    WHERE $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $precio="0.0000";
      if($result["p01"]!="0,0000") {
        $precio=$result["p01"];
      }
      $util1="0.0000";
      if($result["util01"]!="0,0000") {
        $util1=$result["util01"];
      }
      $util8="0.0000";
      if($result["util08"]!="0,0000") {
        $util8=$result["util08"];
      }
      $arreglo[$result["iid"]]=$result["pname"]." [".$result["serial"]."]|".$precio."|".$util1."|".$util8;
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executePrefijo(sfWebRequest $request){
    $search=$request->getParameter('search');

    $oc = Doctrine_Core::getTable('OrdenesCompra')->findOneBy('id', $search);

    $exit="1";
    if($oc->getEstatus()==2 || $oc->getEstatus()==3) {
      $exit="0";
    }
    
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($exit));
  }

}
