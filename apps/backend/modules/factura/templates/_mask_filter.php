<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <?php echo $form['empresa_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['empresa_id']->renderError())  { echo $form['empresa_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_filters_num_fact_fiscal">Fact Fiscal</label>
    <?php echo $form['num_fact_fiscal']->render(array('class' => 'form-control'))?>
    <?php if ($form['num_fact_fiscal']->renderError())  { echo $form['num_fact_fiscal']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_filters_ndespacho">Num Despacho</label>
    <?php echo $form['ndespacho']->render(array('class' => 'form-control'))?>
    <?php if ($form['ndespacho']->renderError())  { echo $form['ndespacho']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="factura_filters_num_factura">Num Factura</label>
    <?php echo $form['num_factura']->render(array('class' => 'form-control'))?>
    <?php if ($form['num_factura']->renderError())  { echo $form['num_factura']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <?php echo $form['razon_social']->renderLabel()?>
    <?php echo $form['razon_social']->render(array('class' => 'form-control'))?>
    <?php if ($form['razon_social']->renderError())  { echo $form['razon_social']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <?php echo $form['doc_id']->renderLabel()?>
    <?php echo $form['doc_id']->render(array('class' => 'form-control docid'))?>
    <?php if ($form['doc_id']->renderError())  { echo $form['doc_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <?php echo $form['estatus']->renderLabel()?>
    <?php echo $form['estatus']->render(array('class' => 'form-control'))?>
    <?php if ($form['estatus']->renderError())  { echo $form['estatus']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3"></div>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#factura_filters_empresa_id").select2({ width: '100%' });
    $("#factura_filters_creado_por").select2({ width: '100%' });
    $("#factura_filters_updated_por").select2({ width: '100%' });
    $("#factura_filters_estatus").select2({ width: '100%'});
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
    $("#factura_filters_empresa_id option").each(function() {
      var id_old=$(this).val();
      var i=0;
      $("#empresas_usuario .item").each(function() {
        var id=$(this).text();
        if(id_old==id) {
          i=1;
        }
      });
      if(i==0) {
        if($("#factura_filters_empresa_id option[value='"+id_old+"']").is(':selected')) {
          j++;
        }
        $("#factura_filters_empresa_id option[value='"+id_old+"']").remove();
      }
    });
    if(j>0) {
      $('#factura_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
    if ($("#factura_filters_empresa_id").find('option:selected').length== 0) {
      $('#factura_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
  });
</script>