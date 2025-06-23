<label for="orden_compra_deposito_id">Deposito</label>
<select name="orden_compra[deposito_id]" class="form-control" id="orden_compra_deposito_id">
  <?php
    $results = Doctrine_Query::create()
      ->select('id.nombre, id.id')
      ->from('InvDeposito id')
      ->andWhere('id.empresa_id =?', $sf_params->get('id'))
      ->andWhere('id.tipo =?', 1)
      ->orderBy('id.id ASC')
      ->execute();
      foreach ($results as $result) {
        echo "<option value='".$result->getId()."'>".$result->getNombre()."</option>";
      }
  ?>
</select>

<script type="text/javascript">
  $( document ).ready(function() {
    $('#campo_inv').load('<?php echo url_for('orden_compra/inv') ?>?id='+$("#orden_compra_deposito_id").val()).fadeIn("slow");
    $("#orden_compra_deposito_id").on('change', function(event){
      $('#campo_inv').load('<?php echo url_for('orden_compra/inv') ?>?id='+this.value).fadeIn("slow");
      $( "#item" ).empty();
    });
  });
</script>
