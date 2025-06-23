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
          <select name="orden_compra[orden_compra_det][<?php echo $num?>][inventario_id]" class="form-control orden_compra_det_inventario_id" id="orden_compra_orden_compra_det_<?php echo $num?>_inventario_id">
          </select>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <?php echo $form['orden_compra_det'][$num]['qty']->render(array('class' => 'form-control onlyqty det_qty orden_compra_det_qty', 'placeholder' => 'Cant.'))?>
        </div>
        <div class="form-group">
          <input class="form-control max_item numero2" name="max_item" readonly id="orden_compra_orden_compra_det_<?php echo $num; ?>_max_item">
        </div>
      </div>
      <div class="col-md-2">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['orden_compra_det'][$num]['price_unit']->render(array('class' => 'form-control det_unit orden_compra_det_price_unit money_intern', 'readonly' => 'readonly'))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control det_unit_bs numero" type="text" id="orden_compra_det_unit_<?php echo $num?>_bs" readonly>
        </div>
      </div>
      <div class="col-md-3">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['orden_compra_det'][$num]['price_tot']->render(array('class' => 'form-control det_total orden_compra_det_price_tot money_intern', 'placeholder' => 'Total', 'readonly' => 'readonly'))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control det_total_bs numero" type="text" id="orden_compra_det_tot_<?php echo $num?>_bs" readonly>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>
<script>
  var select = document.getElementById("orden_compra_orden_compra_det_<?php echo $num; ?>_inventario_id");
  $( "#prods .item" ).each(function( index,element ) {
    var id=$(this).find(".id").text();
    var name=$(this).find(".name").text();
    var serial=$(this).find(".serial").text();
    var tipo_precio = $("#cliente_price").text();

    var precio = parseFloat($(this).find(".price_"+tipo_precio).text());
    if(precio>0) {
      var el = document.createElement("option");
      el.textContent = name+" ["+serial+"]";
      el.value = id;
      select.appendChild(el);
    }
  });

  $(function () {
    $('.money_intern').mask("#.##0,0000", {
        clearIfNotMatch: true,
        placeholder: "#,####",
        reverse: true
      });
    $('.onlyqty').mask("###0", {reverse: true});
    item_prod(<?php echo $num; ?>);
    sumar();
    $("#orden_compra_orden_compra_det_<?php echo $num; ?>_inventario_id").on('change', function(event){
      item_prod(<?php echo $num; ?>);
      sumar();
    });

    $("#orden_compra_orden_compra_det_<?php echo $num; ?>_inventario_id").select2({ width: '100%'});
    $('.det_qty').keyup(function(){
      sumar();
    });
  });
</script>
