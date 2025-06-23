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
      $updateus=$updateus." UPDATE sf_guard_user SET full_name='$full_name' , email_address='$email_address' , username='$username', cliente_id=$cliente_id, cargo='$cargo' , algorithm='$algorithm' , is_active=$is_active , is_super_admin=$is_super_admin , last_login='$last_login' , updated_at='$updated_at' WHERE id=$id; ";
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

 echo $replaceup=substr($replaceup, 0, -2)."; COMMIT; ";

  if($k>0) {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $error2 = $q->execute($replaceup);
    $q->close();
  } 

  echo json_encode($newDataup);
}