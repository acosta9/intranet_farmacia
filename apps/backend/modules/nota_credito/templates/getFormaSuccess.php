<label for="nota_credito_forma_pago_id">Forma de Pago</label>
<select name="nota_credito[forma_pago_id]" class="form-control" id="nota_credito_forma_pago_id">
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
  if($("#nota_credito_moneda").val()==1) {
    $('#nota_credito_monto').prop('readonly', true);
    $('#monto_bs').prop('readonly', false);
  } else {
    $('#nota_credito_monto').prop('readonly', false);
    $('#monto_bs').prop('readonly', true);
  }
});
</script>
