<?php
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
// factura //
  if($tipo=="createdat") {
    $results = $q->execute("SELECT created_at as fecha FROM factura WHERE empresa_id=$eid AND updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else if($tipo=="updatedat") {
    $results = $q->execute("SELECT updated_at as fecha FROM factura WHERE empresa_id=$eid AND updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
  foreach ($results as $result) {
   $fecha1=strtotime($result["fecha"]);
  }

// cliente //
  if($tipo=="createdat") {
    $results2 = $q->execute("SELECT created_at as fecha FROM cliente WHERE empresa_id=$eid AND updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else if($tipo=="updatedat") {
    $results2 = $q->execute("SELECT updated_at as fecha FROM cliente WHERE empresa_id=$eid && updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }  
  foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
  }

  // cuentas_cobrar //
  if($tipo=="createdat") {
    $results3 = $q->execute("SELECT created_at as fecha FROM cuentas_cobrar WHERE empresa_id=$eid AND updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else if($tipo=="updatedat") {
    $results3 = $q->execute("SELECT updated_at as fecha FROM cuentas_cobrar WHERE empresa_id=$eid AND updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
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