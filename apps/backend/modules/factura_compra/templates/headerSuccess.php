<?php
if(!$sf_params->get('id')=='0') {
  $cliente=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$sf_params->get('id'));
}
?>
<?php if (!empty($cliente)): ?>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="factura_compra_razon_social">Razon social</label>
      <input value="<?php echo $cliente->getFullName()?>" type="text" name="factura_compra[razon_social]" class="form-control" readonly="readonly" id="factura_compra_razon_social">
    </div>
  </div>
  <div class="col-md-3"></div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="factura_compra_doc_id">Doc. de Identidad</label>
      <input value="<?php echo $cliente->getDocId()?>" type="text" name="factura_compra[doc_id]" class="form-control" readonly="readonly" id="factura_compra_doc_id">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="factura_compra_direccion">Direccion</label>
      <input value="<?php echo ($cliente->getDireccion()) ?>" type="text" name="factura_compra[direccion]" class="form-control" readonly="readonly" id="factura_compra_direccion">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="factura_compra_telf">Telf</label>
      <input value="<?php echo $cliente->getTelf()?>" type="text" name="factura_compra[telf]" class="form-control" readonly="readonly" id="factura_compra_telf">
    </div>
  </div>
</div>
<?php endif; ?>