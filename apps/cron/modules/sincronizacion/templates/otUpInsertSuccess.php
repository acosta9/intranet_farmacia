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
    CURLOPT_URL => "http://$domain/api.php/otros/getFecha?eid=$eid&tipo=createdat",
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
 
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  // otros //
  $otros=array();
    $results = $q->execute("SELECT * FROM otros WHERE empresa_id = '$eid' AND id IN ( SELECT MAX(id) FROM otros as o2 WHERE empresa_id = '$eid' GROUP BY o2.nombre )");

    foreach ($results as $result) {
     
      $otros[]=array (
        'id' => $result["id"],
        'eid' => $result["empresa_id"],
        'nom' => $result["nombre"],
        'val' => $result["valor"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"]),
        'cby' => $result["created_by"],
        'uby' => $result["updated_by"]   
      );
    }

  // forma_pago //
  $formasp=array();
  if(!empty($data[0]['fecha2'])){
    $results2 = $q->execute("SELECT * FROM forma_pago WHERE created_at>'$fechafp'");

    foreach ($results2 as $result2) {
     
      $formasp[]=array (
        'id' => $result2["id"],
        'mon' => $result2["moneda"],
        'nom' => $result2["nombre"],
        'acr' => $result2["acronimo"],
        'act' => $result2["activo"],
        'des' => $result2["descripcion"],
        'catp' => strtotime($result2["created_at"]),
        'uatp' => strtotime($result2["updated_at"]),
        'cby' => $result2["created_by"],
        'uby' => $result2["updated_by"]    
      );
    }
  }

  // oferta //
  $ofertas=array();
  if(!empty($data[0]['fecha3'])){
    $results3 = $q->execute("SELECT * FROM oferta WHERE empresa_id=$eid && created_at>'$fechaof'");

    foreach ($results3 as $result3) {
      $oid=$result3["id"];
       $ofertasDetalle = $q->execute("SELECT * FROM oferta_det WHERE oferta_id = $oid");
       $detalles = array();
      foreach ($ofertasDetalle as $detalle) {
        $detalles[] =  array ( 'oid' => $detalle["oferta_id"],
                               'iid' => $detalle["inventario_id"] );  
      }     
     
      $ofertas[]=array (
        'id' => $result3["id"],
        'nom' => $result3["nombre"],
        'fe' => $result3["fecha"],
        'fev' => $result3["fecha_venc"],
        'eid' => $result3["empresa_id"],
        'did' => $result3["deposito_id"],
        'nc' => $result3["ncontrol"],
        'tof' => $result3["tipo_oferta"],
        'act' => $result3["activo"],
        'pusd' => $result3["precio_usd"],
        'qty' => $result3["qty"],
        'ex' => $result3["exento"],
        'tasa' => $result3["tasa"],
        'urli' => $result3["url_imagen"],
        'urlid' => $result3["url_imagen_desc"],
        'des' => $result3["descripcion"],
        'cat' => strtotime($result3["created_at"]),
        'uat' => strtotime($result3["updated_at"]),
        'cby' => $result3["created_by"],
        'uby' => $result3["updated_by"],
        'dets' =>$detalles  
      );
    }
  }

  $otData = array();
  $otData[]=array (
    'otro' => $otros,
    'formap' => $formasp,
    'oferta' => $ofertas
  );

 echo $data_update = json_encode($otData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/otros/post?tipo=createdat&eid=$eid",
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