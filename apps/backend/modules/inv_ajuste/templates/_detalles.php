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
          <label for="inv_ajuste_det_inventario_id">Producto</label>
          <select name="inv_ajuste[inv_ajuste_det][<?php echo $num?>][inventario_id]" class="form-control inv_ajuste_det_inventario_id" id="inv_ajuste_inv_ajuste_det_<?php echo $num?>_inventario_id" required>
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group" id="inventario_det_id_<?php echo $num; ?>">
          <label for="inv_ajuste_det_inventario_det_id">Lote</label>
          <select name="inv_ajuste[inv_ajuste_det][<?php echo $num?>][inventario_det_id]" class="form-control inv_ajuste_det_inventario_det_id" id="inv_ajuste_inv_ajuste_det_<?php echo $num?>_inventario_det_id">
          </select>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="">Qty Act.</label>
          <input type="text" value="0" class="form-control numero2" id="qty_act_<?php echo $num; ?>" readonly>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="">Fecha Venc.</label>
          <input type="text" class="form-control dateonly" id="fvenc_act_<?php echo $num; ?>" readonly>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="">Tipo de Operacion</label>
          <?php echo $form['inv_ajuste_det'][$num]['tipo']->render(array('class' => 'form-control inv_ajuste_det_tipo'))?>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="inv_ajuste_det_qty">Cantidad</label>
          <?php echo $form['inv_ajuste_det'][$num]['qty']->render(array('class' => 'form-control onlyqty det_qty inv_ajuste_det_qty'))?>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="">Fecha Venc. Nueva</label>
          <?php echo $form['inv_ajuste_det'][$num]['fecha_venc']->render(array('class' => 'form-control dateonly inv_ajuste_det_fecha_venc', 'readonly' => 'readonly'))?>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="">Lote Nuevo</label>
          <?php echo $form['inv_ajuste_det'][$num]['lote']->render(array('class' => 'form-control inv_ajuste_det_lote'))?>
        </div>
      </div>
      <?php echo $form['inv_ajuste_det'][$num]['price_unit']->render(array('type' => 'hidden', 'class' => 'det_unit inv_ajuste_det_price_unit numero', 'readonly' => 'readonly'))?>
      <?php echo $form['inv_ajuste_det'][$num]['price_tot']->render(array('type' => 'hidden', 'class' => 'det_total inv_ajuste_det_price_tot numero',  'readonly' => 'readonly'))?>
    </div>
  </div>
</div>
<div><div><div>
<script>
  $(document).ready(function() {
    $("#inv_ajuste_inv_ajuste_det_<?php echo $num; ?>_inventario_id").select2({
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inv_ajuste")."/getProductos2"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term,
            did: $("#inv_ajuste_deposito_id").val()
          }
          // Query parameters will be ?search=[term]&type=public
          return query;
        },
        processResults: function (data) {
          var arr = []
          $.each(data, function (index, value) {
            var res = value.split("|");
            $("#inv_ajuste_inv_ajuste_det_<?php echo $num; ?>_price_unit").val(res[1]);
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
    $("#inv_ajuste_inv_ajuste_det_<?php echo $num; ?>_inventario_id").on('change', function(event){
      $('#inventario_det_id_<?php echo $num; ?>').load('<?php echo url_for('inv_ajuste/lote') ?>?id='+$("#inv_ajuste_inv_ajuste_det_<?php echo $num; ?>_inventario_id").val()+"&num="+<?php echo $num; ?>).fadeIn("slow");
      sumar();
    });

    $('.det_qty').keyup(function(){
      sumar();
    });
  });
</script>
