<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['direccion']->renderLabel()?>
    <?php echo $form['direccion']->render(array('class' => 'form-control'))?>
    <?php if ($form['direccion']->renderError())  { echo $form['direccion']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['descripcion']->renderLabel()?>
    <?php echo $form['descripcion']->render(array('class' => 'form-control'))?>
    <?php if ($form['descripcion']->renderError())  { echo $form['descripcion']->renderError(); } ?>
  </div>
</div>
<script src="/plugins/inputmask/jquery.inputmask.bundle.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    $( "form" ).submit(function( event ) {
      $('#loading').fadeIn( "slow", function() {});
    });
    $("[data-mask]").inputmask();
    $("#cliente_vendedor_01").select2({ width: '100%'});
    $("#cliente_vendedor_02").select2({ width: '100%'});
  });
</script>
