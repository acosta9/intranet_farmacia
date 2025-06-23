<label for="recibo_pago_compra_forma_pago_id">Forma de Pago</label>
<select name="recibo_pago_compra[forma_pago_id]" class="form-control" id="recibo_pago_compra_forma_pago_id">
<?php
$results = Doctrine_Query::create()
  ->select('fp.*')
  ->from('FormaPago fp')
  ->where('fp.moneda = ?', $sf_params->get('id'))
  ->andWhere('fp.activo=1')
  ->orderBy('fp.nombre ASC')
  ->execute();
foreach ($results as $result) {
  echo "<option value='".$result->getId()."'>".$result->getNombre()."</option>";
}
?>
</select>

<script>
$( document ).ready(function() {
  if($("#recibo_pago_compra_moneda").val()==1) {
    $('#recibo_pago_compra_monto').prop('readonly', true);
    $('#monto_bs').prop('readonly', false);
  } else {
    $('#recibo_pago_compra_monto').prop('readonly', false);
    $('#monto_bs').prop('readonly', true);
  }
});
</script>
