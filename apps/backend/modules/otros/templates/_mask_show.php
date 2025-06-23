<div class="col-md-6">
  <div class="form-group">
    <label>EMPRESA</label>
    <input type="text" value="<?php echo $form->getObject()->get('Empresa') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>TIPO TASA</label>
    <input type="text" value="<?php echo $otros->getTipoTasa(); ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>VALOR</label>
    <input type="text" value="<?php echo $form->getObject()->get('valor') ?>" class="form-control money" readonly="">
  </div>
</div>
