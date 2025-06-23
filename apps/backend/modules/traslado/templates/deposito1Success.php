<div class="form-group">
  <label for="traslado_deposito_desde">Deposito Origen</label>
  <select name="traslado[deposito_desde]" class="form-control" id="traslado_deposito_desde">
    <?php
      $results = Doctrine_Query::create()
        ->select('id.nombre as idname, id.id as idid, e.id as eid, e.acronimo as emin')
        ->from('InvDeposito id')
        ->leftJoin('id.Empresa e')
        ->andWhere('id.empresa_id =?', $sf_params->get('id'))
        ->orderBy('id.nombre ASC')
        ->execute();
      foreach ($results as $result) {
        echo "<option value='".$result["idid"]."'>[".$result["emin"]."] ".$result["idname"]."</option>";
      }
    ?>
  </select>
</div>
<?php
  $tasa="";
  $results = Doctrine_Query::create()
    ->select("FORMAT(REPLACE(o.valor, ' ', ''), 4, 'de_DE') as p01")
    ->from('Otros o')
    ->where('o.empresa_id = ?', $sf_params->get('id'))
    ->orderBy('o.id DESC')
    ->limit(1)
    ->execute();
  foreach ($results as $result) {
    $tasa=$result["p01"];
  }
?>
<div class="form-group">
  <label class="col-sm-12 control-label">Tasa</label>
  <div class="col-sm-12">
    <input class="form-control" readonly="readonly" type="text" name="traslado[tasa_cambio]" value="<?php echo $tasa; ?>" id="traslado_tasa_cambio" required>
  </div>
</div>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#traslado_deposito_desde").on('change', function(event){
      $( "#item" ).empty();
    });
  });
</script>
