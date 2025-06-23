<h3>NUEVO EN MAGUEY?</h3>

<?php echo form_tag_for($form, '@sf_guard_user') ?>
  <?php echo $form->renderHiddenFields(false) ?>
  <?php if ($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
  <?php endif; ?>

  <input type="hidden" readonly="readonly" name="sf_guard_user[username]" value="1" id="sf_guard_user_username">

  <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon input-icon-show"></i>
    <label>Nombre completo</label>
    <input name="sf_guard_user[first_name]" id="sf_guard_user_first_name" class="form-control" placeholder="e.j. John Doe" type="text" />
  </div>
  <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon input-icon-show"></i>
    <label>Correo</label>
    <input name="sf_guard_user[email_address]" id="sf_guard_user_email_address" class="form-control" placeholder="e.j. johndoe@gmail.com" type="text" />
  </div>
  <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
    <label>Contraseña</label>
    <input name="sf_guard_user[password]" id="sf_guard_user_password" class="form-control" type="password" placeholder="mi contraseña" />
  </div>
  <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon input-icon-show"></i>
    <label>Confirmar contraseña</label>
    <input name="sf_guard_user[password_again]" id="sf_guard_user_password_again" class="form-control" type="password" placeholder="mi contraseña" />
  </div>
  <input class="btn btn-susc" type="submit" value="Registrar" />
</form>
