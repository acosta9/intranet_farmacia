<?php
  $eid = $sf_params->get('eid');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

// kardex //
  
    $results = $q->execute("SELECT fecha as fecha FROM kardex WHERE empresa_id=$eid ORDER BY fecha DESC LIMIT 1");
   

  $data=array();
  foreach ($results as $result) {
    $data=array(array("fecha" => strtotime($result["fecha"])));
  }
  echo json_encode($data, JSON_PRETTY_PRINT);
  
?>