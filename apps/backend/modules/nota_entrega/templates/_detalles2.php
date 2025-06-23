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
          <select name="nota_entrega[nota_entrega_det][<?php echo $num?>][oferta_id]" class="form-control nota_entrega_det_oferta_id" id="nota_entrega_nota_entrega_det_<?php echo $num?>_oferta_id">
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
                $("#nota_entrega_nota_entrega_det_<?php echo $num?>_oferta_id option[value=<?php echo $r["id"]; ?>]").remove();
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
            <?php echo $form['nota_entrega_det'][$num]['exento']->render(array('class' => 'form-control det_exento nota_entrega_det_exento', 'readonly' => 'readonly'))?>
          </div>
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <?php echo $form['nota_entrega_det'][$num]['qty']->render(array('class' => 'form-control onlyqty det_qty nota_entrega_det_qty', 'placeholder' => 'Cant.'))?>
        </div>
        <div class="form-group">
          <input class="form-control max_item onlyqty" name="max_item" readonly id="nota_entrega_nota_entrega_det_<?php echo $num; ?>_max_item">
        </div>
      </div>
      <div class="col-md-2">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['nota_entrega_det'][$num]['price_unit']->render(array('class' => 'form-control det_unit nota_entrega_det_price_unit money_intern', 'readonly' => 'readonly'))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control det_unit_bs money_intern" type="text" id="nota_entrega_det_unit_<?php echo $num?>_bs" readonly>
        </div>
      </div>
      <div class="col-md-3">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <?php echo $form['nota_entrega_det'][$num]['price_tot']->render(array('class' => 'form-control det_total nota_entrega_det_price_tot money_intern', 'placeholder' => 'Total', 'readonly' => 'readonly'))?>
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BSS</span>
          </div>
          <input class="form-control det_total_bs money_intern" type="text" id="nota_entrega_det_tot_<?php echo $num?>_bs" readonly>
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
    $("#nota_entrega_nota_entrega_det_<?php echo $num; ?>_oferta_id").on('change', function(event){
      item_prod2(<?php echo $num; ?>);
      sumar();
    });

    $("#nota_entrega_nota_entrega_det_<?php echo $num; ?>_oferta_id").select2({ width: '100%'});
    $('.det_qty').keyup(function(){
      sumar();
    });
  });
</script>
