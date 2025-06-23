<?php

// Only allow POST requests
if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
  throw new Exception('Only POST requests are allowed');
}

// Make sure Content-Type is application/json 
$content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
if (stripos($content_type, 'application/json') === false) {
  throw new Exception('Content-Type must be application/json');
}

// Read the input stream
$body = file_get_contents("php://input");

$object = json_decode($body, true);

// Throw an exception if decoding failed
if (!is_array($object)) {
  throw new Exception('Failed to decode JSON object');
}
// traslado //
$otIds=array(); $i=0;
   foreach ($object as $item => $value) { 
      $otIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $otIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM traslado WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDatat=array();
  $updatet="BEGIN; set foreign_key_checks=0; ";
  $j=0; 
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $estatus=$value["est"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];

    if(!empty($ids_existentes[$id])) {
      $updatet=$updatet." UPDATE traslado SET  estatus=$estatus, updated_at='$updated_at', updated_by='$updated_by' WHERE id=$id; ";
      $j++;
    } 
    $newDatat[]=$value;
   }

  $updatet=$updatet."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatet);
  }

  echo json_encode($newDatat);
  $q->close();

