<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Mi Perfil</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage")?>">Inicio</a></li>
          <li class="breadcrumb-item active">Mi Perfil</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <?php if ($imagen=$form->getObject()->getUrlImagen())  { ?>
                <img class="profile-user-img img-fluid img-circle" src="/uploads/sf_guard_user/<?php echo $imagen; ?>" alt="<?php echo $form->getObject()->getNombre(); ?>">
              <?php } else { ?>
                <img class="profile-user-img img-fluid img-circle" src="/images/user_icon.png" alt="sin avatar">
              <?php } ?>
            </div>
            <h3 class="profile-username text-center"><?php echo $form->getObject()->getNombre(); ?></h3>
            <p class="text-muted text-center"><?php echo $form->getObject()->getCargo(); ?></p>
          </div>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Perfil</a></li>
              <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Contraseña</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
                <?php include_partial('form', array('form' => $form)) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
