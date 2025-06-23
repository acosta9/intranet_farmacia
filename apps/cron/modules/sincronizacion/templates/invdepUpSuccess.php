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

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/invdep/getFecha?eid=$eid&tipo=$tipo",
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

  foreach($data as $item) {
    if(!empty($item["fecha"])) {
      $fecha=date("Y-m-d H:i:s", $item["fecha"]);
    } else {
      die();
    }
  }
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

  if($tipo == "createdat"){
    $results = $q->execute("SELECT * FROM inv_deposito WHERE empresa_id=$eid && created_at>='$fecha'");

    $newData=array();
    foreach ($results as $result) {
      
      $newData[]=array (
        'id' => $result["id"],
        'eid' => $result["empresa_id"],
        'nom' => $result["nombre"],
        'acr' => $result["acronimo"],
        'tipo' => $result["tipo"],
        'des' => $result["descripcion"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"]),
        'cby' => $result["created_by"],
        'uby' => $result["updated_by"]
      );
    }
  }
  else if($tipo == "updatedat"){
    $results = $q->execute("SELECT * FROM inv_deposito WHERE empresa_id=$eid && updated_at>='$fecha'");

    $newData=array();
    foreach ($results as $result) {
      
      $newData[]=array (
        'id' => $result["id"],
        'eid' => $result["empresa_id"],
        'nom' => $result["nombre"],
        'acr' => $result["acronimo"],
        'tipo' => $result["tipo"],
        'des' => $result["descripcion"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]
      );
    }
  }
  $data_update = json_encode($newData);
  
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/invdep/post?tipo=$tipo",
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