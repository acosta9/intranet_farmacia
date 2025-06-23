<?php
  use_helper('I18N');
?>

<div style="height: 100vh;">
  <div class="gx-app-login-wrap">
    <div class="gx-app-login-container">
      <div class="gx-app-login-main-content" style="background-image: url(/images/fondo<?php echo rand(1,3)?>.jpg);">
        <div class="gx-app-logo-content">
          <div class="gx-app-logo-wid">
            <h1>Iniciar Sesión</h1>
            <h5>Use un nombre de usuario y contraseña válido para poder tener acceso al sistema.</h5>
          </div>
        </div>
        <div class="gx-app-login-content">
          <div class="login-logo">
            <?php echo __('<a href="%siteref%" style="color: #000"><b>Intranet</b>%siteac%</a>', array('%siteref%' => sfAdminDash::getProperty('siteref'), '%siteac%' => sfAdminDash::getProperty('siteac'))) ?>
          </div>
          <form action="<?php echo url_for(sfAdminDash::getProperty('login_route', '@sf_guard_signin')); ?>" method="post">
            <?php echo $form->renderGlobalErrors(); ?>
            <?php if(isset($form['_csrf_token'])): ?>
              <?php echo $form['_csrf_token']->render(); ?>
            <?php endif; ?>
            <?php if($form['username']->renderError() || $form['password']->renderError()): ?>
              <div class="callout callout-danger">
                <h5> El usuario y/o contraseña no es válida.</h5>
              </div>
            <?php endif; ?>

            <div class="input-group mb-3">
              <?php echo $form['username']->render(array('class' => 'form-control', 'placeholder' => "Usuario")); ?>
                <div class="input-group-append input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Contraseña" id="signin_password" name="signin[password]">
              <div class="input-group-append input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember" style="color: #000">Recordarme</label>
                </div>
              </div>
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .gx-app-login-wrap {
  height: 100%;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: -ms-flex;
  display: flex;
  -webkit-flex-direction: column;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-flex-wrap: nowrap;
  -ms-flex-wrap: nowrap;
  flex-wrap: nowrap;
  -webkit-justify-content: center;
  -ms-justify-content: center;
  justify-content: center;
  overflow-x: hidden;
}
@media screen and (max-width: 575px) {
  .gx-app-login-wrap {
    padding-top: 20px;
    -webkit-justify-content: flex-start;
    -ms-justify-content: flex-start;
    justify-content: flex-start;
  }
}
.gx-app-login-container {
  position: relative;
  max-width: 680px;
  width: 94%;
  margin: 0 auto;
}
@media screen and (max-width: 575px) {
  .gx-app-login-container {
    padding-bottom: 20px ;
  }
}
.gx-app-login-container .gx-loader-view {
  position: absolute;
  left: 0;
  right: 0;
  text-align: center;
  top: 0;
  bottom: 0;
  z-index: 2;
}
.gx-app-login-main-content {
  display: -webkit-flex;
  display: -ms-flexbox;
  display: -ms-flex;
  display: flex;
  -webkit-flex-direction: row;
  -ms-flex-direction: row;
  flex-direction: row;
  -webkit-flex-wrap: wrap;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  background-color: #000000;
  -webkit-box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.03);
  -moz-box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.03);
  box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.03);
  -webkit-border-radius: 12px;
  -moz-border-radius: 12px;
  border-radius: 12px;
  font-size: 14px;
  overflow: hidden;
}
.gx-app-login-content {
  padding: 35px 35px 20px;
  width: 60%;
}
.gx-app-login-content .ant-input {
  background-color: #f5f5f5;
}
.gx-app-login-content .ant-input:focus {
  box-shadow: none;
  border-color: #038fde;
}
.gx-app-login-content .gx-btn {
  padding: 6px 35px !important;
  height: auto;
}
.gx-app-login-content .ant-form-item-control-wrapper {
  width: 100%;
}
.gx-app-login-content .ant-form-item-children {
  display: block;
}
@media screen and (max-width: 575px) {
  .gx-app-login-content {
    width: 100%;
    padding: 20px 20px 10px;
  }
}
.gx-app-login-header {
  margin-bottom: 30px;
}
@media screen and (max-width: 575px) {
  .gx-app-login-header {
    margin-bottom: 15px;
  }
}
  .gx-app-logo-content {
    color: #000;
    padding: 45px 55px 45px;
    width: 40%;
    position: relative;
    overflow: hidden;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: -ms-flex;
    display: flex;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    -webkit-flex-wrap: nowrap;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
  }
  .gx-app-logo-content > * {
    position: relative;
    z-index: 2;
  }
  .gx-app-logo-content h1 {
    color: #000;
  }
  @media screen and (max-width: 575px) {
  .gx-app-logo-content {
    width: 100%;
    padding: 20px 20px 10px;
  }
}
  .gx-app-logo-content-bg {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
  }
  .gx-app-logo-wid {
    z-index: 5;
      margin-bottom: auto;
  }

  .gx-app-login-main-content:before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1;
    right: 0;
    bottom: 0;
    background-color: #6d8cd2a8;
    border-radius: 12px;
  }
  .login-page, .register-page {
    background-color: #f5f5f5 !important;
  }
  .gx-app-login-content {
    z-index: 5;
    padding: 45px 35px 45px;
    width: 60%;
  }
  .gx-app-login-content .ant-input {
    background-color: #f5f5f5;
  }
  .gx-app-login-content .ant-input:focus {
    box-shadow: none;
    border-color: #038fde;
  }
  .gx-app-login-content .gx-btn {
    padding: 6px 35px !important;
    height: auto;
  }
  .gx-app-login-content .ant-form-item-control-wrapper {
    width: 100%;
  }
  .gx-app-login-content .ant-form-item-children {
    display: block;
  }
  @media screen and (max-width: 575px) {
  .gx-app-login-content {
    width: 100%;
    padding: 20px 20px 10px;
  }
}

</style>