<?php
if(!$sf_params->get('id')=='0') {
  $cliente=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$sf_params->get('id'));
}
?>
<?php if (!empty($cliente)): ?>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="nota_debito_razon_social">Razon social</label>
      <input value="<?php echo $cliente->getFullName()?>" type="text" class="form-control" readonly="readonly" id="nota_debito_razon_social">
    </div>
  </div>
  <div class="col-md-3"></div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="nota_debito_doc_id">Doc. de Identidad</label>
      <input value="<?php echo $cliente->getDocId()?>" type="text" class="form-control" readonly="readonly" id="nota_debito_doc_id">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="nota_debito_direccion">Direccion</label>
      <input value="<?php echo ($cliente->getDireccion()) ?>" type="text" class="form-control" readonly="readonly" id="nota_debito_direccion">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="nota_debito_telf">Telf</label>
      <input value="<?php echo $cliente->getTelf()?>" type="text" class="form-control" readonly="readonly" id="nota_debito_telf">
    </div>
  </div>
</div>
<?php endif; ?>
<script>
  $('#loading').fadeOut( "slow", function() {});
</script>