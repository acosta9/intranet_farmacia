<label for="">Deposito</label>
  <select class="form-control" multiple id="deposito_id" required>
  <?php
    $empresa_id=explode(",",$sf_params->get('id'));
    $deposito_id=$sf_params->get('did');

    $results = Doctrine_Query::create()
      ->select('d.id as did, d.nombre as dname, e.id as eid, e.nombre as ename, e.acronimo as emin')
      ->from('InvDeposito d, d.Empresa e')
      ->whereIn('d.empresa_id', $empresa_id)
      ->orderBy('e.nombre ASC, d.nombre ASC')
      ->groupBy('d.id')
      ->execute();
    $i=0;
    foreach ($results as $result) {
      if ($i==0) { ?>
        <option selected="selected" value="<?php echo $result["did"] ?>"><?php echo "[".$result["emin"]."] ".$result["dname"] ?></option>
      <?php $i++; } else { ?>
        <option value="<?php echo $result["did"] ?>"><?php echo "[".$result["emin"]."] ".$result["dname"] ?></option>
      <?php }
    }
  ?>
</select>
<script type="text/javascript">
  $( document ).ready(function() {
    $("#deposito_id").select2({width: '100%' });
    cargar();
  });
</script>