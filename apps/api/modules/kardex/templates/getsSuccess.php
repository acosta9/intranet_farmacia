<?php
// kardex //
  $eid = $sf_params->get('eid');
  $fecha1 = date("Y-m-d H:i:s", $sf_params->get('fecha1')); 
 
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

 // kardex //

   $kardex=array();
    $results2 = $q->execute("SELECT * FROM kardex WHERE empresa_id = '$eid' AND fecha >= '$fecha1' ORDER BY fecha ASC LIMIT 200");

    foreach ($results2 as $result2) {
     
      $kardex[]=array (
        'id' => $result2["id"],
        'eid' => $result2["empresa_id"],
        'did' => $result2["deposito_id"],
        'pid' => $result2["producto_id"],
        'uid' => $result2["user_id"],
        'tabla' => $result2["tabla"],
        'tid' => $result2["tabla_id"],
        'fe' => $result2["fecha"],
        'cant' => $result2["cantidad"],
        'punit' => $result2["price_unit"],
        'ptot' => $result2["price_tot"],
        'tipo' => $result2["tipo"],
        'con' => $result2["concepto"],
        'lote' => $result2["lote"],
        'fvenc' => $result2["fvenc"]
       );
    }
 
$q->close();
echo json_encode($kardex, JSON_PRETTY_PRINT);
?>