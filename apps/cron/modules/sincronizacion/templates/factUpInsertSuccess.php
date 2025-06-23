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
    CURLOPT_URL => "http://$domain/api.php/factura/getFecha?eid=$eid&tipo=createdat",
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
    $results = $q->execute("SELECT * FROM factura WHERE empresa_id = '$eid' AND created_at>='$fecha1' ORDER BY created_at ASC LIMIT 100");

    foreach ($results as $result) {
     
      $facturas[]=array (
        'id' => $result["id"],
        'fe' => $result["fecha"],
        'dc' => $result["dias_credito"],
        'eid' => $result["empresa_id"],
        'did' => $result["deposito_id"],
        'cid' => $result["cliente_id"],
        'ocid' => $result["nota_entrega_id"],
        'ntid' => $result["orden_compra_id"],
        'cid' => $result["caja_id"],
        'rs' => $result["razon_social"],
        'doc' => $result["doc_id"],
        'telf' => $result["telf"],
        'dir' => $result["direccion"],
        'dire' => $result["direccion_entrega"],
        'nc' => $result["ncontrol"],
        'nfac' => $result["num_factura"],
        'nfacf' => $result["num_fact_fiscal"],
        'codf' => $result["codigof"],
        'ndes' => $result["ndespacho"],
        'fp' => $result["forma_pago"],
        'tasa' => $result["tasa_cambio"],
        'subt' => $result["subtotal"],
        'subtd' => $result["subtotal_desc"],
        'iva' => $result["iva"],
        'bi' => $result["base_imponible"],
        'ivam' => $result["iva_monto"],
        'total' => $result["total"],
        'total2' => $result["total2"],
        'desc' => $result["descuento"],
        'monf' => $result["monto_faltante"],
        'monp' => $result["monto_pagado"],
        'hinv' => $result["has_invoice"],
        'est' => $result["estatus"],
        'cat' => strtotime($result["created_at"]),
        'uat' => strtotime($result["updated_at"]),
        'cby' => $result["created_by"],
        'uby' => $result["updated_by"]   
      );
    }
  }
 
  // cliente //
  $clientes=array();
  if(!empty($data[0]['fecha2'])){
    $results2 = $q->execute("SELECT * FROM cliente WHERE empresa_id = '$eid' AND created_at>='$fecha2' ORDER BY created_at ASC LIMIT 100");

    foreach ($results2 as $result2) {
     
      $clientes[]=array (
        'id' => $result2["id"],
        'eid' => $result2["empresa_id"],
        'fna' => $result2["full_name"],
        'doc' => $result2["doc_id"],
        'sicm' => $result2["sicm"],
        'zona' => $result2["zona"],
        'dir' => $result2["direccion"],
        'telf' => $result2["telf"],
        'cel' => $result2["celular"],
        'email' => $result2["email"],
        'tp' => $result2["tipo_precio"],
        'dc' => $result2["dias_credito"],
        'act' => $result2["activo"],
        'des' => $result2["descripcion"],
        'v1' => $result2["vendedor_01"],
        'v1p' => $result2["vendedor_01_profit"],
        'v2' => $result2["vendedor_02"],
        'v2p' => $result2["vendedor_02_profit"],
        'cat' => strtotime($result2["created_at"]),
        'uat' => strtotime($result2["updated_at"]),
        'cby' => $result2["created_by"],
        'uby' => $result2["updated_by"] 
      );
    }
  }
 
  // cuentas_cobrar //
  $ctascobrars=array();
  if(!empty($data[0]['fecha3'])){
    $results3 = $q->execute("SELECT * FROM cuentas_cobrar WHERE empresa_id = '$eid' AND created_at>='$fecha3' ORDER BY created_at ASC LIMIT 100");

    foreach ($results3 as $result3) {
     
      $ctascobrars[]=array (
        'id' => $result3["id"],
        'fe' => $result3["fecha"],
        'dc' => $result3["dias_credito"],
        'eid' => $result3["empresa_id"],
        'cid' => $result3["cliente_id"],
        'fid' => $result3["factura_id"],
        'neid' => $result3["nota_entrega_id"],
        'total' => $result3["total"],
        'monf' => $result3["monto_faltante"],
        'monp' => $result3["monto_pagado"],
        'tasa' => $result3["tasa_cambio"],
        'est' => $result3["estatus"],
        'cat' => strtotime($result3["created_at"]),
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
    CURLOPT_URL => "http://$domain/api.php/factura/post?tipo=createdat",
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