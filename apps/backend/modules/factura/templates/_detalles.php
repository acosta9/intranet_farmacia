<?php if(empty($pid)): ?>
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
            <select name="factura[factura_det][<?php echo $num?>][inventario_id]" class="form-control factura_det_inventario_id" id="factura_factura_det_<?php echo $num?>_inventario_id">
            </select>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <?php echo $form['factura_det'][$num]['exento']->render(array('class' => 'form-control det_exento factura_det_exento', 'readonly' => 'readonly'))?>
            </div>
          </div>
        </div>
        <div class="col-md-1">
          <div class="form-group">
            <?php echo $form['factura_det'][$num]['qty']->render(array('class' => 'form-control onlyqty det_qty factura_det_qty', 'placeholder' => 'Cant.'))?>
          </div>
          <div class="form-group">
            <input class="form-control max_item onlyqty" name="max_item" readonly id="factura_factura_det_<?php echo $num; ?>_max_item">
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['factura_det'][$num]['price_unit']->render(array('class' => 'form-control det_unit factura_det_price_unit money_intern', 'readonly' => 'readonly'))?>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BSS</span>
            </div>
            <input class="form-control det_unit_bs money_intern" type="text" id="factura_det_unit_<?php echo $num?>_bs" readonly>
          </div>
        </div>
        <div class="col-md-3">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['factura_det'][$num]['price_tot']->render(array('class' => 'form-control det_total factura_det_price_tot money_intern', 'placeholder' => 'Total', 'readonly' => 'readonly'))?>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BSS</span>
            </div>
            <input class="form-control det_total_bs numero" type="text" id="factura_det_tot_<?php echo $num?>_bs" readonly>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div><div><div>
  <script>
    var select = document.getElementById("factura_factura_det_<?php echo $num; ?>_inventario_id");
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
      $("#factura_factura_det_<?php echo $num; ?>_inventario_id").on('change', function(event){
        item_prod(<?php echo $num; ?>);
        sumar();
      });

      $("#factura_factura_det_<?php echo $num; ?>_inventario_id").select2({ width: '100%'});
      $('.det_qty').keyup(function(){
        sumar();
      });
    });
  </script>
<?php else: ?>
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
            <select name="factura[factura_det][<?php echo $num?>][inventario_id]" class="form-control factura_det_inventario_id" id="factura_factura_det_<?php echo $num?>_inventario_id">
              <?php $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$cid); ?>
              <?php $inv_orden=Doctrine_Core::getTable('Inventario')->findOneBy('id',$pid); ?>
              <?php
                $tasa="0";
                $empresa = Doctrine_Core::getTable('Empresa')->findOneBy('id', $inv_orden->getEmpresaId());
                $results20 = Doctrine_Query::create()
                  ->select('FORMAT(REPLACE(o.valor, " ", ""), 4, "de_DE") as formatNumber')
                  ->from('Otros o')
                  ->where('o.empresa_id = ?', $empresa->getId())
                  ->AndWhere('o.nombre = ?', $empresa->getTasa())
                  ->orderBy('o.id DESC')
                  ->limit(1)
                  ->execute();
                foreach ($results20 as $result) {
                  $tasa=$result["formatNumber"];
                }
                $producto=Doctrine_Core::getTable('Producto')->findOneBy('id',$inv_orden->getProductoId());
                $exento="NO EXENTO";
                if($producto->getExento()==1) {
                  $exento="EXENTO";
                }
              ?>
              <option value="<?php echo $pid; ?>"><?php echo $producto->getNombre()." [".$producto->getSerial()."]"; ?></option>
            </select>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <?php echo $form['factura_det'][$num]['exento']->render(array('class' => 'form-control det_exento factura_det_exento', 'readonly' => 'readonly', 'value' => $exento))?>
            </div>
          </div>
        </div>
        <div class="col-md-1">
          <div class="form-group">
            <?php echo $form['factura_det'][$num]['qty']->render(array('class' => 'form-control onlyqty det_qty factura_det_qty', 'placeholder' => 'Cant.', 'value' => $qty))?>
          </div>
          <div class="form-group">
            <input class="form-control max_item onlyqty" name="max_item" readonly id="factura_factura_det_<?php echo $num; ?>_max_item" value="<?php echo $inv_orden->getCantidad(); ?>">
          </div>
        </div>
        <div class="col-md-2">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['factura_det'][$num]['price_unit']->render(array('class' => 'form-control det_unit factura_det_price_unit', 'readonly' => 'readonly', 'value' => number_format(number_float($producto["precio_usd_".$cliente->getTipoPrecio()]), 4, ',', '.') ))?>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BSS</span>
            </div>
            <input class="form-control det_unit_bs money_intern" type="text" id="factura_det_unit_<?php echo $num?>_bs" readonly>
          </div>
        </div>
        <div class="col-md-3">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">USD</span>
            </div>
            <?php echo $form['factura_det'][$num]['price_tot']->render(array('class' => 'form-control det_total factura_det_price_tot money_intern', 'placeholder' => 'Total', 'readonly' => 'readonly'))?>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">BSS</span>
            </div>
            <input class="form-control det_total_bs money_intern" type="text" id="factura_det_tot_<?php echo $num?>_bs" readonly>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div><div><div>
  <script type="text/javascript">
    $(function () {
      var tasa=number_float("<?php echo $tasa; ?>");
      var punit=number_float($("#factura_factura_det_<?php echo $num; ?>_price_unit").val());
      var qty=number_float($("#factura_factura_det_<?php echo $num; ?>_qty").val());
      var total=punit*qty;
      var unit_bs = punit*tasa;
      var total_bs = total*tasa;
      $('#factura_factura_det_<?php echo $num?>_price_tot').val(SetMoney(total));
      $('#factura_det_unit_<?php echo $num?>_bs').val(SetMoney(unit_bs));
      $('#factura_det_tot_<?php echo $num?>_bs').val(SetMoney(total_bs));

      $('.money_intern').mask("#.##0,0000", {
        clearIfNotMatch: true,
        placeholder: "#,####",
        reverse: true
      });
      $('.onlyqty').mask("###0", {reverse: true});
      $("#factura_factura_det_<?php echo $num; ?>_inventario_id").on('change', function(event){
        item_prod(<?php echo $num; ?>);
        sumar();
      });

      
      $('.det_qty').keyup(function(){
        sumar();
      });
    });
  </script>
<?php endif; ?>

<?php
  function number_float($str) {
    $stripped = str_replace(' ', '', $str);
    $number = str_replace(',', '', $stripped);
    return $number;
  }
?>