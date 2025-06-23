<div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="padding: .345rem .75rem; margin-top: 0.05rem;">+ OPCIONES</button>
  <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, -2px, 0px);">
    <?php if ($sf_user->hasCredential(array(  0 => 'compra2',))): ?>
      <a target="_blank" class="dropdown-item" href="<?php echo url_for("prod_vendidos_ranking")."/batchReporteGeneral"?>">REPORTE GENERAL</a>
    <?php endif; ?>
  </div>
</div>