<?php

/**
 * CuentasPagar
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ired.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class CuentasPagar extends BaseCuentasPagar
{
  public function getEmpresaName() {
    return $this["emin"];
  }

  public function getProveedorName() {
    return $this["pname"];
  }

  public function getRif() {
    return $this["docid"];
  }

  public function getCreatedAtTxt() {
    return mb_strtoupper(format_datetime($this->getCreatedAt(), 'D', 'es_ES'));
  }
  public function getUpdatedAtTxt() {
    return format_datetime($this->getUpdatedAt(), 'f', 'es_ES');
  }

  public function putPagar($monto,$monto2,$moneda) {
    $monto_pagado=number_float4($monto);
    $monto_pagado_bs=number_float4($monto2);
    
      $tasa=$this->getTasaCambio();
      $monto_pagado_new=number_format(number_float4($this->getMontoPagado())+$monto_pagado, 4, '.', '');
      $monto_pagado_new_bs=number_format(number_float4($this->getMontoPagadoBs())+$monto_pagado_bs, 4, '.', '');

      $monto_pagado_tmp=number_float4($this->getMontoPagado())+$monto_pagado;
      $monto_pagado_tmp_bs=number_float4($this->getMontoPagadoBs())+$monto_pagado_bs;

      $monto_faltante=number_format(number_float4($this->getTotal())-$monto_pagado_tmp, 4, '.', '');
      $monto_faltante_bs=number_format(number_float4($this->getTotalBs())-$monto_pagado_tmp_bs, 4, '.', '');

      $monto_faltante_tmp=number_float4($this->getTotal())-$monto_pagado_tmp;
      $monto_faltante_tmp_bs=number_float4($this->getTotalBs())-$monto_pagado_tmp_bs;

      $estatus=0;
      $desc="";
      if($moneda == 2){
        if($monto_faltante_tmp==0){
          $estatus=3;
          $monto_faltante_bs=0.0000;
          $monto_pagado_new_bs=$this->getTotalBs();
          //$desc='<span style="text-decoration: underline;">PAGO TOTAL DE LA <b>PRE-FACTURA N° 000004504A</b> DE FECHA 01/06/2020</span>';
          $desc=$desc.'<span style="text-decoration: underline;">PAGO TOTAL DE LA ';
        } else if($monto_faltante>0){
          $estatus=2;
          $desc=$desc.'<span style="text-decoration: underline;">ABONO DE LA ';
        }
      } else if($moneda == 1){
        if($monto_faltante_tmp_bs==0){
          $estatus=3;
          $monto_faltante=0.0000;
          $monto_pagado_new=$this->getTotal();
          $desc=$desc.'<span style="text-decoration: underline;">PAGO TOTAL DE LA ';
        } else if($monto_faltante_bs>0 ){
          $estatus=2;
          $desc=$desc.'<span style="text-decoration: underline;">ABONO DE LA ';
        }
      } 

      if($this->getFacturaCompraId()) {
        $factura = Doctrine_Core::getTable('FacturaCompra')->findOneBy('id', $this->getFacturaCompraId());
        $factura->monto_faltante=$monto_faltante;
        $factura->monto_pagado=$monto_pagado_new;
        $factura->estatus=$estatus;
        $factura->save();
        $desc=$desc.'<b>FACTURA COMPRA N° '.$factura->getNumFactura().'</b> DE FECHA EMISION '.date("d/m/Y", strtotime($factura->getFecha())).'</span>';
      } else if ($this->getFacturaGastosId()) {
        $factura = Doctrine_Core::getTable('FacturaGastos')->findOneBy('id', $this->getFacturaGastosId());
        $factura->monto_faltante=$monto_faltante;
        $factura->monto_pagado=$monto_pagado_new;
        $factura->estatus=$estatus;
        $factura->save();
        $desc=$desc.'<b>FACTURA GASTOS N° '.$factura->getNumFactura().'</b> DE FECHA EMISION '.date("d/m/Y", strtotime($factura->getFecha())).'</span>';
      }
      $cuenta_cobrar = Doctrine_Core::getTable('CuentasPagar')->findOneBy('id', $this->getId());
      $cuenta_cobrar->monto_faltante=$monto_faltante;
      $cuenta_cobrar->monto_pagado=$monto_pagado_new;
      $cuenta_cobrar->monto_faltante_bs=$monto_faltante_bs;
      $cuenta_cobrar->monto_pagado_bs=$monto_pagado_new_bs;
      $cuenta_cobrar->estatus=$estatus;
      $cuenta_cobrar->save();

      return $desc;
  
  }

  public function putAnular($monto) {
    $monto_pagado=number_float4($monto);
    $monto_pagado_new=number_format(number_float4($this->getMontoPagado())-$monto_pagado, 4, '.', '');
    $monto_pagado_tmp=number_float4($this->getMontoPagado())-$monto_pagado;
    $monto_faltante=number_format(number_float4($this->getTotal())-$monto_pagado_tmp, 4, '.', '');
    $monto_faltante_tmp=number_float4($this->getTotal())-$monto_pagado_tmp;
    $estatus=0;
    if($monto_pagado_tmp==0){
      $estatus=1;
    } else if($monto_pagado_tmp>0){
      $estatus=2;
    }
    if($this->getFacturaCompraId()) {
      $factura = Doctrine_Core::getTable('FacturaCompra')->findOneBy('id', $this->getFacturaCompraId());
      $factura->monto_faltante=$monto_faltante;
      $factura->monto_pagado=$monto_pagado_new;
      $factura->estatus=$estatus;
      $factura->save();
    } else if ($this->getFacturaGastosId()) {
      $factura = Doctrine_Core::getTable('FacturaGastos')->findOneBy('id', $this->getFacturaGastosId());
      $factura->monto_faltante=$monto_faltante;
      $factura->monto_pagado=$monto_pagado_new;
      $factura->estatus=$estatus;
      $factura->save();
    }
    $cuenta_cobrar = Doctrine_Core::getTable('CuentasPagar')->findOneBy('id', $this->getId());
    $cuenta_cobrar->monto_faltante=$monto_faltante;
    $cuenta_cobrar->monto_pagado=$monto_pagado_new;
    $cuenta_cobrar->estatus=$estatus;
    $cuenta_cobrar->save();
  }
}

function number_float4($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return floatval($number);
}
