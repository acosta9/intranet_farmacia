<style>
p {
  margin-top: 2px !important;
  margin-bottom: 2px !important;
}
</style>
<?php
  $traslado=Doctrine_Core::getTable('Traslado')->findOneBy('id',$sf_params->get('id'));
  $empresa_origen=Doctrine_Core::getTable('Empresa')->findOneBy('id',$traslado->getEmpresaDesde());
  $empresa_destino=Doctrine_Core::getTable('Empresa')->findOneBy('id',$traslado->getEmpresaHasta());
  $inv_origen=Doctrine_Core::getTable('InvDeposito')->findOneBy('id',$traslado->getDepositoDesde());
  $inv_destino=Doctrine_Core::getTable('InvDeposito')->findOneBy('id',$traslado->getDepositoHasta());
  $tasa=number_float($traslado->getTasaCambio());
  $hinit="2.6";
?>
  <?php //<span style="position: absolute; left: 4cm; top: 4cm"></span> ?>
<div style="font-size: 12px; max-width: 20cm; height: 27cm; ">
  <table style="position: absolute; left:0.6cm; top: 0.6cm; width: 20.4cm; font-size: 12px !important;">
    <tbody>
      <td colspan="4">
        <img src='/images/<?php echo $empresa_origen->getId()?>.png' height="50"/>
      </td>
      <td colspan="4">
        <address style="text-align: right; font-size: 11px">
          <strong><?php echo mb_strtoupper($empresa_origen->getNombre()." | ".$empresa_origen->getRif()); ?></strong><br>
          <span class="tcaps"><?php echo mb_strtolower($empresa_origen->getDireccion()); ?></span><br>
          Telf: <?php echo $empresa_origen->getTelefono(); ?><br>
          Email: <?php echo $empresa_origen->getEmail(); ?>
        </address>
      </td>
    </tbody>
  </table>
  <table style="position: absolute; left: 0.6cm; top: <?php echo $hinit.'cm'; ?>; width: 14.5cm; height: 2cm; border-spacing: 0px; font-size: 12px !important;">
    <tr>
      <td class="ball tpadd" style="border: 1px solid #000 !important;">
        Traslado de Mercancia<br/><br/>
        <b>DESDE:</b> <?php echo $empresa_origen->getNombre()." - <b>".$inv_origen->getNombre(); ?></b><br/>
        <b>HASTA:</b> <?php echo $empresa_destino->getNombre()." - <b>".$inv_destino->getNombre(); ?></b><br/>
      </td>
    </tr>
  </table>
  <table style="position: absolute; left: 15.8cm; top: <?php echo $hinit.'cm'; $hinit+=2.5; ?>; width: 5.2cm; height: 2cm; border-spacing: 0px; font-size: 12px !important;">
    <tr style="text-align: right">
      <td class="bleft bright btop tpadd" colspan="2">
        <h2 style="margin: 0px !important; padding: 0px !important;">TRASLADO: #<?php echo $traslado->getId(); ?></h2>
      </td>
    </tr>
    <tr style="text-align: right">
      <td class="bleft bright tpadd">
        <b>Fecha de Emisión:</b> <?php echo(date("d/m/Y", strtotime($traslado->getCreatedAt()))); ?>
      </td>
    </tr>
    <tr style="text-align: right">
      <td class="bleft bright bbottom tpadd">
        <b>Emitido Por:</b> <?php echo $traslado->getCreator(); ?>
      </td>
    </tr>
  </table>
  <table style="position: absolute; left: 0.6cm; top: <?php echo $hinit.'cm'; ?>; border-spacing: 0px; font-size: 12px !important;">
    <thead>
      <tr>
        <td style="width: 2.5cm; border-top: 1px dashed; border-bottom: 1px dashed;">
          <b>CODIGO</b>
        </td>
        <td style="width: 8cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: justify">
          <b>ARTICULO</b>
        </td>
        <td style="width: 2.5cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: justify">
          <b>Lote/FVenc</b>
        </td>
        <td style="width: 1cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: right">
          <b>QTY</b>
        </td>
        <td style="width: 3cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: right">
          <b>PRECIO<br/>UNIT.</b>
        </td>
        <td style="width: 3cm; border-top: 1px dashed; border-bottom: 1px dashed; text-align: right">
          <b>TOTAL<br/>NETO</b>
        </td>
      </tr>
    </thead>
    <tbody>
    <?php
    $results = Doctrine_Query::create()
      ->select('td.qty, td.qty_dest, td.price_unit, td.price_tot,
      LOWER(p.nombre) as nombre, p.serial as serial, td.descripcion AS descrip')
      ->from('TrasladoDet td, td.Producto p')
      ->where('td.traslado_id=?', $traslado->getId())
      ->orderBy('td.id ASC')
      ->execute();
      $j=0;
      foreach ($results as $result) {
        $j++;

        $lote = "N/A";
        $fvence = "";

        $findLote = explode(';', $result["descrip"]);
        list($idRenglon, $unidades, $fvence, $lote) = explode("|", $findLote[0]);

        $fvence = explode("-", $fvence);

    ?>
      <tr>
        <td><?php echo $result["serial"] ?></td>
        <td style="text-align: justify"><?php echo ucwords($result["nombre"]) ?></td>
        <td style="text-align: left; font-size: xx-small;"><strong><?php echo ucwords($lote)?></strong><?php echo "/".$fvence[1]."-".substr($fvence[0], 2, 2); ?></td>
        <td style="text-align: right"><?php echo $result["qty"]; ?></td>
        <td style="text-align: right"><?php echo number_format(number_float($result["price_unit"])*$tasa, 2, ',', '.');?></td>
        <td style="text-align: right"><?php echo number_format(number_float($result["price_tot"])*$tasa, 2, ',', '.');?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
  <table style="position: absolute; left: 0.6cm; top: 24.7cm; width: 20cm; border-spacing: 0px; font-size: 12px !important;">
    <tr>
      <td class="tpadd tcenter" style="width: 6cm; border-top: none;">
      </td>
      <td class="tpadd tright bleft btop" style="width: 4cm;">
        <b>CANTIDAD DE LINEAS: </b>
      </td>
      <td class="tpadd tleft btop bright" style="width: 4cm;">
        <b><?php echo number_format($j, 0, ',', ' '); ?></b>
      </td>
      <td class="tpadd tright" style="width: 6cm;">
      </td>
    </tr>
    <tr>
      <td class="tpadd tcenter" style="width: 6cm; border-top: none;">
      </td>
      <td class="tpadd tright bleft bbottom" style="width: 4cm;">
        <b>MONTO TOTAL: </b>
      </td>
      <td class="tpadd tleft bbottom bright" style="width: 4cm;">
        <b><?php echo number_format(number_float($traslado->getMonto())*$tasa, 2, ',', '.'); ?></b>
      </td>
      <td class="tpadd tright" style="width: 6cm;">
      </td>
    </tr>
  </table>
  <table style="position: absolute; left: 0.6cm; top: 25cm; width: 20cm; border-spacing: 0px; font-size: 12px !important;">
    <tr>
      <td class="tpadd tcenter" style="width: 4cm; border-top: none;">
        <b>__________________</b>
      </td>
      <td class="tpadd tright" style="width: 4cm;">
        <b></b>
      </td>
      <td class="tpadd tright" style="width: 4cm;">
        <b></b>
      </td>
      <td class="tpadd tright" style="width: 4cm;">
        <b></b>
      </td>
      <td class="tpadd tcenter" style="width: 4cm;">
        <b>__________________</b>
      </td>
    </tr>
    <tr>
      <td class="tpadd tcenter" style="border-bottom: 1px dashed;">
        <b><?php echo "Autorizado Por:";?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed;">
        <b><?php echo "";?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed;">
        <b><?php echo "";?></b>
      </td>
      <td class="tpadd tright" style="border-bottom: 1px dashed;">
        <b><?php echo "";?></b>
      </td>
      <td class="tpadd tcenter" style="border-bottom: 1px dashed;">
        <b><?php echo "Emitido Por";?></b>
      </td>
    </tr>
  </table>

</div>
<?php
  if($traslado->getEstatus()==3) {
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
