<?php
if(!$sf_params->get('id')=='0') {
  $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$sf_params->get('id'));
}
?>
<div id="cliente_price" style="display:none"><?php echo $cliente->getTipoPrecio()?></div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label for="orden_compra_razon_social">Razon social</label>
      <input value="<?php echo $cliente->getFullName()?>" type="text" class="form-control" readonly="readonly">
    </div>
  </div>
  <div class="col-md-3"></div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="orden_compra_doc_id">Doc. de Identidad</label>
      <input value="<?php echo $cliente->getDocId()?>" type="text" class="form-control" readonly="readonly">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="orden_compra_direccion">Direccion</label>
      <input value="<?php echo ($cliente->getDireccion()) ?>" type="text" class="form-control" readonly="readonly">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label for="orden_compra_telf">Telf</label>
      <input value="<?php echo $cliente->getTelf()?>" type="text" class="form-control" readonly="readonly">
    </div>
  </div>
</div>
