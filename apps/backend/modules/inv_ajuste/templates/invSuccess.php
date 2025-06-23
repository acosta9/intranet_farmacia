<div id="prods" style="display: none">
  <?php
  $did=$sf_params->get('id');
  $deposito=Doctrine_Core::getTable('InvDeposito')->findOneBy('id',$did);
  $results = Doctrine_Query::create()
    ->select('i.id as iid, i.cantidad as cantidad,
    d.id as did, p.id as pid, p.nombre as name, p.serial as serial, 
    p.precio_usd_1 as p01')
    ->from('Inventario i')
    ->leftJoin('i.InvDeposito d')
    ->leftJoin('i.Producto p')
    ->Where('i.deposito_id =?', $did)
    ->orderBy('p.nombre ASC')
    ->execute();
    foreach ($results as $result) {
      echo "<div id='".$result["iid"]."' class='item'>";
        echo "<div class='id'>".$result["iid"]."</div>";
        echo "<div class='serial'>".$result["serial"]."</div>";
        echo "<div class='name'>".$result["name"]."</div>";
        echo "<div class='price_1'>".$result["p01"]."</div>";
        echo "<div class='cantidad'>".$result["cantidad"]."</div>";
      echo "</div>";
    }
  ?>
</div>
