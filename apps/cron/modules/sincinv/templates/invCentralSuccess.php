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
  // SUBIR REGISTROS NUEVOS
  // ---------------------------
  if($tipo=="subir_registros") {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/inventario/getFecha?eid=$eid&tipo=created_at",
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

    foreach($data as $item) {
      if(!empty($item["fecha"])) {
        $fecha=date("Y-m-d H:i:s", $item["fecha"]);
      } else {
        die();
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT * FROM inventario WHERE empresa_id=$eid && created_at>'$fecha' ORDER BY id ASC");
    $q->close();

    $newData=array();
    foreach ($results as $result) {
      $newData[]=array (
        'id' => $result["id"],
        'did' => $result["deposito_id"],
        'eid' => $result["empresa_id"],
        'pid' => $result["producto_id"],
        'qty' => $result["cantidad"],
        'act' => $result["activo"],
        'lstock' => $result["limite_stock"],
        'cat' => strtotime($result["created_at"]),
        'cby' => $result["created_by"]
      );
    }
    $data_update = json_encode($newData);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/inventario/post?tipo=subir_registros",
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
  // ACTUALIZAR LIMITE STOCK Y ACTIVO
  // ---------------------------
  if($tipo=="actualizar_cd") {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT id, activo, limite_stock FROM inventario WHERE empresa_id=$eid ORDER BY id ASC");
    $q->close();

    $newData=array();
    foreach ($results as $result) {
      $newData[]=array (
        'i' => $result["id"],
        'a' => $result["activo"],
        'l' => $result["limite_stock"],
      );
    }
    $data_update = json_encode($newData);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/inventario/post?tipo=actualizar_cd&eid=$eid",
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
  if($tipo=="get_qty") {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/inventario/getRegistros?eid=$eid&tipo=get_qty",
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
      $cantidad=$value["c"];
      $updated_at=date("Y-m-d H:i:s");

      if(!empty($ids_existentes[$id])) {
        $update=$update." UPDATE IGNORE inventario SET cantidad=$cantidad, updated_at='$updated_at' WHERE id=$id; ";
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