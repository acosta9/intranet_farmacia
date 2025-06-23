<div class="gap"></div>

<div class="container p-t-105 form-sesion">
  <div class="row" data-gutter="60">
    <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="alert alert-success m-t-50">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $sf_user->getFlash('notice') ?>
      </div>
    <?php endif; ?>
    <?php if ($sf_user->hasFlash('error')): ?>
      <div class="alert alert-danger m-t-50">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo $sf_user->getFlash('error') ?>
      </div>
    <?php endif; ?>
    <div class="col-md-4 margin-top">
      <h3>BIENVENIDOS A MAGUEY</h3>
      <p class="text-justify">Únete a nuestro mercado orgánico.</p>
    </div>
    <div class="col-md-4">
      <?php include_component('sfGuardAuth', 'signin'); ?>
    </div>
    <div class="col-md-4">
      <?php include_component('sfGuardAuth', 'register'); ?>
    </div>
  </div>
</div>
