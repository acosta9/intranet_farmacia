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

  // ---------------------------
  // DESCARGAR REGISTROS NUEVOS
  // ---------------------------
  if($tipo=="descargar_registros") {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT created_at as fecha FROM inventario WHERE empresa_id=$eid ORDER BY created_at DESC LIMIT 1");
    $q->close();
    $fecha=strtotime("now");
    foreach ($results as $result) {
      $fecha=strtotime($result["fecha"]);
    }

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/inventario/getRegistros?eid=$eid&tipo=get_new_recs&fecha=$fecha",
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

    $invIds=array(); $i=0;
    foreach ($data as $key => $value) { 
      $invIds[$i]=$value["id"];
      $i++;
    }
    $ids=implode(",", $invIds);
    $ids_existentes=array();
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    if(!empty($ids)) {
      $results = $q->execute("SELECT id FROM inventario WHERE id IN ($ids)");
      foreach ($results as $result) {
        $ids_existentes[$result["id"]]=$result["id"];
      }
    }

    $insert="BEGIN; set foreign_key_checks=0; INSERT INTO inventario (id, deposito_id, empresa_id, producto_id, cantidad, activo, limite_stock, created_at, updated_at, created_by, updated_by) VALUES ";
    $k=0; $newData=array();
    foreach ($data as $key => $value) { 
      $id=$value["id"];
      $deposito_id=$value["did"];
      $empresa_id=$value["eid"];
      $producto_id=$value["pid"];
      $cantidad=$value["qty"];
      $activo=$value["act"];
      $limite_stock=$value["lstock"];
      $created_at=date("Y-m-d H:i:s", $value["cat"]);
      $updated_at=date("Y-m-d H:i:s", $value["cat"]);
      $created_by=$value["cby"];
      $updated_by=$value["cby"];

      if(empty($ids_existentes[$id])) {
        $insert=$insert."($id, $deposito_id, $empresa_id, $producto_id, $cantidad, $activo, $limite_stock, '$created_at', '$updated_at', '$created_by', '$updated_by'), ";
        $k++;
        $newData[]=$value;
      }
    }

    if($k>0) {
      $insert=substr($insert, 0, -2)."; COMMIT;";
      $error2 = $q->execute($insert);
    } 
    $q->close();
    echo json_encode($newData);

  }

  // ---------------------------
  // ACTUALIZAR CANTIDAD
  // ---------------------------
  if($tipo=="actualizar_qty") {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT id, cantidad FROM inventario WHERE empresa_id=$eid ORDER BY id ASC");
    $q->close();

    $newData=array();
    foreach ($results as $result) {
      $newData[]=array (
        'i' => $result["id"],
        'c' => $result["cantidad"],
      );
    }
    $data_update = json_encode($newData);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/inventario/post?tipo=actualizar_qty&eid=$eid",
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
    $response = curl_exec($curl);
    curl_close($curl);

    print_r($response);

  }

  // ---------------------------
  // GET CANTIDADES
  // ---------------------------
  if($tipo=="get_act_lim") {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/inventario/getRegistros?eid=$eid&tipo=get_act_lim",
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

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT id FROM inventario WHERE empresa_id=$eid");
    foreach ($results as $result) {
      $ids_existentes[$result["id"]]=$result["id"];
    }

    $update="BEGIN; set foreign_key_checks=0; ";
    $k=0; $newData=array();
    foreach ($data as $key => $value) { 
      $id=$value["i"];
      $activo=$value["a"];
      $limite_stock=$value["l"];
      $updated_at=date("Y-m-d H:i:s");

      if(!empty($ids_existentes[$id])) {
        $update=$update." UPDATE IGNORE inventario SET activo=$activo, limite_stock=$limite_stock, updated_at='$updated_at' WHERE id=$id; ";
        $k++;
        $newData[]=$value;
      }
    }

    if($k>0) {
      $update=$update."COMMIT; ";
      $error2 = $q->execute($update);
    } 
    $q->close();
    echo json_encode($newData);

  }
?>
