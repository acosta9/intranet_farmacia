<?php
 $domain = $sf_params->get('d');
 $tipo = $sf_params->get('t');

 exec("ping -c 3 " . $domain, $output, $result);
  if ($result == 0) {
    echo "<br/>Ping successful!<br/>";
  } else {
    echo "<br/>Ping unsuccessful!<br/>";
    die();
  }

 $q = Doctrine_Manager::getInstance()->getCurrentConnection();
 if($tipo=="createdat") {
  $results = $q->execute("SELECT created_at as fecha FROM prod_unidad WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
 } else {
  $results = $q->execute("SELECT updated_at as fecha FROM prod_unidad WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
 }
  foreach ($results as $result) {
    $fecha1=strtotime($result["fecha"]);
  } 
 if($tipo=="createdat") {
  $results2 = $q->execute("SELECT created_at as fecha FROM prod_laboratorio WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
 } else {
    $results2 = $q->execute("SELECT updated_at as fecha FROM prod_laboratorio WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
 }
  foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
  }
 if($tipo=="createdat") {
  $results3 = $q->execute("SELECT created_at as fecha FROM prod_categoria WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else {
    $results3 = $q->execute("SELECT updated_at as fecha FROM prod_categoria WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
 foreach ($results3 as $result3) {
    $fecha3=strtotime($result3["fecha"]);
  }
  $q->close();
 

 $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/variosprod/gets?tipo=$tipo&fecha1=$fecha1&fecha2=$fecha2&fecha3=$fecha3",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Accept: application/json'
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  $object = json_decode($response, true);

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
