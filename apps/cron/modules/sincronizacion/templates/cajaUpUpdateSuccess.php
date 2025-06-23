<?php
// caja, caja_user, empresa_user
 $eid = $sf_params->get('eid');
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
    CURLOPT_URL => "http://$domain/api.php/caja/getFecha?eid=$eid&tipo=updatedat",
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
  $fechac=date("Y-m-d H:i:s", $data[0]['fecha1']);
 if(!empty($data[0]['fecha2']))
  $fechacu=date("Y-m-d H:i:s", $data[0]['fecha2']);
 if(!empty($data[0]['fecha3']))
  $fechaeu=date("Y-m-d H:i:s", $data[0]['fecha3']);
 
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  // caja //
  $cajas=array();
  if(!empty($data[0]['fecha1'])){
    $results = $q->execute("SELECT * FROM caja WHERE empresa_id = '$eid' && updated_at>'$fechac'");

    foreach ($results as $result) {
     
      $cajas[]=array (
        'id' => $result["id"],
        'nom' => $result["nombre"],
        'tipo' => $result["tipo"],
        'des' => $result["descripcion"],
        'uby' => $result["updated_by"]   
      );
    }
  }

  // caja_user //
  $cajasu=array();
  if(!empty($data[0]['fecha2'])){
    $results2 = $q->execute("SELECT * FROM caja_user WHERE substring(caja_id,1,2)=$eid  && updated_at>'$fechacu'");

    foreach ($results2 as $result2) {
     
      $cajasu[]=array (
        'cid' => $result2["caja_id"],
        'uid' => $result2["user_id"],
        'cat' => strtotime($result2["created_at"]),
        'uat' => strtotime($result2["updated_at"])
      );
    }
  }

  // empresa_user //
  $empuss=array();
  if(!empty($data[0]['fecha3'])){
    $results3 = $q->execute("SELECT * FROM empresa_user WHERE empresa_id = '$eid' && updated_at>'$fechaeu'");

    foreach ($results3 as $result3) {
     
      $empuss[]=array (
        'eid' => $result3["empresa_id"],
        'uid' => $result3["user_id"],
        'cat' => strtotime($result3["created_at"]),
        'uat' => strtotime($result3["updated_at"])
      );
    }
  }


  $caData = array();
  $caData[]=array (
    'caja' => $cajas,
    'cajau' => $cajasu,
    'empus' => $empuss
  );

 echo $data_update = json_encode($caData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/caja/post?tipo=updatedat",
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