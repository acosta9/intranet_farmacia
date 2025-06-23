<?php

  $eid = $sf_params->get('eid');
  $domain = $sf_params->get('d');
  $tipo = $sf_params->get('t');

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  if($tipo=="createdat") {
    $results = $q->execute("SELECT created_at as fecha FROM inventario WHERE empresa_id=$eid ORDER BY created_at DESC LIMIT 1");
  } else {
    $results = $q->execute("SELECT updated_at as fecha FROM inventario WHERE empresa_id=$eid && updated_at<>created_at ORDER BY updated_at DESC LIMIT 1");
  }

  foreach ($results as $result) {
    $fecha=strtotime($result["fecha"]);
  }

  $q->close();

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/inventario/getRegistros?eid=$eid&tipo=$tipo&fecha=$fecha",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
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

  $invIds=array(); $i=0;
  foreach ($data as $key => $value) { 
    $invIds[$i]=$value["id"];
    $i++;
  }
  $ids=implode(",", $invIds);

  $ids_existentes=array();
  if(!empty($ids)) {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT id FROM inventario WHERE id IN ($ids)");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }
    $q->close();
  }
  
  $newData=array();
  $insert="BEGIN; set foreign_key_checks=0; INSERT INTO inventario (id, deposito_id, empresa_id, producto_id, cantidad, activo, limite_stock, created_at, updated_at, created_by, updated_by) VALUES ";
  $update="BEGIN; ";
  $j=0; $k=0;
  foreach ($data as $key => $value) { 
    $id=$value["id"];
    $deposito_id=$value["did"];
    $empresa_id=$value["eid"];
    $producto_id=$value["pid"];
    $cantidad=$value["qty"];
    $activo=$value["act"];
    $limite_stock=$value["lstock"];
    $created_at=date("Y-m-d H:i:s", $value["cat"]);
    $updated_at=date("Y-m-d H:i:s", $value["uat"]);
    $created_by=$value["cby"];
    $updated_by=$value["uby"];

    if(!empty($ids_existentes[$id])) {
      $update=$update." UPDATE inventario SET cantidad=$cantidad, activo=$activo, limite_stock=$limite_stock, updated_at='$updated_at', updated_by=$updated_by WHERE id=$id; ";
      $j++;
    } else {
      $insert=$insert."($id, $deposito_id, $empresa_id, $producto_id, $cantidad, $activo, $limite_stock, '$created_at', '$created_at', '$created_by', '$updated_by'), ";
      $k++;
    }

    $newData[]=array (
      'id' => $id,
      'did' => $deposito_id,
      'eid' => $empresa_id,
      'pid' => $producto_id,
      'cid' => $cantidad,
      'qty' => $activo,
      'lstock' => $limite_stock,
      'cat' => strtotime($created_at),
      'uat' => strtotime($updated_at),
      'cby' => $created_by,
      'uby' => $updated_by
    );
  }
  $insert=substr($insert, 0, -2)."; COMMIT;";
  $update=$update."COMMIT; ";

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();

  if($j>0) {
    $error3 = $q->execute($update);
  }

  if($k>0) {
    $error2 = $q->execute($insert);
  } 

  echo json_encode($newData, JSON_PRETTY_PRINT);
?>