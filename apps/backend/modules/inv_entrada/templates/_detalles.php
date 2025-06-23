</div></div></div>
<div class="card card-primary items" id="sf_fieldset_det_<?php echo $num?>">
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
          <label for="inv_entrada_det_inventario_id">Producto</label>
          <select name="inv_entrada[inv_entrada_det][<?php echo $num?>][inventario_id]" class="form-control inv_entrada_det_inventario_id" id="inv_entrada_inv_entrada_det_<?php echo $num?>_inventario_id" required>
          </select>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label for="inv_entrada_det_qty">Cant.</label>
          <?php echo $form['inv_entrada_det'][$num]['qty']->render(array('class' => 'form-control onlyqty det_qty inv_entrada_det_qty', 'placeholder' => 'Cant.'))?>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="inv_entrada_det_fecha_venc">Fecha Venc.</label>
          <?php echo $form['inv_entrada_det'][$num]['fecha_venc']->render(array('class' => 'form-control dateonly inv_entrada_det_fecha_venc', 'readonly' => 'readonly', 'required' => 'required'))?>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="inv_entrada_det_lote">Lote</label>
          <?php echo $form['inv_entrada_det'][$num]['lote']->render(array('class' => 'form-control inv_entrada_det_lote'))?>
        </div>
      </div>
      <?php echo $form['inv_entrada_det'][$num]['price_unit']->render(array('type' => 'hidden', 'class' => 'det_unit inv_entrada_det_price_unit', 'readonly' => 'readonly'))?>
      <?php echo $form['inv_entrada_det'][$num]['price_tot']->render(array('type' => 'hidden', 'class' => 'det_total inv_entrada_det_price_tot',  'readonly' => 'readonly'))?>
    </div>
  </div>
</div>
<div><div><div>
<script>
  $(document).ready(function() {
    $("#inv_entrada_inv_entrada_det_<?php echo $num; ?>_inventario_id").select2({
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inv_entrada")."/getProductos2"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term,
            did: $("#inv_entrada_deposito_id").val()
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        },
        processResults: function (data) {
          var arr = []
          $.each(data, function (index, value) {
            var res = value.split("|");
            $("#inv_entrada_inv_entrada_det_<?php echo $num; ?>_price_unit").val(res[1]);
            arr.push({
              id: index,
              text: res[0]
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

    $(".dateonly").datepicker({
      language: 'es',
      format: "yyyy-mm-dd"
    });

    $('.onlyqty').mask("###0", {reverse: true});
  });

  $(function () {
    $("#inv_entrada_inv_entrada_det_<?php echo $num; ?>_inventario_id").on('change', function(event){
      sumar();
    });

    $('.det_qty').keyup(function(){
      sumar();
    });
  });
</script>
