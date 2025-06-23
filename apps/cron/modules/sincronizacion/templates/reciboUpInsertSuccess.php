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
    CURLOPT_URL => "http://$domain/api.php/recibo/getFecha?eid=$eid&tipo=createdat",
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
 if(!empty($data[0]['fecha2']))
  $fecha2=date("Y-m-d H:i:s", $data[0]['fecha2']);

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  
  // recibo_pago //
  $recibos=array();
  if(!empty($data[0]['fecha1'])){
    $results = $q->execute("SELECT * FROM recibo_pago WHERE empresa_id = '$eid' AND created_at>='$fecha1' ORDER BY created_at ASC LIMIT 100");

    foreach ($results as $result) {
     
      $recibos[]=array (
        'id' => $result["id"],
        'eid' => $result["empresa_id"],
        'cid' => $result["cliente_id"],
        'ccid' => $result["cuentas_cobrar_id"],
        'nc' => $result["ncontrol"],
        'mone' => $result["moneda"],
        'fp' => $result["forma_pago_id"],
        'numr' => $result["num_recibo"],
        'fe' => $result["fecha"],
        'mon' => $result["monto"],
        'mon2' => $result["monto2"],
        'quien' => $result["quien_paga"],
        'urli' => $result["url_imagen"],
        'tasa' => $result["tasa_cambio"],
        'des' => $result["descripcion"],
        'anu' => $result["anulado"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"]),
        'cby' => $result["created_by"],
        'uby' => $result["updated_by"]   
      );
    }
  }

  // prod_vendidos //
  $pvendidos=array();
  if(!empty($data[0]['fecha2'])){
    $results2 = $q->execute("SELECT * FROM prod_vendidos WHERE empresa_id = '$eid' AND fecha>='$fecha2' ORDER BY fecha ASC LIMIT 200");

    foreach ($results2 as $result2) {
     
      $pvendidos[]=array (
        'id' => $result2["id"],
        'eid' => $result2["empresa_id"],
        'did' => $result2["deposito_id"],
        'pid' => $result2["producto_id"],
        'cid' => $result2["cliente_id"],
        'uid' => $result2["user_id"],
        'punit' => $result2["price_unit"],
        'ptot' => $result2["price_tot"],
        'tabla' => $result2["tabla"],
        'tid' => $result2["tabla_id"],
        'fe' => $result2["fecha"],
        'cant' => $result2["cantidad"],
        'of' => $result2["oferta"],
        'anu' => $result2["anulado"]
       );
    }
  }
  
  $recData = array();
  $recData[]=array (
    'recibo' => $recibos,
    'pvendido' => $pvendidos
  );

 echo $data_update = json_encode($recData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/recibo/post?tipo=createdat",
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