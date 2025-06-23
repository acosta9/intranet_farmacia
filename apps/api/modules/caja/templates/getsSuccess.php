<?php
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  $fecha1 = date("Y-m-d H:i:s", $sf_params->get('fecha1')); 
  $fecha2 = date("Y-m-d H:i:s", $sf_params->get('fecha2'));
  $fecha3 = date("Y-m-d H:i:s", $sf_params->get('fecha3'));

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

// caja //
  if($tipo=="createdat") {
    $cajas=array();
    $results = $q->execute("SELECT * FROM caja WHERE empresa_id = $eid AND created_at>'$fecha1'");

    foreach ($results as $result) {
     
      $cajas[]=array (
        'id' => $result["id"],
        'eid' => $result["empresa_id"],
        'nom' => $result["nombre"],
        'tipo' => $result["tipo"],
        'sta' => $result["status"],
        'fe' => $result["fecha"],
        'des' => $result["descripcion"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"]),
        'cby' => $result["created_by"],
        'uby' => $result["updated_by"]   
      );
    }
  } elseif($tipo=="updatedat") {
    $cajas=array();
    $results = $q->execute("SELECT * FROM caja WHERE empresa_id = $eid AND updated_at>'$fecha1'");

    foreach ($results as $result) {
     
      $cajas[]=array (
        'id' => $result["id"],
        'nom' => $result["nombre"],
        'tipo' => $result["tipo"],
        'des' => $result["descripcion"],
        'uby' => $result["updated_by"]   
      );
    }
  }
  
 // caja_user //
  if($tipo=="createdat") {
    $cajasu=array();
    $results2 = $q->execute("SELECT * FROM caja_user WHERE substring(caja_id,1,2)=$eid AND created_at>'$fecha2'");

    foreach ($results2 as $result2) {
     
      $cajasu[]=array (
        'cid' => $result2["caja_id"],
        'uid' => $result2["user_id"],
        'cat' => strtotime($result2["created_at"]),
        'uat' => strtotime($result2["updated_at"])
      );
    }
  } elseif($tipo=="updatedat") {
    $cajasu=array();
    $results2 = $q->execute("SELECT * FROM caja_user WHERE substring(caja_id,1,2)=$eid AND updated_at>'$fecha2'");

    foreach ($results2 as $result2) {
     
      $cajasu[]=array (
        'cid' => $result2["caja_id"],
        'uid' => $result2["user_id"],
        'cat' => strtotime($result2["created_at"]),
        'uat' => strtotime($result2["updated_at"])
      );
    }
  }  
  
// empresa_user //
  if($tipo=="createdat") {
   $empuss=array();
    $results3 = $q->execute("SELECT * FROM empresa_user WHERE empresa_id = $eid AND created_at>'$fecha3'");

    foreach ($results3 as $result3) {
     
      $empuss[]=array (
        'eid' => $result3["empresa_id"],
        'uid' => $result3["user_id"],
        'cat' => strtotime($result3["created_at"]),
        'uat' => strtotime($result3["updated_at"])
      );
    }
  } elseif($tipo=="updatedat") {
    $empuss=array();
    $results3 = $q->execute("SELECT * FROM empresa_user WHERE empresa_id = $eid AND updated_at>'$fecha3'");

    foreach ($results3 as $result3) {
     
      $empuss[]=array (
        'eid' => $result3["empresa_id"],
        'uid' => $result3["user_id"],
        'cat' => strtotime($result3["created_at"]),
        'uat' => strtotime($result3["updated_at"])
      );
    }
  }  
 
$caData = array();
  $caData[]=array (
    'caja' => $cajas,
    'cajau' => $cajasu,
    'empus' => $empuss
  );
  
$q->close();
echo json_encode($caData, JSON_PRETTY_PRINT);
?>