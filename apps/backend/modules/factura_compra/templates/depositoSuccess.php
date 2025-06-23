<label for="factura_compra_deposito_id">Deposito</label>
<select name="factura_compra[deposito_id]" class="form-control" id="factura_compra_deposito_id">
  <?php
    $results = Doctrine_Query::create()
      ->select('id.nombre, id.id')
      ->from('InvDeposito id')
      ->andWhere('id.empresa_id =?', $sf_params->get('id'))
      ->orderBy('id.id ASC')
      ->execute();
      foreach ($results as $result) {
        echo "<option value='".$result->getId()."'>".$result->getNombre()."</option>";
      }
  ?>
</select>

<script type="text/javascript">
  $( document ).ready(function() {
    $("#factura_compra_deposito_id").on('change', function(event){
      $( "#item" ).empty();
      addItemsBd();
    });
  });
</script>
