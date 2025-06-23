<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <?php echo $form['empresa_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['empresa_id']->renderError())  { echo $form['empresa_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['cliente']->renderLabel()?>
    <?php echo $form['cliente']->render(array('class' => 'form-control'))?>
    <?php if ($form['cliente']->renderError())  { echo $form['cliente']->renderError(); } ?>
  </div>
</div>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#retenciones_filters_creado_por").select2({ width: '100%' });
    $("#retenciones_filters_empresa_id").select2({ width: '100%' });

    var moneda=$('#retenciones_filters_coin').val();
    var forma_pago=$('#retenciones_filters_forma_pago_id').val();
    $('#retenciones_filters_forma_pago_id').load('<?php echo url_for('retenciones/formaFilters') ?>?id='+moneda+'&fid='+forma_pago).fadeIn("slow");

  });
  $(function () {
    $("#retenciones_filters_coin").on('change', function(event){
      $('#retenciones_filters_forma_pago_id').hide();
      $('#retenciones_filters_forma_pago_id').load('<?php echo url_for('retenciones/formaFilters') ?>?id='+this.value).fadeIn("slow");
    });
  });
</script>

<?php
  $results = Doctrine_Query::create()
    ->select('e.id, e.nombre, eu.user_id')
    ->from('Empresa e')
    ->leftJoin('e.EmpresaUser eu')
    ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
    ->orderBy('e.nombre ASC')
    ->execute();
  echo "<div id='empresas_usuario' style='display:none'>";
  foreach ($results as $result) {
    echo "<div class='item'>".$result->getId()."</div>";
  }
  echo "</div>";
?>
<script type="text/javascript">
  $( document ).ready(function() {
    var j=0;
    $("#retenciones_filters_empresa_id option").each(function() {
      var id_old=$(this).val();
      var i=0;
      $("#empresas_usuario .item").each(function() {
        var id=$(this).text();
        if(id_old==id) {
          i=1;
        }
      });
      if(i==0) {
        if($("#retenciones_filters_empresa_id option[value='"+id_old+"']").is(':selected')) {
          j++;
        }
        $("#retenciones_filters_empresa_id option[value='"+id_old+"']").remove();
      }
    });
    if(j>0) {
      $('#retenciones_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
    if ($("#retenciones_filters_empresa_id").find('option:selected').length== 0) {
      $('#retenciones_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
  });
</script>
