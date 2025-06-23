<?php
  $tipo = $sf_params->get('tipo');
  $fecha1 = date("Y-m-d H:i:s", $sf_params->get('fecha1'));
  $fecha2 = date("Y-m-d H:i:s", $sf_params->get('fecha2'));
  $fecha3 = date("Y-m-d H:i:s", $sf_params->get('fecha3'));

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

// sf_guard_user //
  if($tipo=="createdat") {
    $usuarios=array();
    $results = $q->execute("SELECT * FROM sf_guard_user WHERE created_at>'$fecha1'");

    foreach ($results as $result) {
     
      $usuarios[]=array (
        'id' => $result["id"],
        'fna' => $result["full_name"],
        'ead' => $result["email_address"],
        'cla' => $result["clave"],
        'usr' => $result["username"],
        'cid' => $result["cliente_id"],
        'urli' => $result["url_imagen"],
        'car' => $result["cargo"],
        'alg' => $result["algorithm"],
        'salt' => $result["salt"],
        'pass' => $result["password"],
        'act' => $result["is_active"],
        'sup' => $result["is_super_admin"],
        'last' => $result["last_login"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"])    
      );
    }
  } else if($tipo=="updatedat") {
    $usuarios=array();
    $results = $q->execute("SELECT * FROM sf_guard_user WHERE updated_at>'$fecha1'");

    foreach ($results as $result) {
     
      $usuarios[]=array (
        'id' => $result["id"],
        'fna' => $result["full_name"],
        'ead' => $result["email_address"],
        'usr' => $result["username"],
        'cid' => $result["cliente_id"],
        'car' => $result["cargo"],
        'alg' => $result["algorithm"],
        'act' => $result["is_active"],
        'sup' => $result["is_super_admin"],
        'uat' => strtotime($result["updated_at"]) 
      );
    }
  }
  
// sf_guard_permission //
  if($tipo=="createdat") {
    $permisos=array();
    $results2 = $q->execute("SELECT * FROM sf_guard_permission WHERE created_at>'$fecha2'");

    foreach ($results2 as $result2) {
     
      $permisos[]=array (
        'idp' => $result2["id"],
        'nap' => $result2["name"],
        'desp' => $result2["description"],
        'cat' => strtotime($result2["created_at"]),
        'uat' => strtotime($result2["updated_at"])    
      );
    }
  } else if($tipo=="updatedat") {
    $permisos=array();
    $results2 = $q->execute("SELECT * FROM sf_guard_permission WHERE updated_at>'$fecha2'");

    foreach ($results2 as $result2) {
     
      $permisos[]=array (
        'idp' => $result2["id"],
        'nap' => $result2["name"],
        'desp' => $result2["description"],
        'uat' => strtotime($result2["updated_at"])    
      );
    }
  }  
  
// sf_guard_user_permission //
  if($tipo=="createdat") {
   $upermisos=array();
    $results3 = $q->execute("SELECT * FROM sf_guard_user_permission WHERE created_at>'$fecha3'");

    foreach ($results3 as $result3) {
     
      $upermisos[]=array (
        'iduup' => $result3["user_id"],
        'idpup' => $result3["permission_id"],
        'cat' => strtotime($result3["created_at"]),
        'uat' => strtotime($result3["updated_at"])    
      );
    }
  } else if($tipo=="updatedat") {
    $upermisos=array();
    $results3 = $q->execute("SELECT * FROM sf_guard_user_permission WHERE updated_at>'$fecha3'");

    foreach ($results3 as $result3) {
     
      $upermisos[]=array (
        'iduup' => $result3["user_id"],
        'idpup' => $result3["permission_id"],
        'cat' => strtotime($result3["created_at"]),
        'uat' => strtotime($result3["updated_at"])    
      );
    }
  }  
 
$usData = array();
  $usData[]=array (
    'usuario' => $usuarios,
    'permiso' => $permisos,
    'upermiso' => $upermisos
  );
$q->close();
echo json_encode($usData, JSON_PRETTY_PRINT);
?>