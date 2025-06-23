<div class="col-md-6 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Nombre</label>
    <div class="col-sm-12">
        <?php echo $form['nombre']->render(array('class' => 'form-control'))?>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Serial</label>
    <div class="col-sm-12">
        <?php echo $form['serial']->render(array('class' => 'form-control'))?>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-12"></div>
<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Tipo</label>
    <div class="col-sm-12">
        <?php echo $form['tipo']->render(array('class' => 'form-control'))?>
    </div>
  </div>
</div>
<div class="col-md-3 col-sm-12">
  <div class="form-group">
    <label class="col-sm-12 control-label">Unidad</label>
    <div class="col-sm-12">
        <?php echo $form['unidad_id']->render(array('class' => 'form-control'))?>
    </div>
  </div>
</div>
<input value="1" type="hidden" name="producto[activo]" id="producto_activo">