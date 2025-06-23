<?php
  $empresa_id=$sf_params->get('id');
  $tasa="0";
  $results = Doctrine_Query::create()
  ->select('FORMAT(REPLACE(o.valor, " ", ""), 4, "de_DE") as formatNumber')
    ->from('Otros o')
    ->where('o.empresa_id = ?', $empresa_id)
    ->orderBy('o.id DESC')
    ->limit(1)
    ->execute();
  foreach ($results as $result) {
    $tasa=$result["formatNumber"];
  }
  echo "<div id='ttasa' style='display:none'>".$tasa."</div>";
?>
<label for="nota_credito_cliente_id">Cliente</label>
<select name="nota_credito[cliente_id]" class="form-control" id="nota_credito_cliente_id">
  <?php
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
    $("#nota_credito_cliente_id").select2({ width: '100%'});
    getTasa();
    sumar();
  });
</script>
