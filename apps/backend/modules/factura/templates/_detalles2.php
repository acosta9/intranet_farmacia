<?php if(empty($pid)): ?>
</div></div></div>
<div class="card card-warning items" id="sf_fieldset_det_<?php echo $num."_".$eid?>">
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
          <select name="factura[factura_det][<?php echo $num?>][oferta_id]" class="form-control factura_det_oferta_id" id="factura_factura_det_<?php echo $num?>_oferta_id">
            <?php
            $results = Doctrine_Query::create()
              ->select('ofer.nombre as name, ofer.id, od.id as odid, i.id as iid, p.id as pid,
              i.cantidad as cantidad, p.nombre as name, p.codigo as codigo, p.serial as serial')
              ->from('Oferta ofer')
              ->leftJoin('ofer.OfertaDet od')
              ->leftJoin('od.Inventario i')
              ->leftJoin('i.Producto p')
              ->Where('i.deposito_id =?', $did)
              ->andWhere('i.activo =?', 1)
              ->andWhere('ofer.activo =?', 1)
              ->andWhere("ofer.fecha <= '".date("Y-m-d")."' AND ofer.fecha_venc >= '".date("Y-m-d")."' ")
              ->orderBy('i.cantidad ASC')
              ->execute();
              foreach ($results as $r) {
                echo "<option value='".$r["id"]."'>".$r["name"]." [".$r["id"]."]</option>";
              }
            ?>
          </select>
          <script>
            <?php
            foreach ($results as $r):
              if ($r["cantidad"]<1):
            ?>
                $("#factura_factura_det_<?php echo $num?>_oferta_id option[value=<?php echo $r["id"]; ?>]").remove();
            <?php
              endif;
            endforeach; ?>
          </script>
          <div class="offts" style="display:none">
          <?php
            $results = Doctrine_Query::create()
              ->select('ofer.precio_usd as precio_usd, ofer.nombre as name, ofer.id, od.id as odid, i.id as iid, i.cantidad as cantidad,
              d.id as did, p.id as pid, p.nombre as name, p.codigo as codigo, p.serial as serial, ofer.exento as exento')
              ->from('Oferta ofer')
              ->leftJoin('ofer.OfertaDet od')
              ->leftJoin('od.Inventario i')
              ->leftJoin('i.InvDeposito d')
              ->leftJoin('i.Producto p')
              ->Where('i.deposito_id =?', $did)
              ->andWhere('i.activo =?', 1)
              ->andWhere('ofer.activo =?', 1)
              ->orderBy('i.cantidad ASC')
              ->execute();
              foreach ($results as $r) {
                echo "<div id='".$r["id"]."' class='item'>";
                  echo "<div class='id'>".$r["id"]."</div>";
                  echo "<div class='max'>".$r["cantidad"]."</div>";
                  echo "<div class='price'>".str_replace(".",",",$r["precio_usd"])."</div>";
                  $exento="NO EXENTO";
                  if($r["exento"]){
                    $exento="EXENTO";
                  }
                  echo "<div class='exento'>".$exento."</div>";
                echo "</div>";
              }
            ?>
            </div>
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
          <input class="form-control det_total_bs money_intern" type="text" id="factura_det_tot_<?php echo $num?>_bs" readonly>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>
<script>
  $(function () {
    $('.money_intern').mask("#.##0,0000", {
      clearIfNotMatch: true,
      placeholder: "#,####",
      reverse: true
    });
    $('.onlyqty').mask("###0", {reverse: true});
    item_prod2(<?php echo $num; ?>);
    sumar();
    $("#factura_factura_det_<?php echo $num; ?>_oferta_id").on('change', function(event){
      item_prod2(<?php echo $num; ?>);
      sumar();
    });

    $("#factura_factura_det_<?php echo $num; ?>_oferta_id").select2({ width: '100%'});
    $('.det_qty').keyup(function(){
      sumar();
    });
  });
</script>
<?php else: ?>
  </div></div></div>
<div class="card card-warning items" id="sf_fieldset_det_<?php echo $num."_".$eid?>">
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
          <select name="factura[factura_det][<?php echo $num?>][oferta_id]" class="form-control factura_det_oferta_id" id="factura_factura_det_<?php echo $num?>_oferta_id">
            <?php $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$cid); ?>
            <?php $inv_orden=Doctrine_Core::getTable('Oferta')->findOneBy('id',$pid); ?>
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
              $exento="NO EXENTO";
              if($inv_orden->getExento()==1) {
                $exento="EXENTO";
              }
            ?>
            <option value="<?php echo $pid; ?>"><?php echo $inv_orden->getNombre()." [".$inv_orden->getId()."]"; ?></option>
            <?php
            $results = Doctrine_Query::create()
              ->select('o.id as oid, od.id as odid, i.id as iid, i.cantidad as cantidad')
              ->from('OfertaDet od')
              ->leftJoin('od.Inventario i')
              ->leftJoin('od.Oferta o')
              ->where('o.id = ?', $pid)
              ->andWhere('o.activo =?', 1)
              ->andWhere("o.fecha <= '".date("Y-m-d")."' AND o.fecha_venc >= '".date("Y-m-d")."' ")
              ->orderBy('i.cantidad ASC')
              ->execute();
            $cantidad=0;
            foreach ($results as $result) {
                $cantidad=$result["cantidad"];
            }
            ?>
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
          <input class="form-control max_item only_qty" name="max_item" readonly id="factura_factura_det_<?php echo $num; ?>_max_item" value="<?php echo $cantidad; ?>">
        </div>
      </div>
      <div class="col-md-2">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['factura_det'][$num]['price_unit']->render(array('class' => 'form-control det_unit factura_det_price_unit', 'readonly' => 'readonly', 'value' => number_format(number_float($inv_orden->getPrecioUsd()), 4, ',', '.')))?>
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
<script>
  $(function () {
    var tasa=number_float("<?php echo $tasa; ?>");
    var punit=number_float($("#factura_factura_det_<?php echo $num; ?>_price_unit").val());
    var qty=number_float($("#factura_factura_det_<?php echo $num; ?>_qty").val());
    var total=punit*qty;
    var unit_bs = punit*tasa;
    var total_bs = total*tasa;

    console.log(tasa);
    console.log(punit);
    console.log(unit_bs);

    $('.money_intern').mask("#.##0,0000", {
      clearIfNotMatch: true,
      placeholder: "#,####",
      reverse: true
    });
    $('.onlyqty').mask("###0", {reverse: true});

    $('#factura_factura_det_<?php echo $num?>_price_tot').val(SetMoney(total));
    $('#factura_det_unit_<?php echo $num?>_bs').val(SetMoney(unit_bs));
    $('#factura_det_tot_<?php echo $num?>_bs').val(SetMoney(total_bs));

    $("#factura_factura_det_<?php echo $num; ?>_oferta_id").on('change', function(event){
      item_prod2(<?php echo $num; ?>);
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