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

$tipo = $sf_params->get('tipo');

if($tipo=="subir_registros") {
  $invIds=array(); $i=0;
  foreach ($object as $key => $value) { 
    $invIds[$i]=$value["id"];
    $i++;
  }
  $ids=implode(",", $invIds);
  $ids_existentes=array();
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  if(!empty($ids)) {
    $results = $q->execute("SELECT id FROM inventario WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }

  $insert="BEGIN; set foreign_key_checks=0; INSERT INTO inventario (id, deposito_id, empresa_id, producto_id, cantidad, activo, limite_stock, created_at, updated_at, created_by, updated_by) VALUES ";
  $k=0; $newData=array();
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $deposito_id=$value["did"];
    $empresa_id=$value["eid"];
    $producto_id=$value["pid"];
    $cantidad=$value["qty"];
    $activo=$value["act"];
    $limite_stock=$value["lstock"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["cat"]);
    $created_by=$value["cby"];
    $updated_by=$value["cby"];

    if(empty($ids_existentes[$id])) {
      $insert=$insert."($id, $deposito_id, $empresa_id, $producto_id, $cantidad, $activo, $limite_stock, '$created_at', '$updated_at', '$created_by', '$updated_by'), ";
      $k++;
      $newData[]=$value;
    }
  }

  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  } 
  $q->close();
  echo json_encode($newData);
} 

if($tipo=="actualizar_cd") {
  $eid = $sf_params->get('eid');
  $ids_existentes=array();
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT id FROM inventario WHERE empresa_id=$eid");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }

  $update="BEGIN; set foreign_key_checks=0; ";
  $k=0; $newData=array();
  foreach ($object as $key => $value) { 
    $id=$value["i"];
    $activo=$value["a"];
    $limite_stock=$value["l"];
    $updated_at=date("Y-m-d H:i:s");

    if(!empty($ids_existentes[$id])) {
      $update=$update." UPDATE IGNORE inventario SET activo=$activo, limite_stock=$limite_stock, updated_at='$updated_at' WHERE id=$id; ";
      $k++;
      $newData[]=$value;
    }
  }

  if($k>0) {
    $update=$update."COMMIT; ";
    $error2 = $q->execute($update);
  } 
  $q->close();
  echo json_encode($newData);
}

if($tipo=="actualizar_qty") {
  $eid = $sf_params->get('eid');
  $ids_existentes=array();
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT id FROM inventario WHERE empresa_id=$eid");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }

  $update="BEGIN; set foreign_key_checks=0;";
  $k=0; $newData=array();
  foreach ($object as $key => $value) { 
    $id=$value["i"];
    $cantidad=$value["c"];
    $updated_at=date("Y-m-d H:i:s");

    if(!empty($ids_existentes[$id])) {
      $update=$update." UPDATE IGNORE inventario SET cantidad=$cantidad, updated_at='$updated_at' WHERE id=$id; ";
      $k++;
      $newData[]=$value;
    }
  }

  if($k>0) {
    $update=$update."COMMIT; ";
    $error2 = $q->execute($update);
  } 
  $q->close();
  echo json_encode($newData);
}
