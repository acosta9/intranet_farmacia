<?php use_helper('Date') ?>
<div class="container p-t-105 ">
  <h1 class="page-title">Mi cuenta</h1>
</div>

<div class="container">
  <div class="row">
    <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $sf_user->getFlash('notice') ?>
      </div>
    <?php endif; ?>
    <?php if ($sf_user->hasFlash('error')): ?>
      <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $sf_user->getFlash('error') ?>
      </div>
    <?php endif; ?>

    <div class="col-md-3">
      <aside class="user-profile-sidebar">
        <div class="user-profile-avatar text-center">
          <?php if ($sf_guard_user->getUrlImagen())  { ?>
            <img style="max-width: 120px; height: 120px;" src="/uploads/sf_guard_user/<?php echo $sf_guard_user->getUrlImagen(); ?>" alt="<?php echo $sf_guard_user->getFirstName(); ?>">
          <?php } else { ?>
            <img style="border-radius: 50%; max-width: 120px; height: 120px;" src="/images/user.png" alt="sin avatar">
          <?php } ?>
          <h5><?php echo $sf_guard_user->getFirstName(); ?></h5>
          <p>Miembro desde <?php echo format_datetime($sf_guard_user->getCreatedAt(), 'D', 'es_ES'); ?></p>
        </div>
        <ul class="list user-profile-nav">
          <li><a href="<?php echo url_for("user")?>/micuenta"><i class="fa fa-user"></i>Editar Perfil</a></li>
          <li><a href="<?php echo url_for("user")?>/favoritos"><i class="fa fa-heart"></i>Favoritos</a></li>
          <li><a href="<?php echo url_for("user")?>/historial"><i class="fa fa-clock-o"></i>Compras</a></li>
        </ul>
      </aside>
    </div>
    <div class="col-md-9">
      <div class="row form-sesion">
        <div class="col-md-5">
          <?php include_component('sfGuardAuth', 'update'); ?>
        </div>
        <div class="col-md-4 col-md-offset-1">
          <?php include_component('sfGuardAuth', 'password'); ?>
        </div>
      </div>
    </div>
  </div>
</div>
