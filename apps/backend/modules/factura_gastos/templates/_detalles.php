</div></div></div>
<div class="card card-primary items" id="sf_fieldset_det_<?php echo $num; ?>">
  <div class="card-header">
    <h3 class="card-title">item [<?php echo $num ?>]</h3>
    <div class="card-tools">
      <a href="javascript:void(0)" class="btn btn-tool del_servicio" onclick="del_usuario(this)"><i class="fas fa-times"></i></a>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
        <?php echo $form['factura_gastos_det'][$num]['descripcion']->render(array('class' => "form-control det_descripcion factura_gastos_det_descripcion", 'placeholder' => 'Descripcion', 'style' => 'height: 6rem !important'))?>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <?php echo $form['factura_gastos_det'][$num]['qty']->render(array('class' => "form-control onlyqty_intern det_qty factura_gastos_det_qty", 'placeholder' => 'Cant.'))?>
        </div>
        <div class="row">
          <div class="col-md-12">
            <select name="factura_gastos[factura_gastos_det][<?php echo $num?>][exento]" id="factura_gastos_factura_gastos_det_<?php echo $num?>_exento" class="factura_gastos_det_exento det_exento form-control">
              <option value="EXENTO">EXENTO</option>
              <option value="NO_EXENTO">NO EXENTO</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['factura_gastos_det'][$num]['price_unit']->render(array('class' => "form-control det_unit factura_gastos_det_price_unit money_intern"))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control money_intern det_unit_bs" type="text" id="factura_gastos_det_unit_<?php echo $num?>_bs">
        </div>
      </div>
      <div class="col-md-3">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['factura_gastos_det'][$num]['price_tot']->render(array('class' => "form-control det_total factura_gastos_det_price_tot", 'placeholder' => 'Total', 'readonly' => 'readonly'))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control det_total_bs" type="text" id="factura_gastos_det_tot_<?php echo $num?>_bs" readonly>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>
<script>
  $(document).ready(function() {
    $('.onlyqty_intern').mask("###0", {reverse: true});

    $('.money_intern').mask("#.##0,0000", {
      clearIfNotMatch: true,
      placeholder: "#,####",
      reverse: true
    });

  });

  $(function () {

    $('.det_qty').keyup(function(){
      sumar();
    });

    $('.det_unit').keyup(function(){
      sumar();
    });

    $('.det_unit_bs').keyup(function(){
      sumarBs();
    });
  });
</script>