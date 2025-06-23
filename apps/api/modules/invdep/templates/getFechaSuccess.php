<?php
  $eid = $sf_params->get('eid');
  $tipo = $sf_params->get('tipo');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

  if($tipo=="createdat") {
    $results = $q->execute("SELECT created_at as fecha FROM inv_deposito WHERE empresa_id=$eid ORDER BY created_at DESC LIMIT 1");
  } else if($tipo=="updatedat") {
    $results = $q->execute("SELECT updated_at as fecha FROM inv_deposito WHERE empresa_id=$eid && updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
  $q->close();

  $data=array();
  foreach ($results as $result) {
    $data=array(array("fecha" => strtotime($result["fecha"])));
  }
  echo json_encode($data);
?>
