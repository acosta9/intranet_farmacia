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
    <label for="inv_entrada_filters_cod">Codigo</label>
    <?php echo $form['cod']->render(array('class' => 'form-control'))?>
    <?php if ($form['cod']->renderError())  { echo $form['cod']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inv_entrada_filters_cod">Descripcion</label>
    <?php echo $form['descripcion']->render(array('class' => 'form-control'))?>
    <?php if ($form['descripcion']->renderError())  { echo $form['descripcion']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="inv_entrada_filters_anulado">Estatus</label>
    <?php echo $form['anulado']->render(array('class' => 'form-control'))?>
    <?php if ($form['anulado']->renderError())  { echo $form['anulado']->renderError(); } ?>
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
    $("#inv_salida_filters_empresa_id option").each(function() {
      var id_old=$(this).val();
      var i=0;
      $("#empresas_usuario .item").each(function() {
        var id=$(this).text();
        if(id_old==id) {
          i=1;
        }
      });
      if(i==0) {
        if($("#inv_salida_filters_empresa_id option[value='"+id_old+"']").is(':selected')) {
          j++;
        }
        $("#inv_salida_filters_empresa_id option[value='"+id_old+"']").remove();
      }
    });
    if(j>0) {
      $('#inv_salida_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
    if ($("#inv_salida_filters_empresa_id").find('option:selected').length== 0) {
      $('#inv_salida_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }

    $("#inv_salida_filters_empresa_id").select2({ width: '100%' });
    $("#inv_salida_filters_deposito_id").select2({ width: '100%' });
    $("#inv_salida_filters_creado_por").select2({ width: '100%' });
    $("#inv_salida_filters_updated_por").select2({ width: '100%' });
    $("#inv_salida_filters_unidad_id").select2({ width: '100%' });
    $("#inv_salida_filters_categoria_id").select2({ width: '100%' });

    var emps = [];
    $.each($("#inv_salida_filters_empresa_id option:selected"), function(){
      emps.push($(this).val());
    });
    var deposito_id=$('#inv_salida_filters_deposito_id').val();
    $('#inv_salida_filters_deposito_id').load('<?php echo url_for('inv_salida/depositoFilters') ?>?id='+emps.join(",")+'&did='+deposito_id).fadeIn("slow");

    var prods=$("#prod_hidden").text();
    prods=prods.trim();
    if(prods.length>2) {
      var res = prods.split(";");
      for (index = 0; index < res.length; index++) {
        if(res[index].length>1) {
          var res2 = res[index].split("|");
          $("#inv_salida_filters_producto").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
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
          $("#inv_salida_filters_compuesto_id").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
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
          $("#inv_salida_filters_laboratorio_id").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
        }
      }
    }

    $("#inv_salida_filters_producto").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inv_salida")."/getProductos"; ?>',
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

    $("#inv_salida_filters_compuesto_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inv_salida")."/getCompuestos"; ?>',
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

    $("#inv_salida_filters_laboratorio_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inv_salida")."/getLaboratorios"; ?>',
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
  $("#inv_salida_filters_empresa_id").on('change', function(event){
    var emps = [];
    $.each($("#inv_salida_filters_empresa_id option:selected"), function(){
      emps.push($(this).val());
    });
    $('#inv_salida_filters_deposito_id').hide();
    $('#inv_salida_filters_deposito_id').load('<?php echo url_for('inv_salida/depositoFilters') ?>?id='+emps.join(",")).fadeIn("slow");
  });  
</script>