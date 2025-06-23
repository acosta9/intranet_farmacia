<?php  $q = Doctrine_Manager::getInstance()->getCurrentConnection(); ?>
<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>
<table style="border-spacing: 0px; width: 100%;" id="tabla_export">
  <thead>
    <tr>
      <td colspan="13" style="text-align: center; text-decoration: underline;">
        <p style="margin-top: 0px !important">
          <b>REPORTE DE SALDO A PROVEEDORES</b>
          <b><?php echo date('d/m/Y') ?></b>
        </p>
      </td>
    </tr>
    <tr style="font-size: 11px !important">
      <td class="bbottom"></td>
      <td class="bbottom tleft"><b>EMPRESA</b></td>
      <td colspan="2" class="bbottom tleft"><b>RAZON SOCIAL</b></td>
      <td class="bbottom tleft"><b>TOTAL USD</b></td>
      <td class="bbottom tleft"><b>TOTAL BsS</b></td>
      <td class="bbottom tleft"><b>ABONADO USD</b></td>
      <td class="bbottom tleft"><b>ABONADO BsS</b></td>
      <td class="bbottom tleft"><b>SALDO USD</b></td>
      <td class="bbottom tleft"><b>SALDO BsS</b></td>
      <td class="bbottom tleft"><b>ESTATUS</b></td>
      <td class="bbottom tleft"><b>FACTURA</b></td>
      <td class="bbottom tcenter"><b>DIAS<br/>MORA</b></td>
    </tr>
  </thead>
  <tbody>
    <?php $i=1;
    foreach ($cuentas_pagars as $pagar) {
     if($pagar->getEstatus()==1 || $pagar->getEstatus()==2) {  // saldo pendiente o abonado
        if($pagar->getEstatus()==1)
          $estatus="PENDIENTE";
        else
          $estatus="ABONADO";

      if($pagar->getFacturaCompraId()) {
        $doc="FC:".$pagar->getFnum();
       } else if($pagar->getFacturaGastosId()) {
        $doc="FG:".$pagar->getFgnum(); }

      $dcreditos=$pagar->getDiascredito().$pagar->getGdiascredito();
      if ($pagar->getEstatus()==3) {
        $fecha_uno=strtotime($pagar->getFechaRecepcion());
        $fecha_dos=strtotime($pagar->getUpdatedAt());
        $fecha_diff=($fecha_dos - $fecha_uno)/60/60/24;
        $fecha_diff-=$dcreditos;
        if($fecha_diff<0) {
          $dias=0;
        } else {
          $dias=number_format($fecha_diff,0);
        }
      } else if($pagar->getEstatus()==4) {
          $dias=0;
      } else {
        $fecha_uno=strtotime($pagar->getFechaRecepcion());
        $fecha_dos=strtotime(date("Y-m-d H:i:s"));
        $fecha_diff=($fecha_dos - $fecha_uno)/60/60/24;
        $fecha_diff-=$dcreditos;
        if($fecha_diff<0) {
          $dias=0;
        } else {
          $dias=number_format($fecha_diff,0);
        }
       }
     ///////////////////////////////// Busco monto exacto en bs en factura /////////////////////////////////////
       $total2=0; $abonado_usd=0;$abonado_bs=0;$saldo_usd=0;$saldo_bs=0;
      if($pagar->getFacturaCompraId()) {
        $fid=$pagar->getFacturaCompraId();
      $factData = $q->execute("SELECT fc.total2 as total2
        FROM factura_compra as fc
        WHERE fc.id=$fid");
        foreach ($factData as $factD) {
          $total2=$factD["total2"]; 
        } 
      } else if($pagar->getFacturaGastosId()) {
          $fgid=$pagar->getFacturaGastosId();
          $factgData = $q->execute("SELECT fg.total2 as total2
          FROM factura_gastos as fg
          WHERE fg.id=$fgid");
          foreach ($factgData as $factgD) {
            $total2=$factgD["total2"]; 
          } 
        }
     ///////////////////////////// Busco monto exacto pagado en BS en recibo de pago ///////////////////////////
        $idp=$pagar->getId();
        $recData = $q->execute("SELECT SUM(rpc.monto2) as monto2
        FROM recibo_pago_compra as rpc
        WHERE rpc.cuentas_pagar_id=$idp");
        foreach ($recData as $recD) {
          $monto2=$recD["monto2"]; 
        } 

     ?>
      <tr style="font-size: 11px !important" >
        <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
        <td class="bbottom tleft tcaps" ><?php echo mb_strtolower($pagar->getEmpresaName());?></td>
        <td colspan="2" class="bbottom tleft tcaps" ><?php echo mb_strtolower($pagar->getProveedorName());?></td>
        <td class="bbottom tleft"><?php echo $pagar->getTotalTxt(); ?></td>
        <td class="bbottom tleft"><?php echo number_format($total2, 2, ',', '.'); ?></td>
        <td class="bbottom tleft"><?php echo $pagar->getMontoPagadoTxt(); ?></td>
        <td class="bbottom tleft"><?php echo number_format($monto2, 2, ',', '.'); ?></td>
        <td class="bbottom tleft"><?php echo $pagar->getmontoFaltanteTxt(); ?></td>
        <td class="bbottom tleft"><?php echo number_format($monto2, 2, ',', '.'); ?></td>
        <td class="bbottom tleft"><?php echo $estatus; ?></td>
        <td class="bbottom tleft tcaps" ><?php echo $doc; ?></td>
        <td class="bbottom tcenter tcaps" ><?php echo $dias; ?></td>
      </tr>
    <?php   } // if estatus pendiente 
      } // foreach ?>
  </tbody>
</table>

<style>
  .btn {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    text-decoration: none;
  }
  .btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    box-shadow: 0 1px 1px rgba(0,0,0,.075);
  }
  .btn-success {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
    box-shadow: 0 1px 1px rgba(0,0,0,.075);
  }
  .tcaps {
    text-transform: capitalize;
  }
  .clight {
    color: #adadad;
  }
  .ball {
    border: 1px solid #b3b3b38a !important;
  }

  .bright {
    border-right: 1px solid #b3b3b38a !important;
  }

  .bleft {
    border-left: 1px solid #b3b3b38a !important;
  }

  .bbottom {
    border-bottom: 1px solid #b3b3b38a !important;
  }

  .btop {
    border-top: 1px solid #b3b3b38a !important;
  }

  .tleft {
    text-align: left !important;
  }

  .tright {
    text-align: right !important;
  }

  .tcenter {
    text-align: center !important;
  }

  .vcenter {
    vertical-align: middle !important;
  }
</style>

<script>
  function toPdf() {
    $("#botones").hide();
    <?php $dt = new DateTime(); ?>
    var fecha = "<?php echo $dt->format('Y-m-d_H:i:s'); ?>";
    var css = '@page { size: 297mm 210mm; margin: 2mm 2mm 2mm 2mm; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    document.title='pagoprov_'+fecha+'.pdf';
    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);

    window.print();
    $("#botones").show();
  }
  function toExcel() {
    <?php $dt = new DateTime(); ?>
    var fecha = "<?php echo $dt->format('Y-m-d_H:i:s'); ?>";
    $("#tabla_export").table2excel({
      filename: 'pagoprov_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>
<script src="/js/jquery.table2excel.min.js"></script>