<label for="inv_ajuste_deposito_id">Deposito</label>
<select name="inv_ajuste[deposito_id]" class="form-control" id="inv_ajuste_deposito_id">
  <?php
    $empresa_id=$sf_params->get('id');
    $results = Doctrine_Query::create()
      ->select('id.id as idid, id.nombre as idname, e.id as eid, e.acronimo as emin')
      ->from('InvDeposito id')
      ->leftJoin('id.Empresa e')
      ->where('id.empresa_id = ?', $empresa_id)
      ->orderBy('id.id ASC')
      ->execute();
    foreach ($results as $result) {
        echo "<option value='".$result["idid"]."'>[".$result["emin"]."] ".$result["idname"]."</option>";
    }
  ?>
</select>

<script type="text/javascript">
  $( document ).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    $("#inv_ajuste_deposito_id").on('change', function(event){
      $( "#item" ).empty();
    });
  });
</script>
