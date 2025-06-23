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
  <script src="/plugins/jquery/jquery.min.js"></script>
  <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
</head>
<?php if (!$sf_user->isAuthenticated()): ?>
  <body class="login-page">
    <?php echo $sf_content ?>
  </body>
<?php else : ?>
  <body>
    <?php echo $sf_content ?>
  </body>
<?php endif; ?>
</html>
