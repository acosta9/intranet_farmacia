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
//echo $object['produ'];
// Throw an exception if decoding failed
if (!is_array($object)) {
  throw new Exception('Failed to decode JSON object');
}

// prod_unidad //
$puIds=array(); $i=0;
if($object[0]['produ'] && $tipo == "createdat"){
  foreach ($object[0]['produ'] as $item => $value) { 
      $puIds[$i]=$value["id"];
      $i++;
    }  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $puIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM prod_unidad WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDatapu=array();
  $insertpu="BEGIN; set foreign_key_checks=0; INSERT INTO prod_unidad (id, nombre, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
  $k=0;
  foreach ($object[0]['produ'] as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nom"];
    $descripcion=$value["des"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];

    if(empty($ids_existentes[$id])) {
      $insertpu=$insertpu."($id, '$nombre', '$descripcion', '$created_at', '$created_at', $created_by, $updated_by), ";
      $k++;
    }
    $newDatapu[]=$value;
   }

  $insertpu=substr($insertpu, 0, -2)."; COMMIT;";
  if($k>0) {
    $error2 = $q->execute($insertpu);
  } 
  echo json_encode($newDatapu);
  $q->close();

} elseif($object[0]['produ'] && $tipo == "updatedat"){
  
  foreach ($object[0]['produ'] as $item => $value) { 
      $puIds[$i]=$value["id"];
      $i++;
    }  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $puIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM prod_unidad WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDatapu=array();
  $updatepu="BEGIN; set foreign_key_checks=0; ";
  $j=0; 
  foreach ($object[0]['produ'] as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nom"];
    $descripcion=$value["des"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];

    if(!empty($ids_existentes[$id])) {
      $updatepu=$updatepu." UPDATE prod_unidad SET nombre='$nombre', descripcion='$descripcion', updated_at='$updated_at', updated_by=$updated_by WHERE id=$id; ";
      $j++;
    } 
    $newDatapu[]=$value;
   }

  $updatepu=$updatepu."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatepu);
  }
  
  echo json_encode($newDatapu);
  $q->close();
}

// prod_laboratorio //

$plIds=array(); $ii=0;
if($object[0]['prodl'] && $tipo == "createdat"){ 
  foreach ($object[0]['prodl'] as $item => $value) { 
      $plIds[$ii]=$value["id"];
      $ii++;
    }

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $plIds);
  $ids_existentespl=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM prod_laboratorio WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentespl[$result["id"]]=$result["id"];
    }
  }
  $newDatapl=array();
  $insertpl="BEGIN; set foreign_key_checks=0; INSERT INTO prod_laboratorio (id, nombre, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
  $k=0;
  foreach ($object[0]['prodl'] as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nom"];
    $descripcion=$value["des"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];

    if(empty($ids_existentespl[$id])) {
     $insertpl=$insertpl."($id, '$nombre', '$descripcion', '$created_at', '$created_at', $created_by, $updated_by), ";
      $k++;
    }
    $newDatapl[]=$value;
   }

  $insertpl=substr($insertpl, 0, -2)."; COMMIT;";

  if($k>0) {
    $error2 = $q->execute($insertpl);
  } 

  echo json_encode($newDatapl);
  $q->close();
}
elseif($object[0]['prodl'] && $tipo == "updatedat"){ 
  foreach ($object[0]['prodl'] as $item => $value) { 
      $plIds[$ii]=$value["id"];
      $ii++;
    }

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $plIds);
  $ids_existentespl=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM prod_laboratorio WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentespl[$result["id"]]=$result["id"];
    }
  }
  $newDatapl=array();
  $updatepl="BEGIN; set foreign_key_checks=0; ";
  $j=0; $k=0;
  foreach ($object[0]['prodl'] as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nom"];
    $descripcion=$value["des"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];

    if(!empty($ids_existentespl[$id])) {
      $updatepl=$updatepl." UPDATE prod_laboratorio SET nombre='$nombre', descripcion='$descripcion', updated_at='$updated_at', updated_by=$updated_by WHERE id=$id; ";
      $j++;
    } 
    $newDatapl[]=$value;
   }

  $updatepl=$updatepl."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatepl);
  }

  echo json_encode($newDatapl);
  $q->close();
}

// prod_categoria //

$pcIds=array(); $i=0; 
if($object[0]['prodc'] && $tipo == "createdat"){ 
  foreach ($object[0]['prodc'] as $item => $value) { 
      $pcIds[$i]=$value["id"];
      $i++;
    }  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $pcIds);
  $ids_existentespc=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM prod_categoria WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentespc[$result["id"]]=$result["id"];
    }
  }
  $newDatapc=array();
  $insertpc="BEGIN; set foreign_key_checks=0; INSERT INTO prod_categoria (id,  codigo, codigo_full, nombre, descripcion, url_imagen, created_at, updated_at, created_by, updated_by) VALUES ";
  $k=0;
  foreach ($object[0]['prodc'] as $key => $value) { 
    $id=$value["id"];
    $codigo=$value["cod"];
    $codigo_full=$value["codf"];
    $nombre=$value["nom"];
    $descripcion=$value["des"];
    $url_imagen=$value["urli"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];
  
    if(empty($ids_existentespc[$id])) {
      $insertpc=$insertpc."($id, '$codigo', '$codigo_full', '$nombre', '$descripcion', '$url_imagen', '$created_at', '$created_at', $created_by, $updated_by), ";
      $k++;
    }
    $newDatapc[]=$value;
   }

  $insertpc=substr($insertpc, 0, -2)."; COMMIT;";
 
  if($k>0) {
    $error2 = $q->execute($insertpc);
  } 
  echo json_encode($newDatapc);
  $q->close();
}
elseif($object[0]['prodc'] && $tipo == "updatedat"){ 
  foreach ($object[0]['prodc'] as $item => $value) { 
      $pcIds[$i]=$value["id"];
      $i++;
    }  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $pcIds);
  $ids_existentespc=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM prod_categoria WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentespc[$result["id"]]=$result["id"];
    }
  }
  $newDatapc=array();
  $updatepc="BEGIN; set foreign_key_checks=0; ";
  $j=0; 
  foreach ($object[0]['prodc'] as $key => $value) { 
    $id=$value["id"];
    $codigo=$value["cod"];
    $codigo_full=$value["codf"];
    $nombre=$value["nom"];
    $descripcion=$value["des"];
    $url_imagen=$value["urli"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];
  
    if(!empty($ids_existentespc[$id])) {
      $updatepc=$updatepc." UPDATE prod_categoria SET codigo='$codigo', codigo_full='$codigo_full', nombre='$nombre', descripcion='$descripcion', url_imagen='$url_imagen', updated_at='$updated_at', updated_by=$updated_by WHERE id=$id; ";
      $j++;
    } 
    $newDatapc[]=$value;
   }

  $updatepc=$updatepc."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatepc);
  }
 
  echo json_encode($newDatapc);
  $q->close();
}  