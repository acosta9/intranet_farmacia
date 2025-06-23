<?php
$tipo = $sf_params->get('tipo');

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


// inv_deposito //
$Ids=array(); $i=0;
if($tipo == "createdat"){
 foreach ($object as $key => $value) { 
  $Ids[$i]=$value["id"];
  $i++;
} 
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $Ids);
$ids_existentes=array();
if(!empty($ids)){
  $results = $q->execute("SELECT id FROM inv_deposito WHERE id IN ($ids)");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }
}
$newData=array();
$insert="BEGIN; set foreign_key_checks=0; INSERT INTO inv_deposito (id, empresa_id, nombre, acronimo, tipo, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
$k=0;
foreach ($object as $key => $value) { 
  $id=$value["id"];
  $empresa_id=$value["eid"];
  $nombre=$value["nom"];
  $acronimo=$value["acr"];
  $tipo=$value["tipo"];
  $descripcion=$value["des"];
  $created_at=date("Y-m-d H:i:s", $value["cat"]);
  $updated_at=date("Y-m-d H:i:s", $value["uat"]);
  $created_by=$value["cby"];
  $updated_by=$value["uby"]; 
  
  if(empty($ids_existentes[$id])) {
    $insert=$insert."($id, $empresa_id, '$nombre', '$acronimo', $tipo, '$descripcion', '$created_at', '$created_at', $created_by, $updated_by), ";
    $k++;
  }
  $newData[]=$value;
   
 }

 $insert=substr($insert, 0, -2)."; COMMIT;";

  if($k>0) {
    $error2 = $q->execute($insert);
  } 
 
  echo json_encode($newData);
  $q->close();
} 
else if($tipo == "updatedat") {
  foreach ($object as $key => $value) { 
    $Ids[$i]=$value["id"];
    $i++;
  }
   
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $Ids);
$ids_existentes=array();
if(!empty($ids)){
  $results = $q->execute("SELECT id FROM inv_deposito WHERE id IN ($ids)");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }
}
  $newData=array();
  $update="BEGIN; set foreign_key_checks=0;";
  $j=0; 
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $empresa_id=$value["eid"];
    $nombre=$value["nom"];
    $acronimo=$value["acr"];
    $tipo=$value["tipo"];
    $descripcion=$value["des"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"]; 
    
    if(!empty($ids_existentes[$id])) {
       $update=$update." UPDATE inv_deposito SET empresa_id = $empresa_id, nombre = '$nombre', acronimo = '$acronimo', tipo = $tipo, descripcion = '$descripcion', updated_at = '$updated_at', updated_by =  $updated_by WHERE id=$id; ";
      $j++;
    }
    $newData[]=$value;
   }

   $update=$update."COMMIT; ";

    if($j>0) {
      $error3 = $q->execute($update);
    }
    
    echo json_encode($newData);
    $q->close();
}

