<?php
// factura, cliente, cuentas_cobrar
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
    CURLOPT_URL => "http://$domain/api.php/factura/getFecha?eid=$eid&tipo=updatedat",
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
 if(!empty($data[0]['fecha3']))
  $fecha3=date("Y-m-d H:i:s", $data[0]['fecha3']);
 

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  // factura //
  $facturas=array();
  if(!empty($data[0]['fecha1'])){
    $results = $q->execute("SELECT * FROM factura WHERE empresa_id = '$eid' && updated_at>='$fecha1' LIMIT 100");

    foreach ($results as $result) {
     
      $facturas[]=array (
        'id' => $result["id"],
        'est' => $result["estatus"],
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"]   
      );
    }
  }
 
  // cliente //
  $clientes=array();
  if(!empty($data[0]['fecha2'])){
    $results2 = $q->execute("SELECT * FROM cliente WHERE empresa_id = '$eid' && updated_at>='$fecha2' LIMIT 100");

    foreach ($results2 as $result2) {
     
      $clientes[]=array (
        'id' => $result2["id"],
        'fna' => $result2["full_name"],
        'doc' => $result2["doc_id"],
        'dir' => $result2["direccion"],
        'telf' => $result2["telf"],
        'uat' => strtotime($result2["updated_at"]),
        'uby' => $result2["updated_by"] 
      );
    }
  }
 
  // cuentas_cobrar //
  $ctascobrars=array();
  if(!empty($data[0]['fecha3'])){
    $results3 = $q->execute("SELECT * FROM cuentas_cobrar WHERE empresa_id = '$eid'  && updated_at>='$fecha3' LIMIT 100");

    foreach ($results3 as $result3) {
     
      $ctascobrars[]=array (
        'id' => $result3["id"],
        'est' => $result3["estatus"],
        'uat' => strtotime($result3["updated_at"])
      );
    }
  }

  $factData = array();
  $factData[]=array (
    'factura' => $facturas,
    'cliente' => $clientes,
    'ctascobrar' => $ctascobrars
  );

 echo $data_update = json_encode($factData);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/factura/post?tipo=updatedat",
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