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

  // ---------------------------
  // SUBIR REGISTROS NUEVOS
  // ---------------------------
  if($tipo=="subir_registros") {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/productos/getFecha?tipo=created_at",
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
    $results = $q->execute("SELECT * FROM producto WHERE created_at>='$fecha' ORDER BY id ASC");
    $q->close();

    $newData=array();
    foreach ($results as $result) {
      $newData[]=array (
        'id' => $result["id"],
        'nombre' => "'".str_replace(['"',"'"], "",$result["nombre"])."'",
        'serial' => $result["serial"],
        'serial2' => $result["serial2"],
        'serial3' => $result["serial3"],
        'serial4' => $result["serial4"],
        'tasa' => $result["tasa"],
        'serial_bulto1' => $result["serial_bulto1"],
        'cantidad_bulto1' => $result["cantidad_bulto1"],
        'serial_bulto2' => $result["serial_bulto2"],
        'cantidad_bulto2' => $result["cantidad_bulto2"],
        'codigo' => $result["codigo"],
        'laboratorio_id' => $result["laboratorio_id"],
        'categoria_id' => $result["categoria_id"],
        'unidad_id' => $result["unidad_id"],
        'subproducto_id' => $result["subproducto_id"],
        'qty_desglozado' => $result["qty_desglozado"],
        'tipo' => $result["tipo"],
        'activo' => $result["activo"],
        'costo_usd_1' => $result["costo_usd_1"],
        'util_usd_1' => $result["util_usd_1"],
        'util_usd_2' => $result["util_usd_2"],
        'util_usd_3' => $result["util_usd_3"],
        'util_usd_4' => $result["util_usd_4"],
        'util_usd_5' => $result["util_usd_5"],
        'util_usd_6' => $result["util_usd_6"],
        'util_usd_7' => $result["util_usd_7"],
        'util_usd_8' => $result["util_usd_8"],
        'precio_usd_1' => $result["precio_usd_1"],
        'precio_usd_2' => $result["precio_usd_2"],
        'precio_usd_3' => $result["precio_usd_3"],
        'precio_usd_4' => $result["precio_usd_4"],
        'precio_usd_5' => $result["precio_usd_5"],
        'precio_usd_6' => $result["precio_usd_6"],
        'precio_usd_7' => $result["precio_usd_7"],
        'precio_usd_8' => $result["precio_usd_8"],
        'exento' => $result["exento"],
        'destacado' => $result["destacado"],
        'tags' => $result["tags"],
        'url_imagen' => $result["url_imagen"],
        'url_imagen_desc' => $result["url_imagen_desc"],
        'descripcion' => $result["descripcion"],
        'mas_detalles' => "",
        'cat' => strtotime($result["created_at"]),
        'cby' => $result["created_by"],
      );
    }
    $data_update = json_encode($newData);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/productos/post?tipo=subir_registros",
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
  if($tipo=="actualizar_registros") {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/productos/getFecha?tipo=updated_at",
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
        echo "DIE()".$fecha;
        die();
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT * FROM producto WHERE updated_at>='$fecha' ORDER BY id ASC");
    $q->close();

    $newData=array();
    foreach ($results as $result) {
      $newData[]=array (
        'id' => $result["id"],
        'nombre' => "'".str_replace(['"',"'"], "",$result["nombre"])."'",
        'serial' => $result["serial"],
        'serial2' => $result["serial2"],
        'serial3' => $result["serial3"],
        'serial4' => $result["serial4"],
        'tasa' => $result["tasa"],
        'serial_bulto1' => $result["serial_bulto1"],
        'cantidad_bulto1' => $result["cantidad_bulto1"],
        'serial_bulto2' => $result["serial_bulto2"],
        'cantidad_bulto2' => $result["cantidad_bulto2"],
        'codigo' => $result["codigo"],
        'laboratorio_id' => $result["laboratorio_id"],
        'categoria_id' => $result["categoria_id"],
        'unidad_id' => $result["unidad_id"],
        'subproducto_id' => $result["subproducto_id"],
        'qty_desglozado' => $result["qty_desglozado"],
        'tipo' => $result["tipo"],
        'activo' => $result["activo"],
        'costo_usd_1' => $result["costo_usd_1"],
        'util_usd_1' => $result["util_usd_1"],
        'util_usd_2' => $result["util_usd_2"],
        'util_usd_3' => $result["util_usd_3"],
        'util_usd_4' => $result["util_usd_4"],
        'util_usd_5' => $result["util_usd_5"],
        'util_usd_6' => $result["util_usd_6"],
        'util_usd_7' => $result["util_usd_7"],
        'util_usd_8' => $result["util_usd_8"],
        'precio_usd_1' => $result["precio_usd_1"],
        'precio_usd_2' => $result["precio_usd_2"],
        'precio_usd_3' => $result["precio_usd_3"],
        'precio_usd_4' => $result["precio_usd_4"],
        'precio_usd_5' => $result["precio_usd_5"],
        'precio_usd_6' => $result["precio_usd_6"],
        'precio_usd_7' => $result["precio_usd_7"],
        'precio_usd_8' => $result["precio_usd_8"],
        'exento' => $result["exento"],
        'destacado' => $result["destacado"],
        'tags' => $result["tags"],
        'url_imagen' => $result["url_imagen"],
        'url_imagen_desc' => $result["url_imagen_desc"],
        'descripcion' => $result["descripcion"],
        'mas_detalles' => "",
        'uat' => strtotime($result["updated_at"]),
        'uby' => $result["updated_by"],
      );
    }
    $data_update = json_encode($newData);
    
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://$domain/api.php/productos/post?tipo=actualizar_registros",
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

  ?>