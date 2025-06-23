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
    CURLOPT_URL => "http://$domain/api.php/variosprod/getFecha?tipo=updatedat",
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
  $fechapu=date("Y-m-d H:i:s", $data[0]['fecha1']);
if(!empty($data[0]['fecha2']))
  $fechapl=date("Y-m-d H:i:s", $data[0]['fecha2']);
if(!empty($data[0]['fecha3']))
  $fechapc=date("Y-m-d H:i:s", $data[0]['fecha3']);
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  
  // prod_unidad //
  $produs=array();
  if(!empty($data[0]['fecha1'])){
    $results = $q->execute("SELECT * FROM prod_unidad WHERE updated_at>'$fechapu'");

    foreach ($results as $result) {
     
      $produs[]=array (
        'id' => $result["id"],
        'nom' => $result["nombre"],
        'des' => $result["descripcion"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]   
      );
    }
  }
  // prod_laboratorio //
  $prodls=array();
  if(!empty($data[0]['fecha2'])){
    $results2 = $q->execute("SELECT * FROM prod_laboratorio WHERE updated_at>'$fechapl'");

    foreach ($results2 as $result2) {
     
      $prodls[]=array (
        'id' => $result2["id"],
        'nom' => $result2["nombre"],
        'des' => $result2["descripcion"],
        'uat' => strtotime($result2["updated_at"]),
        'uby' => $result2["updated_by"]     
      );
    }
  }
  // prod_categoria //
  $prodcs=array();
  if(!empty($data[0]['fecha3'])){
    $results3 = $q->execute("SELECT * FROM prod_categoria WHERE updated_at>'$fechapc'");

    foreach ($results3 as $result3) {
     
      $prodcs[]=array (
        'id' => $result3["id"],
        'cod' => $result3["codigo"],
        'codf' => $result3["codigo_full"],
        'nom' => $result3["nombre"],
        'des' => $result3["descripcion"],
        'urli' => $result3["url_imagen"],
        'uat' => strtotime($result3["updated_at"]),
        'uby' => $result3["updated_by"]     
      );
    }
  }

  $vpData = array();
  $vpData[]=array (
    'produ' => $produs,
    'prodl' => $prodls,
    'prodc' => $prodcs
  );

 echo $data_update = json_encode($vpData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/variosprod/post?tipo=updatedat",
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