<?php

$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$results = $q->execute("SELECT p.id as pid, id.id as did, id.empresa_id as eid
  FROM producto as p
  LEFT JOIN inv_deposito as id ON true
  LEFT JOIN inventario as i ON (i.producto_id=p.id && i.deposito_id=id.id)
  WHERE i.id IS NULL
  ORDER BY did ASC, pid ASC
  LIMIT 300");
$k=0;
$insert="";
$insert_header="INSERT INTO inventario (id, deposito_id, empresa_id, producto_id, cantidad, activo, limite_stock, created_at, updated_at, created_by, updated_by) VALUES ";
foreach ($results as $result) {
  $did=$result["did"];
  $eid=$result["eid"];
  $pid=$result["pid"];

  $insert=$insert." ".$insert_header."((SELECT CONCAT('$did',IFNULL((SELECT INSERT(MAX(i.id), LOCATE('$did', MAX(i.id)), CHAR_LENGTH('$did'), '')+1 FROM inventario as i WHERE i.deposito_id=$did),1))), $did, $eid, $pid, '0', '1', '0', now(), now(), '1', '1'); "; 
  $k++;
}

if($k>0) {
  $insert=substr($insert, 0, -2).";";
  $error2 = $q->execute($insert);
}
$q->close();

echo "se ingresaron $k registros";

?>