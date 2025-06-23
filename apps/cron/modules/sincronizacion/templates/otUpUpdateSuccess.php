<?php
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
    CURLOPT_URL => "http://$domain/api.php/otros/getFecha?eid=$eid&tipo=updatedat",
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
  $fechaot=date("Y-m-d H:i:s", $data[0]['fecha1']);
 if(!empty($data[0]['fecha2']))
  $fechafp=date("Y-m-d H:i:s", $data[0]['fecha2']);
 if(!empty($data[0]['fecha3']))
  $fechaof=date("Y-m-d H:i:s", $data[0]['fecha3']);
 
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  // otros //
  $otros=array();
 
  // forma_pago //
  $formasp=array();
  if(!empty($data[0]['fecha2'])){
    $results2 = $q->execute("SELECT * FROM forma_pago WHERE  updated_at>'$fechafp'");

    foreach ($results2 as $result2) {
     
      $formasp[]=array (
        'id' => $result2["id"],
        'mon' => $result2["moneda"],
        'nom' => $result2["nombre"],
        'acr' => $result2["acronimo"],
        'act' => $result2["activo"],
        'des' => $result2["descripcion"],
        'uat' => strtotime($result2["updated_at"]),
        'uby' => $result2["updated_by"]    
      );
    }
  }
  
    // oferta //
  $ofertas=array();
  if(!empty($data[0]['fecha3'])){
    $results3 = $q->execute("SELECT * FROM oferta WHERE empresa_id = '$eid'  && updated_at>'$fechaof'");

    foreach ($results3 as $result3) {
     
      $ofertas[]=array (
        'id' => $result3["id"],
        'fev' => $result3["fecha_venc"],
        'act' => $result3["activo"],
        'uat' => strtotime($result3["updated_at"]),
        'uby' => $result3["updated_by"]   
      );
    }
  }

  $odets=array();

  $otData = array();
  $otData[]=array (
    'otro' => $otros,
    'formap' => $formasp,
    'oferta' => $ofertas
  );

 echo $data_update = json_encode($otData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/otros/post?tipo=updatedat",
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

  //print_r($data);
?>