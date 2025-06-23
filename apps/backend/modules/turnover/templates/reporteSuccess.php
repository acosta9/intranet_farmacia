<?php
  $tipo="--"; $tipoQuery="";
  if($sf_params->get('tipo')=="1") {
    $tipo="IMPORTADO";
    $tipoQuery=" && p.tipo='1' ";
  } else if ($sf_params->get('tipo')=="0") {
    $tipo="NACIONAL";
    $tipoQuery=" && p.tipo='0' ";
  }
  $emp="";
  if(!empty($empid=$sf_params->get('eid'))) {
    $results = Doctrine_Query::create()
      ->select('e.acronimo as ename')
      ->from('Empresa e')
      ->Where('e.id =?', $empid)
      ->execute();
    foreach ($results as $result) {
      $emp=$result["ename"];
    }
  }

  $unit="--"; $unitQuery="";
  if(!empty($unitId=$sf_params->get("unit"))) {
    $unitQuery=" && p.unidad_id ='$unitId' ";
    $unitT=Doctrine::getTable('ProdUnidad')->findOneBy('id',$sf_params->get("unit"));
    $unit=$unitT->getNombre();
  }
  $cat="--"; $catQuery="";
  if(!empty($sf_params->get("cid"))) {
    $cat=$sf_params->get("cid");
    $catQuery=" && pc.nombre LIKE '$cat%' ";
  }

  $prodData="--"; $productQuery="";
  if(!empty($sf_params->get("pid"))) {
    $prodData=$sf_params->get("pid");
    $productQuery=" && p.id = '$prodData' ";
    $productoRow=Doctrine::getTable('Producto')->findOneBy('id',$sf_params->get("pid"));
    $prodData=$productoRow->getNombre();
  }

  $desde="--"; $desdeQuery="";
  if(!empty($sf_params->get("desde"))) {
    $desde=$sf_params->get("desde");
    $desdeQuery=" && k.fecha >= '$desde"." 00:00:00'";
  }

  $hasta="--"; $hastaQuery="";
  if(!empty($sf_params->get("hasta"))) {
    $hasta=$sf_params->get("hasta");
    $hastaQuery=" && k.fecha <= '$hasta"." 23:59:00'";
  }

// comentarios para modificar existencia: i.cantidad as cantInv, podria poner una condicion con la descripcion del deposito para contar los del deposito de almacen de ventas y los del deposito centro de distribucion de santa maria

  $fecha=date('Y')."/01/01 00:00:00";
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $kardex = $q->execute("SELECT SUM(k.cantidad) as qty, k.tipo as tipo, MONTH(k.fecha) as mes,
    p.id as pid, p.nombre as pname, p.serial as serial, i.cantidad as cantInv
    FROM kardex as k
    LEFT JOIN inv_deposito as id ON k.deposito_id=id.id
    LEFT JOIN producto as p ON k.producto_id=p.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    LEFT JOIN inventario as i ON p.id=i.producto_id
    WHERE k.empresa_id=$empid && id.tipo=1 $desdeQuery $hastaQuery $tipoQuery $catQuery $unitQuery $productQuery
    GROUP BY mes, k.producto_id, k.tipo
    ORDER BY mes ASC, p.nombre ASC");
  $prods=array(); $listado=array();
  foreach($kardex as $data) {
    $listado[$data["pid"]][$data["mes"]][$data["tipo"]]=$data["qty"];
    $prods[$data["pid"]]["id"]=$data["pid"];
    $prods[$data["pid"]]["nombre"]=$data["pname"];
    $prods[$data["pid"]]["serial"]=$data["serial"];
    $prods[$data["pid"]]["existencia"]=$data["cantInv"];
  }

  $invs = $q->execute("SELECT i.cantidad as cantInv, p.id as pid
    FROM inventario as i
    LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
    LEFT JOIN producto as p ON i.producto_id=p.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    WHERE i.empresa_id=$empid && id.tipo=1 $tipoQuery $catQuery $unitQuery $productQuery
    ORDER BY p.id ASC");
  $invData=array();
  foreach($invs as $inv) {
    $invData[$inv["pid"]]=$inv["cantInv"]; /// ojo es aqui donde analizare la existencia
  }
  
?>
<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>
<div>
  <table style="border-spacing: 0px; width: 100%; font-size: 12px" id="tabla_export">
    <thead>
      <tr>
        <td colspan="34" class="ball" style="text-align:center">
          TURNOVER: <?php echo date('d/m/Y H:i:s'); ?>
        </td>
      </tr>
      <tr>
        <td colspan="6" class="bleft bbottom"><b>EMPRESA:</b> <?php echo $emp." [PISO DE VENTA]"; ?></td>
        <td colspan="7" class="bleft bright bbottom"><b>PRODUCTO:</b> <?php echo $prodData; ?></td>
        <td colspan="7" class="bleft bright bbottom"><b>CATEGORIA:</b> <?php echo $cat; ?></td>
        <td colspan="7" class="bleft bright bbottom"><b>PRESENTACION:</b> <?php echo $unit; ?></td>
        <td colspan="7" class="bleft bright bbottom"><b>TIPO:</b> <?php echo $tipo; ?></td>
      </tr>
      <tr>
        <td colspan="2" class="bleft bbottom"><b>DESDE:</b> <?php list($annoD, $mesD, $diaD)=explode("-",$desde); echo $diaD."/".$mesD."/".$annoD?></td>
        <td colspan="6" class="bleft bright bbottom"><b>HASTA:</b> <?php list($annoH, $mesH, $diaH)=explode("-",$hasta); echo $diaH."/".$mesH."/".$annoH?></td>
      </tr>
      <tr>
        <td colspan="34"><br/><br/></td>
      </tr>
      <tr style="background-color: #b3afafab;">
        <td class="bleft btop" rowspan="2"><b>NOMBRE</b></td>
        <td class="bleft btop" rowspan="2"><b>SERIAL</b></td>
        <td class="bleft btop" rowspan="2"><b>SALDO ANT.</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>ENE</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>FEB</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>MAR</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>ABR</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>MAY</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>JUN</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>JUL</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>AGOS</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>SEPT</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>OCT</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>NOV</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>DIC</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>TOTAL</b></td>
        <td class="bleft bbottom btop" colspan="2"><b>PROMEDIO<br/>MENSUAL</b></td>
        <td class="bleft bbottom btop bright" rowspan="2"><b>EXISTENCIA</b></td>
        <td class="bright btop" rowspan="2"><b>SUG.<br/>COMPRAS</b></td>
        <td class="bright btop" rowspan="2"><b>CANT. A<br/>COMPRAR</b></td>
      </tr>
      <tr style="background-color: #b3afafab;">
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft"><b>SALIDA</b></td>
        <td class="bleft"><b>ENTRADA</b></td>
        <td class="bleft bright"><b>SALIDA</b></td>
      </tr>
    </thead>
    <tbody>
    <?php 
      foreach ($prods as $prod): $ent=0; $sal=0; ?>
      <tr>
        <td class="btop bleft bright"><?php echo $prod["nombre"]; $entrada=0; $salida=0;?></td>
        <td class="btop bright"><?php echo $prod["serial"]; ?></td>
        <td class="btop bright tcenter">0</td> <!-- Comentario: aqui si entrada o salida es cero no cuento el mes, si es else cuento un contador para sacar el promedio  -->
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["1"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["1"]["1"]; $entrada+=$listado[$prod["id"]]["1"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["1"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["1"]["2"]; $salida+=$listado[$prod["id"]]["1"]["2"]; $sal++; };  ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["2"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["2"]["1"]; $entrada+=$listado[$prod["id"]]["2"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["2"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["2"]["2"]; $salida+=$listado[$prod["id"]]["2"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["3"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["3"]["1"]; $entrada+=$listado[$prod["id"]]["3"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["3"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["3"]["2"]; $salida+=$listado[$prod["id"]]["3"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["4"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["4"]["1"]; $entrada+=$listado[$prod["id"]]["4"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["4"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["4"]["2"]; $salida+=$listado[$prod["id"]]["4"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["5"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["5"]["1"]; $entrada+=$listado[$prod["id"]]["5"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["5"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["5"]["2"]; $salida+=$listado[$prod["id"]]["5"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["6"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["6"]["1"]; $entrada+=$listado[$prod["id"]]["6"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["6"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["6"]["2"]; $salida+=$listado[$prod["id"]]["6"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["7"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["7"]["1"]; $entrada+=$listado[$prod["id"]]["7"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["7"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["7"]["2"]; $salida+=$listado[$prod["id"]]["7"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["8"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["8"]["1"]; $entrada+=$listado[$prod["id"]]["8"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["8"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["8"]["2"]; $salida+=$listado[$prod["id"]]["8"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["9"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["9"]["1"]; $entrada+=$listado[$prod["id"]]["9"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["9"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["9"]["2"]; $salida+=$listado[$prod["id"]]["9"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["10"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["10"]["1"]; $entrada+=$listado[$prod["id"]]["10"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["10"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["10"]["2"]; $salida+=$listado[$prod["id"]]["10"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["11"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["11"]["1"]; $entrada+=$listado[$prod["id"]]["11"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["11"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["11"]["2"]; $salida+=$listado[$prod["id"]]["11"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["12"]["1"])) {echo "0"; } else { echo $listado[$prod["id"]]["12"]["1"]; $entrada+=$listado[$prod["id"]]["12"]["1"]; $ent++; }; ?></td>
        <td class="btop bright tcenter"><?php if(empty($listado[$prod["id"]]["12"]["2"])) {echo "0"; } else { echo $listado[$prod["id"]]["12"]["2"]; $salida+=$listado[$prod["id"]]["12"]["2"]; $sal++; }; ?></td>
        <td class="btop bright tcenter"><?php echo $entrada; ?></td>
        <td class="btop bright tcenter"><?php echo $salida; ?></td>
        <td class="btop bright tcenter"><?php if($entrada>0){ echo number_format($entrada/$ent);} else { echo "0";} ?></td>
        <td class="btop bright tcenter"><?php if($salida>0) {echo $prom_salida=number_format($salida/$sal);} else { echo "0";} ?></td>
        <td class="btop bright tcenter"><?php echo $existencia=$invData[$prod["id"]]; ?></td>
        <td class="btop bright tcenter"><?php echo $sug=$prom_salida-$existencia; ?></td>
        <td class="btop bright tcenter"><?php echo ($sug*1.30); ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<style>
  .btn {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    text-decoration: none;
  }
  .btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    box-shadow: 0 1px 1px rgba(0,0,0,.075);
  }
  .btn-success {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
    box-shadow: 0 1px 1px rgba(0,0,0,.075);
  }
  .tcaps {
    text-transform: capitalize;
  }
  .clight {
    color: #adadad;
  }
  .ball {
    border: 1px solid #4441418c !important;
  }

  .bright {
    border-right: 1px solid #4441418c !important;
  }

  .bleft {
    border-left: 1px solid #4441418c !important;
  }

  .bbottom {
    border-bottom: 1px solid #4441418c !important;
  }

  .btop {
    border-top: 1px solid #4441418c !important;
  }

  .tleft {
    text-align: left !important;
  }

  .tright {
    text-align: right !important;
  }

  .tcenter {
    text-align: center !important;
  }

  .vcenter {
    vertical-align: middle !important;
  }
</style>

<script src="/js/jquery.table2excel.min.js"></script>
<script>
  function toPdf() {
    $("#botones").hide();
    <?php $dt = new DateTime(); ?>
    var fecha = "<?php echo $dt->format('Y-m-d_H:i:s'); ?>";
    var css = '@page { size: 297mm 210mm; margin: 2mm 2mm 2mm 2mm; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    document.title='turnover_'+fecha+'.pdf';
    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);

    window.print();
    $("#botones").show();
  }
  function toExcel() {
    <?php $dt = new DateTime(); ?>
    var fecha = "<?php echo $dt->format('Y-m-d_H:i:s'); ?>";
    $("#tabla_export").table2excel({
      filename: 'turnover_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>
