<?php
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
 $fecha1=0;$fecha2=0;
if($tipo=="createdat") { 
 $results = $q->execute("SELECT created_at as fecha FROM compuesto  WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
} else {
  $results = $q->execute("SELECT updated_at as fecha FROM compuesto WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
 } 
  foreach ($results as $result) {
    $fecha1=strtotime($result["fecha"]);
  }
if($tipo=="createdat") { 
 $results2 = $q->execute("SELECT created_at as fecha FROM producto WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
 } else {
   $results2 = $q->execute("SELECT updated_at as fecha FROM producto WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  } 
  foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
  }
 
  $q->close();
   

 $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/compuesto/gets?tipo=$tipo&fecha1=$fecha1&fecha2=$fecha2",
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


// compuesto //
$Ids=array(); $i=0; $j=0;
if($object[0]['compuesto'] && $tipo == "createdat"){
   foreach ($object[0]['compuesto'] as $item => $value) { 
      $Ids[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $Ids);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM compuesto WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newData=array();
  $insert="BEGIN; set foreign_key_checks=0; INSERT INTO compuesto (id, nombre, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
  $k=0;
  foreach ($object[0]['compuesto'] as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nom"];
    $descripcion=$value["des"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];

    if(empty($ids_existentes[$id])) {
      $insert=$insert."($id, '$nombre', '$descripcion', '$created_at', '$created_at', $created_by, $updated_by), ";
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
elseif($object[0]['compuesto'] && $tipo == "updatedat"){
   foreach ($object[0]['compuesto'] as $item => $value) { 
      $Ids[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $Ids);
  $ids_existentes=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM compuesto WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
  }
  $newData=array();
  $update="BEGIN; set foreign_key_checks=0; ";
  $j=0;
  foreach ($object[0]['compuesto'] as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nom"];
    $descripcion=$value["des"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];

    if(!empty($ids_existentes[$id])) {
       $update=$update." UPDATE compuesto SET nombre='$nombre', descripcion='$descripcion', updated_at='$updated_at', updated_by=$updated_by WHERE id=$id; ";
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

// prod_compuesto //
$newDatapc=array();
if($object[0]['prodcp']){
  $replacepc="BEGIN; set foreign_key_checks=0; REPLACE INTO prod_compuesto (producto_id , compuesto_id ) VALUES ";

  $k=0;
  foreach ($object[0]['prodcp'] as $key => $value) {
    $producto_id=$value["pid"];
    $compuesto_id=$value["cid"];
     
    $replacepc=$replacepc."($producto_id , $compuesto_id), ";
    $k++;

    $newDatapc[]=$value;
   }

   $replacepc=substr($replacepc, 0, -2)."; COMMIT;";

  if($k>0) {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $error2 = $q->execute($replacepc);
    $q->close();
  } 

  echo json_encode($newDatapc);
  
}
?>