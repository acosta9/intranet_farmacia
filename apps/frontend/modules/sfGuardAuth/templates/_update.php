<h4>Información personal</h4>
<?php echo form_tag_for($form, '@sf_guard_user') ?>
  <?php echo $form->renderHiddenFields(false) ?>
  <?php if ($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
  <?php endif; ?>

  <input type="hidden" readonly="readonly" name="sf_guard_user[is_active]" value="<?php echo $form->getObject()->getIsActive(); ?>" id="sf_guard_user_is_active">
  <input type="hidden" readonly="readonly" name="sf_guard_user[is_super_admin]" value="<?php echo $form->getObject()->getIsSuperAdmin(); ?>" id="sf_guard_user_is_super_admin">
  <input type="hidden" readonly="readonly" name="sf_guard_user[username]" value="1" id="sf_guard_user_username">

  <div class="form-group form-group-icon-left"><i class="fa fa-file input-icon"></i>
    <label>Imagen de avatar</label>
    <div class="img-avatar">
      <?php
        $imagen=$form->getObject()->getUrlImagen();
        if($imagen) {
          echo "<img style='width: 50px; height: 50px; display: inline-block;' src='/uploads/sf_guard_user/".$imagen."' class='thumbnail'>";
        } else {
          echo "<img style='width: 50px; height: 50px; display: inline-block;' src='/images/user.png' class='thumbnail'>";
        }
      ?>
      <div class="foto2">
        <?php echo $form['url_imagen']->render() ?>
      </div>
    </div>
  </div>

  <div class="form-group form-group-icon-left"><i class="fa fa-user input-icon"></i>
    <label>Nombre Completo</label>
    <input class="form-control" type="text" placeholder="Nombre" name="sf_guard_user[first_name]" value="<?php echo $form->getObject()->getFirstName(); ?>" id="sf_guard_user_first_name" required>

  </div>
  <div class="form-group form-group-icon-left"><i class="fa fa-envelope input-icon"></i>
    <label>Correo</label>
    <input class="form-control" type="email" placeholder="Correo Electronico" name="sf_guard_user[email_address]" value="<?php echo $form->getObject()->getEmailAddress(); ?>" id="sf_guard_user_email_address" readonly="readonly">
  </div>
  <div class="gap gap-small"></div>
  <hr>

  <input type="submit" class="btn btn-susc" value="Guardar">

</form>
