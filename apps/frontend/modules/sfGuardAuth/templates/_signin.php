<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="login woocommerce-form woocommerce-form-login ">
  <?php echo $form['_csrf_token'] ?>
  <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide form-row-username">
    <label for="username">Usuario&nbsp;<span class="required">*</span></label>
    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="signin[username]" id="signin_username" value="" />
  </p>
  <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide form-row-password">
    <label for="password">Contraseña&nbsp;<span class="required">*</span></label>
    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="signin[password]" id="signin_password" autocomplete="current-password" />
  </p>
  <p class="form-row">
    <button type="submit" class="button woocommerce-button woocommerce-form-login__submit" name="login" value="Log in">Log in</button>
  </p>
</form>