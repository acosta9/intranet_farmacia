<div id="prods" style="display: none">
  <?php
  $did=$sf_params->get('id');
  $deposito=Doctrine_Core::getTable('InvDeposito')->findOneBy('id',$did);
  $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$deposito->getEmpresaId());
  $results = Doctrine_Query::create()
    ->select('i.id as iid, i.cantidad as cantidad,
    d.id as did, p.id as pid, p.nombre as name, p.codigo as codigo, p.serial as serial, p.exento as exento,
    p.precio_usd_1 as p01, p.precio_usd_2 as p02, p.precio_usd_3 as p03, p.precio_usd_4 as p04,
    p.precio_usd_5 as p05, p.precio_usd_6 as p06, p.precio_usd_7 as p07')
    ->from('Inventario i')
    ->leftJoin('i.InvDeposito d')
    ->leftJoin('i.Producto p')
    ->Where('i.deposito_id =?', $did)
    ->andWhere('i.activo =?', 1)
    ->andWhere('i.cantidad >0')
    ->orderBy('p.nombre ASC')
    ->execute();
    foreach ($results as $result) {
      echo "<div id='".$result["iid"]."' class='item'>";
        echo "<div class='id'>".$result["iid"]."</div>";
        echo "<div class='cod'>".$result["codigo"]."</div>";
        echo "<div class='serial'>".$result["serial"]."</div>";
        echo "<div class='name'>".$result["name"]."</div>";
        echo "<div class='max'>".$result["cantidad"]."</div>";
        $exento="NO EXENTO";
        if($result["exento"]){
          $exento="EXENTO";
        }
        echo "<div class='exento'>".$exento."</div>";
        echo "<div class='price_1'>".str_replace(".",",",$result["p01"])."</div>";
        echo "<div class='price_2'>".str_replace(".",",",$result["p02"])."</div>";
        echo "<div class='price_3'>".str_replace(".",",",$result["p03"])."</div>";
        echo "<div class='price_4'>".str_replace(".",",",$result["p04"])."</div>";
        echo "<div class='price_5'>".str_replace(".",",",$result["p05"])."</div>";
        echo "<div class='price_6'>".str_replace(".",",",$result["p06"])."</div>";
        echo "<div class='price_7'>".str_replace(".",",",$result["p07"])."</div>";
      echo "</div>";
    }
  ?>
</div>
<script type="text/javascript">
  $( document ).ready(function() {
    $('#nota_entrega_iva').val("<?php echo $empresa->getIva(); ?>")
  });
</script>
