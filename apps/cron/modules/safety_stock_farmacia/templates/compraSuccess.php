<?php

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT srvid FROM server_name WHERE 1");
  $empresa="";
  foreach ($results as $item) {
    $empresa=$item["srvid"];
  }

  if(empty($empresa)) {
    die();
  }

  echo "---------------------------------<br/>";
  echo "---------------------<br/>";
  echo "factura_compra insert all -> ".$empresa."<br/>";

  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT ie.id as ieid, ie.empresa_id as eid, ie.deposito_id as did, ie.created_at as fecha, ie.created_by as uid,
    ied.id as iedid, ied.fecha_venc as fvenc, ied.lote as lote, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot, CAST(REPLACE(ied.qty, ' ', '') AS UNSIGNED) as qty,
    i.producto_id as pid
    FROM (SELECT factura_compra.id, d.empresa_id, factura_compra.deposito_id, factura_compra.created_at, factura_compra.created_by
      FROM factura_compra
      LEFT JOIN kardex as k ON (factura_compra.id=k.tabla_id && k.tabla='factura_compra' && k.tipo=1)
      LEFT JOIN inv_deposito as d ON factura_compra.deposito_id=d.id
      WHERE factura_compra.sumar_inv=1 && d.empresa_id IN ($empresa) && factura_compra.created_at<='$fechaMinus' && k.id IS NULL ORDER BY factura_compra.id ASC LIMIT 500) as ie
    LEFT JOIN factura_compra_det as ied ON ie.id=ied.factura_compra_id
    LEFT JOIN inventario as i ON ied.inventario_id=i.id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $id="FCN-".$result["ieid"]."-".$result["iedid"];
    $eid=$result["eid"];
    $did=$result["did"];
    $producto_id=$result["pid"];
    $uid=$result["uid"];
    $tabla="factura_compra";
    $tabla_id=$result["ieid"];
    $punit=$result["punit"];
    $ptot=$result["ptot"];
    $fecha=$result["fecha"];
    $qty=$result["qty"];
    $concepto="Factura de Compra #".$result["ieid"];
    $lote=$result["lote"];
    $fvenc=$result["fvenc"];
    $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', 1, '$concepto', '$lote', '$fvenc'), "; 
    $k++;
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();


  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  echo "---------------------------------<br/>";
  echo "---------------------<br/>";
  echo "factura_compra anular all -> ".$empresa."<br/>";

  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT ie.id as ieid, ie.empresa_id as eid, ie.deposito_id as did, ie.updated_at as fecha, ie.updated_by as uid,
    ied.id as iedid, ied.fecha_venc as fvenc, ied.lote as lote, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot, CAST(REPLACE(ied.qty, ' ', '') AS UNSIGNED) as qty,
    i.producto_id as pid
    FROM (SELECT factura_compra.id, d.empresa_id, factura_compra.deposito_id, factura_compra.updated_at, factura_compra.updated_by
      FROM factura_compra
      LEFT JOIN kardex as k ON (factura_compra.id=k.tabla_id && k.tabla='factura_compra' && k.tipo=2)
      LEFT JOIN inv_deposito as d ON factura_compra.deposito_id=d.id
      WHERE factura_compra.estatus=4 && factura_compra.sumar_inv=1 && d.empresa_id IN ($empresa) && factura_compra.updated_at<='$fechaMinus' && k.id IS NULL ORDER BY factura_compra.id ASC LIMIT 500) as ie
    LEFT JOIN factura_compra_det as ied ON ie.id=ied.factura_compra_id
    LEFT JOIN inventario as i ON ied.inventario_id=i.id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $id="FCA-".$result["ieid"]."-".$result["iedid"];
    $eid=$result["eid"];
    $did=$result["did"];
    $producto_id=$result["pid"];
    $uid=$result["uid"];
    $tabla="factura_compra";
    $tabla_id=$result["ieid"];
    $punit=$result["punit"];
    $ptot=$result["ptot"];
    $fecha=$result["fecha"];
    $qty=$result["qty"];
    $concepto="Anulacion Factura de Compra #".$result["ieid"];
    $lote=$result["lote"];
    $fvenc=$result["fvenc"];
    $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', 2, '$concepto', '$lote', '$fvenc'), "; 
    $k++;
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();

?>