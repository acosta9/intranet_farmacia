<?php use_helper('Date') ?>
<div class="container p-t-105">
  <h1 class="page-title">Productos / Foodfits favoritos</h1>
</div>

<div class="container">
  <div class="row">
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
      <div class="row">
        <?php foreach($favoritos as $favorito) { ?>
          <div class="col-md-3 th-thumb">
            <?php if($favorito->getTipo()=="1") { ?>
              <a href="<?php echo url_for('producto/show?id='.$favorito->getProductoId()); ?>"><img src="/uploads/producto/<?php echo $favorito->getUrlImagen() ?>" alt="<?php echo $favorito->getNombre() ?>" title="<?php echo $favorito->getNombre() ?>" class="thumbnail"/></a>
              <h5><a href="<?php echo url_for('producto/show?id='.$favorito->getProductoId()); ?>"><?php echo $favorito->getNombre() ?></a></h5>
            <?php } else {?>
              <a href="<?php echo url_for('foodfit/show?id='.$favorito->getProductoId()); ?>"><img src="/uploads/foodfit/<?php echo $favorito->getUrlImagen() ?>" alt="<?php echo $favorito->getNombre() ?>" title="<?php echo $favorito->getNombre() ?>" class="thumbnail"/></a>
              <h5><a href="<?php echo url_for('foodfit/show?id='.$favorito->getProductoId()); ?>"><?php echo $favorito->getNombre() ?></a></h5>
            <?php } ?>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
