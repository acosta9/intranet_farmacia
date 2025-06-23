<?php
// kardex
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
    CURLOPT_URL => "http://$domain/api.php/kardex/getFecha?eid=$eid",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 45,
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
 /* $NuevaFecha = strtotime ( '-30 minute' , strtotime ($fecha) ) ;
  $nfecha =date("Y-m-d H:i:s", $NuevaFecha);*/
 $nfecha = $fecha;
 
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
 
  // kardex //
  $kardex=array();
  if($nfecha){
    $results2 = $q->execute("SELECT * FROM kardex WHERE empresa_id = '$eid' AND fecha >= '$nfecha' ORDER BY fecha ASC LIMIT 200");

    foreach ($results2 as $result2) {
     
      $kardex[]=array (
        'id' => $result2["id"],
        'eid' => $result2["empresa_id"],
        'did' => $result2["deposito_id"],
        'pid' => $result2["producto_id"],
        'uid' => $result2["user_id"],
        'tabla' => $result2["tabla"],
        'tid' => $result2["tabla_id"],
        'fe' => $result2["fecha"],
        'cant' => $result2["cantidad"],
        'punit' => $result2["price_unit"],
        'ptot' => $result2["price_tot"],
        'tipo' => $result2["tipo"],
        'con' => $result2["concepto"],
        'lote' => $result2["lote"],
        'fvenc' => $result2["fvenc"]
       );
    }
  }
    
 echo $data_update = json_encode($kardex);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/kardex/post",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 45,
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