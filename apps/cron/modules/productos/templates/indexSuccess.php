<?php
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT srvid FROM server_name WHERE 1");
  $empresa=""; $depositos="";
  foreach ($results as $item) {
    $empresa=$item["srvid"];
  }

  if(empty($empresa)) {
    die();
  }


  echo "---------------------------------<br/>";
  echo "---------------------<br/>";
  echo "facturas insert all -> ".$empresa."<br/>";
  $k=0; $fechaMinus=date('Y-m-d H:i:s', strtotime('-1 minutes'));
  $results = $q->execute("SELECT f.id as fid, f.cliente_id as clid, f.empresa_id as eid, f.deposito_id as did, f.created_at as fecha, f.created_by as uid,
    fd.id as fdid, fd.oferta_id as ofid, fd.price_unit as punit, fd.price_tot as ptot, fd.descripcion as descr,
    i.producto_id as pid, i2.producto_id as i2pid
    FROM (SELECT factura.id, factura.cliente_id, factura.empresa_id, factura.deposito_id, factura.created_at, factura.created_by
      FROM factura
      LEFT JOIN prod_vendidos as k ON (factura.id=k.tabla_id && k.tabla='factura')
      WHERE factura.empresa_id IN ($empresa) && factura.created_at<='$fechaMinus' && k.id IS NULL ORDER BY factura.id ASC LIMIT 2000) as f
    LEFT JOIN factura_det as fd ON f.id=fd.factura_id
    LEFT JOIN inventario as i ON fd.inventario_id=i.id
    LEFT JOIN oferta as o ON fd.oferta_id=o.id
    LEFT JOIN oferta_det as od ON o.id=od.oferta_id
    LEFT JOIN inventario as i2 ON od.inventario_id=i2.id
    WHERE fd.id IS NOT NULL
    ORDER BY f.id ASC, fd.id ASC");

  //  id	empresa_id	deposito_id	producto_id	tabla	tabla_id	fecha	cantidad	oferta	anulado
  $insert="BEGIN; set foreign_key_checks=0; INSERT IGNORE INTO prod_vendidos (id, empresa_id, deposito_id, cliente_id, user_id, tabla, tabla_id, fecha, anulado, price_unit, price_tot, producto_id, cantidad, oferta) VALUES ";

  foreach ($results as $result) {
    $items = explode(';', $result["descr"]);
    $j=0;
    foreach ($items as $item) {
      if(strlen($item)>0) {
        $j++;
        list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
        $id="FN-".$result["fid"]."-".$result["fdid"]."-".$j;
        $eid=$result["eid"];
        $did=$result["did"];
        $clid=$result["clid"];
        $uid=$result["uid"];
        $tabla="factura";
        $tabla_id=$result["fid"];
        $fecha=$result["fecha"];
        $punit=$result["punit"];
        $ptot=$result["ptot"];

        if(empty($result["ofid"])) {
          $producto_id=$result["pid"];
          $oferta=0;
        } else {
          $producto_id=$result["i2pid"];
          $oferta=1;
        }
        
        $insert=$insert."('$id', $eid, $did, $clid, $uid, '$tabla', $tabla_id, '$fecha', 0, '$punit', '$ptot', $producto_id, '$qty', $oferta), "; 
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
  $q->execute("UPDATE prod_vendidos as pv LEFT JOIN factura as f ON (pv.tabla='factura' && pv.tabla_id=f.id) SET pv.anulado=1 WHERE f.estatus=4");
?>