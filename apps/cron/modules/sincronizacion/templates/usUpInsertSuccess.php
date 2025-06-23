<?php
 $domain = $sf_params->get('d');

 exec("ping -c 3 " . $domain, $output, $result);
  if ($result == 0) {
    echo "<br/>Ping successful!<br/>";
  } else {
    echo "<br/>Ping unsuccessful!<br/>";
    die();
  }

 $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/usuario/getFecha?tipo=createdat",
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
  $data = json_decode($response, true);

 if(!empty($data[0]['fecha1']))
  $fechaus=date("Y-m-d H:i:s", $data[0]['fecha1']);
 if(!empty($data[0]['fecha2']))
  $fechap=date("Y-m-d H:i:s", $data[0]['fecha2']);
 if(!empty($data[0]['fecha3']))
  $fechaup=date("Y-m-d H:i:s", $data[0]['fecha3']);


  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  // sf_guard_user //
  $usuarios=array();
  if(!empty($data[0]['fecha1'])){
    $results = $q->execute("SELECT * FROM sf_guard_user WHERE created_at>'$fechaus'");

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
  }
  // sf_guard_permission //
  $permisos=array();
  if(!empty($data[0]['fecha2'])){
    $results2 = $q->execute("SELECT * FROM sf_guard_permission WHERE created_at>'$fechap'");

    foreach ($results2 as $result2) {
     
      $permisos[]=array (
        'idp' => $result2["id"],
        'nap' => $result2["name"],
        'desp' => $result2["description"],
        'cat' => strtotime($result2["created_at"]),
        'uat' => strtotime($result2["updated_at"])    
      );
    }
  }
// sf_guard_user_permission //
 $upermisos=array();
 if(!empty($data[0]['fecha3'])){
    $results3 = $q->execute("SELECT * FROM sf_guard_user_permission WHERE created_at>'$fechaup'");

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

 echo $data_update = json_encode($usData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/usuario/post?tipo=createdat",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => "$data_update",
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
      'Accept: application/json'
    ),
  ));
  $resp = curl_exec($curl);
  curl_close($curl);
  $data = json_decode($resp, true);

  print_r($data);
?>