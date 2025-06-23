<?php
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
    CURLOPT_URL => "http://$domain/api.php/traslado/getFecha?eid=$eid&tipo=createdat",
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

 
 foreach($data as $item) {
    if(!empty($item["fecha"])) {
      $fecha=date("Y-m-d H:i:s", $item["fecha"]);
    } else {
      die();
    }
  }
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  // traslado //
  $traslado=array();
  $results = $q->execute("SELECT * FROM traslado WHERE empresa_hasta = $eid AND created_at>'$fecha'");

   foreach ($results as $result) {
       $tid=$result["id"];
       $trasDetalle = $q->execute("SELECT * FROM traslado_det WHERE traslado_id = $tid");
       $detalles = array();
      foreach ($trasDetalle as $detalle) {
        $detalles[] =  array ( 'tid' => $detalle["traslado_id"],
                               'pid' => $detalle["producto_id"],
                               'iid' => $detalle["inventario_id"],
                               'qty' => $detalle["qty"],
                               'pdid' => $detalle["prod_destino_id"],
                               'idid' => $detalle["inv_destino_id"],
                               'qtyd' => $detalle["qty_dest"],
                               'punit' => $detalle["price_unit"],
                               'ptot' => $detalle["price_tot"],
                               'des' => $detalle["descripcion"] );    
      }     
   
      $traslado[]=array (
        'id' => $result["id"],
        'nctr' => $result["ncontrol"],
        'eidd' => $result["empresa_desde"],
        'didd' => $result["deposito_desde"],
        'eidh' => $result["empresa_hasta"],
        'didh' => $result["deposito_hasta"],
        'est' => $result["estatus"],
        'tas' => $result["tasa_cambio"],
        'mon' => $result["monto"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"]),
        'cby' => $result["created_by"],
        'uby' => $result["updated_by"],
        'dets' =>$detalles   
      );
    }

 echo $data_update = json_encode($traslado);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "http://$domain/api.php/traslado/post?tipo=createdat",
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

  //print_r($data);
?>