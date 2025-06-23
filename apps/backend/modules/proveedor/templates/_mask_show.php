<div class="col-md-3">
  <div class="form-group">
    <label>CODIGO</label>
    <input type="text" value="<?php echo $form->getObject()->get('id') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3"></div>
<div class="col-md-6">
  <div class="form-group">
    <label>NOMBRE</label>
    <input type="text" value="<?php echo $form->getObject()->get('full_name') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>RIF/CI</label>
    <input type="text" value="<?php echo $form->getObject()->get('doc_id') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>TIPO DE PROVEEDOR</label>
    <input type="text" value="<?php echo $proveedor->getTipoTxt(); ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>TELEFONO (1)</label>
    <input type="text" value="<?php echo $form->getObject()->get('telf') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>TELEFONO (2)</label>
    <input type="text" value="<?php echo $form->getObject()->get('celular') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>CORREO ELECTRONICO</label>
    <input type="text" value="<?php echo $form->getObject()->get('email') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>DIRECCION</label>
    <textarea class="form-control" readonly=""><?php echo $form->getObject()->get('direccion') ?></textarea>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>DESCRIPCION</label>
    <textarea class="form-control" readonly=""><?php echo $form->getObject()->get('descripcion') ?></textarea>
  </div>
</div>
