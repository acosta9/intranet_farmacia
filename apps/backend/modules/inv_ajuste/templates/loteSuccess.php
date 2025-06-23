<?php $num=$sf_params->get('num'); ?>
<label for="">Lote</label>
<select name="inv_ajuste[inv_ajuste_det][<?php echo $num?>][inventario_det_id]" class="form-control inv_ajuste_det_inventario_det_id" id="inv_ajuste_inv_ajuste_det_<?php echo $num?>_inventario_det_id">
  <?php
    $results = Doctrine_Query::create()
      ->select('id.lote, id.id, id.cantidad, id.fecha_venc, id.lote')
      ->from('InventarioDet id')
      ->andWhere('id.inventario_id =?', $sf_params->get('id'))
      ->orderBy('id.id DESC')
      ->limit(10)
      ->execute();
    foreach ($results as $result) {
      echo "<option value='".$result->getId()."'>".$result->getLote()."</option>";
    }
  ?>
</select>
<div id="lots_<?php echo $num; ?>" style="display: none">
<?php
  foreach ($results as $result) {
    echo "<div id='".$result["id"]."' class='item'>";
    echo "<div class='id'>".$result["id"]."</div>";
    echo "<div class='qty'>".$result["cantidad"]."</div>";
    echo "<div class='lote'>".$result["lote"]."</div>";
    $phpdate = strtotime($result["fecha_venc"]);
    echo "<div class='fvenc'>".date('Y-m-d', $phpdate)."</div>";
    echo "</div>";
  }
?>
</div>
<script>
$(function () {
  item_lot($("#inv_ajuste_inv_ajuste_det_<?php echo $num?>_inventario_det_id").val());
  $("#inv_ajuste_inv_ajuste_det_<?php echo $num?>_inventario_det_id").on('change', function(event){
    item_lot(this.value);
  });
});
function item_lot(id) {
  var num=<?php echo $num;?>;
  var qty = number_float($("#lots_"+num).find("#"+id+" .qty").text());
  var fvenc = $("#lots_"+num).find("#"+id+" .fvenc").text();
  var lote = $("#lots_"+num).find("#"+id+" .lote").text();
  $("#qty_act_"+num).val(qty);
  $("#fvenc_act_"+num).val(fvenc);
  $("#inv_ajuste_inv_ajuste_det_"+num+"_fecha_venc").val(fvenc);
  $("#inv_ajuste_inv_ajuste_det_"+num+"_lote").val(lote);
}
</script>