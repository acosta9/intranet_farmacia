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
//echo $object['usuario'];
// Throw an exception if decoding failed
if (!is_array($object)) {
  throw new Exception('Failed to decode JSON object');
}

$eid = $sf_params->get('eid');

// otros //
$otIds=array(); $i=0;
if($object[0]['otro']){
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT * FROM otros WHERE empresa_id='$eid' && id IN ( SELECT MAX(id) FROM otros as o2 WHERE empresa_id = '$eid' GROUP BY o2.nombre )");
  $arreglo =array();
  foreach ($results as $result) {
    $arreglo[$result["nombre"]]=$result["valor"];
  }
  
  $newDataot=array();
  $insertot="BEGIN; set foreign_key_checks=0; INSERT INTO otros (empresa_id, nombre, valor, created_at, updated_at, created_by, updated_by) VALUES ";

   $k=0;
  foreach ($object[0]['otro'] as $key => $value) { 
    $id=$value["id"];
    $empresa_id=$value["eid"];
    $nombre=$value["nom"];
    $valor=$value["val"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"]; 

    if(!empty($arreglo[$nombre])) {
      $old=$arreglo[$nombre];
      if($valor!=$old) {
         $insertot=$insertot."($empresa_id, '$nombre', '$valor', '$created_at', '$updated_at', $created_by, $updated_by), ";
        $k++;
      }
    }
    $newDataot[]=$value;
   }

  if($k>0) {
    $insertot=substr($insertot, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insertot);
  } 

  echo json_encode($newDataot);
  $q->close();
}

// forma_pago //

$fpIds=array(); $ii=0; 
if($object[0]['formap'] && $tipo == "createdat"){
   foreach ($object[0]['formap'] as $item => $value) { 
      $fpIds[$ii]=$value["id"];
      $ii++;
    }  
 
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $fpIds);
  $ids_existentesfp=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM forma_pago WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentesfp[$result["id"]]=$result["id"];
    }
  }
  $newDatafp=array();
  $insertfp="BEGIN; set foreign_key_checks=0; INSERT INTO forma_pago (id, moneda, nombre, acronimo, activo, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
  $k=0;
  foreach ($object[0]['formap'] as $key => $value) { 
    $id=$value["id"];
    $moneda=$value["mon"];
    $nombre=$value["nom"];
    $acronimo=$value["acr"];
    $activo=$value["act"];
    $descripcion=$value["des"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];

    if(empty($ids_existentesfp[$id])) {
       $insertfp=$insertfp."($id, $moneda, '$nombre', '$acronimo', $activo, '$descripcion', '$created_at', '$created_at', '$created_by', '$updated_by'), ";
        $k++;
    }
    $newDatafp[]=$value;
   }
  $insertfp=substr($insertfp, 0, -2)."; COMMIT;";

  if($k>0) {
    $error2 = $q->execute($insertfp);
  } 
  echo json_encode($newDatafp);
  $q->close();
} 
elseif($object[0]['formap'] && $tipo == "updatedat"){
   foreach ($object[0]['formap'] as $item => $value) { 
      $fpIds[$ii]=$value["id"];
      $ii++;
    }  

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $fpIds);
  $ids_existentesfp=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM forma_pago WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentesfp[$result["id"]]=$result["id"];
    }
  }
  $newDatafp=array();
  $updatefp="BEGIN; set foreign_key_checks=0; ";
  $j=0; 
  foreach ($object[0]['formap'] as $key => $value) { 
    $id=$value["id"];
    $moneda=$value["mon"];
    $nombre=$value["nom"];
    $acronimo=$value["acr"];
    $activo=$value["act"];
    $descripcion=$value["des"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];

    if(!empty($ids_existentesfp[$id])) {
      $updatefp=$updatefp." UPDATE forma_pago SET moneda=$moneda, nombre='$nombre', acronimo='$acronimo', activo=$activo, descripcion='$descripcion', updated_at='$updated_at', updated_by='$updated_by' WHERE id=$id; ";
        $j++;
     }
    $newDatafp[]=$value;
   }

  $updatefp=$updatefp."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatefp);
  }
  echo json_encode($newDatafp);
  $q->close();
}

// oferta //
$ofIds=array(); $i=0;
if($object[0]['oferta'] && $tipo == "createdat"){

   foreach ($object[0]['oferta'] as $item => $value) { 
      $ofIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $ofIds);
  $ids_existentesof=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM oferta WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentesof[$result["id"]]=$result["id"];
    }
  }
   $newDataof=array();
  $insertof="BEGIN; set foreign_key_checks=0; INSERT INTO oferta (id, nombre, fecha, fecha_venc, empresa_id, deposito_id, ncontrol,tipo_oferta, activo, precio_usd, qty, exento,tasa, url_imagen, url_imagen_desc, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
  $insertod="INSERT INTO oferta_det (oferta_id, inventario_id) VALUES ";
  $k=0; $y=0;
  foreach ($object[0]['oferta'] as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nom"];
    $fecha=$value["fe"];
    $fecha_venc=$value["fev"];
    $empresa_id=$value["eid"];
    $deposito_id=$value["did"];
    $ncontrol=$value["nc"];
    $tipo_oferta=$value["tof"];
    $activo=$value["act"];
    $precio_usd=$value["pusd"];
    $qty=$value["qty"];
    $exento=$value["ex"];
    $tasa=$value["tasa"];
    $url_imagen=$value["urli"];
    $url_imagen_desc=$value["urlid"];
    $descripcion=$value["des"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];
    $dets=$value["dets"];
  
    if(empty($ids_existentesof[$id])) {
       $insertof=$insertof."($id,'$nombre','$fecha','$fecha_venc',$empresa_id,$deposito_id,'$ncontrol', $tipo_oferta,$activo,'$precio_usd','$qty',$exento,'$tasa','$url_imagen','$url_imagen_desc','$descripcion','$created_at','$created_at',$created_by,$updated_by), ";
        $k++;
        foreach ($value["dets"] as $key => $detalle) {
          $oferta_id=$detalle["oid"];
          $inventario_id=$detalle["iid"];
       
       $insertod=$insertod."($oferta_id,$inventario_id), ";
       $y++;
      }
    }
  //  $newDataof[]=$value;
   }

  $insertof=substr($insertof, 0, -2)."; ";
  $insertod=substr($insertod, 0, -2)."; COMMIT;";
 echo $sentencia=$insertof.$insertod;
   if($k>0) {
    $error2 = $q->execute($sentencia);
  } 
 // echo json_encode($newDataof);
  $q->close();
 } 
 elseif($object[0]['oferta'] && $tipo == "updatedat"){
   foreach ($object[0]['oferta'] as $item => $value) { 
      $ofIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $ofIds);
  $ids_existentesof=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM oferta WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentesof[$result["id"]]=$result["id"];
    }
  }
  $newDataof=array();
  $updateof="BEGIN; set foreign_key_checks=0; ";
  $j=0; 
  foreach ($object[0]['oferta'] as $key => $value) { 
    $id=$value["id"];
    $fecha_venc=$value["fev"];
    $activo=$value["act"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];
         
    if(!empty($ids_existentesof[$id])) {
      $updateof=$updateof." UPDATE oferta SET fecha_venc='$fecha_venc', activo=$activo, updated_at='$updated_at', updated_by='$updated_by' WHERE id=$id; ";
        $j++;
      } 
    $newDataof[]=$value;
   }

  $updateof=$updateof."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updateof);
  }
  echo json_encode($newDataof);
  $q->close();
 } 
