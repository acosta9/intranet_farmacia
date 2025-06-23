<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php include_title() ?>
  <link rel="shortcut icon" href="/images/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>#loading{width:100%;height:100%;top:0;left:0;position:fixed;display:block;opacity:.9;background-color:#e7f0f2f0;z-index:998;text-align:center}#loading-image{position:absolute;top:100px;left:28%;z-index:999}</style>
</head>
<?php if (!$sf_user->isAuthenticated()): ?>
  <body class="login-page">
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/css/adminlte.min.css">
    <link rel="stylesheet" href="/css/main3.css">
  <?php echo $sf_content ?>
<?php else : ?>
  <body id="bodynew" class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <script src="/js/jquery-3.5.1.min.js"></script>
    <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/js/adminlte.js"></script>

    <div id="loading">
      <img id="loading-image" src="/images/loading2.gif" alt="Loading..." />
    </div>
    <div class="wrapper">
      <?php include_component('sfAdminDash','header'); ?>
      <script src="/js/jquery.mask.min.js"></script>
      <script src="/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
      <script src="/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
      <script src="/plugins/string-mask/src/string-mask.js"></script>
      <script src="/js/main15.js"></script>

      <div class="content-wrapper" id="contenido_body">
        <div class="row">
          <div class="col-md-12" id="flash-error">
            <?php if ($sf_user->hasFlash('notice')): ?>
              <div id="alert" class="alert alert-success alert-dismissable" style="margin: 15px 15px 0px 15px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alerta!</h4>
                <?php echo mb_strtoupper($sf_user->getFlash('notice')) ?>
              </div>
            <?php endif; ?>
            <?php if ($sf_user->hasFlash('error')): ?>
              <div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>
                <?php echo mb_strtoupper($sf_user->getFlash('error')) ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php echo $sf_content ?>
      </div>
      <?php include_partial('sfAdminDash/footer'); ?>
    </div>

    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/css/adminlte.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/sans-pro/style.css">
    <link rel="stylesheet" href="/js/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    <script src="/js/select2/dist/js/select2.full.min.js"></script>
    <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<?php endif; ?>
  </body>
</html>
