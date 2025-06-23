<?php
// caja_arqueo, caja_corte, caja_det, caja_efectivo //
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
    CURLOPT_URL => "http://$domain/api.php/cajaf/getidsf?eid=$eid",
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
 
 if(!empty($data[0]['idar']))
  $idar=$data[0]['idar'];
 if(!empty($data[0]['idcr']))
  $idcr=$data[0]['idcr'];
 if(!empty($data[0]['iddt']))
  $iddt=$data[0]['iddt'];
 if(!empty($data[0]['idef']))
  $idef=$data[0]['idef'];
 
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  // caja_arqueo //
  $cajaars=array();
  if($idar){
    $results = $q->execute("SELECT * FROM caja_arqueo WHERE id >'$idar'");

    foreach ($results as $result) {
     
      $cajaars[]=array (
        'id' => $result["id"],
        'cid' => $result["caja_id"],
        'uid' => $result["sf_guard_user_id"],
        'fe' => $result["fecha"],
        'mon' => $result["moneda"],
        'fpid' => $result["forma_pago_id"],
        'monto' => $result["monto"],
        'des' => $result["descripcion"]
      );
    }
  }

  // caja_corte //
  $cajacortes=array();
  if($idcr){
    $results2 = $q->execute("SELECT * FROM caja_corte WHERE id >'$idcr'");

    foreach ($results2 as $result2) {
     
      $cajacortes[]=array (
        'id' => $result2["id"],
        'cid' => $result2["caja_id"],
        'uid' => $result2["sf_guard_user_id"],
        'tipo' => $result2["tipo"],
        'fini' => $result2["fecha_ini"],
        'fin' => $result2["fecha_fin"],
        'uz' => $result2["ult_repz"],
        'fz' => $result2["fecha_repz"],
        'hz' => $result2["hora_repz"],
        'uf' => $result2["ult_fact"],
        'fuf' => $result2["fecha_ult_fact"],
        'huf' => $result2["hora_ult_fact"],
        'unc' => $result2["ult_nc"],
        'exf' => $result2["exento_fact"],
        'bif' => $result2["base_impt1_fact"],
        'it1f' => $result2["iva_t1_fact"],
        'exnc' => $result2["exento_nc"],
        'binc' => $result2["base_impt1_nc"],
        'it1nc' => $result2["iva_t1_nc"],
        'codf' => $result2["codigof"],
        'cantf' => $result2["cant_fact"],
        'cantnc' => $result2["cant_nc"]
       );
    }
  }
 
  // caja_det //
  $cajadets=array();
  if($iddt){
    $results3 = $q->execute("SELECT * FROM caja_det WHERE  id >'$iddt'");

    foreach ($results3 as $result3) {
     
      $cajadets[]=array (
        'id' => $result3["id"],
        'cid' => $result3["caja_id"],
        'uid' => $result3["sf_guard_user_id"],
        'fe' => $result3["fecha"],
        'st' => $result3["status"],
        'fon' => $result3["fondo"],
        'des' => $result3["descripcion"]
      );
    }
  }

  // caja_efectivo //
  $cajaefs=array();
  if($idef){
    $results4 = $q->execute("SELECT * FROM caja_efectivo WHERE  id >'$idef'");

    foreach ($results4 as $result4) {
     
      $cajaefs[]=array (
        'id' => $result4["id"],
        'cid' => $result4["caja_id"],
        'uid' => $result4["sf_guard_user_id"],
        'fe' => $result4["fecha"],
        'mon' => $result4["moneda"],
        'bil' => $result4["billete"],
        'cant' => $result4["cantidad"],
        'des' => $result4["descripcion"]
      );
    }
  }

  $caData = array();
  $caData[]=array (
    'cajaar' => $cajaars,
    'cajacorte' => $cajacortes,
    'cajadet' => $cajadets,
    'cajaef' => $cajaefs
  );

 echo $data_update = json_encode($caData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/cajaf/post",
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