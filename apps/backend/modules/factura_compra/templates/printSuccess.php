<style>
p {
  margin-top: 2px !important;
  margin-bottom: 2px !important;
}
</style>
<?php
  $fact=Doctrine_Core::getTable('Factura')->findOneBy('id',$sf_params->get('id'));
  $cl=Doctrine_Core::getTable('Cliente')->findOneBy('id',$fact->getClienteId());
  $emp=Doctrine_Core::getTable('Empresa')->findOneBy('id',$fact->getEmpresaId());
  $tasa=number_float($fact->getTasaCambio());
  list($anno, $mes, $dia) = explode('-',$fact->getFecha());
  $hinit="3";
?>
  <?php //<span style="position: absolute; left: 4cm; top: 4cm"></span> ?>
<div style="font-size: 12px; max-width: 20cm; height: 27cm; ">
  <?php if(strlen($emp->getCodCoorpotulipa())>0): ?>
    <h2 style="position: absolute; left: 9cm; top: <?php echo $hinit.'cm'; $hinit+=1; ?>;">
      <?php echo $emp->getCodCoorpotulipa(); ?>
    </h2>
  <?php endif; ?>
  <table style="position: absolute; left: 0.6cm; top: <?php echo $hinit.'cm'; ?>; width: 12cm; height: 3.3cm; border-spacing: 0px; font-size: 12px !important;">
    <tr>
      <td class="ball tpadd">
        <b>Cliente:</b> <?php echo $fact->getRazonSocial() ?><br/><b>R.I.F.:</b> <?php echo $fact->getDocId() ?>
      </td>
    </tr>
    <tr>
      <td class="bleft bbottom bright tpadd">
        <b>Domicilio Fiscal:</b> <?php echo $fact->getDireccion() ?>
      </td>
    </tr>
    <tr>
      <td class="bleft bbottom bright tpadd"><b>Direccion de Entrega:</b> <?php echo mb_strtoupper($fact->getDireccionEntrega()) ?></td>
    </tr>
  </table>
  <table style="position: absolute; left: 12.8cm; top: <?php echo $hinit.'cm'; $hinit+=3.8; ?>; width: 8.2cm; height: 3.3cm; border-spacing: 0px; font-size: 12px !important;">
    <tr>
      <td class="bleft btop tpadd btop bright" colspan="2">
        <h1 style="margin: 0px !important; padding: 0px !important;">FACTURA: <?php echo $fact->getNumFactura(); ?></h1>
      </td>
    </tr>
    <tr>
      <td class="bleft tpadd">
        <b>Emision:</b> <?php echo $dia."/".$mes."/".$anno; ?>
      </td>
      <td class="bright tpadd">
        <b>Dias de Credito:</b> <?php echo $fact->getDiasCredito(); ?>
      </td>
    </tr>
    <tr>
      <td class="bleft tpadd">
        <b>Orden #:</b> <?php echo $fact->getNcontrol(); ?>
      </td>
      <td class="bright tpadd">
        <b>Pagina:</b> <?php echo "001"; ?>
      </td>
    </tr>
    <tr>
      <td class="bleft tpadd bbottom">
        <b>SICM:</b> <?php echo $cl->getSicm(); ?>
      </td>
      <td class="bright tpadd bbottom">
        Condiciones de la Transacción:<br/>CREDITO a 0 Días
      </td>
    </tr>
  </table>
  <table style="position: absolute; left: 0.6cm; top: <?php echo $hinit.'cm'; ?>; border-spacing: 0px; font-size: 12px !important;">
    <thead>
      <tr>
        <td style="width: 2.5cm; border-top: 1px dashed; border-bottom: 1px dashed;">
          <b>CODIGO</b>
        </td>
        <td style="width: 9cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: justify">
          <b>ARTICULO</b>
        </td>
        <td style="width: 2.5cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: justify">
          <b>LOTE Y VENC</b>
        </td>
        <td style="width: 2cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: right">
          <b>PRECIO<br/>UNIT.</b>
        </td>
        <td style="width: 2cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: right">
          <b>QTY</b>
        </td>
        <td style="width: 2cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: right">
          <b>TOTAL<br/>NETO</b>
        </td>
      </tr>
    </thead>
    <tbody>
    <?php
    $results = Doctrine_Query::create()
      ->select('fd.exento as exento, fd.qty, fd.price_unit, fd.price_tot, fd.descripcion, i.id, p.nombre as product, p.serial as serial, ofer.id as ofid, ofer.nombre as ofname, ofer.ncontrol as ofserial')
      ->from('FacturaDet fd, fd.Inventario i, i.Producto p, fd.Oferta ofer')
      ->where('fd.factura_id = ?', $fact->getId())
      ->orderBy('fd.id ASC')
      ->execute();
      foreach ($results as $result) {
        $items = explode(';', $result["descripcion"]);
        $exento="G";
        if(str_replace(" ", "_", $result["exento"])=="EXENTO") {
          $exento="E";
        }
    ?>
      <tr>
        <td><?php echo $result["serial"].$result["ofserial"] ?></td>
        <td style="text-align: justify"><?php echo $result["product"].$result["ofname"]." (".$exento.")" ?></td>
        <td>
          <?php
            foreach ($items as $item) {
              if(strlen($item)>0) {
                list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
                $phpdate = strtotime($fvenc);
                echo "<b>".$lote."</b> <small>".date('M-Y', $phpdate)."</small><br/>";
              }
            }
          ?>        
        </td>
        <td style="text-align: right"><?php echo number_format(number_float($result["price_unit"])*$tasa, 4, ',', '.');?></td>
        <td style="text-align: right"><?php echo $result["qty"]; ?></td>
        <td style="text-align: right"><?php echo number_format(number_float($result["price_tot"])*$tasa, 4, ',', '.');?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
  <table style="position: absolute; left: 0.6cm; top: 25cm; width: 20cm; border-spacing: 0px; font-size: 12px !important;">
    <tr>
      <td class="tpadd tright" style="width: 5cm; border-top: 1px dashed;">
        <b>Total Descuento</b>
      </td>
      <td class="tpadd tright" style="width: 5cm; border-top: 1px dashed;">
        <b>Total Bruto</b>
      </td>
      <td class="tpadd tright" style="width: 5cm; border-top: 1px dashed;">
        <b>Total Impuesto</b>
      </td>
      <td class="tpadd tright" style="width: 5cm; border-top: 1px dashed;">
        <b>TOTAL GENERAL</b>
      </td>
    </tr>
    <tr>
      <td class="tpadd tright" style="border-bottom: 1px dashed;">
        <b><?php echo number_format((number_float($fact->getSubTotal())-number_float($fact->getSubtotalDesc()))*$tasa, 4, ',', '.');?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed;">
        <b><?php echo number_format(number_float($fact->getSubtotalDesc())*$tasa, 4, ',', '.');?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed;">
        <b><?php echo number_format(number_float($fact->getIvaMonto())*$tasa, 4, ',', '.');?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed;">
        <b><?php echo number_format(number_float($fact->getTotal())*$tasa, 4, ',', '.');?></b>
      </td>
    </tr>
    <tr>
      <td colspan="4">
        <?php
        $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $total=number_format(number_float($fact->getTotal())*$tasa, 4, '.', '');
        list($pre_tot,$suf_tot)=explode(".",$total);
        echo "Son: Bs. ".mb_strtoupper($f->format($pre_tot))." CON ".mb_strtoupper($f->format($suf_tot));
        ?>
      </td>
    </tr>
  </table>

</div>
<?php
  if($fact->getAnulado()==1) {
    echo "<img src='/images/anulado.png'style='position: absolute; top: 10cm; left: 8cm'/><br/>";
  }
?>
<script>
  window.onload = function () {
    window.print();
  }
</script>
<style>
  .tcaps {
    text-transform: capitalize;
  }
  .tpadd {
    padding: 0.1cm;
  }
  .clight {
    color: #adadad;
  }
  .ball {
    border: 1px solid #000 !important;
  }

  .bright {
    border-right: 1px solid #000 !important;
  }

  .bleft {
    border-left: 1px solid #000 !important;
  }

  .bbottom {
    border-bottom: 1px solid #000 !important;
  }

  .btop {
    border-top: 1px solid #000 !important;
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

<?php
function number_float($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return $number;
}
?>
