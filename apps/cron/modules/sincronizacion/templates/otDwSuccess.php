<?php
// otros, forma_pago, oferta, oferta_det //
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
$fecha1=0;$fecha2=0;$fecha3=0;
if($tipo=="createdat") { 
  $results = $q->execute("SELECT created_at as fecha FROM otros WHERE empresa_id=$eid AND updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else {
    $results = $q->execute("SELECT updated_at as fecha FROM otros WHERE empresa_id=$eid AND updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }
  foreach ($results as $result) {
    $fecha1=strtotime($result["fecha"]);
  }
if($tipo=="createdat") { 
 $results2 = $q->execute("SELECT created_at as fecha FROM forma_pago  WHERE updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else {
 $results2 = $q->execute("SELECT updated_at as fecha FROM forma_pago WHERE updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
 }
  foreach ($results2 as $result2) {
    $fecha2=strtotime($result2["fecha"]);
  }
if($tipo=="createdat") {   
 $results3 = $q->execute("SELECT created_at as fecha FROM oferta WHERE empresa_id=$eid AND updated_at=created_at ORDER BY created_at DESC LIMIT 1");
  } else {
 $results3 = $q->execute("SELECT updated_at as fecha FROM oferta WHERE empresa_id=$eid AND updated_at<>created_at ORDER BY updated_at DESC LIMIT 1"); 
}
 foreach ($results3 as $result3) {
    $fecha3=strtotime($result3["fecha"]);
  }
   $q->close();


 $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/otros/gets?eid=$eid&tipo=$tipo&fecha1=$fecha1&fecha2=$fecha2&fecha3=$fecha3",
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
 

// otros //
$otIds=array(); $i=0;
if($object[0]['otro']){
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT * FROM otros WHERE empresa_id = '$eid' AND id IN ( SELECT MAX(id) FROM otros as o2 WHERE empresa_id = '$eid' GROUP BY o2.nombre )");
  $arreglo =array();
  foreach ($results as $result) {
    $arreglo[$result["nombre"]]=$result["valor"];
  }
  
  $newDataot=array();
  $insertot="BEGIN; set foreign_key_checks=0; INSERT INTO otros (empresa_id, nombre, valor, created_at, updated_at, created_by, updated_by) VALUES ";

   $k=0;
  foreach ($object[0]['otro'] as $key => $value) { 
    $id=$value["id"];
    $empresa_id=$value["eid"];
    $nombre=$value["nom"];
    $valor=$value["val"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];

    if(!empty($arreglo[$nombre])) {
      $old=$arreglo[$nombre];
      if($valor!=$old) {
         $insertot=$insertot."($empresa_id, '$nombre', '$valor', '$created_at', '$updated_at', $created_by, $updated_by), ";
        $k++;
      }
    }
    $newDataot[]=$value;
   }

  if($k>0) {
    $insertot=substr($insertot, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insertot);
  } 

  echo json_encode($newDataot);
  $q->close();
}

// forma_pago //

$fpIds=array(); $ii=0; 
if($object[0]['formap'] && $tipo == "createdat"){
   foreach ($object[0]['formap'] as $item => $value) { 
      $fpIds[$ii]=$value["id"];
      $ii++;
    }  
 
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $fpIds);
  $ids_existentesfp=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM forma_pago WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentesfp[$result["id"]]=$result["id"];
    }
  }
  $newDatafp=array();
  $insertfp="BEGIN; set foreign_key_checks=0; INSERT INTO forma_pago (id, moneda, nombre, acronimo, activo, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
  $k=0;
  foreach ($object[0]['formap'] as $key => $value) { 
    $id=$value["id"];
    $moneda=$value["mon"];
    $nombre=$value["nom"];
    $acronimo=$value["acr"];
    $activo=$value["act"];
    $descripcion=$value["des"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];

    if(empty($ids_existentesfp[$id])) {
       $insertfp=$insertfp."($id, $moneda, '$nombre', '$acronimo', $activo, '$descripcion', '$created_at', '$created_at', $created_by, $updated_by), ";
        $k++;
    }
    $newDatafp[]=$value;
   }
  $insertfp=substr($insertfp, 0, -2)."; COMMIT;";

  if($k>0) {
    $error2 = $q->execute($insertfp);
  } 
  echo json_encode($newDatafp);
  $q->close();
} 
elseif($object[0]['formap'] && $tipo == "updatedat"){
   foreach ($object[0]['formap'] as $item => $value) { 
      $fpIds[$ii]=$value["id"];
      $ii++;
    }  

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $fpIds);
  $ids_existentesfp=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM forma_pago WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentesfp[$result["id"]]=$result["id"];
    }
  }
  $newDatafp=array();
  $updatefp="BEGIN; set foreign_key_checks=0; ";
  $j=0; 
  foreach ($object[0]['formap'] as $key => $value) { 
    $id=$value["id"];
    $moneda=$value["mon"];
    $nombre=$value["nom"];
    $acronimo=$value["acr"];
    $activo=$value["act"];
    $descripcion=$value["des"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];

    if(!empty($ids_existentesfp[$id])) {
      $updatefp=$updatefp." UPDATE forma_pago SET moneda=$moneda, nombre='$nombre', acronimo='$acronimo', activo=$activo, descripcion='$descripcion', updated_at='$updated_at', updated_by=$updated_by WHERE id=$id; ";
        $j++;
     }
    $newDatafp[]=$value;
   }

  $updatefp=$updatefp."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updatefp);
  }
  echo json_encode($newDatafp);
  $q->close();
}

// oferta //
$ofIds=array(); $i=0;
if($object[0]['oferta'] && $tipo == "createdat"){

   foreach ($object[0]['oferta'] as $item => $value) { 
      $ofIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $ofIds);
  $ids_existentesof=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM oferta WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentesof[$result["id"]]=$result["id"];
    }
  }
  $newDataof=array();
  $insertof="BEGIN; set foreign_key_checks=0; INSERT INTO oferta (id, nombre, fecha, fecha_venc, empresa_id, deposito_id, ncontrol,tipo_oferta, activo, precio_usd, qty, exento,tasa, url_imagen, url_imagen_desc, descripcion, created_at, updated_at, created_by, updated_by) VALUES ";
  $insertod="INSERT INTO oferta_det (oferta_id, inventario_id) VALUES ";
  $k=0; $y=0;
  foreach ($object[0]['oferta'] as $key => $value) { 
    $id=$value["id"];
    $nombre=$value["nom"];
    $fecha=$value["fe"];
    $fecha_venc=$value["fev"];
    $empresa_id=$value["eid"];
    $deposito_id=$value["did"];
    $ncontrol=$value["nc"];
    $tipo_oferta=$value["tof"];
    $activo=$value["act"];
    $precio_usd=$value["pusd"];
    $qty=$value["qty"];
    $exento=$value["ex"];
    $tasa=$value["tasa"];
    $url_imagen=$value["urli"];
    $url_imagen_desc=$value["urlid"];
    $descripcion=$value["des"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];
    $dets=$value["dets"];
  
    if(empty($ids_existentesof[$id])) {
       $insertof=$insertof."($id,'$nombre','$fecha','$fecha_venc',$empresa_id,$deposito_id,'$ncontrol', $tipo_oferta,$activo,'$precio_usd','$qty',$exento,'$tasa','$url_imagen','$url_imagen_desc','$descripcion','$created_at','$created_at',$created_by,$updated_by), ";
        $k++;
        foreach ($value["dets"] as $key => $detalle) {
          $oferta_id=$detalle["oid"];
          $inventario_id=$detalle["iid"];
       
       $insertod=$insertod."($oferta_id,$inventario_id), ";
       $y++;
      }
    }
  //  $newDataof[]=$value;
   }

  $insertof=substr($insertof, 0, -2)."; ";
  $insertod=substr($insertod, 0, -2)."; COMMIT;";
 echo $sentencia=$insertof.$insertod;
   if($k>0) {
    $error2 = $q->execute($sentencia);
  } 
 // echo json_encode($newDataof);
  $q->close();
 } 
 elseif($object[0]['oferta'] && $tipo == "updatedat"){
   foreach ($object[0]['oferta'] as $item => $value) { 
      $ofIds[$i]=$value["id"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $ofIds);
  $ids_existentesof=array();
  if(!empty($ids)){
    $results = $q->execute("SELECT id FROM oferta WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentesof[$result["id"]]=$result["id"];
    }
  }
  $newDataof=array();
  $updateof="BEGIN; set foreign_key_checks=0; ";
  $j=0; 
  foreach ($object[0]['oferta'] as $key => $value) { 
    $id=$value["id"];
    $fecha_venc=$value["fev"];
    $activo=$value["act"];
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $updated_by=$value["uby"];
         
    if(!empty($ids_existentesof[$id])) {
      $updateof=$updateof." UPDATE oferta SET fecha_venc='$fecha_venc', activo=$activo, updated_at='$updated_at', updated_by=$updated_by WHERE id=$id; ";
        $j++;
      } 
    $newDataof[]=$value;
   }

  $updateof=$updateof."COMMIT; ";

  if($j>0) {
    $error3 = $q->execute($updateof);
  }
  echo json_encode($newDataof);
  $q->close();
 } 

// oferta_det //

if(!empty($object[0]['odet']) && $tipo == "createdat") {
  
  foreach ($object[0]['odet'] as $item => $value) { 
      $ofdIds[$i]=$value["oid"];
      $i++;
    }  
   
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $ids=implode(",", $ofdIds);
  $ids_existentesofd=array();
  if(!empty($ids)){
    $y=0;
    $results = $q->execute("SELECT id FROM oferta_det WHERE oferta_id IN ($ids)");
    foreach ($results as $result) {
      $y++;
      $ids_existentesofd[$result["id"]]=$result["id"];
    }
  }
 
  if($y==0){     
    $newDataod=array();
    $insertod="BEGIN; set foreign_key_checks=0; INSERT INTO oferta_det (oferta_id, inventario_id) VALUES ";
    $k=0;
    foreach ($object[0]['odet'] as $key => $value) { 
      $id=$value["id"];
      $oferta_id=$value["oid"];
      $inventario_id=$value["iid"];
    
      $insertod=$insertod."($oferta_id, $inventario_id), ";
        $k++;
      
      $newDataod[]=$value;
     }

    $insertod=substr($insertod, 0, -2)."; COMMIT;";
   
    if($k>0) {
      $error2 = $q->execute($insertod);
    } 

    echo json_encode($newDataod);
    $q->close();
   } 
} 