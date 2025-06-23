<?php
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
    CURLOPT_URL => "http://$domain/api.php/compuesto/getFecha?tipo=updatedat",
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
  $fechac=date("Y-m-d H:i:s", $data[0]['fecha1']);
 if(!empty($data[0]['fecha2']))
  $fechap=date("Y-m-d H:i:s", $data[0]['fecha2']);
 
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  
  // compuesto //
  $compuestos=array();
  if(!empty($data[0]['fecha1'])){
    $results = $q->execute("SELECT * FROM compuesto WHERE updated_at>='$fechac'");

    foreach ($results as $result) {
     
      $compuestos[]=array (
        'id' => $result["id"],
        'nom' => $result["nombre"],
        'des' => $result["descripcion"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]   
      );
    }
  }
  // prod_compuesto //
  $prodcps=array();
  if(!empty($data[0]['fecha2'])){
    $results2 = $q->execute("SELECT prod_compuesto.producto_id, prod_compuesto.compuesto_id FROM producto INNER JOIN prod_compuesto ON producto.id = prod_compuesto.producto_id WHERE producto.updated_at>='$fechap' ");

    foreach ($results2 as $result2) {
     
      $prodcps[]=array (
        'pid' => $result2["producto_id"],
        'cid' => $result2["compuesto_id"]   
      );
    }
  }

  $compData = array();
  $compData[]=array (
    'compuesto' => $compuestos,
    'prodcp' => $prodcps
  );

 echo $data_update = json_encode($compData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/compuesto/post?tipo=updatedat",
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