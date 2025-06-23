<div id="prods" style="display: none">
  <?php
  $did=$sf_params->get('id');
  $deposito=Doctrine_Core::getTable('InvDeposito')->findOneBy('id',$did);
  $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$deposito->getEmpresaId());
  $results = Doctrine_Query::create()
    ->select('i.id as iid, i.cantidad as cantidad,
    d.id as did, p.id as pid, p.nombre as name, p.codigo as codigo, p.serial as serial, p.exento as exento, 
    p.costo_usd_1 as costo')
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
        echo "<div class='qty'>".$result["cantidad"]."</div>";
        echo "<div class='costo_usd'>".$result["costo"]."</div>";
        $exento="NO EXENTO";
        if($result["exento"]){
          $exento="EXENTO";
        }
        echo "<div class='exento'>".$exento."</div>";
      echo "</div>";
    }
  ?>
</div>
