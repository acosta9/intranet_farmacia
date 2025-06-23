</div></div></div>
<div class="card card-primary items" id="sf_fieldset_det_<?php echo $num."_".$eid?>">
  <div class="card-header">
    <h3 class="card-title">item [<?php echo $num ?>]</h3>
    <div class="card-tools">
      <a href="javascript:void(0)" class="btn btn-tool del_servicio" onclick="del_usuario(this)"><i class="fas fa-times"></i></a>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <?php echo $form['traslado_det'][$num]['producto_id']->render(array('class' => 'traslado_det_producto_id', 'type' => 'hidden'))?>
          <select name="traslado[traslado_det][<?php echo $num?>][inventario_id]" class="form-control traslado_det_inventario_id" id="traslado_traslado_det_<?php echo $num?>_inventario_id">
          </select>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <?php echo $form['traslado_det'][$num]['exento']->render(array('class' => 'form-control det_exento traslado_det_exento', 'readonly' => 'readonly'))?>
          </div>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <?php echo $form['traslado_det'][$num]['qty']->render(array('class' => 'form-control onlyqty det_qty traslado_det_qty', 'placeholder' => 'Cant.'))?>
        </div>
        <div class="form-group">
          <input class="form-control max_item" name="max_item" readonly id="traslado_traslado_det_<?php echo $num; ?>_max_item">
        </div>
      </div>
      <div class="col-md-2">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['traslado_det'][$num]['price_unit']->render(array('class' => 'form-control det_unit traslado_det_price_unit money_intern', 'readonly' => 'readonly'))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control det_unit_bs money_intern" type="text" id="traslado_det_unit_<?php echo $num?>_bs" readonly>
        </div>
      </div>
      <div class="col-md-3">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['traslado_det'][$num]['price_tot']->render(array('class' => 'form-control det_total traslado_det_price_tot money_intern', 'placeholder' => 'Total', 'readonly' => 'readonly'))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control det_total_bs money_intern" type="text" id="traslado_det_tot_<?php echo $num?>_bs" readonly>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>
<script>
  $(document).ready(function() {
    $("#traslado_traslado_det_<?php echo $num; ?>_inventario_id").select2({
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("traslado")."/getProductos2"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term,
            did: $("#traslado_deposito_desde").val()
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        },
        processResults: function (data) {
          var arr = []
          $.each(data, function (index, value) {
            var res = value.split("|");
            arr.push({
              id: index,
              text: res[0],
              price: res[1],
              produto_id: res[2],
              max: res[3]
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
      templateSelection: formatRepoSelection
    });

    function formatRepoSelection (repo) {
      var str=repo.price;
      var max=repo.max;
      var pid=repo.produto_id;
      if(max) {
        $("#traslado_traslado_det_<?php echo $num; ?>_price_unit").val(str);
        $("#traslado_traslado_det_<?php echo $num; ?>_max_item").val(max);
        $("#traslado_traslado_det_<?php echo $num; ?>_producto_id").val(pid);
        $("#traslado_traslado_det_<?php echo $num; ?>_exento").val("EXENTO");
      }
      return repo.text;
    }

    $('.onlyqty').mask("###0", {reverse: true});

    $('.money_intern').mask("#.##0,0000", {
      clearIfNotMatch: true,
      placeholder: "#,####",
      reverse: true
    });
  });

   $(function () {
    sumar();
    $("#traslado_traslado_det_<?php echo $num; ?>_inventario_id").on('change', function(event){
      sumar();
    });

    $('.det_qty').keyup(function(){
      sumar();
    });
  });
</script>
