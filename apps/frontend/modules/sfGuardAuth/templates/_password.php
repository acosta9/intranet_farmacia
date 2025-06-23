<h4>Cambiar contraseña</h4>
<?php echo form_tag_for($form, '@sf_guard_user') ?>
  <?php echo $form->renderHiddenFields(false) ?>
  <?php if ($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
  <?php endif; ?>

  <input type="hidden" readonly="readonly" name="sf_guard_user[username]" value="1" id="sf_guard_user_username">
  <input type="hidden" readonly="readonly" name="sf_guard_user[first_name]" value="<?php echo $form->getObject()->getFirstName(); ?>" id="sf_guard_user_first_name">
  <input type="hidden" readonly="readonly" name="sf_guard_user[email_address]" value="<?php echo $form->getObject()->getEmailAddress(); ?>" id="sf_guard_user_email_address">
  <input type="hidden" readonly="readonly" name="sf_guard_user[url_imagen]" value="<?php echo $form->getObject()->getUrlImagen(); ?>" id="sf_guard_user_url_imagen">

  <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
    <label>Nueva contraseña</label>
    <input type="password" class="form-control" class="input-text" name="sf_guard_user[password]" id="sf_guard_user_password" required/>
  </div>

  <div class="form-group form-group-icon-left"><i class="fa fa-lock input-icon"></i>
    <label>Repetir nueva contraseña</label>
    <input type="password" class="form-control" class="input-text" name="sf_guard_user[password_again]" id="sf_guard_user_password_again" required/>
  </div>
  <hr />
  <input class="btn btn-susc" type="submit" value="Cambiar" />
</form>
