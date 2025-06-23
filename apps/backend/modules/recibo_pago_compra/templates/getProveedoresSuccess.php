<label for="recibo_pago_compra_proveedor_id">Proveedor</label>
<select name="recibo_pago_compra[proveedor_id]" class="form-control" id="recibo_pago_compra_proveedor_id">
  <?php //->where('p.empresa_id = ?', $empresa_id)
    $empresa_id=$sf_params->get('id');
    $results = Doctrine_Query::create()
    ->select('p.*')
    ->from('Proveedor p')
    ->orderBy('p.full_name ASC')
    ->execute();
    foreach ($results as $result) {
      echo "<option value='".$result->getId()."'>".$result->getFullName()." [".$result->getDocId()."]"."</option>";
    }
  ?>
</select>

<script type="text/javascript">
  $( document ).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    $("#recibo_pago_compra_proveedor_id").select2({ width: '100%'});
    $('#campo_det').load('<?php echo url_for('recibo_pago_compra/header') ?>?id='+$("#recibo_pago_compra_proveedor_id").val()+'&emp='+'<?php echo $empresa_id ?>').fadeIn("slow");
    $("#recibo_pago_compra_proveedor_id").on('change', function(event){
      $('#campo_det').hide();
      $('#campo_det').load('<?php echo url_for('recibo_pago_compra/header') ?>?id='+this.value+'&emp='+'<?php echo $empresa_id ?>').fadeIn("slow");
    });                           
  });
</script>
