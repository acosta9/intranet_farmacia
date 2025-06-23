<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <?php echo $form['empresa_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['empresa_id']->renderError())  { echo $form['empresa_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['deposito_id']->renderLabel()?>
    <?php echo $form['deposito_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['deposito_id']->renderError())  { echo $form['deposito_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inventario_filters_activo">Cod</label>
    <?php echo $form['cod']->render(array('class' => 'form-control'))?>
    <?php if ($form['cod']->renderError())  { echo $form['cod']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inventario_filters_activo">Estatus</label>
    <?php echo $form['activo']->render(array('class' => 'form-control'))?>
    <?php if ($form['activo']->renderError())  { echo $form['activo']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inventario_filters_activo">Destacado</label>
    <?php echo $form['destacado']->render(array('class' => 'form-control'))?>
    <?php if ($form['destacado']->renderError())  { echo $form['destacado']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="inventario_filters_cantidad">Cantidad Mayor que</label>
    <?php echo $form['qty_mayor']->render(array('class' => 'form-control'))?>
    <?php if ($form['qty_mayor']->renderError())  { echo $form['qty_mayor']->renderError(); } ?>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
  <label for="inventario_filters_cantidad">Cantidad Menor que</label>
    <?php echo $form['qty_menor']->render(array('class' => 'form-control'))?>
    <?php if ($form['qty_menor']->renderError())  { echo $form['qty_menor']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
  <label for="inventario_filters_cantidad">Vencidos</label>
    <?php echo $form['vencido']->render(array('class' => 'form-control'))?>
    <?php if ($form['vencido']->renderError())  { echo $form['vencido']->renderError(); } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
  <label for="inventario_filters_cantidad">Proximo a vencerse</label>
    <?php echo $form['proximo_vencer']->render(array('class' => 'form-control dateonly', 'readonly' => 'readonly'))?>
    <?php if ($form['proximo_vencer']->renderError())  { echo $form['proximo_vencer']->renderError(); } ?>
  </div>
</div>
<div class="col-md-8">
  <div class="form-group">
    <label for="inv_entrada_filters_cod">Producto</label>
    <?php echo $form['producto']->render(array('class' => 'form-control'))?>
    <?php if ($form['producto']->renderError())  { echo $form['producto']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4"></div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inv_entrada_filters_cod">Categoria</label>
    <?php echo $form['categoria_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['categoria_id']->renderError())  { echo $form['categoria_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inv_entrada_filters_cod">Compuesto</label>
    <?php echo $form['compuesto_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['compuesto_id']->renderError())  { echo $form['compuesto_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inv_entrada_filters_cod">Laboratorio</label>
    <?php echo $form['laboratorio_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['laboratorio_id']->renderError())  { echo $form['laboratorio_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inv_entrada_filters_cod">Presentacion</label>
    <?php echo $form['unidad_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['unidad_id']->renderError())  { echo $form['unidad_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inv_entrada_filters_cod">Tipo</label>
    <?php echo $form['tipo']->render(array('class' => 'form-control'))?>
    <?php if ($form['tipo']->renderError())  { echo $form['tipo']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4"></div>

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
    $("#inventario_filters_empresa_id option").each(function() {
      var id_old=$(this).val();
      var i=0;
      $("#empresas_usuario .item").each(function() {
        var id=$(this).text();
        if(id_old==id) {
          i=1;
        }
      });
      if(i==0) {
        if($("#inventario_filters_empresa_id option[value='"+id_old+"']").is(':selected')) {
          j++;
        }
        $("#inventario_filters_empresa_id option[value='"+id_old+"']").remove();
      }
    });
    if(j>0) {
      $('#inventario_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
    if ($("#inventario_filters_empresa_id").find('option:selected').length== 0) {
      $('#inventario_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }

    $("#inventario_filters_empresa_id").select2({ width: '100%' });
    $("#inventario_filters_creado_por").select2({ width: '100%' });
    $("#inventario_filters_updated_por").select2({ width: '100%' });
    $("#inventario_filters_deposito_id").select2({ width: '100%' });

    $("#inventario_filters_unidad_id").select2({ width: '100%' });
    $("#inventario_filters_categoria_id").select2({ width: '100%' });
    $("#inventario_filters_compuesto_id").select2({ width: '100%' });
    $("#inventario_filters_laboratorio_id").select2({ width: '100%' });

    var emps = [];
    $.each($("#inventario_filters_empresa_id option:selected"), function(){
      emps.push($(this).val());
    });
    var deposito_id=$('#inventario_filters_deposito_id').val();
    $('#inventario_filters_deposito_id').load('<?php echo url_for('inventario/depositoFilters') ?>?id='+emps.join(",")+'&did='+deposito_id).fadeIn("slow");

    $("#inventario_filters_empresa_id").on('change', function(event){
      var emps = [];
      $.each($("#inventario_filters_empresa_id option:selected"), function(){
        emps.push($(this).val());
      });
      $('#inventario_filters_deposito_id').hide();
      $('#inventario_filters_deposito_id').load('<?php echo url_for('inventario/depositoFilters') ?>?id='+emps.join(",")).fadeIn("slow");
    });

    var prods=$("#prod_hidden").text();
    prods=prods.trim();
    if(prods.length>2) {
      var res = prods.split(";");
      for (index = 0; index < res.length; index++) {
        if(res[index].length>1) {
          var res2 = res[index].split("|");
          $("#inventario_filters_producto").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
        }
      }
    }

    var comps=$("#comp_hidden").text();
    comps=comps.trim();
    if(comps.length>2) {
      var res = comps.split(";");
      for (index = 0; index < res.length; index++) {
        if(res[index].length>1) {
          var res2 = res[index].split("|");
          $("#inventario_filters_compuesto_id").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
        }
      }
    }

    var labs=$("#lab_hidden").text();
    labs=labs.trim();
    if(labs.length>2) {
      var res = labs.split(";");
      for (index = 0; index < res.length; index++) {
        if(res[index].length>1) {
          var res2 = res[index].split("|");
          $("#inventario_filters_laboratorio_id").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
        }
      }
    }

    $("#inventario_filters_producto").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inventario")."/getProductos"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term
          }
          // Query parameters will be ?search=[term]&type=public
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
      placeholder: 'Busca un producto',
      minimumInputLength: 2,
    });

    $("#inventario_filters_compuesto_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inventario")."/getCompuestos"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term
          }
          // Query parameters will be ?search=[term]&type=public
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
      placeholder: 'Busca un compuesto',
      minimumInputLength: 2,
    });

    $("#inventario_filters_laboratorio_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inventario")."/getLaboratorios"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term
          }
          // Query parameters will be ?search=[term]&type=public
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
      placeholder: 'Busca un laboratorio',
      minimumInputLength: 2,
    });

  });

</script>