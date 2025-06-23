<?php
/*
tipo
1: inventario debajo del minimo
2: 
*/
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$results = $q->execute("SELECT id, did, prodid from triggers where estatus=1 && tipo=1");
$data = array();
foreach ($results as $item) {
  $data[$item["did"]][$item["prodid"]]=$item["id"];
}

$results = $q->execute("SELECT i.empresa_id as eid, i.deposito_id as did, i.producto_id as prodid, i.cantidad as qty, i.limite_stock as minimo
  FROM inventario as i
  LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
  WHERE id.tipo=1 && i.cantidad<=i.limite_stock && i.limite_stock<>0");

$fecha=strtotime('now');
$values="INSERT INTO triggers (eid, did, prodid, tipo, estatus, descripcion, cantidad, minimo, open_unixtime, close_unixtime) VALUES ";
$i=0;
foreach ($results as $item) {
  $eid=$item["eid"];
  $did=$item["did"];
  $prodid=$item["prodid"];
  $desc='Inventario por debajo del minimo ideal';
  $qty=$item["qty"];
  $minimo=$item["minimo"];

  if(empty($data[$did][$prodid])) {
    $values=$values."('$eid', '$did', '$prodid', '1', '1', '$desc', $qty, $minimo, '$fecha', '$fecha'), ";
    $i=1;
  }
}

if($i>0) {
  $values=substr($values, 0, -2).";";
  $error = $q->execute($values);
}

$results = $q->execute("SELECT i.deposito_id as did, i.producto_id as prodid
  FROM inventario as i
  LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
  WHERE id.tipo=1 && i.cantidad>i.limite_stock && i.limite_stock<>0");

foreach ($results as $item) {
  $did=$item["did"];
  $prodid=$item["prodid"];
  $fechaUpdate=strtotime('now');

  if(!empty($data[$did][$prodid])) {
    $id=$data[$did][$prodid];
    $q->execute("UPDATE triggers SET estatus=2, close_unixtime='$fechaUpdate' WHERE id='$id'");
  }
}

$fechaInicio=strtotime(date("Y-m-d")."00:00:10");
$fechaFin=strtotime(date("Y-m-d")."23:59:50");

$q->execute("UPDATE triggers as t
  LEFT JOIN inventario as i ON (t.did=i.deposito_id && t.prodid=i.producto_id)
  SET t.cantidad=i.cantidad
  WHERE t.open_unixtime>=$fechaInicio && t.open_unixtime<=$fechaFin");

?>