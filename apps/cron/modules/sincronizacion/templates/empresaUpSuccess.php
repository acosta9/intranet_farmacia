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
    CURLOPT_URL => "http://$domain/api.php/empresa/getFecha?eid=$eid",
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
    $results = $q->execute("SELECT * FROM empresa WHERE id=$eid && updated_at>'$fecha'");

    $newData=array();
      foreach ($results as $result) {
  
      $newData[]=array (
        'id' => $result["id"],
        'nom' => $result["nombre"],
        'acr' => $result["acronimo"],
        'rif' => $result["rif"],
        'corpt' => $result["cod_coorpotulipa"],
        'dir' => $result["direccion"],
        'tlf' => $result["telefono"],
        'email' => $result["email"],
        'tipo' => $result["tipo"],
        'iva' => $result["iva"],
        'tasa' => $result["tasa"],
        'fvrc' => $result["venc_registro_comercio"],
        'fvrif' => $result["venc_rif"],
        'fvb' => $result["venc_bomberos"],
        'fvl' => $result["venc_lic_funcionamiento"],
        'fvuc' => $result["venc_uso_conforme"],
        'fvps' => $result["venc_permiso_sanitario"],
        'fvpi' => $result["venc_permiso_instalacion"],
        'fvda' => $result["venc_destinado_afines"],
        'fvdab' => $result["venc_destinado_abastos"],
        'des' => $result["descripcion"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]
      );
    }

   $data_update = json_encode($newData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/empresa/post",
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