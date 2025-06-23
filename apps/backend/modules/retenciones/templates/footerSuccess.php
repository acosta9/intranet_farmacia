<?php
$base_imponible=0;
$iva_impuesto=0;
$tasa=0;
if(!empty($sf_params->get('id'))) {
  $cuentasCobrar=Doctrine_Core::getTable('CuentasCobrar')->findOneBy('id',$sf_params->get('id'));
  if($cuentasCobrar) {
    $factura=Doctrine_Core::getTable('Factura')->findOneBy('id',$cuentasCobrar->getFacturaId());
    $tasa=number_float($factura->getTasaCambio());
    if($factura->getBaseImponible()<=0) {
      $base_imponible=number_float($factura->getSubTotal())*$tasa;
    } else {
      $base_imponible=number_float($factura->getBaseImponible())*$tasa;
    }
    $iva_impuesto=number_float($factura->getIvaMonto())*$tasa;    
  }
}
?>
<input type="hidden" id="ttasa" value="<?php echo  number_format($tasa, 4, ',', '.'); ?>"/>
<div class="col-md-3">
  <div class="form-group">
    <label for="retenciones_fecha">Fecha</label>
    <input type="text" name="retenciones[fecha]" id="retenciones_fecha" value="<?php $date2 = new DateTime(); echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" readonly="readonly">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label for="retenciones_num_recibo">Comprobante</label>
    <input type="text" name="retenciones[comprobante]" class="form-control" id="retenciones_comprobante"/>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label for="retenciones_tipo">Tipo</label>
    <select name="retenciones[tipo]" class="form-control" id="retenciones_tipo">
      <option value="1">IVA</option>
      <option value="2" selected>ISLR</option>
      <option value="3">TIMBRE FISCAL</option>
    </select>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <div class="col-sm-12 control-label pl-0">
      <label for="retenciones_url_imagen">Recibo</label>
    </div>
    <div class="col-sm-12 foto2 pl-0">
      <input type="file" name="retenciones[url_imagen]" class="retenciones_url_imagen form-control" style="width: 100% !important" id="retenciones_url_imagen">
    </div>
  </div>
</div>
<div class="col-md-3">
  <label for="retenciones_tasa_cambio">Base Imponible</label>
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">BS</span>
    </div>
    <input class="form-control money_intern" type="text" name="retenciones[base_imponible]" id="retenciones_base_imponible" value="<?php echo $base_imponible; ?>" readonly>
  </div>
</div>
<div class="col-md-3">
  <label for="retenciones_tasa_cambio">Impuesto Iva</label>
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">BS</span>
    </div>
    <input class="form-control money_intern" type="text" name="retenciones[iva_impuesto]" id="retenciones_iva_impuesto" value="<?php echo $iva_impuesto; ?>" readonly>
  </div>
</div>
<div class="col-md-3">
  <label for="retenciones_tasa_cambio">Monto Retenido</label>
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">BS</span>
    </div>
    <input class="form-control money_intern" type="text" name="retenciones[monto]" id="retenciones_monto">
  </div>
</div>
<div class="col-md-3">
  <label for="retenciones_tasa_cambio">Monto Retenido USD</label>
  <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text">USD</span>
    </div>
    <input class="form-control money_intern" type="text" name="retenciones[monto_usd]" id="retenciones_monto_usd" readonly>
  </div>
</div>

<script>
  $( document ).ready(function() {
    $('.money_intern').mask("#.##0,0000", {
      clearIfNotMatch: true,
      placeholder: "#,####",
      reverse: true
    });
    $('#retenciones_monto').keyup(function(){
      sumar();
    });
  });
  function sumar() {
    var tasa = 0;
    var monto = 0;
    var monto_usd = 0;
    if($("#ttasa").val()) {
      tasa = number_float($("#ttasa").val());
    }
    if($("#retenciones_monto").val()) {
      monto = number_float($("#retenciones_monto").val());
    }

    var monto_usd=monto/tasa;
    $("#retenciones_monto_usd").val(SetMoney(monto_usd));
  }
</script>

<?php
function number_float($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return $number;
}
?>
