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
          <label for="inv_salida_det_inventario_id">Producto</label>
          <select name="inv_salida[inv_salida_det][<?php echo $num?>][inventario_id]" class="form-control inv_salida_det_inventario_id" id="inv_salida_inv_salida_det_<?php echo $num?>_inventario_id" required>
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group" id="max_<?php echo $num; ?>">
          <label for="">Cant Act.</label>
          <input type="text" value="" class="form-control qty_max" id="qty_act_<?php echo $num;?>" readonly="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="inv_salida_det_qty">Cant. a salir</label>
          <?php echo $form['inv_salida_det'][$num]['qty']->render(array('class' => 'form-control onlyqty det_qty inv_salida_det_qty'))?>
        </div>
      </div>
      <?php echo $form['inv_salida_det'][$num]['price_unit']->render(array('type' => 'hidden', 'class' => 'det_unit inv_salida_det_price_unit numero', 'readonly' => 'readonly'))?>
      <?php echo $form['inv_salida_det'][$num]['price_tot']->render(array('type' => 'hidden', 'class' => 'det_total inv_salida_det_price_tot numero',  'readonly' => 'readonly'))?>
    </div>
  </div>
</div>
<div><div><div>
<script>
  $(document).ready(function() {
    $("#inv_salida_inv_salida_det_<?php echo $num; ?>_inventario_id").select2({
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inv_salida")."/getProductos2"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term,
            did: $("#inv_salida_deposito_id").val()
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        },
        processResults: function (data) {
          var arr = []
          $.each(data, function (index, value) {
            var res = value.split("|");
            $("#inv_salida_inv_salida_det_<?php echo $num; ?>_price_unit").val(res[1]);
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

    $('.onlyqty').mask("###0", {reverse: true});
  });

  $(function () {
    $("#inv_salida_inv_salida_det_<?php echo $num; ?>_inventario_id").on('change', function(event){
      $('#max_<?php echo $num; ?>').load('<?php echo url_for('inv_salida/qty') ?>?id='+$("#inv_salida_inv_salida_det_<?php echo $num; ?>_inventario_id").val()+"&num="+<?php echo $num; ?>).fadeIn("slow");
      sumar();
    });

    $('.det_qty').keyup(function(){
      sumar();
    });
  });
</script>
