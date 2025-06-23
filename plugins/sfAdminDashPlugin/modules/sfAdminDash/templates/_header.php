<?php
if (!isset($called_from_component)):
  include_component('sfAdminDash', 'header');
else:
  use_helper('I18N');
  /** @var Array of menu items */ $items = $sf_data->getRaw('items');
  /** @var Array of categories, each containing an array of menu items and settings */ $categories = $sf_data->getRaw('categories');
  /** @var string|null Link to the module (for breadcrumbs) */ $module_link = $sf_data->getRaw('module_link');
  /** @var string|null Link to the action (for breadcrumbs) */ $action_link = $sf_data->getRaw('action_link');
?>

    <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
      <ul class="navbar-nav">
        <li class="nav-item">
          
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo url_for("@homepage") ?>" class="nav-link">Intranet</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo url_for ('@sf_guard_user_micuenta') ?>" class="nav-link">Mi Perfil</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <?php 
            $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
          ?>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <span class="badge bg-warning" style="margin: 0.7rem 0rem 0rem 0rem">
            <?php echo mb_strtoupper($ename["nombre"]); ?>
          </span>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-slide="true" href="<?php echo url_for ('@sf_guard_signout') ?>">
            <i class="fas fa-power-off"></i>
          </a>
        </li>
      </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="<?php echo url_for("@homepage"); ?>" class="brand-link">
        <img src="/images/logo.png" alt="farmacia" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Intranet</span>
      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php if($sf_user->getGuardUser()->getUrlImagen()) { ?>
              <img src="<?php echo "/uploads/sf_guard_user/".$sf_user->getGuardUser()->getUrlImagen() ?>" class="img-circle elevation-2" alt="User Image">
            <?php } else { ?>
              <img src="<?php echo "/images/user_icon.png" ?>" class="img-circle elevation-2" alt="User Image">
            <?php } ?>
          </div>
          <div class="info">
            <a href="<?php echo url_for ('@sf_guard_user_micuenta') ?>" class="d-block" id="avatar-name"><?php echo $sf_user->getGuardUser()->getFullName(); ?></a>
          </div>
        </div>
        <nav class="mt-2">
          <?php include_partial('sfAdminDash/menu', array('items' => $items, 'categories' => $categories)); ?>
        </nav>
      </div>
    </aside>

<?php endif; ?>
