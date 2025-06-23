<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['nombre']->renderLabel()?>
    <?php echo $form['nombre']->render(array('class' => 'form-control'))?>
    <?php if ($form['nombre']->renderError())  { echo $form['nombre']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['serial']->renderLabel()?>
    <?php echo $form['serial']->render(array('class' => 'form-control'))?>
    <?php if ($form['serial']->renderError())  { echo $form['serial']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4"></div>
<div class="col-md-4">
  <div class="form-group">
    <label for="producto_filters_catname">Categoria</label>
    <?php echo $form['catname']->render(array('class' => 'form-control'))?>
    <?php if ($form['catname']->renderError())  { echo $form['catname']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="producto_filters_compuesto_id">Compuesto</label>
    <?php echo $form['compuesto_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['compuesto_id']->renderError())  { echo $form['compuesto_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['laboratorio_id']->renderLabel()?>
    <?php echo $form['laboratorio_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['laboratorio_id']->renderError())  { echo $form['laboratorio_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="producto_filters_unidad_id">Presentacion</label>
    <?php echo $form['unidad_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['unidad_id']->renderError())  { echo $form['unidad_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['tipo']->renderLabel()?>
    <?php echo $form['tipo']->render(array('class' => 'form-control'))?>
    <?php if ($form['tipo']->renderError())  { echo $form['tipo']->renderError(); } ?>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <?php echo $form['destacado']->renderLabel()?>
    <?php echo $form['destacado']->render(array('class' => 'form-control'))?>
    <?php if ($form['destacado']->renderError())  { echo $form['destacado']->renderError(); } ?>
  </div>
</div>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#producto_filters_unidad_id").select2({ width: '100%' });
    $("#producto_filters_catname").select2({ width: '100%' });
    $("#producto_filters_creado_por").select2({ width: '100%' });
    $("#producto_filters_updated_por").select2({ width: '100%' });

    var comps=$("#comp_hidden").text();
    comps=comps.trim();
    if(comps.length>2) {
      var res = comps.split(";");
      for (index = 0; index < res.length; index++) {
        if(res[index].length>1) {
          var res2 = res[index].split("|");
          $("#producto_filters_compuesto_id").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
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
          $("#producto_filters_laboratorio_id").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
        }
      }
    }

    $("#producto_filters_compuesto_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("producto")."/getCompuestos"; ?>',
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

    $("#producto_filters_laboratorio_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("producto")."/getLaboratorios"; ?>',
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
