<style> .table-list th:last-child, td:last-child, th:nth-last-child(2), td:nth-last-child(2), th:nth-last-child(3), td:nth-last-child(3) { text-align: right; } </style>
<div class="col-md-5">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <?php echo $form['empresa_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['empresa_id']->renderError())  { echo $form['empresa_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-5">
  <div class="form-group">
    <?php echo $form['proveedor']->renderLabel()?>
    <?php echo $form['proveedor']->render(array('class' => 'form-control'))?>
    <?php if ($form['proveedor']->renderError())  { echo $form['proveedor']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="cotizacion_compra_filters_ncontrol">N° Control</label>
    <?php echo $form['ncontrol']->render(array('class' => 'form-control'))?>
    <?php if ($form['ncontrol']->renderError())  { echo $form['ncontrol']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label for="cotizacion_compra_filters_estatus">Estatus</label>
    <?php echo $form['estatus']->render(array('class' => 'form-control'))?>
    <?php if ($form['estatus']->renderError())  { echo $form['estatus']->renderError(); } ?>
  </div>
</div>
<div class="col-md-9"></div>
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
    $("#cotizacion_compra_filters_empresa_id option").each(function() {
      var id_old=$(this).val();
      var i=0;
      $("#empresas_usuario .item").each(function() {
        var id=$(this).text();
        if(id_old==id) {
          i=1;
        }
      });
      if(i==0) {
        if($("#cotizacion_compra_filters_empresa_id option[value='"+id_old+"']").is(':selected')) {
          j++;
        }
        $("#cotizacion_compra_filters_empresa_id option[value='"+id_old+"']").remove();
      }
    });
    if(j>0) {
      $('#cotizacion_compra_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
    if ($("#cotizacion_compra_filters_empresa_id").find('option:selected').length== 0) {
      $('#cotizacion_compra_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }

    $("#cotizacion_compra_filters_empresa_id").select2({ width: '100%' });
    $("#cotizacion_compra_filters_creado_por").select2({ width: '100%' });
    $("#cotizacion_compra_filters_updated_por").select2({ width: '100%' });
    $("#cotizacion_compra_filters_estatus").select2({ width: '100%'});

    var prods=$("#prod_hidden").text();
    prods=prods.trim();
    if(prods.length>2) {
      var res = prods.split(";");
      for (index = 0; index < res.length; index++) {
        if(res[index].length>1) {
          var res2 = res[index].split("|");
          $("#cotizacion_compra_filters_proveedor").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
        }
      }
    }

    $("#cotizacion_compra_filters_proveedor").select2({
      width: '100%',
      multiple: false,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("cotizacion_compra")."/getProveedor"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term,
            eid: $("#cotizacion_compra_filters_empresa_id").val().toString()
          }
          return query;
        },
        processResults: function (data) {
          var arr = []
          $.each(data, function (index, value) {
            arr.push({
              id: index,
              text: value
            })
          })
          return {
            results: arr
          };
        },
        cache: false
      },
      placeholder: 'Busca un proveedor',
      minimumInputLength: 2,
    });

  });
</script>