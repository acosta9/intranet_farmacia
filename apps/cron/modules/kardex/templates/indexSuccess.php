<?php
  // -----------------------
  // FACTURASSSSS
  // -----------------------
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT srvid FROM server_name WHERE 1");
  $empresa=""; $depositos="";
  foreach ($results as $item) {
    $empresa=$item["srvid"];
  }

  if(empty($empresa)) {
    die();
  }

  $results = $q->execute("SELECT GROUP_CONCAT(id) as deps FROM inv_deposito WHERE empresa_id IN($empresa) group by empresa_id");
  foreach ($results as $item) {
    $depositos=$item["deps"];
  }

  echo "---------------------------------<br/>";
  echo "---------------------<br/>";
  echo "facturas insert all -> ".$empresa."<br/>";
  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT f.id as fid, f.empresa_id as eid, f.deposito_id as did, f.created_at as fecha, f.created_by as uid,
    f.num_fact_fiscal as nfiscal, f.ndespacho as ndespacho, f.num_factura as nfact,
    fd.id as fdid, fd.oferta_id as ofid, fd.price_unit as punit, fd.price_tot as ptot, fd.descripcion as descr,
    i.producto_id as pid, i2.producto_id as i2pid
    FROM (SELECT factura.id, factura.empresa_id, factura.deposito_id, factura.created_at, factura.created_by, factura.num_fact_fiscal, factura.ndespacho, factura.num_factura
      FROM factura
      LEFT JOIN kardex as k ON (factura.id=k.tabla_id && k.tabla='factura' && k.tipo=2)
      WHERE factura.empresa_id IN ($empresa) && factura.created_at<='$fechaMinus' && k.id IS NULL ORDER BY factura.id ASC LIMIT 2000) as f
    LEFT JOIN factura_det as fd ON f.id=fd.factura_id
    LEFT JOIN inventario as i ON fd.inventario_id=i.id
    LEFT JOIN oferta as o ON fd.oferta_id=o.id
    LEFT JOIN oferta_det as od ON o.id=od.oferta_id
    LEFT JOIN inventario as i2 ON od.inventario_id=i2.id
    WHERE fd.id IS NOT NULL
    ORDER BY f.id ASC, fd.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $items = explode(';', $result["descr"]);
    $j=0;
    foreach ($items as $item) {
      if(strlen($item)>0) {
        $j++;
        list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
        //echo "FN-".$result["fid"]."-".$result["fdid"]."-".$j."<br/>";
        $id="FN-".$result["fid"]."-".$result["fdid"]."-".$j;
        $eid=$result["eid"];
        $did=$result["did"];
        $uid=$result["uid"];
        $tabla="factura";
        $tabla_id=$result["fid"];
        $punit=$result["punit"];
        $ptot=$result["ptot"];
        $fecha=$result["fecha"];
        if(empty($result["ofid"])) {
          $producto_id=$result["pid"];
        } else {
          $producto_id=$result["i2pid"];
        }
        if(!empty($result["nfiscal"])) {
          $nfact=$result["nfiscal"];
        } else if(!empty($result["ndespacho"])) {
          $nfact=$result["ndespacho"];
        } else {
          $nfact=$result["nfact"];
        }
        $concepto="Factura de venta #".$nfact;
        
        $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', 2, '$concepto', '$lote', '$fvenc'), "; 
        $k++;
      }
    }
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();


  $q = Doctrine_Manager::getInstance()->getCurrentConnection();  
  echo "---------------------<br/>";
  echo "facturas anulado<br/>";
  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT f.id as fid, f.empresa_id as eid, f.deposito_id as did, f.updated_at as fecha, f.updated_by as uid,
    f.num_fact_fiscal as nfiscal, f.ndespacho as ndespacho, f.num_factura as nfact,
    fd.id as fdid, fd.oferta_id as ofid, fd.price_unit as punit, fd.price_tot as ptot, fd.descripcion as descr,
    i.producto_id as pid, i2.producto_id as i2pid
    FROM (SELECT factura.id, factura.empresa_id, factura.deposito_id, factura.updated_at, factura.updated_by, factura.num_fact_fiscal, factura.ndespacho, factura.num_factura
      FROM factura
      LEFT JOIN kardex as k ON (factura.id=k.tabla_id && k.tabla='factura' && k.tipo=1)
      WHERE factura.estatus=4 && factura.empresa_id IN ($empresa) && factura.updated_at<='$fechaMinus' && k.id IS NULL ORDER BY factura.id ASC LIMIT 200) as f
    LEFT JOIN factura_det as fd ON f.id=fd.factura_id
    LEFT JOIN inventario as i ON fd.inventario_id=i.id
    LEFT JOIN oferta as o ON fd.oferta_id=o.id
    LEFT JOIN oferta_det as od ON o.id=od.oferta_id
    LEFT JOIN inventario as i2 ON od.inventario_id=i2.id
    WHERE fd.id IS NOT NULL
    ORDER BY f.id ASC, fd.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $items = explode(';', $result["descr"]);
    $j=0;
    foreach ($items as $item) {
      if(strlen($item)>0) {
        $j++;
        list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
        //echo "FN-".$result["fid"]."-".$result["fdid"]."-".$j."<br/>";
        $id="FD-".$result["fid"]."-".$result["fdid"]."-".$j;
        $eid=$result["eid"];
        $did=$result["did"];
        $uid=$result["uid"];
        $tabla="factura";
        $tabla_id=$result["fid"];
        $punit=$result["punit"];
        $ptot=$result["ptot"];
        $fecha=$result["fecha"];
        if(empty($result["ofid"])) {
          $producto_id=$result["pid"];
        } else {
          $producto_id=$result["i2pid"];
        }
        if(!empty($result["nfiscal"])) {
          $nfact=$result["nfiscal"];
        } else if(!empty($result["ndespacho"])) {
          $nfact=$result["ndespacho"];
        } else {
          $nfact=$result["nfact"];
        }
        $concepto="Anulacion Factura de venta #".$nfact;
        
        $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', 1, '$concepto', '$lote', '$fvenc'), "; 
        $k++;
      }
    }
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();


  // -----------------------
  // INV. ENTRADA
  // -----------------------

  $q = Doctrine_Manager::getInstance()->getCurrentConnection(); 
  echo "---------------------------------<br/>";
  echo "---------------------<br/>";
  echo "inv_entrada insert all -> ".$empresa."<br/>";

  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT ie.id as ieid, ie.empresa_id as eid, ie.deposito_id as did, ie.created_at as fecha, ie.created_by as uid,
    ied.id as iedid, ied.fecha_venc as fvenc, ied.lote as lote, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot, CAST(REPLACE(ied.qty, ' ', '') AS UNSIGNED) as qty,
    i.producto_id as pid
    FROM (SELECT inv_entrada.id, inv_entrada.empresa_id, inv_entrada.deposito_id, inv_entrada.created_at, inv_entrada.created_by
      FROM inv_entrada
      LEFT JOIN kardex as k ON (inv_entrada.id=k.tabla_id && k.tabla='inv_entrada' && k.tipo=1)
      WHERE inv_entrada.empresa_id IN ($empresa) && inv_entrada.created_at<='$fechaMinus' && k.id IS NULL ORDER BY inv_entrada.id ASC LIMIT 2000) as ie
    LEFT JOIN inv_entrada_det as ied ON ie.id=ied.inv_entrada_id
    LEFT JOIN inventario as i ON ied.inventario_id=i.id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $id="IEN-".$result["ieid"]."-".$result["iedid"];
    $eid=$result["eid"];
    $did=$result["did"];
    $producto_id=$result["pid"];
    $uid=$result["uid"];
    $tabla="inv_entrada";
    $tabla_id=$result["ieid"];
    $punit=$result["punit"];
    $ptot=$result["ptot"];
    $fecha=$result["fecha"];
    $qty=$result["qty"];
    $concepto="Entrada de Inventario #".$result["ieid"];
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
  echo "---------------------<br/>";
  echo "inv_entrada anulado<br/>";
  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT ie.id as ieid, ie.empresa_id as eid, ie.deposito_id as did, ie.updated_at as fecha, ie.updated_by as uid,
    ied.id as iedid, ied.fecha_venc as fvenc, ied.lote as lote, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot, CAST(REPLACE(ied.qty, ' ', '') AS UNSIGNED) as qty,
    i.producto_id as pid
    FROM (SELECT inv_entrada.id, inv_entrada.empresa_id, inv_entrada.deposito_id, inv_entrada.updated_at, inv_entrada.updated_by
      FROM inv_entrada
      LEFT JOIN kardex as k ON (inv_entrada.id=k.tabla_id && k.tabla='inv_entrada' && k.tipo=2)
      WHERE inv_entrada.anulado=1 && inv_entrada.empresa_id IN ($empresa) && inv_entrada.updated_at<='$fechaMinus' && k.id IS NULL ORDER BY inv_entrada.id ASC LIMIT 200) as ie
    LEFT JOIN inv_entrada_det as ied ON ie.id=ied.inv_entrada_id
    LEFT JOIN inventario as i ON ied.inventario_id=i.id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $id="IEA-".$result["ieid"]."-".$result["iedid"];
    $eid=$result["eid"];
    $did=$result["did"];
    $producto_id=$result["pid"];
    $uid=$result["uid"];
    $tabla="inv_entrada";
    $tabla_id=$result["ieid"];
    $punit=$result["punit"];
    $ptot=$result["ptot"];
    $fecha=$result["fecha"];
    $qty=$result["qty"];
    $concepto="Anulacion Entrada de Inventario #".$result["ieid"];
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


  // -----------------------
  // INV. SALIDA
  // -----------------------


  $q = Doctrine_Manager::getInstance()->getCurrentConnection(); 
  echo "---------------------------------<br/>";
  echo "---------------------<br/>";
  echo "inv_salida insert all -> ".$empresa."<br/>";

  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT ie.id as ieid, ie.empresa_id as eid, ie.deposito_id as did, ie.created_at as fecha, ie.created_by as uid,
    ied.id as iedid, ied.devolucion as descr, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot,
    i.producto_id as pid
    FROM (SELECT inv_salida.id, inv_salida.empresa_id, inv_salida.deposito_id, inv_salida.created_at, inv_salida.created_by
      FROM inv_salida
      LEFT JOIN kardex as k ON (inv_salida.id=k.tabla_id && k.tabla='inv_salida' && k.tipo=2)
      WHERE inv_salida.empresa_id IN ($empresa) && inv_salida.created_at<='$fechaMinus' && k.id IS NULL ORDER BY inv_salida.id ASC LIMIT 2000) as ie
    LEFT JOIN inv_salida_det as ied ON ie.id=ied.inv_salida_id
    LEFT JOIN inventario as i ON ied.inventario_id=i.id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $items = explode(';', $result["descr"]);
    $j=0;
    foreach ($items as $item) {
      if(strlen($item)>0) {
        $j++;
        list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
        $id="ISN-".$result["ieid"]."-".$result["iedid"]."-".$j;
        $eid=$result["eid"];
        $did=$result["did"];
        $producto_id=$result["pid"];
        $uid=$result["uid"];
        $tabla="inv_salida";
        $tabla_id=$result["ieid"];
        $punit=$result["punit"];
        $ptot=$result["ptot"];
        $fecha=$result["fecha"];
        $concepto="Salida de Inventario #".$result["ieid"];
        $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', 2, '$concepto', '$lote', '$fvenc'), "; 
        $k++;
      }
    }
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();
  
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection(); 
  echo "---------------------<br/>";
  echo "inv_salida anulado<br/>";
  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT ie.id as ieid, ie.empresa_id as eid, ie.deposito_id as did, ie.updated_at as fecha, ie.updated_by as uid,
    ied.id as iedid, ied.devolucion as descr, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot,
    i.producto_id as pid
    FROM (SELECT inv_salida.id, inv_salida.empresa_id, inv_salida.deposito_id, inv_salida.updated_at, inv_salida.updated_by
      FROM inv_salida
      LEFT JOIN kardex as k ON (inv_salida.id=k.tabla_id && k.tabla='inv_salida' && k.tipo=1)
      WHERE inv_salida.anulado=1 && inv_salida.empresa_id IN ($empresa) && inv_salida.updated_at<='$fechaMinus' && k.id IS NULL ORDER BY inv_salida.id ASC LIMIT 200) as ie
    LEFT JOIN inv_salida_det as ied ON ie.id=ied.inv_salida_id
    LEFT JOIN inventario as i ON ied.inventario_id=i.id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $items = explode(';', $result["descr"]);
    $j=0;
    foreach ($items as $item) {
      if(strlen($item)>0) {
        $j++;
        list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
        $id="ISA-".$result["ieid"]."-".$result["iedid"]."-".$j;
        $eid=$result["eid"];
        $did=$result["did"];
        $producto_id=$result["pid"];
        $uid=$result["uid"];
        $tabla="inv_salida";
        $tabla_id=$result["ieid"];
        $punit=$result["punit"];
        $ptot=$result["ptot"];
        $fecha=$result["fecha"];
        $concepto="Anulacion Salida de Inventario #".$result["ieid"];
        $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', 1, '$concepto', '$lote', '$fvenc'), "; 
        $k++;
      }
    }
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();


  // -----------------------
  // INV. AJUSTE
  // -----------------------

  $q = Doctrine_Manager::getInstance()->getCurrentConnection(); 
  echo "---------------------------------<br/>";
  echo "---------------------<br/>";
  echo "inv_ajuste insert all -> ".$empresa."<br/>";

  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT ie.id as ieid, ie.empresa_id as eid, ie.deposito_id as did, ie.created_at as fecha, ie.created_by as uid,
    ied.tipo as tipo, ied.id as iedid, ied.fecha_venc as fvenc, ied.lote as lote, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot, CAST(REPLACE(ied.qty, ' ', '') AS UNSIGNED) as qty,
    i.producto_id as pid
    FROM (SELECT inv_ajuste.id, inv_ajuste.empresa_id, inv_ajuste.deposito_id, inv_ajuste.created_at, inv_ajuste.created_by
      FROM inv_ajuste
      LEFT JOIN kardex as k ON (inv_ajuste.id=k.tabla_id && k.tabla='inv_ajuste' && k.concepto NOT LIKE 'Anulacion%')
      WHERE inv_ajuste.empresa_id IN ($empresa) && inv_ajuste.created_at<='$fechaMinus' && k.id IS NULL ORDER BY inv_ajuste.id ASC LIMIT 2000) as ie
    LEFT JOIN inv_ajuste_det as ied ON ie.id=ied.inv_ajuste_id
    LEFT JOIN inventario as i ON ied.inventario_id=i.id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $id="IAN-".$result["ieid"]."-".$result["iedid"];
    $eid=$result["eid"];
    $did=$result["did"];
    $producto_id=$result["pid"];
    $uid=$result["uid"];
    $tabla="inv_ajuste";
    $tabla_id=$result["ieid"];
    $punit=$result["punit"];
    $ptot=$result["ptot"];
    $fecha=$result["fecha"];
    $qty=$result["qty"];
    $concepto="Ajuste de Inventario #".$result["ieid"];
    $lote=$result["lote"];
    $fvenc=$result["fvenc"];
    $tipo=$result["tipo"];
    $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', $tipo, '$concepto', '$lote', '$fvenc'), "; 
    $k++;
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();
  
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection(); 
  echo "---------------------<br/>";
  echo "inv_ajuste anulado<br/>";
  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT ie.id as ieid, ie.empresa_id as eid, ie.deposito_id as did, ie.updated_at as fecha, ie.updated_by as uid,
    ied.tipo as tipo, ied.id as iedid, ied.fecha_venc as fvenc, ied.lote as lote, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot, CAST(REPLACE(ied.qty, ' ', '') AS UNSIGNED) as qty,
    i.producto_id as pid
    FROM (SELECT inv_ajuste.id, inv_ajuste.empresa_id, inv_ajuste.deposito_id, inv_ajuste.updated_at, inv_ajuste.updated_by
      FROM inv_ajuste
      LEFT JOIN kardex as k ON (inv_ajuste.id=k.tabla_id && k.tabla='inv_ajuste' && k.concepto LIKE 'Anulacion%')
      WHERE inv_ajuste.anulado=1 && inv_ajuste.empresa_id IN ($empresa) && inv_ajuste.updated_at<='$fechaMinus' && k.id IS NULL ORDER BY inv_ajuste.id ASC LIMIT 200) as ie
    LEFT JOIN inv_ajuste_det as ied ON ie.id=ied.inv_ajuste_id
    LEFT JOIN inventario as i ON ied.inventario_id=i.id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $id="IAA-".$result["ieid"]."-".$result["iedid"];
    $eid=$result["eid"];
    $did=$result["did"];
    $producto_id=$result["pid"];
    $uid=$result["uid"];
    $tabla="inv_ajuste";
    $tabla_id=$result["ieid"];
    $punit=$result["punit"];
    $ptot=$result["ptot"];
    $fecha=$result["fecha"];
    $qty=$result["qty"];
    $concepto="Anulacion Ajuste de Inventario #".$result["ieid"];
    $lote=$result["lote"];
    $fvenc=$result["fvenc"];
    if($result["tipo"]==1) {
      $tipo=2;
    } else {
      $tipo=1;
    }
    $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', $tipo, '$concepto', '$lote', '$fvenc'), "; 
    $k++;
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();

  // -----------------------
  // TRASLADOS
  // -----------------------
/*
  $q = Doctrine_Manager::getInstance()->getCurrentConnection(); 
  echo "---------------------------------<br/>";
  echo "---------------------<br/>";
  echo "traslado insert all -> ".$empresa."<br/>";

  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));  
  $results = $q->execute("SELECT ie.id as ieid, ie.created_at as fecha, ie.created_by as uid,
    ie.empresa_desde as edesde, ie.empresa_hasta as ehasta, ie.deposito_desde as ddesde, ie.deposito_hasta as dhasta,
    ied.id as iedid, ied.descripcion as descr, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot,
    ied.producto_id as pid
    FROM (SELECT traslado.id, traslado.empresa_desde, traslado.empresa_hasta, traslado.deposito_desde, traslado.deposito_hasta, traslado.created_at, traslado.created_by
      FROM traslado
      LEFT JOIN kardex as k ON (traslado.id=k.tabla_id && k.tabla='traslado' && k.concepto NOT LIKE 'Anulacion%')
      WHERE (traslado.deposito_desde IN ($depositos) || traslado.deposito_hasta IN ($depositos)) && traslado.created_at<='$fechaMinus' && k.id IS NULL ORDER BY traslado.id ASC LIMIT 500) as ie
    LEFT JOIN traslado_det as ied ON ie.id=ied.traslado_id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $items = explode(';', $result["descr"]);
    $j=0;
    foreach ($items as $item) {
      if(strlen($item)>0) {
        $j++;
        list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
        $producto_id=$result["pid"];
        $uid=$result["uid"];
        $tabla="traslado";
        $tabla_id=$result["ieid"];
        $punit=$result["punit"];
        $ptot=$result["ptot"];
        $fecha=$result["fecha"];
        $concepto="Traslado de Inventario #".$result["ieid"];

        if(strpos($depositos, $result["ddesde"]) !== false) {
          $id="TRDN-".$result["ieid"]."-".$result["iedid"]."-".$j;
          $tipo=2;
          $eid=$result["edesde"];
          $did=$result["ddesde"];
          $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', $tipo, '$concepto', '$lote', '$fvenc'), "; 
          $k++;
        }
        if(strpos($depositos, $result["dhasta"]) !== false) {
          $id="TRHN-".$result["ieid"]."-".$result["iedid"]."-".$j;
          $tipo=1;
          $eid=$result["ehasta"];
          $did=$result["dhasta"];
          $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', $tipo, '$concepto', '$lote', '$fvenc'), "; 
          $k++;
        }
      }
    }
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();

  $q = Doctrine_Manager::getInstance()->getCurrentConnection(); 
  echo "---------------------------------<br/>";
  echo "traslado anulado<br/>";

  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT ie.id as ieid, ie.updated_at as fecha, ie.updated_by as uid,
    ie.empresa_desde as edesde, ie.empresa_hasta as ehasta, ie.deposito_desde as ddesde, ie.deposito_hasta as dhasta,
    ied.id as iedid, ied.descripcion as descr, REPLACE(ied.price_unit, ' ', '') as punit, REPLACE(ied.price_tot, ' ', '') as ptot,
    ied.producto_id as pid
    FROM (SELECT traslado.id, traslado.empresa_desde, traslado.empresa_hasta, traslado.deposito_desde, traslado.deposito_hasta, traslado.updated_at, traslado.updated_by
      FROM traslado
      LEFT JOIN kardex as k ON (traslado.id=k.tabla_id && k.tabla='traslado' && k.concepto LIKE 'Anulacion%')
      WHERE traslado.estatus=3 && (traslado.deposito_desde IN ($depositos) || traslado.deposito_hasta IN ($depositos)) && traslado.updated_at<='$fechaMinus' && k.id IS NULL ORDER BY traslado.id ASC LIMIT 500) as ie
    LEFT JOIN traslado_det as ied ON ie.id=ied.traslado_id
    WHERE ied.id IS NOT NULL
    ORDER BY ie.id ASC, ied.id ASC");
  
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO kardex (id, empresa_id, deposito_id, producto_id, user_id, tabla, tabla_id, price_unit, price_tot, fecha, cantidad, tipo, concepto, lote, fvenc) VALUES ";
  foreach ($results as $result) {
    $items = explode(';', $result["descr"]);
    $j=0;
    foreach ($items as $item) {
      if(strlen($item)>0) {
        $j++;
        list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
        $producto_id=$result["pid"];
        $uid=$result["uid"];
        $tabla="traslado";
        $tabla_id=$result["ieid"];
        $punit=$result["punit"];
        $ptot=$result["ptot"];
        $fecha=$result["fecha"];
        $concepto="Anulacion Traslado de Inventario #".$result["ieid"];

        if(strpos($depositos, $result["ddesde"]) !== false) {
          $id="TRDA-".$result["ieid"]."-".$result["iedid"]."-".$j;
          $tipo=1;
          $eid=$result["edesde"];
          $did=$result["ddesde"];
          $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', $tipo, '$concepto', '$lote', '$fvenc'), "; 
          $k++;
        }
        if(strpos($depositos, $result["dhasta"]) !== false) {
          $id="TRHA-".$result["ieid"]."-".$result["iedid"]."-".$j;
          $tipo=2;
          $eid=$result["ehasta"];
          $did=$result["dhasta"];
          $insert=$insert."('$id', $eid, $did, $producto_id, $uid, '$tabla', $tabla_id, '$punit', '$ptot', '$fecha', '$qty', $tipo, '$concepto', '$lote', '$fvenc'), "; 
          $k++;
        }
      }
    }
  }
  if($k>0) {
    $insert=substr($insert, 0, -2)."; COMMIT;";
    $error2 = $q->execute($insert);
  }
  $q->close();
  */
?>