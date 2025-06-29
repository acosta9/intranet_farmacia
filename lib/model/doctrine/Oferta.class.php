<?php

/**
 * Oferta
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    ired.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Oferta extends BaseOferta
{
  public function getEstatus() {
    if($this->getActivo()==0) {
      return "DES-HABILITADO";
    } else {
      return "HABILITADO";
    }
  }
  public function getTipo() {
    if($this->getTipoOferta()==1) {
      return "DESCUENTO";
    } else if($this->getTipoOferta()==2) {
      return "LLEVATE XX PAGA Y";
    } else {
      return "COMBO";
    }
  }
  public function getTipoTasa() {
    if($this->getTasa()=="T01") {
      return "TASA MED";
    } else if($this->getTasa()=="T02"){
      return "TASA MISC";
    } else if($this->getTasa()=="T03"){
      return "TASA DIA";
    }
  }
  public function getEmpresaName() {
    return $this["emin"];
  }
  public function getDepositoName() {
    return $this["idname"];
  }
  public function getCreatedAtTxt() {
    return format_datetime($this->getCreatedAt(), 'f', 'es_ES');
  }
  public function getUpdatedAtTxt() {
    return format_datetime($this->getUpdatedAt(), 'f', 'es_ES');
  }
  public function restarInventario($cant) {
    $multiplier=1;
    if($this->getTipoOferta()==2) {
      $multiplier=$this->getQty();
    }
    $cant_real=$cant*$multiplier;
    $desc="";
    $dets = Doctrine_Core::getTable('OfertaDet')
      ->createQuery('a')
      ->Where('oferta_id=?', $this->getId())
      ->execute();
    foreach($dets as $det) {
      $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $det->getInventarioId());
      $desc=$desc.$inventario->restarInventario($cant_real);
    }
    return $desc;
  }
  public function sumarDevolucion($datos) {
    $items = explode(';', $datos);
    foreach ($items as $item) {
      if(strlen($item)>0) {
        list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
        $this->sumarAjuste($qty, $InvDetId);
      }
    }
  }
  public function sumarAjuste($cant, $InvDetId) {
    $inventario_det = Doctrine_Core::getTable('InventarioDet')->findOneBy('id', $InvDetId);
    $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $inventario_det->getInventarioId());
    $cant_inv=numero_cant($inventario->getQty())+numero_cant($cant);
    $inventario->cantidad=$cant_inv;
    $inventario->save();
    $dets = Doctrine_Core::getTable('InventarioDet')
      ->createQuery('a')
      ->Where('id=?', $InvDetId)
      ->orderBy('id DESC')
      ->limit(1)
      ->execute();
    foreach ($dets as $det) {
      $det->cantidad=numero_cant($det->getCantidad())+numero_cant($cant);
      $det->save();
      break;
    }
  }
}
