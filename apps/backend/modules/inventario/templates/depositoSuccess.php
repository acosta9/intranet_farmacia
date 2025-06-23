<label for="inventario_deposito_id">Deposito</label>
<select name="inventario[deposito_id]" class="form-control" id="inventario_deposito_id">
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