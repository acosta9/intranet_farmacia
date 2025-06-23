<?php
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
// recibo_pago //
  if($tipo=="createdat") {
    $results = $q->execute("SELECT created_at as fecha FROM recibo_pago WHERE empresa_id=$eid AND created_at = updated_at ORDER BY created_at DESC LIMIT 1");
  } else if($tipo=="updatedat") {
    $results = $q->execute("SELECT updated_at as fecha FROM recibo_pago WHERE empresa_id=$eid AND updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
  foreach ($results as $result) {
   $fecha1=strtotime($result["fecha"]);
  }

// prod_vendidos //
  
    $results2 = $q->execute("SELECT fecha as fecha FROM prod_vendidos WHERE empresa_id=$eid ORDER BY fecha DESC LIMIT 1");
   foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
  }

    
  $data = array();
  $data1 = array();

  $data1['fecha1'] = $fecha1;
  $data1['fecha2'] = $fecha2;
  
  $data[] = $data1;
  
  echo json_encode($data, JSON_PRETTY_PRINT);
?>