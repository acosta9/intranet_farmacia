<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_desde']->renderLabel()?>
    <?php echo $form['empresa_desde']->render(array('class' => 'form-control'))?>
    <?php if ($form['empresa_desde']->renderError())  { echo $form['empresa_desde']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['deposito_desde']->renderLabel()?>
    <?php echo $form['deposito_desde']->render(array('class' => 'form-control'))?>
    <?php if ($form['deposito_desde']->renderError())  { echo $form['deposito_desde']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_hasta']->renderLabel()?>
    <?php echo $form['empresa_hasta']->render(array('class' => 'form-control'))?>
    <?php if ($form['empresa_hasta']->renderError())  { echo $form['empresa_hasta']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['deposito_hasta']->renderLabel()?>
    <?php echo $form['deposito_hasta']->render(array('class' => 'form-control'))?>
    <?php if ($form['deposito_hasta']->renderError())  { echo $form['deposito_hasta']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['estatus']->renderLabel()?>
    <?php echo $form['estatus']->render(array('class' => 'form-control'))?>
    <?php if ($form['estatus']->renderError())  { echo $form['estatus']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6"></div>
<?php
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
  $userid=$sf_user->getGuardUser()->getId();
  $eid=$ename["srvid"];
  if($ename["tipo"]=="1") {
    $results = $q->execute("SELECT e.id as eid, e.nombre as nombre, e.acronimo as acronimo 
      FROM empresa as e
      LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
      WHERE eu.user_id=$userid && e.id IN ($eid)
      ORDER BY e.nombre ASC");
  } else {
    $results = $q->execute("SELECT e.id as eid, e.nombre as nombre, e.acronimo as acronimo 
      FROM empresa as e
      LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
      WHERE eu.user_id=$userid
      ORDER BY e.nombre ASC");
  }
  echo "<div id='empresas_usuario' style='display:none'>";
  foreach ($results as $result) {
    echo "<div class='item'>".$result["eid"]."</div>";
  }
  echo "</div>";
?>

<script type="text/javascript">
  $( document ).ready(function() {
    var j=0;
    $("#traslado_filters_empresa_hasta option").each(function() {
      var id_old=$(this).val();
      var i=0;
      $("#empresas_usuario .item").each(function() {
        var id=$(this).text();
        if(id_old==id) {
          i=1;
        }
      });
      if(i==0) {
        if($("#traslado_filters_empresa_hasta option[value='"+id_old+"']").is(':selected')) {
          j++;
        }
        $("#traslado_filters_empresa_hasta option[value='"+id_old+"']").remove();
      }
    });
    if(j>0) {
      $('#traslado_filters_empresa_hasta option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
    if ($("#traslado_filters_empresa_hasta").find('option:selected').length== 0) {
      $('#traslado_filters_empresa_hasta option').prop('selected', true);
      $( "#form_filter" ).submit();
    }

    $("#traslado_filters_empresa_desde").select2({ width: '100%' });
    $("#traslado_filters_empresa_hasta").select2({ width: '100%' });
    $("#traslado_filters_deposito_desde").select2({ width: '100%' });
    $("#traslado_filters_deposito_hasta").select2({ width: '100%' });
    $("#traslado_filters_estatus").select2({ width: '100%' });
    $("#traslado_filters_creado_por").select2({ width: '100%' });
    $("#traslado_filters_updated_por").select2({ width: '100%' });

    var emps = [];
    $.each($("#traslado_filters_empresa_desde option:selected"), function(){
      emps.push($(this).val());
    });
    var deposito_desde_id=$('#traslado_filters_deposito_desde').val();
    $('#traslado_filters_deposito_desde').load('<?php echo url_for('traslado/depositoFilters') ?>?id='+emps.join(",")+'&did='+deposito_desde_id).fadeIn("slow");

    var emps2 = [];
    $.each($("#traslado_filters_empresa_hasta option:selected"), function(){
      emps2.push($(this).val());
    });
    var deposito_hasta_id=$('#traslado_filters_deposito_hasta').val();
    $('#traslado_filters_deposito_hasta').load('<?php echo url_for('traslado/depositoFilters') ?>?id='+emps2.join(",")+'&did='+deposito_hasta_id).fadeIn("slow");
  });
  $(function () {
    $("#traslado_filters_empresa_desde").on('change', function(event){
      var emps = [];
      $.each($("#traslado_filters_empresa_desde option:selected"), function(){
        emps.push($(this).val());
      });
      $('#traslado_filters_deposito_desde').hide();
      $('#traslado_filters_deposito_desde').load('<?php echo url_for('traslado/depositoFilters') ?>?id='+emps.join(",")).fadeIn("slow");
    });
    $("#traslado_filters_empresa_hasta").on('change', function(event){
      var emps = [];
      $.each($("#traslado_filters_empresa_hasta option:selected"), function(){
        emps.push($(this).val());
      });
      $('#traslado_filters_deposito_hasta').hide();
      $('#traslado_filters_deposito_hasta').load('<?php echo url_for('traslado/depositoFilters') ?>?id='+emps.join(",")).fadeIn("slow");
    });
  });
</script>
