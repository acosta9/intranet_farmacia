<?php

  $eid = $sf_params->get('eid');
  $domain = $sf_params->get('d');

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/inventario/getFecha?eid=$eid&tipo=updatedat",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
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

  $eid = $sf_params->get('eid');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

  $newData=array();
  $results = $q->execute("SELECT * FROM inventario WHERE empresa_id=$eid && updated_at<>created_at && updated_at>'$fecha'");

  foreach ($results as $result) {
    if(empty($result["limite_stock"])) {
      $lstock="0";
    }
    $newData[]=array (
      'id' => $result["id"],
      'did' => $result["deposito_id"],
      'eid' => $result["empresa_id"],
      'pid' => $result["producto_id"],
      'qty' => $result["cantidad"],
      'act' => $result["activo"],
      'lstock' => $lstock,
      'cat' => strtotime($result["created_at"]),
      'uat' => strtotime($result["updated_at"]),
      'cby' => $result["created_by"],
      'uby' => $result["updated_by"]
    );
  }
  $data_update = json_encode($newData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/inventario/post",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
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