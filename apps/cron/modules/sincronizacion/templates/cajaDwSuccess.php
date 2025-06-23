<?php
 $eid = $sf_params->get('eid');
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
 $fecha1=0;$fecha2=0;$fecha3=0;
  
 if($tipo=="createdat") { 
  $results = $q->execute("SELECT created_at as fecha FROM caja WHERE empresa_id=$eid ORDER BY created_at DESC LIMIT 1");
  } else {
    $results = $q->execute("SELECT updated_at as fecha FROM caja WHERE empresa_id=$eid AND updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
  foreach ($results as $result) {
    $fecha1=strtotime($result["fecha"]);
  }
  if($tipo=="createdat") { 
  $results2 = $q->execute("SELECT created_at as fecha FROM caja_user WHERE substring(caja_id,1,2)=$eid ORDER BY created_at DESC LIMIT 1");
  } else {
    $results2 = $q->execute("SELECT updated_at as fecha FROM caja_user WHERE substring(caja_id,1,2)=$eid ORDER BY updated_at DESC LIMIT 1");
  }
  foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
  }
  if($tipo=="createdat") { 
  $results3 = $q->execute("SELECT created_at as fecha FROM empresa_user WHERE empresa_id=$eid ORDER BY created_at DESC LIMIT 1");
  } else {
    $results3 = $q->execute("SELECT updated_at as fecha FROM empresa_user WHERE empresa_id=$eid ORDER BY updated_at DESC LIMIT 1");
  }
 foreach ($results3 as $result3) {
    $fecha3=strtotime($result3["fecha"]);
  }
 
   $q->close();


 $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/caja/gets?eid=$eid&tipo=$tipo&fecha1=$fecha1&fecha2=$fecha2&fecha3=$fecha3",
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

// caja //
$cIds=array(); $i=0;
if($object[0]['caja'] && $tipo == "createdat"){
   foreach ($object[0]['caja'] as $item => $value) { 
      $cIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $cIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM caja WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDatac=array();
  $insertc="BEGIN; set foreign_key_checks=0; INSERT INTO caja (id, empresa_id, nombre, tipo, status, fecha, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
  $k=0;
  foreach ($object[0]['caja'] as $key => $value) { 
    $id=$value["id"];
    $empresa_id=$value["eid"];
    $nombre=$value["nom"];
    $tipo=$value["tipo"];
    $status=$value["sta"];
    $fecha=$value["fe"];
    $descripcion=$value["des"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];

    if(empty($ids_existentes[$id])) {
      $insertc=$insertc."($id, $empresa_id, '$nombre', $tipo, $status, '$fecha', '$descripcion', '$created_at', '$created_at', $created_by, $updated_by), ";
      $k++;
    }
    $newDatac[]=$value;
   }

  $insertc=substr($insertc, 0, -2)."; COMMIT;";

  if($k>0) {
    $error2 = $q->execute($insertc);
  } 

  echo json_encode($newDatac);
  $q->close();
}
elseif($object[0]['caja'] && $tipo == "updatedat"){
   foreach ($object[0]['caja'] as $item => $value) { 
      $cIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $cIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM caja WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDatac=array();
  $updatec="BEGIN; set foreign_key_checks=0; ";
  $j=0;
  foreach ($object[0]['caja'] as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nom"];
    $tipo=$value["tipo"];
    $descripcion=$value["des"];
    $updated_by=$value["uby"];

    if(!empty($ids_existentes[$id])) {
      $updatec=$updatec." UPDATE caja SET nombre='$nombre', tipo=$tipo, descripcion='$descripcion',  updated_by=$updated_by WHERE id=$id; ";
      $j++;
    } 
    $newDatac[]=$value;
   }

  $updatec=$updatec."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatec);
  }

  echo json_encode($newDatac);
  $q->close();
}

// caja_user //

$newDatacu=array();
if($object[0]['cajau']){
  $replacecu="BEGIN; set foreign_key_checks=0; REPLACE INTO caja_user (caja_id, user_id, created_at, updated_at) VALUES ";

  $k=0;
  foreach ($object[0]['cajau'] as $key => $value) {
    $caja_id=$value["cid"];
    $user_id=$value["uid"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
     
    $replacecu=$replacecu."($caja_id, $user_id, '$created_at', '$updated_at'), ";
    $k++;

    $newDatacu[]=$value;
   }

 echo $replacecu=substr($replacecu, 0, -2)."; COMMIT; ";

  if($k>0) {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $error2 = $q->execute($replacecu);
    $q->close();
  } 
  echo json_encode($newDatacu);
}

// empresa_user //

$newDataeu=array();
if($object[0]['empus']){
  $replaceeu="BEGIN; set foreign_key_checks=0; REPLACE INTO empresa_user (empresa_id, user_id, created_at, updated_at) VALUES ";

  $k=0;
  foreach ($object[0]['empus'] as $key => $value) {
    $empresa_id=$value["eid"];
    $user_id=$value["uid"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
     
    $replaceeu=$replaceeu."($empresa_id, $user_id, '$created_at', '$updated_at'), ";
    $k++;

    $newDataeu[]=$value;
   }

  $replaceeu=substr($replaceeu, 0, -2)."; COMMIT;";

  if($k>0) {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $error2 = $q->execute($replaceeu);
    $q->close();
  } 
  echo json_encode($newDataeu);
}