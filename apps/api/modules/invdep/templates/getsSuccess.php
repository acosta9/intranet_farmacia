<?php
// inv_deposito//
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  $fecha = date("Y-m-d H:i:s", $sf_params->get('fecha'));

 $q = Doctrine_Manager::getInstance()->getCurrentConnection(); 
 if($tipo == "createdat"){
    
    $results = $q->execute("SELECT * FROM inv_deposito WHERE empresa_id=$eid && created_at>='$fecha'");

    $newData=array();
    foreach ($results as $result) {
      
      $newData[]=array (
        'id' => $result["id"],
        'eid' => $result["empresa_id"],
        'nom' => $result["nombre"],
        'acr' => $result["acronimo"],
        'tipo' => $result["tipo"],
        'des' => $result["descripcion"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"]),
        'cby' => $result["created_by"],
        'uby' => $result["updated_by"]
      );
    }
  }
  else if($tipo == "updatedat"){
    $results = $q->execute("SELECT * FROM inv_deposito WHERE empresa_id=$eid && updated_at>='$fecha'");

    $newData=array();
    foreach ($results as $result) {
      
      $newData[]=array (
        'id' => $result["id"],
        'eid' => $result["empresa_id"],
        'nom' => $result["nombre"],
        'acr' => $result["acronimo"],
        'tipo' => $result["tipo"],
        'des' => $result["descripcion"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]
      );
    }
  }
  echo json_encode($newData, JSON_PRETTY_PRINT);