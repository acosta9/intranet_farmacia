<?php
  $eid = $sf_params->get('eid');
  $domain = $sf_params->get('d');
  $tipo = $sf_params->get('t');

 exec("ping -c 3 " . $domain, $output, $result);
  if ($result == 0) {
    echo "<br/>Ping successful!<br/>";
  } else {
    echo "<br/>Ping unsuccessful!<br/>";
    die();
  }

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  if($tipo=="createdat") {
    $results = $q->execute("SELECT created_at as fecha FROM inv_deposito WHERE empresa_id=$eid  ORDER BY created_at DESC LIMIT 1");
  } else {
    $results = $q->execute("SELECT updated_at as fecha FROM inv_deposito WHERE empresa_id=$eid && updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }

  foreach ($results as $result) {
    $fecha=strtotime($result["fecha"]);
  }

  $q->close();

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/invdep/gets?eid=$eid&tipo=$tipo&fecha=$fecha",
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

// inv_deposito //
$Ids=array(); $i=0;
if($tipo == "createdat"){
 foreach ($object as $key => $value) { 
  $Ids[$i]=$value["id"];
  $i++;
} 
 
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $Ids);
$ids_existentes=array();
if(!empty($ids)){
  $results = $q->execute("SELECT id FROM inv_deposito WHERE id IN ($ids)");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }
}
$newData=array();
$insert="BEGIN; set foreign_key_checks=0; INSERT INTO inv_deposito (id, empresa_id, nombre, acronimo, tipo, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
$k=0;
foreach ($object as $key => $value) { 
  $id=$value["id"];
  $empresa_id=$value["eid"];
  $nombre=$value["nom"];
  $acronimo=$value["acr"];
  $tipo=$value["tipo"];
  $descripcion=$value["des"];
  $created_at=date("Y-m-d H:i:s", $value["cat"]);
  $updated_at=date("Y-m-d H:i:s", $value["uat"]);
  $created_by=$value["cby"];
  $updated_by=$value["uby"]; 
  
  if(empty($ids_existentes[$id])) {
    $insert=$insert."($id, $empresa_id, '$nombre', '$acronimo', $tipo, '$descripcion', '$created_at', '$created_at', $created_by, $updated_by), ";
    $k++;
  }
  $newData[]=$value;
   
 }

 $insert=substr($insert, 0, -2)."; COMMIT;";

  if($k>0) {
    $error2 = $q->execute($insert);
  } 
 
  echo json_encode($newData);
  $q->close();
} 
else if($tipo == "updatedat") {
  foreach ($object as $key => $value) { 
    $Ids[$i]=$value["id"];
    $i++;
  }
   
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$ids=implode(",", $Ids);
$ids_existentes=array();
if(!empty($ids)){
  $results = $q->execute("SELECT id FROM inv_deposito WHERE id IN ($ids)");
  foreach ($results as $result) {
    $ids_existentes[$result["id"]]=$result["id"];
  }
}
  $newData=array();
  $update="BEGIN; set foreign_key_checks=0;";
  $j=0; 
  foreach ($object as $key => $value) { 
    $id=$value["id"];
    $empresa_id=$value["eid"];
    $nombre=$value["nom"];
    $acronimo=$value["acr"];
    $tipo=$value["tipo"];
    $descripcion=$value["des"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"]; 
    
    if(!empty($ids_existentes[$id])) {
       $update=$update." UPDATE inv_deposito SET empresa_id = $empresa_id, nombre = '$nombre', acronimo = '$acronimo', tipo = $tipo, descripcion = '$descripcion', updated_at = '$updated_at', updated_by =  $updated_by WHERE id=$id; ";
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
}