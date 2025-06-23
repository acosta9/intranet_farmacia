<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <?php echo $form['empresa_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['empresa_id']->renderError())  { echo $form['empresa_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6"></div>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#nota_entrega_filters_empresa_id").select2({ width: '100%' });
    $("#nota_entrega_filters_creado_por").select2({ width: '100%' });
    $("#nota_entrega_filters_updated_por").select2({ width: '100%' });
    $("#nota_entrega_filters_estatus").select2({ width: '100%'});
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
    $("#nota_entrega_filters_empresa_id option").each(function() {
      var id_old=$(this).val();
      var i=0;
      $("#empresas_usuario .item").each(function() {
        var id=$(this).text();
        if(id_old==id) {
          i=1;
        }
      });
      if(i==0) {
        if($("#nota_entrega_filters_empresa_id option[value='"+id_old+"']").is(':selected')) {
          j++;
        }
        $("#nota_entrega_filters_empresa_id option[value='"+id_old+"']").remove();
      }
    });
    if(j>0) {
      $('#nota_entrega_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
    if ($("#nota_entrega_filters_empresa_id").find('option:selected').length== 0) {
      $('#nota_entrega_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
  });
</script>