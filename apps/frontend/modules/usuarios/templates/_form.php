<div class="gap"></div>

<div class="container p-t-105">
  <div class="row" data-gutter="60">
    <?php if ($form->hasErrors()): ?>
      <div class="alert alert-danger m-t-50">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error</strong>: Revisa los datos introducidos.
      </div>
    <?php endif; ?>
    <div class="col-md-4 margin-top">
      <h3>BIENVENIDOS A MAGUEY</h3>
      <p class="text-justify">Únete a nuestro mercado orgánico.</p>
    </div>
    <div class="col-md-4">
      <?php include_component('sfGuardAuth', 'signin'); ?>
    </div>
    <div class="col-md-4">
      <h3>NUEVO EN MAGUEY?</h3>

      <?php echo form_tag_for($form, '@sf_guard_user') ?>
        <?php echo $form->renderHiddenFields(false) ?>
        <?php if ($form->hasGlobalErrors()): ?>
          <?php echo $form->renderGlobalErrors() ?>
        <?php endif; ?>

        <input type="hidden" readonly="readonly" name="sf_guard_user[username]" value="1" id="sf_guard_user_username">


        <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
          <label>Nombre completo</label>
          <?php echo $form['first_name']->render(array('class' => 'form-control', 'placeholder' => 'e.j. John Doe')) ?>
          <?php echo $form['first_name']->renderError() ?>
        </div>
        <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-show"></i>
          <label>Correo</label>
          <?php echo $form['email_address']->render(array('class' => 'form-control', 'placeholder' => 'e.j. johndoe@gmail.com')) ?>
          <?php echo $form['email_address']->renderError() ?>
        </div>
        <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
          <label>Contraseña</label>
          <?php echo $form['password']->render(array('class' => 'form-control', 'placeholder' => 'mi contraseña', 'type' => 'password')) ?>
          <?php echo $form['password']->renderError() ?>
        </div>
        <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
          <label>Confirmar contraseña</label>
          <?php echo $form['password_again']->render(array('class' => 'form-control', 'placeholder' => 'mi contraseña', 'type' => 'password')) ?>
          <?php echo $form['password_again']->renderError() ?>
        </div>
        <input class="btn btn-susc" type="submit" value="Registrar" />
      </form>
    </div>
  </div>
</div>
