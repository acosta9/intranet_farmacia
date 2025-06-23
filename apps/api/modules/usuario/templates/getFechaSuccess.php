<?php
  $tipo = $sf_params->get('tipo');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
// sf_guard_user //
  if($tipo=="createdat") {
    $results = $q->execute("SELECT created_at as fecha FROM sf_guard_user ORDER BY created_at DESC LIMIT 1");
  } else if($tipo=="updatedat") {
    $results = $q->execute("SELECT updated_at as fecha FROM sf_guard_user WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
  foreach ($results as $result) {
   $fecha1=strtotime($result["fecha"]);
  }

// sf_guard_permission //
  if($tipo=="createdat") {
    $results2 = $q->execute("SELECT created_at as fecha FROM sf_guard_permission WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else if($tipo=="updatedat") {
    $results2 = $q->execute("SELECT updated_at as fecha FROM sf_guard_permission WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }  
  foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
  }

// sf_guard_user_permission //
  if($tipo=="createdat") {
    $results3 = $q->execute("SELECT created_at as fecha FROM sf_guard_user_permission WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else if($tipo=="updatedat") {
    $results3 = $q->execute("SELECT updated_at as fecha FROM sf_guard_user_permission WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }  
  foreach ($results3 as $result3) {
    $fecha3=strtotime($result3["fecha"]);
  }

$data = array();
$data1 = array();

$data1['fecha1'] = $fecha1;
$data1['fecha2'] = $fecha2;
$data1['fecha3'] = $fecha3;

$data[] = $data1;

  echo json_encode($data, JSON_PRETTY_PRINT);
?>