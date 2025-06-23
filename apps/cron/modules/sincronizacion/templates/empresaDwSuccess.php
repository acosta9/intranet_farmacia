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
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
   $results = $q->execute("SELECT updated_at as fecha FROM empresa WHERE id=$eid");

  foreach ($results as $result) {
    $fecha=strtotime($result["fecha"]);
  }

  $q->close();

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/empresa/gets?eid=$eid&fecha=$fecha",
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
  $object = json_decode($response, true);

// empresa //
$Ids=array(); $i=0;
  foreach ($object as $key => $value) { 
    $Ids[$i]=$value["id"];
    $i++;
  }
   
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $Ids);
$ids_existentes=array();
if(!empty($ids)){
  $results = $q->execute("SELECT id FROM empresa WHERE id IN ($ids)");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }
}
  $newData=array();
  $update="BEGIN; set foreign_key_checks=0;";
  $j=0; 
  foreach ($object as $key => $value) { 
      $id=$value["id"];
      $nombre=$value["nom"];
      $acronimo=$value["acr"];
      $rif=$value["rif"];
      $cod_coorpotulipa=$value["corpt"];
      $direccion=$value["dir"];
      $telefono=$value["tlf"];
      $email=$value["email"];
      $tipo=$value["tipo"];
      $iva=$value["iva"];
      $tasa=$value["tasa"];
      $venc_registro_comercio=$value["fvrc"];
      $venc_rif=$value["fvrif"];
      $venc_bomberos=$value["fvb"];
      $venc_lic_funcionamiento=$value["fvl"];
      $venc_uso_conforme=$value["fvuc"];
      $venc_permiso_sanitario=$value["fvps"];
      $venc_permiso_instalacion=$value["fvpi"];
      $venc_destinado_afines=$value["fvda"];
      $venc_destinado_abastos=$value["fvdab"];
      $descripcion=$value["des"];
      $updated_at=date("Y-m-d H:i:s", $value["uat"]);
      $updated_by=$value["uby"]; 
    
    if(!empty($ids_existentes[$id])) {
       $update=$update." UPDATE empresa SET nombre = '$nombre', acronimo = '$acronimo', rif = '$rif', cod_coorpotulipa = '$cod_coorpotulipa', direccion = '$direccion', telefono = '$telefono', email = '$email', tipo = $tipo, iva = $iva, tasa = '$tasa', venc_registro_comercio = '$venc_registro_comercio', venc_rif = '$venc_rif', venc_bomberos = '$venc_bomberos', venc_lic_funcionamiento = '$venc_lic_funcionamiento', venc_uso_conforme = '$venc_uso_conforme', venc_permiso_sanitario = '$venc_permiso_sanitario', venc_permiso_instalacion = '$venc_permiso_instalacion', venc_destinado_afines = '$venc_destinado_afines', venc_destinado_abastos = '$venc_destinado_abastos', descripcion = '$descripcion', updated_at = '$updated_at', updated_by =  $updated_by WHERE id=$id; ";
      $j++;
    }
    $newData[]=$value;
   }

   $update=$update."COMMIT; ";

    if($j>0) {
      $error3 = $q->execute($update);
    }
    
    echo json_encode($newData);
    $q->close();