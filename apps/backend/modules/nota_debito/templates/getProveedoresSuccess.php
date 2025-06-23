<label for="nota_debito_proveedor_id">Proveedor</label>
<select name="nota_debito[proveedor_id]" class="form-control" id="nota_debito_proveedor_id">
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
    
    $tasa="0";
    $empresa = Doctrine_Core::getTable('Empresa')->findOneBy('id', $empresa_id);
    $results = Doctrine_Query::create()
      ->select('FORMAT(REPLACE(o.valor, " ", ""), 4, "de_DE") as valorFormat')
      ->from('Otros o')
      ->where('o.empresa_id = ?', $empresa_id)
      ->AndWhere('o.nombre = ?', $empresa->getTasa())
      ->orderBy('o.id DESC')
      ->limit(1)
      ->execute();
    foreach ($results as $result) {
      $tasa=$result["valorFormat"];
    }
  ?>
</select>

<script type="text/javascript">
  $( document ).ready(function() {
    $("#nota_debito_tasa_cambio").val("<?php echo $tasa; ?>");
    $("#nota_debito_proveedor_id").select2({ width: '100%'});
    $('#campo_det').load('<?php echo url_for('nota_debito/header') ?>?id='+$("#nota_debito_proveedor_id").val()).fadeIn("slow");
    $("#nota_debito_proveedor_id").on('change', function(event){
      $('#campo_det').hide();
      $('#campo_det').load('<?php echo url_for('nota_debito/header') ?>?id='+this.value).fadeIn("slow");
    });
  });
</script>
