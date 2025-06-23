<style>
p {
  margin-top: 2px !important;
  margin-bottom: 2px !important;
}
</style>
<?php
  $ne=Doctrine_Core::getTable('NotaEntrega')->findOneBy('id',$sf_params->get('id'));
  $cl=Doctrine_Core::getTable('Cliente')->findOneBy('id',$ne->getClienteId());
  $emp=Doctrine_Core::getTable('Empresa')->findOneBy('id',$ne->getEmpresaId());
  $tasa=number_float($ne->getTasaCambio());
  list($anno, $mes, $dia) = explode('-',$ne->getFecha());
  $hinit="2.6";
?>
  <?php //<span style="position: absolute; left: 4cm; top: 4cm"></span> ?>
<div style="font-size: 12px; max-width: 20cm; height: 27cm; ">
  <table style="position: absolute; left:0.6cm; top: 0.6cm; width: 20.4cm; font-size: 12px !important;">
    <tbody>
      <td colspan="4">
        <img src='/images/<?php echo $emp->getId()?>.jpg' height="50"/>
      </td>
      <td colspan="4">
        <address style="text-align: right; font-size: 11px">
          <strong><?php echo mb_strtoupper($emp->getNombre()." | ".$emp->getRif()); ?></strong><br>
          <span class="tcaps"><?php echo mb_strtolower($emp->getDireccion()); ?></span><br>
          Telf: <?php echo $emp->getTelefono(); ?><br>
          Email: <?php echo $emp->getEmail(); ?>
        </address>
      </td>
    </tbody>
  </table>
  <table style="position: absolute; left: 0.6cm; top: <?php echo $hinit.'cm'; ?>; width: 12cm; height: 3.3cm; border-spacing: 0px; font-size: 12px !important;">
    <tr>
      <td class="ball tpadd">
        <b>Cliente:</b> <?php echo $ne->getRazonSocial() ?><br/><b>R.I.F.:</b> <?php echo $ne->getDocId() ?>
      </td>
    </tr>
    <tr>
      <td class="bleft bbottom bright tpadd">
        <b>Domicilio Fiscal:</b> <?php echo $ne->getDireccion() ?>
      </td>
    </tr>
    <tr>
      <td class="bleft bbottom bright tpadd"><b>Direccion de Entrega:</b> <?php echo mb_strtoupper($ne->getDireccionEntrega()) ?></td>
    </tr>
  </table>
  <table style="position: absolute; left: 12.8cm; top: <?php echo $hinit.'cm'; $hinit+=3.8; ?>; width: 8.2cm; height: 3.3cm; border-spacing: 0px; font-size: 12px !important;">
    <tr>
      <td class="bleft btop tpadd">
        <h2 style="margin: 0px !important; padding: 0px !important;">FACTURA</h2>
      </td>
      <td class="btop bright tpadd">
        <h2 style="margin: 0px !important; padding: 0px !important;">#<?php echo $ne->getNcontrol(); ?></h2>
      </td>
    </tr>
    <tr>
      <td class="bleft tpadd">
        <b>Emision:</b> <?php echo $dia."/".$mes."/".$anno; ?>
      </td>
      <td class="bright tpadd">
        <b>Dias de credito:</b> <?php echo $ne->getDiasCredito(); ?>
      </td>
    </tr>
    <tr>
      <td class="bleft tpadd">
        <b>Vendedor #:</b> <?php echo $ne->getCreator(); ?>
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
        Condiciones de la Transacción: CREDITO a 0 Días
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
      ->select('ned.exento as exento, ned.qty, ned.price_unit, ned.price_tot, ned.descripcion, i.id, p.nombre as product, p.serial as serial, ofer.id as ofid, ofer.nombre as ofname, ofer.ncontrol as ofserial')
      ->from('NotaEntregaDet ned, ned.Inventario i, i.Producto p, ned.Oferta as ofer')
      ->where('ned.nota_entrega_id=?', $ne->getId())
      ->orderBy('ned.id ASC')
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
        <td style="text-align: right"><?php echo number_format(number_float($result->getPriceUnit())*$tasa, 2, ',', '.');?></td>
        <td style="text-align: right"><?php echo $result->getQty(); ?></td>
        <td style="text-align: right"><?php echo number_format(number_float($result->getPriceTot())*$tasa, 2, ',', '.');?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
  <table style="position: absolute; left: 0.6cm; top: 25cm; width: 20cm; border-spacing: 0px; font-size: 12px !important;">
    <tr>
      <td class="tpadd tcenter" style="width: 4cm; border-top: none;">
        <b>__________________</b>
      </td>
      <td class="tpadd tright" style="width: 4cm; border-top: 1px dashed; border-left: 1px dashed;">
        <b>Total Descuento</b>
      </td>
      <td class="tpadd tright" style="width: 4cm; border-top: 1px dashed;">
        <b>Total Bruto</b>
      </td>
      <td class="tpadd tright" style="width: 4cm; border-top: 1px dashed;">
        <b>Total Impuesto</b>
      </td>
      <td class="tpadd tright" style="width: 4cm; border-top: 1px dashed; border-right: 1px dashed;">
        <b>TOTAL GENERAL</b>
      </td>
    </tr>
    <tr>
      <td class="tpadd tcenter" style="border-bottom: 1px dashed;">
        <b><?php echo "Recibi Conforme";?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed; border-left: 1px dashed;">
        <b><?php echo number_format((number_float($ne->getSubTotal())-number_float($ne->getSubtotalDesc()))*$tasa, 2, ',', '.');?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed;">
        <b><?php echo number_format(number_float($ne->getSubtotalDesc())*$tasa, 2, ',', '.');?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed;">
        <b><?php echo number_format(number_float($ne->getIvaMonto())*$tasa, 2, ',', '.');?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed; border-right: 1px dashed;">
        <b><?php echo number_format(number_float($ne->getTotal())*$tasa, 2, ',', '.');?></b>
      </td>
    </tr>
    <tr>
      <td colspan="4">
        <?php
        $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $total=number_format(number_float($ne->getTotal())*$tasa, 2, '.', '');
        list($pre_tot,$suf_tot)=explode(".",$total);
        echo "Son: Bs. ".mb_strtoupper($f->format($pre_tot))." CON ".mb_strtoupper($f->format($suf_tot));
        ?>
      </td>
    </tr>
  </table>

</div>
<?php
  if($ne->getEstatus()==4) {
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
  return floatval($number);
}
?>
