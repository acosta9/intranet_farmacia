<label for="recibo_pago_cliente_id">Cliente</label>
<select name="recibo_pago[cliente_id]" class="form-control" id="recibo_pago_cliente_id">
  <?php
    $empresa_id=$sf_params->get('id');
    $results = Doctrine_Query::create()
      ->select('c.*')
      ->from('Cliente c')
      ->where('c.empresa_id = ?', $empresa_id)
      ->orderBy('c.full_name ASC')
      ->execute();
    foreach ($results as $result) {
      echo "<option value='".$result->getId()."'>".$result->getFullName()." [".$result->getDocId()."]"."</option>";
    }
  ?>
</select>

<script type="text/javascript">
  $( document ).ready(function() {
    $("#recibo_pago_cliente_id").select2({ width: '100%'});
    $('#campo_det').load('<?php echo url_for('recibo_pago/header') ?>?id='+$("#recibo_pago_cliente_id").val()).fadeIn("slow");
    $("#recibo_pago_cliente_id").on('change', function(event){
      $('#campo_det').hide();
      $('#campo_det').load('<?php echo url_for('recibo_pago/header') ?>?id='+this.value).fadeIn("slow");
    });
  });
</script>
