<label class="col-sm-12 control-label">Deposito</label>
<div class="col-sm-12">
  <select class="form-control" required="required" name="oferta[deposito_id]" id="oferta_deposito_id">
    <?php
    $empresa_id=$sf_params->get('id');
    $results = Doctrine_Query::create()
      ->select('id.id as idid, id.nombre as idname, e.id as eid, e.acronimo as emin')
      ->from('InvDeposito id')
      ->leftJoin('id.Empresa e')
      ->where('id.empresa_id = ?', $empresa_id)
      ->andWhere('id.tipo =?', 1)
      ->orderBy('id.id ASC')
      ->execute();
    foreach ($results as $result) {
        echo "<option value='".$result["idid"]."'>[".$result["emin"]."] ".$result["idname"]."</option>";
    }
    ?>
  </select>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $( "#item" ).empty();
    $(".add_item").click();
  });
  $('#oferta_deposito_id').change(function(){
    $( "#item" ).empty();
    $(".add_item").click();
  });
</script>