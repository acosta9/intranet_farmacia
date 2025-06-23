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
 $fecha1=0;$fecha2=0;$fecha3=0;

if($tipo=="createdat") {
 $results = $q->execute("SELECT created_at as fecha FROM sf_guard_user ORDER BY created_at DESC LIMIT 1");
  } else {
    $results = $q->execute("SELECT updated_at as fecha FROM sf_guard_user WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
  foreach ($results as $result) {
    $fecha1=strtotime($result["fecha"]);
  }
 if($tipo=="createdat") {
 $results2 = $q->execute("SELECT created_at as fecha FROM sf_guard_permission WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else {
    $results2 = $q->execute("SELECT updated_at as fecha FROM sf_guard_permission WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
  foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
  }
if($tipo=="createdat") {
 $results3 = $q->execute("SELECT created_at as fecha FROM sf_guard_user_permission ORDER BY created_at DESC LIMIT 1");
  } else {
    $results3 = $q->execute("SELECT updated_at as fecha FROM sf_guard_user_permission ORDER BY updated_at DESC LIMIT 1");
  }
 foreach ($results3 as $result3) {
    $fecha3=strtotime($result3["fecha"]);
  }
  $q->close();
 

 $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/usuario/gets?tipo=$tipo&fecha1=$fecha1&fecha2=$fecha2&fecha3=$fecha3",
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


// sf_guard_user //
$usIds=array(); $i=0; 
if($object[0]['usuario'] && $tipo == "createdat"){
  foreach ($object[0]['usuario'] as $key => $value) { 
    $usIds[$i]=$value["id"];
    $i++;
  }  

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $usIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM sf_guard_user WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDataus=array();
  $insertus="BEGIN; set foreign_key_checks=0; INSERT INTO sf_guard_user (id , full_name , email_address , clave , username , url_imagen , cargo , algorithm , salt , password , is_active , is_super_admin , last_login , created_at , updated_at) VALUES ";
  $k=0;
  foreach ($object[0]['usuario'] as $key => $value) { 
    $id=$value["id"];
    $full_name=$value["fna"];
    $email_address=$value["ead"];
    $clave=$value["cla"];
    $username=$value["usr"];
    $cliente_id=$value["cid"];
    $url_imagen=$value["urli"];
    $cargo=$value["car"];
    $algorithm=$value["alg"];
    $salt=$value["salt"];
    $password=$value["pass"];
    $is_active=$value["act"];
    $is_super_admin=$value["sup"];
    $last_login=$value["last"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    if($clave==NULL || $clave=="" || $clave==null){
      $clave='NULL';
    } else {
      $clave='$clave';
    }
    if($cliente_id==NULL || $cliente_id=="" || $cliente_id==null){
      $cliente_id='NULL';
    } else {
      $cliente_id='$cliente_id';
    }

    if(empty($ids_existentes[$id])) {
      $insertus=$insertus."($id, '$full_name' , '$email_address' , $clave , '$username' , '$url_imagen' , '$cargo' , '$algorithm' , '$salt' , '$password' , $is_active , $is_super_admin , '$last_login' , '$created_at', '$created_at'), ";
      $k++;
    }
    $newDataus[]=$value;
   }
   $insertus=substr($insertus, 0, -2)."; COMMIT; ";
 
  if($k>0) {
    $error2 = $q->execute($insertus);
  } 
  echo json_encode($newDataus);
  $q->close();
}
elseif($object[0]['usuario'] && $tipo == "updatedat"){
  foreach ($object[0]['usuario'] as $key => $value) { 
    $usIds[$i]=$value["id"];
    $i++;
  }  

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $usIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM sf_guard_user WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDataus=array();
  $updateus="BEGIN; set foreign_key_checks=0; ";
  $j=0;
  foreach ($object[0]['usuario'] as $key => $value) { 
    $id=$value["id"];
    $full_name=$value["fna"];
    $email_address=$value["ead"];
    $username=$value["usr"];
    $cliente_id=$value["cid"];
    $cargo=$value["car"];
    $algorithm=$value["alg"];
    $is_active=$value["act"];
    $is_super_admin=$value["sup"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
  
    if($cliente_id==NULL || $cliente_id=="" || $cliente_id==null){
      $cliente_id='NULL';
    } else {
      $cliente_id='$cliente_id';
    }

    if(!empty($ids_existentes[$id])) {
      $updateus=$updateus." UPDATE sf_guard_user SET full_name='$full_name' , email_address='$email_address' , username='$username', cliente_id=$cliente_id, cargo='$cargo' , algorithm='$algorithm' , is_active=$is_active , is_super_admin=$is_super_admin , updated_at='$updated_at' WHERE id=$id; ";
      $j++;
    }
    $newDataus[]=$value;
   }
   $updateus=$updateus."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updateus);
  }
  
  echo json_encode($newDataus);
  $q->close();
}

// sf_guard_permission //
$pIds=array(); $i=0;
if($object[0]['permiso'] && $tipo == "createdat"){
  foreach ($object[0]['permiso'] as $key => $value) { 
    $pIds[$i]=$value["idp"];
    $i++;
  }  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $idsp=implode(",", $pIds);
  $ids_existentesp=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM sf_guard_permission WHERE id IN ($idsp)");
    foreach ($results as $result) {
      $ids_existentesp[$result["id"]]=$result["id"];
    }
  }
  $newDatap=array();
  $insertp="BEGIN; set foreign_key_checks=0; INSERT INTO sf_guard_permission (id , name , description , created_at , updated_at) VALUES ";
  $k=0;
  foreach ($object[0]['permiso'] as $key => $value) { 
    $id=$value["idp"];
    $name=$value["nap"];
    $description=$value["desp"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);

    if(empty($ids_existentesp[$id])) {
      $insertp=$insertp."($id , '$name' , '$description' , '$created_at' , '$created_at'), ";
      $k++;
    }
    $newDatap[]=$value;
   }

  $insertp=substr($insertp, 0, -2)."; COMMIT;";
 
  if($k>0) {
    $error2 = $q->execute($insertp);
  } 
  echo json_encode($newDatap);
$q->close();
}
elseif($object[0]['permiso'] && $tipo == "updatedat"){
  foreach ($object[0]['permiso'] as $key => $value) { 
    $pIds[$i]=$value["idp"];
    $i++;
  }  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $idsp=implode(",", $pIds);
  $ids_existentesp=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM sf_guard_permission WHERE id IN ($idsp)");
    foreach ($results as $result) {
      $ids_existentesp[$result["id"]]=$result["id"];
    }
  }
  $newDatap=array();
  $updatep="BEGIN; set foreign_key_checks=0; ";
  $j=0;
  foreach ($object[0]['permiso'] as $key => $value) { 
    $id=$value["idp"];
    $name=$value["nap"];
    $description=$value["desp"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);

    if(!empty($ids_existentesp[$id])) {
     $updatep=$updatep." UPDATE sf_guard_permission SET  name='$name', description='$description', updated_at='$updated_at' WHERE id=$id; ";
      $j++;
    }
    $newDatap[]=$value;
   }

  $updatep=$updatep."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatep);
  }
  echo json_encode($newDatap);
  $q->close();
}

// sf_guard_user_permission //

$newDataup=array();
if($object[0]['upermiso']){
  $replaceup="BEGIN; set foreign_key_checks=0; REPLACE INTO sf_guard_user_permission (user_id, permission_id, created_at, updated_at) VALUES ";

  $k=0;
  foreach ($object[0]['upermiso'] as $key => $value) {
    $user_id=$value["iduup"];
    $permission_id=$value["idpup"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
     
    $replaceup=$replaceup."($user_id , $permission_id , '$created_at' , '$updated_at'), ";
    $k++;

    $newDataup[]=$value;
   }

  $replaceup=substr($replaceup, 0, -2)."; COMMIT;";

  if($k>0) {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $error2 = $q->execute($replaceup);
    $q->close();
  } 

  echo json_encode($newDataup);
 } 
?>