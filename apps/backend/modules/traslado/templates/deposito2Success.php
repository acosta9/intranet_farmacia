<label for="traslado_deposito_hasta">Deposito Destino</label>
<select name="traslado[deposito_hasta]" class="form-control" id="traslado_deposito_hasta">
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
