<?php
  $cat=str_replace("_"," ",str_replace("-","/",$sf_params->get('cat')));
  $com=$sf_params->get('com');
  $lab=$sf_params->get('lab');
  $pre=$sf_params->get('pre');
  $tipo=$sf_params->get('tipo');
  $nombre=$sf_params->get('nombre');
  $max=$sf_params->get('cant');

  $catQuery="";
  if(!empty($cat)) {
    $catQuery=" && pc.nombre LIKE '$cat%' ";
  }

  $comQuery="";
  if(!empty($com)) {
    $com=str_replace(",","','",$com);
    $comQuery=" && pcomp.compuesto_id IN ('$com')";
  }

  $labQuery="";
  if(!empty($lab)) {
    $lab=str_replace(",","','",$lab);
    $labQuery=" && p.laboratorio_id IN ('$lab')";
  }

  $preQuery="";
  if(!empty($pre)) {
    $pre=str_replace(",","','",$pre);
    $preQuery=" && p.unidad_id IN ('$pre')";
  }

  $tipoQuery="";
  if($tipo!="z") {
    $tipoQuery=" && p.tipo='$tipo' ";
  }

  $nombreQuery="";
  if(!empty($nombre)) {
    $words=explode(" ",$nombre);
    foreach ($words as $word) {
      $nombreQuery=$nombreQuery."&& (p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%') ";
    }
  }

  if($max=="todos") {
    $limit="";
  } else {
    $limit=" LIMIT $max";
  }

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $query = $q->execute("SELECT UPPER(p.nombre) as nombre, FORMAT(REPLACE(p.precio_usd_8, ' ', ''), 2, 'de_DE') as precio
    FROM producto as p
    LEFT JOIN prod_laboratorio as pl ON p.laboratorio_id=pl.id
    LEFT JOIN prod_unidad as pu ON p.unidad_id=pu.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    LEFT JOIN prod_compuesto as pcomp ON p.id=pcomp.producto_id
    WHERE 1 $catQuery $comQuery $labQuery $preQuery $tipoQuery $nombreQuery
    GROUP BY p.id
    ORDER BY p.updated_at DESC
    $limit");
?>
<?php foreach ($query as $item): ?>
  <div style="max-width: 55mm; height: 30mm; font-size: 3mm" >
    <p style="text-align: center">
      <img src="/images/logo_tag.jpg" style="height: 13mm"/><br/>
      <?php echo $item["nombre"]; ?><br/>
      <span style="font-size: 6mm">REF.: <?php echo $item["precio"]; ?></span>
    </p>
  </div>
<?php endforeach; ?>

<script>
  $( document ).ready(function() {
    imprimir();
  });
  function imprimir() {
    var css = '@page { size: 56mm 31mm; margin: 0mm 0mm 0mm 0mm; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);

    window.print();
  }
</script>
<style>
  body {
    margin: 0px !important;
  }
  p {
    margin-top: 2px !important;
    margin-bottom: 2px !important;
  }
</style>