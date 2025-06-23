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
    <label for="kardex_filters_cod">Usuario</label>
    <?php echo $form['user_id']->render(array('class' => 'form-control'))?>
    <?php if ($form['user_id']->renderError())  { echo $form['user_id']->renderError(); } ?>
  </div>
</div>
<div class="col-md-8">
  <div class="form-group">
    <label for="kardex_filters_cod">Producto</label>
    <?php echo $form['producto']->render(array('class' => 'form-control'))?>
    <?php if ($form['producto']->renderError())  { echo $form['producto']->renderError(); } ?>
  </div>
</div>
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
    var prods=$("#prod_hidden").text();
    prods=prods.trim();
    if(prods.length>2) {
      var res = prods.split(";");
      for (index = 0; index < res.length; index++) {
        if(res[index].length>1) {
          var res2 = res[index].split("|");
          $("#kardex_filters_producto").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
        }
      }
    }
    $(".desc_id").each(function() {
      $(this).parent().attr('style', 'width: 30%');
    });
    var j=0;
    $("#kardex_filters_empresa_id option").each(function() {
      var id_old=$(this).val();
      var i=0;
      $("#empresas_usuario .item").each(function() {
        var id=$(this).text();
        if(id_old==id) {
          i=1;
        }
      });
      if(i==0) {
        if($("#kardex_filters_empresa_id option[value='"+id_old+"']").is(':selected')) {
          j++;
        }
        $("#kardex_filters_empresa_id option[value='"+id_old+"']").remove();
      }
    });
    if(j>0) {
      $('#kardex_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }
    if ($("#kardex_filters_empresa_id").find('option:selected').length== 0) {
      $('#kardex_filters_empresa_id option').prop('selected', true);
      $( "#form_filter" ).submit();
    }

    $("#kardex_filters_empresa_id").select2({ width: '100%' });
    $("#kardex_filters_deposito_id").select2({ width: '100%' });
    $("#kardex_filters_user_id").select2({ width: '100%' });

    var emps = [];
    $.each($("#kardex_filters_empresa_id option:selected"), function(){
      emps.push($(this).val());
    });
    var deposito_id=$('#kardex_filters_deposito_id').val();
    $('#kardex_filters_deposito_id').load('<?php echo url_for('kardex/depositoFilters') ?>?id='+emps.join(",")+'&did='+deposito_id).fadeIn("slow");
    
    $("#kardex_filters_empresa_id").on('change', function(event){
      var emps = [];
      $.each($("#kardex_filters_empresa_id option:selected"), function(){
        emps.push($(this).val());
      });
      $('#kardex_filters_deposito_id').hide();
      $('#kardex_filters_deposito_id').load('<?php echo url_for('kardex/depositoFilters') ?>?id='+emps.join(",")).fadeIn("slow");
    });

    $("#kardex_filters_producto").select2({
      width: '100%',
      multiple: false,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("kardex")."/getProductos"; ?>',
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

  });
</script>