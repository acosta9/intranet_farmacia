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
    $results = $q->execute("SELECT id FROM producto WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }

  $insert="BEGIN; set foreign_key_checks=0; INSERT INTO producto (id, nombre, serial, serial2, serial3, serial4, tasa, serial_bulto1, cantidad_bulto1, serial_bulto2, 
  cantidad_bulto2, codigo, laboratorio_id, categoria_id, unidad_id, subproducto_id, qty_desglozado, tipo, activo, costo_usd_1, util_usd_1, util_usd_2, util_usd_3, 
  util_usd_4, util_usd_5, util_usd_6, util_usd_7, util_usd_8, precio_usd_1, precio_usd_2, precio_usd_3, precio_usd_4, precio_usd_5, precio_usd_6, precio_usd_7, 
  precio_usd_8, exento, destacado, tags, url_imagen, url_imagen_desc, descripcion, mas_detalles, created_at, updated_at, created_by, updated_by) VALUES ";
  $k=0; $newData=array();
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nombre"];
    if(empty(trim($value["serial"]))) {
      $serial="NULL";
    } else {
      $serial="'".$value["serial"]."'";
    }  
    if(empty(trim($value["serial2"]))) {
      $serial2="NULL";
    } else {
      $serial2="'".$value["serial2"]."'";
    }  
    if(empty(trim($value["serial3"]))) {
      $serial3="NULL";
    } else {
      $serial3="'".$value["serial3"]."'";
    }  
    if(empty(trim($value["serial4"]))) {
      $serial4="NULL";
    } else {
      $serial4="'".$value["serial4"]."'";
    } 
    $tasa=$value["tasa"];
    if(empty(trim($value["serial_bulto1"]))) {
      $serial_bulto1="NULL";
    } else {
      $serial_bulto1="'".$value["serial_bulto1"]."'";
    } 
    $cantidad_bulto1=$value["cantidad_bulto1"];
    if(empty(trim($value["serial_bulto2"]))) {
      $serial_bulto2="NULL";
    } else {
      $serial_bulto2="'".$value["serial_bulto2"]."'";
    } 
    $cantidad_bulto2=$value["cantidad_bulto2"];
    $codigo=$value["codigo"];
    //laboratorio_id, suproducto_id, qty_desglozado
    if(empty(trim($value["laboratorio_id"]))) {
      $laboratorio_id="NULL";
    } else {
      $laboratorio_id=$value["laboratorio_id"];
    }
    $categoria_id=$value["categoria_id"];
    $unidad_id=$value["unidad_id"];
    if(empty(trim($value["subproducto_id"]))) {
      $subproducto_id="NULL";
    } else {
      $subproducto_id=$value["subproducto_id"];
    }
    if(empty(trim($value["qty_desglozado"]))) {
      $qty_desglozado="NULL";
    } else {
      $qty_desglozado=$value["qty_desglozado"];
    }  
    $tipo=$value["tipo"];
    $activo=$value["activo"];
    $costo_usd_1=$value["costo_usd_1"];
    $util_usd_1=$value["util_usd_1"];
    $util_usd_2=$value["util_usd_2"];
    $util_usd_3=$value["util_usd_3"];
    $util_usd_4=$value["util_usd_4"];
    $util_usd_5=$value["util_usd_5"];
    $util_usd_6=$value["util_usd_6"];
    $util_usd_7=$value["util_usd_7"];
    $util_usd_8=$value["util_usd_8"];
    $precio_usd_1=$value["precio_usd_1"];
    $precio_usd_2=$value["precio_usd_2"];
    $precio_usd_3=$value["precio_usd_3"];
    $precio_usd_4=$value["precio_usd_4"];
    $precio_usd_5=$value["precio_usd_5"];
    $precio_usd_6=$value["precio_usd_6"];
    $precio_usd_7=$value["precio_usd_7"];
    $precio_usd_8=$value["precio_usd_8"];
    $exento=$value["exento"];
    $destacado=$value["destacado"];
    $tags=$value["tags"];
    $url_imagen=$value["url_imagen"];
    $url_imagen_desc=$value["url_imagen_desc"];
    $descripcion=$value["descripcion"];
    $mas_detalles=$value["mas_detalles"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["cat"]);
    $created_by=$value["cby"];
    $updated_by=$value["cby"];

    if(empty($ids_existentes[$id])) {
      $insert=$insert."($id, $nombre, $serial, $serial2, $serial3, $serial4, '$tasa', $serial_bulto1, '$cantidad_bulto1', $serial_bulto2, '$cantidad_bulto2', '$codigo', $laboratorio_id, $categoria_id, $unidad_id, $subproducto_id, $qty_desglozado, $tipo, $activo, '$costo_usd_1', '$util_usd_1', '$util_usd_2', '$util_usd_3', '$util_usd_4', '$util_usd_5', '$util_usd_6', '$util_usd_7', '$util_usd_8', '$precio_usd_1', '$precio_usd_2', '$precio_usd_3', '$precio_usd_4', '$precio_usd_5', '$precio_usd_6', '$precio_usd_7', '$precio_usd_8', $exento, $destacado, '$tags', '$url_imagen', '$url_imagen_desc', '$descripcion', '$mas_detalles', '$created_at', '$updated_at', $created_by, $updated_by), ";
      $k++;
      $newData[]=$value;
    }
  }

  //print_r(substr($insert, 0, -2)."; COMMIT;");

  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  } 
  $q->close();
  echo json_encode($newData);
} 

if($tipo=="actualizar_registros") {
  $invIds=array(); $i=0;
  foreach ($object as $key => $value) { 
    $invIds[$i]=$value["id"];
    $i++;
  }
  $ids=implode(",", $invIds);
  $ids_existentes=array();
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  if(!empty($ids)) {
    $results = $q->execute("SELECT id FROM producto WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }

  $update="BEGIN; set foreign_key_checks=0; ";
  $k=0; $newData=array();
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nombre"];
    if(empty(trim($value["serial"]))) {
      $serial="NULL";
    } else {
      $serial="'".$value["serial"]."'";
    }  
    if(empty(trim($value["serial2"]))) {
      $serial2="NULL";
    } else {
      $serial2="'".$value["serial2"]."'";
    }  
    if(empty(trim($value["serial3"]))) {
      $serial3="NULL";
    } else {
      $serial3="'".$value["serial3"]."'";
    }  
    if(empty(trim($value["serial4"]))) {
      $serial4="NULL";
    } else {
      $serial4="'".$value["serial4"]."'";
    } 
    $tasa=$value["tasa"];
    if(empty(trim($value["serial_bulto1"]))) {
      $serial_bulto1="NULL";
    } else {
      $serial_bulto1="'".$value["serial_bulto1"]."'";
    } 
    $cantidad_bulto1=$value["cantidad_bulto1"];
    if(empty(trim($value["serial_bulto2"]))) {
      $serial_bulto2="NULL";
    } else {
      $serial_bulto2="'".$value["serial_bulto2"]."'";
    } 
    $cantidad_bulto2=$value["cantidad_bulto2"];
    $codigo=$value["codigo"];
    //laboratorio_id, suproducto_id, qty_desglozado
    if(empty(trim($value["laboratorio_id"]))) {
      $laboratorio_id="NULL";
    } else {
      $laboratorio_id=$value["laboratorio_id"];
    }
    $categoria_id=$value["categoria_id"];
    $unidad_id=$value["unidad_id"];
    if(empty(trim($value["subproducto_id"]))) {
      $subproducto_id="NULL";
    } else {
      $subproducto_id=$value["subproducto_id"];
    }
    if(empty(trim($value["qty_desglozado"]))) {
      $qty_desglozado="NULL";
    } else {
      $qty_desglozado=$value["qty_desglozado"];
    }  
    $tipo=$value["tipo"];
    $activo=$value["activo"];
    $costo_usd_1=$value["costo_usd_1"];
    $util_usd_1=$value["util_usd_1"];
    $util_usd_2=$value["util_usd_2"];
    $util_usd_3=$value["util_usd_3"];
    $util_usd_4=$value["util_usd_4"];
    $util_usd_5=$value["util_usd_5"];
    $util_usd_6=$value["util_usd_6"];
    $util_usd_7=$value["util_usd_7"];
    $util_usd_8=$value["util_usd_8"];
    $precio_usd_1=$value["precio_usd_1"];
    $precio_usd_2=$value["precio_usd_2"];
    $precio_usd_3=$value["precio_usd_3"];
    $precio_usd_4=$value["precio_usd_4"];
    $precio_usd_5=$value["precio_usd_5"];
    $precio_usd_6=$value["precio_usd_6"];
    $precio_usd_7=$value["precio_usd_7"];
    $precio_usd_8=$value["precio_usd_8"];
    $exento=$value["exento"];
    $destacado=$value["destacado"];
    $tags=$value["tags"];
    $url_imagen=$value["url_imagen"];
    $url_imagen_desc=$value["url_imagen_desc"];
    $descripcion=$value["descripcion"];
    $mas_detalles=$value["mas_detalles"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];

    if(!empty($ids_existentes[$id])) {
      $update=$update." UPDATE IGNORE producto SET nombre=$nombre, serial=$serial, serial2=$serial2, serial3=$serial3, serial4=$serial4, tasa='$tasa', serial_bulto1=$serial_bulto1, cantidad_bulto1='$cantidad_bulto1', serial_bulto2=$serial_bulto2, cantidad_bulto2='$cantidad_bulto2', codigo='$codigo', laboratorio_id=$laboratorio_id, categoria_id='$categoria_id', unidad_id='$unidad_id', subproducto_id=$subproducto_id, qty_desglozado=$qty_desglozado, tipo=$tipo, activo=$activo, costo_usd_1='$costo_usd_1', util_usd_1='$util_usd_1', util_usd_2='$util_usd_2', util_usd_3='$util_usd_3', util_usd_4='$util_usd_4', util_usd_5='$util_usd_5', util_usd_6='$util_usd_6', util_usd_7='$util_usd_7', util_usd_8='$util_usd_8', precio_usd_1='$precio_usd_1', precio_usd_2='$precio_usd_2', precio_usd_3='$precio_usd_3', precio_usd_4='$precio_usd_4', precio_usd_5='$precio_usd_5', precio_usd_6='$precio_usd_6', precio_usd_7='$precio_usd_7', precio_usd_8='$precio_usd_8', exento=$exento, destacado=$destacado, tags='$tags', url_imagen='$url_imagen', url_imagen_desc='$url_imagen_desc', descripcion='$descripcion', mas_detalles='$mas_detalles', updated_at='$updated_at', updated_by=$updated_by WHERE id='$id'; ";
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
?>