<?php
  $eid = $sf_params->get('eid');
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
 
    $results = $q->execute("SELECT updated_at as fecha FROM traslado WHERE empresa_hasta=$eid && updated_at <> created_at ORDER BY updated_at DESC LIMIT 1");

  $data=array();
  foreach ($results as $result) {
    $data=array(array("fecha" => strtotime($result["fecha"])));
  }
   echo json_encode($data);
?>s