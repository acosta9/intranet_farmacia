<?php
  $eid = $sf_params->get('eid');
  $fecha1 = date("Y-m-d H:i:s", $sf_params->get('fecha1')); 
 
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

  // traslado //
  
    $traslado=array();
    $results = $q->execute("SELECT * FROM traslado WHERE empresa_hasta=$eid AND created_at <> updated_at && updated_at>'$fecha1'");

    foreach ($results as $result) {
     
      $traslado[]=array (
        'id' => $result["id"],
        'est' => $result["estatus"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]   
      );
    }

$q->close();
echo json_encode($traslado);
?>