<?php
if(!$sf_params->get('id')=='0') {
  $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$sf_params->get('id'));
}
?>
<div id="cliente_price" style="display:none"><?php echo $cliente->getTipoPrecio()?></div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="nota_entrega_razon_social">Razon social</label>
      <input value="<?php echo $cliente->getFullName()?>" type="text" name="nota_entrega[razon_social]" class="form-control" readonly="readonly" id="nota_entrega_razon_social">
    </div>
  </div>
  <div class="col-md-3"></div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="nota_entrega_doc_id">Doc. de Identidad</label>
      <input value="<?php echo $cliente->getDocId()?>" type="text" name="nota_entrega[doc_id]" class="form-control" readonly="readonly" id="nota_entrega_doc_id">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="nota_entrega_direccion">Direccion</label>
      <input value="<?php echo ($cliente->getDireccion()) ?>" type="text" name="nota_entrega[direccion]" class="form-control" readonly="readonly" id="nota_entrega_direccion">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="nota_entrega_telf">Telf</label>
      <input value="<?php echo $cliente->getTelf()?>" type="text" name="nota_entrega[telf]" class="form-control" readonly="readonly" id="nota_entrega_telf">
    </div>
  </div>
</div>

<script type="text/javascript">
  $( document ).ready(function() {
    $("#nota_entrega_dias_credito").val("<?php echo $cliente->getDiasCredito(); ?>");
  });
</script>
