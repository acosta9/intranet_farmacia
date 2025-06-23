<?php
$eidd = $sf_params->get('eidd');
$eidh = $sf_params->get('eidh');
$domain = $sf_params->get('d');

exec("ping -c 3 " . $domain, $output, $result);
  if ($result == 0) {
    echo "<br/>Ping successful!<br/>";
  } else {
    echo "<br/>Ping unsuccessful!<br/>";
    die();
  }

$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$fecha1=0;
    $results = $q->execute("SELECT updated_at as fecha FROM traslado WHERE empresa_desde=$eidd AND empresa_hasta=$eidh && updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");

  foreach ($results as $result) {
    $fecha1=strtotime($result["fecha"]);
  }

   $q->close();
  

 $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/traslado/getsfarm?eid=$eidh&fecha1=$fecha1",
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
  $object = json_decode($response, true);
 // print_r($object); 

// traslado //
$otIds=array(); $i=0;
    foreach ($object as $item => $value) { 
      $otIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $otIds);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM traslado WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newDatat=array();
  $updatet="BEGIN; set foreign_key_checks=0; ";
  $j=0; 
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $estatus=$value["est"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];

    if(!empty($ids_existentes[$id])) {
      $updatet=$updatet." UPDATE traslado SET  estatus=$estatus, updated_at='$updated_at', updated_by='$updated_by' WHERE id=$id; ";
      $j++;
    } 
    $newDatat[]=$value;
   }

  $updatet=$updatet."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatet);
  }

  echo json_encode($newDatat);
  $q->close();
?>