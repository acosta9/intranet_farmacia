<div class="col-md-4">
  <div class="form-group">
    <label>CODIGO</label>
    <input type="text" value="<?php echo $form->getObject()->get('id') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-8"></div>
<div class="col-md-4">
  <div class="form-group">
    <label>EMPRESA</label>
    <input type="text" value="<?php echo $form->getObject()->get('Empresa') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>NOMBRE</label>
    <input type="text" value="<?php echo $form->getObject()->get('nombre') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>ACRONIMO</label>
    <input type="text" value="<?php echo $form->getObject()->get('acronimo') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>TIPO</label>
    <input type="text" value="<?php echo $form->getObject()->get('TipoDeposito') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>DESCRIPCION</label>
    <textarea class="form-control" readonly=""><?php echo $form->getObject()->get('descripcion') ?></textarea>
  </div>
</div>
