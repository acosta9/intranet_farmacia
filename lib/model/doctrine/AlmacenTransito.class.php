<?php

/**
 * AlmacenTransito
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ired.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class AlmacenTransito extends BaseAlmacenTransito
{
  public function getCompany() {
    return $this["emin"];
  }

  public function getDeposito() {
    return $this["dname"];
  }

  public function getClienteName() {
    return $this["cname"];
  }

  public function  getRif() {
    return $this["docid"];
  }

  public function getTipoTxt() {
    if($this->getTipo()==1) {
      return "FACTURA";
    } else if($this->getTipo()==2) {
      return "NOTA EN.";
    } else if($this->getTipo()==3) {
      return "TRASLADO";
    }
  }

  public function getDocTxt() {
    if($this->getTipo()==1) {
      $factura=Doctrine_Core::getTable('Factura')->findOneBy('id',$this->getFacturaId());
      echo $factura->getNumFactura();
    } else if($this->getTipo()==2) {
      return "NOTA EN.";
    } else if($this->getTipo()==3) {
      return "TRASLADO";
    }
  }

  public function getFechaEmbalajeTxt() {
    if(!empty($this->getFechaEmbalaje())) {
      return mb_strtoupper(format_datetime($this->getFechaEmbalaje(), 'f', 'es_ES'));
    }
  }

  public function getFechaDespachoTxt() {
    if(!empty($this->getFechaDespacho())) {
      return mb_strtoupper(format_datetime($this->getFechaDespacho(), 'f', 'es_ES'));
    }
  }

  public function getProds() {
    if($this->getTipo()==1) {
      $results_prods = Doctrine_Query::create()
        ->select('fd.id as fdid, i.id as iid, p.id as pid, 
        fd.descripcion as desc, p.nombre as pname, p.serial as serial')
        ->from('FacturaDet fd')
        ->leftJoin('fd.Inventario i')
        ->leftJoin('i.Producto p')
        ->Where('fd.factura_id =?', $this->getFacturaId())
        ->andWhere('fd.oferta_id IS NULL')
        ->orderBy('p.nombre ASC')
        ->execute();
    }

    $prods=array();
    foreach ($results_prods as $result ) {
      if(empty($prods[$result["iid"]][$result["serial"]])) {
        $prods[$result["iid"]]["id"]=$result["iid"];
        $prods[$result["iid"]]["serial"]=$result["serial"];
        $prods[$result["iid"]]["nombre"]=$result["pname"];
        $prods[$result["iid"]]["qty"]=$result["qty"];
        $items = explode(';', $result["descripcion"]);
        foreach ($items as $item) {
          if(strlen($item)>0) {
            list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
            $phpdate = strtotime($fvenc);
            if(empty($prods[$result["iid"]]["lote"][$lote])) {
              $prods[$result["iid"]]["lote"][$lote]=$qty;
            } else {
              $qty_lote=floatval($prods[$result["iid"]]["lote"][$lote])+floatval($qty);
              $prods[$result["iid"]]["lote"][$lote]=$qty;
            }
          }
        }
      } else {
        $qty_total=floatval($prods[$result["iid"]]["qty"])+floatval($result["qty"]);
        $prods[$result["iid"]]["id"]=$result["iid"];
        $prods[$result["iid"]]["serial"]=$result["serial"];
        $prods[$result["iid"]]["nombre"]=$result["pname"];
        $prods[$result["iid"]]["qty"]=$qty_total;
        $items = explode(';', $result["descripcion"]);
        foreach ($items as $item) {
          if(strlen($item)>0) {
            list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
            $phpdate = strtotime($fvenc);
            if(empty($prods[$result["iid"]]["lote"][$lote])) {
              $prods[$result["iid"]]["lote"][$lote]=$qty;
            } else {
              $qty_lote=floatval($prods[$result["iid"]]["lote"][$lote])+floatval($qty);
              $prods[$result["iid"]]["lote"][$lote]=$qty;
            }
          }
        }
      }
    }

    return $prods;
  }

  public function getProdsOfer() {
    if($this->getTipo()==1) {
      $results_prods = Doctrine_Query::create()
        ->select('fd.id as fdid, o.id as oid, o.nombre as ofername, fd.qty as qty, fd.descripcion as desc')
        ->from('FacturaDet fd')
        ->leftJoin('fd.Oferta o')
        ->Where('fd.factura_id =?', $this->getFacturaId())
        ->andWhere('fd.inventario_id IS NULL')
        ->orderBy('o.nombre ASC')
        ->execute();
    }

    return $results_prods;
  }


  public function getCreatedAtTxt() {
    return mb_strtoupper(format_datetime($this->getCreatedAt(), 'f', 'es_ES'));
  }
  public function getUpdatedAtTxt() {
    return format_datetime($this->getUpdatedAt(), 'f', 'es_ES');
  }
  public function crearNuevo($id, $tipo) {
    switch ($tipo) {
      // factura
      case 1:
        $factura = Doctrine_Core::getTable('Factura')->findOneBy('id', $id);
        $eid=$factura->getDepositoId();
        $count_ccs = Doctrine_Core::getTable('AlmacenTransito')
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
        $almacen_transito = new AlmacenTransito();
        $almacen_transito->id=$count;
        $almacen_transito->empresa_id=$factura->getEmpresaId();
        $almacen_transito->deposito_id=$factura->getDepositoId();
        $almacen_transito->cliente_id=$factura->getClienteId();
        $almacen_transito->factura_id=$factura->getId();
        $almacen_transito->estatus=1;
        $almacen_transito->tipo=1;
        $almacen_transito->save();
        break;
      default:
        break;
    }
    return true;
  }
}
