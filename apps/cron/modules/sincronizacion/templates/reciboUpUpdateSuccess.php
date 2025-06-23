<?php
// recibo_pago, prod_vendidos
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
    CURLOPT_URL => "http://$domain/api.php/recibo/getFecha?eid=$eid&tipo=updatedat",
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

 
 if(!empty($data[0]['fecha1']))
  $fecha1=date("Y-m-d H:i:s", $data[0]['fecha1']);
 
 
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  // recibo_pago //
  $recibos=array();
  if(!empty($data[0]['fecha1'])){
    $results = $q->execute("SELECT * FROM recibo_pago WHERE empresa_id = '$eid' AND updated_at >='$fecha1' LIMIT 100");

    foreach ($results as $result) {
     
      $recibos[]=array (
        'id' => $result["id"],
        'anu' => $result["anulado"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]   
      );
    }
  }

  // prod_vendidos //
  $pvendidos=array();
  $second_date = date("Y-m-d", strtotime("-5 days"));
  $fecha2 = $second_date." 00:00:00";
  $results2 = $q->execute("SELECT prod_vendidos.id FROM prod_vendidos INNER JOIN factura ON prod_vendidos.tabla_id = factura.id WHERE prod_vendidos.tabla = 'factura' AND factura.estatus = '4' AND factura.created_at >= '$fecha2' AND prod_vendidos.empresa_id = '$eid'");

  foreach ($results2 as $result2) {
     
      $pvendidos[]=array (
        'id' => $result2["id"]        
       );
    }
  
  $recData = array();
  $recData[]=array (
    'recibo' => $recibos,
    'pvendido' => $pvendidos
  );

 echo $data_update = json_encode($recData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/recibo/post?tipo=updatedat",
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