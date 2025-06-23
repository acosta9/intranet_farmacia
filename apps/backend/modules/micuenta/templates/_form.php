<div class="active tab-pane" id="activity">
  <h4 style="color: #3c8dbc">Registre su informacion de perfil aqui</h4>
  <hr>
  <form action="<?php echo url_for('micuenta/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php if (!$form->getObject()->isNew()): ?>
  <input type="hidden" name="sf_method" value="put" />
  <?php endif; ?>
  <?php echo $form->renderHiddenFields(false) ?>
  <div class="form-group">
    <label class="col-sm-4 control-label">Avatar:</label>
    <div class="col-sm-10 foto2">
      <?php echo $form['url_imagen']->render() ?>
      <?php echo $form['url_imagen']->renderError() ?>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-4 control-label">Cargo Laboral:</label>
    <div class="col-sm-10">
      <?php echo $form['cargo']->render(array('class' => 'form-control', 'readonly' => 'readonly')) ?>
      <?php echo $form['cargo']->renderError() ?>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-4 control-label">Nombre de usuario:</label>
    <div class="col-sm-10">
      <?php echo $form['username']->render(array('class' => 'form-control', 'readonly' => 'readonly')) ?>
      <?php echo $form['username']->renderError() ?>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-4 control-label">Nombre:</label>
    <div class="col-sm-10">
      <?php echo $form['full_name']->render(array('class' => 'form-control')) ?>
      <?php echo $form['full_name']->renderError() ?>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-4 control-label">Correo Electronico</label>
    <div class="col-sm-10">
      <?php echo $form['email_address']->render(array('class' => 'form-control')) ?>
      <?php echo $form['email_address']->renderError() ?>
    </div>
  </div>
  <input type="submit" class="btn btn-primary" value="Guardar" />
</div>
<div class="tab-pane" id="timeline">
  <h4 style="color: #3c8dbc">Cambia tu clave actual</h4>
  <hr>
  <div class="form-group">
    <label class="col-sm-4 control-label">Nueva Contraseña</label>
    <div class="col-sm-10">
      <?php echo $form['password']->render(array('class' => 'form-control')) ?>
      <?php echo $form['password']->renderError() ?>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-4 control-label">Vuelva a introducir la nueva contraseña</label>
    <div class="col-sm-10">
      <?php echo $form['password_again']->render(array('class' => 'form-control')) ?>
      <?php echo $form['password_again']->renderError() ?>
    </div>
  </div>
  <input type="submit" class="btn btn-primary" value="Cambiar Contraseña" />
</div>
</form>
<script>
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>