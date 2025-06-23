<div class="col-md-6">
  <div class="form-group">
    <label for="proveedor_filters_full_name">Nombre</label>
    <?php echo $form['full_name']->render(array('class' => 'form-control'))?>
    <?php if ($form['full_name']->renderError())  { echo $form['full_name']->renderError(); } ?>
  </div>
</div>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#proveedor_filters_creado_por").select2({ width: '100%' });
    $("#proveedor_filters_updated_por").select2({ width: '100%' });
  });
</script>

