<?php
  $fecha=date('Y-m-d');
  $emp=$sf_params->get('emp');
  $dep=$sf_params->get('dep');
  $st=$sf_params->get('st');
  $qtyMy=$sf_params->get('qtyMy');
  $qtyMn=$sf_params->get('qtyMn');
  $venc=$sf_params->get('venc');
  $pvenc=$sf_params->get('pvenc');
  $cat=str_replace("_"," ",str_replace("-","/",$sf_params->get('cat')));
  $com=$sf_params->get('com');
  $lab=$sf_params->get('lab');
  $pre=$sf_params->get('pre');
  $tipo=$sf_params->get('tipo');
  $prodId=$sf_params->get('prodId');
  $max=$sf_params->get('cant');

  $empQuery="";
  if(!empty($emp)) {
    $emp=str_replace(",","','",$emp);
    $empQuery=" && inv.empresa_id IN ('$emp')";
  }

  $depQuery="";
  if(!empty($dep)) {
    $dep=str_replace(",","','",$dep);
    $depQuery=" && inv.deposito_id IN ('$dep')";
  }

  $stQuery="";
  if($st!="z") {
    $stQuery=" && inv.activo='$st' ";
  }

  $qtyMyQuery="";
  if(!empty($qtyMy)) {
    $qtyMyQuery=" && CAST(inv.cantidad AS INTEGER) >=$qtyMy ";
  }

  $qtyMnQuery="";
  if(!empty($qtyMn)) {
    $qtyMnQuery=" && CAST(inv.cantidad AS INTEGER) <=$qtyMn ";
  }

  $vencQuery="";
  if($venc!="z") {
    if($venc==1) {
      $vencQuery="&& (CAST(invDet.cantidad AS INTEGER) > 0 && invDet.fecha_venc<='$fecha') ";
    } else {
      $vencQuery="&& (CAST(invDet.cantidad AS INTEGER) > 0 && invDet.fecha_venc>'$fecha') ";
    }
  }

  $pvencQuery="";
  if(!empty($pvenc)) {
    $pvencQuery=" && (CAST(invDet.cantidad AS INTEGER) > 0 && invDet.fecha_venc BETWEEN '$fecha' AND '$pvenc') ";
  }

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

  $prodQuery="";
  if(!empty($prodId)) {
    $prodQuery=" && inv.producto_id='$prodId'";
  }

  if($max=="todos") {
    $limit="";
  } else {
    $limit=" LIMIT $max";
  }

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $query = $q->execute("SELECT UPPER(p.nombre) as nombre, FORMAT(REPLACE(p.precio_usd_8, ' ', ''), 2, 'de_DE') as precio
    FROM inventario as inv
    LEFT JOIN inventario_det as invDet ON inv.id=invDet.inventario_id
    LEFT JOIN empresa as e ON inv.empresa_id=e.id
    LEFT JOIN inv_deposito as dep ON inv.deposito_id=dep.id
    LEFT JOIN producto as p ON inv.producto_id=p.id
    LEFT JOIN prod_laboratorio as pl ON p.laboratorio_id=pl.id
    LEFT JOIN prod_unidad as pu ON p.unidad_id=pu.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    LEFT JOIN prod_compuesto as pcomp ON p.id=pcomp.producto_id
    WHERE 1 $empQuery $depQuery $stQuery $qtyMyQuery $qtyMnQuery $vencQuery $pvencQuery $catQuery $comQuery $labQuery $preQuery $tipoQuery $prodQuery
    GROUP BY p.id
    ORDER BY p.nombre ASC
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