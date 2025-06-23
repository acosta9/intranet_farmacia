<label for="orden_compra_cliente_id">Cliente</label>
<select name="orden_compra[cliente_id]" class="form-control" id="orden_compra_cliente_id">
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
    $tasa="0";
    $empresa = Doctrine_Core::getTable('Empresa')->findOneBy('id', $empresa_id);
    $results = Doctrine_Query::create()
      ->select('FORMAT(REPLACE(o.valor, " ", ""), 4, "de_DE") as formatNumber')
      ->from('Otros o')
      ->where('o.empresa_id = ?', $empresa_id)
      ->AndWhere('o.nombre = ?', $empresa->getTasa())
      ->orderBy('o.id DESC')
      ->limit(1)
      ->execute();
    foreach ($results as $result) {
      $tasa=$result["formatNumber"];
    }
  ?>
</select>

<script type="text/javascript">
  $( document ).ready(function() {
    $("#orden_compra_tasa_cambio").val("<?php echo $tasa; ?>");
    $("#orden_compra_cliente_id").select2({ width: '100%'});
    $('#campo_det').load('<?php echo url_for('orden_compra/header') ?>?id='+$("#orden_compra_cliente_id").val()).fadeIn("slow");
    $("#orden_compra_cliente_id").on('change', function(event){
      $( "#item" ).empty();
      $("#orden_compra_total").val("0.00");
      $('#campo_det').hide();
      $('#campo_det').load('<?php echo url_for('orden_compra/header') ?>?id='+this.value).fadeIn("slow");
    });
  });
</script>
