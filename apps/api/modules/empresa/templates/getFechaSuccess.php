<?php
  $eid = $sf_params->get('eid');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT updated_at as fecha FROM empresa WHERE id=$eid ");


  $data=array();
  foreach ($results as $result) {
    $data=array(array("fecha" => strtotime($result["fecha"])));
  }
  $q->close();
  echo json_encode($data);
?>
