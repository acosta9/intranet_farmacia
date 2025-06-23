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

  $fecha=date('Y')."/01/01 00:00:00";
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $kardex = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial, 
    i.cantidad as cantInv, i.id as iid
    FROM inventario as i
    LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
    LEFT JOIN producto as p ON i.producto_id=p.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    WHERE i.empresa_id=$empid && id.tipo=1 $tipoQuery $catQuery $unitQuery
    GROUP BY i.producto_id
    ORDER BY p.nombre ASC");
  $prods=array();
  foreach($kardex as $data) {
    $prods[$data["iid"]]["id"]=$data["iid"];
    $prods[$data["iid"]]["nombre"]=$data["pname"];
    $prods[$data["iid"]]["serial"]=$data["serial"];
    $prods[$data["iid"]]["existencia"]=$data["cantInv"];
  }

  $ventas = $q->execute("SELECT fd.inventario_id as fdiid, od.inventario_id as odiid
    FROM factura_det as fd
    LEFT JOIN factura as k ON fd.factura_id=k.id
    LEFT JOIN oferta as offer ON fd.oferta_id=offer.id
    LEFT JOIN oferta_det as od ON offer.id=od.oferta_id
    WHERE k.empresa_id=$empid $desdeQuery $hastaQuery");
  $ventasData=array();
  foreach($ventas as $inv) {
    if(!empty($inv["fdiid"])) {
      $ventasData[$inv["fdiid"]]="1";
    } else {
      $ventasData[$inv["odiid"]]="1";
    }
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
        <td colspan="4" class="ball" style="text-align:center">
          PRODUCTOS NO VENDIDOS: <?php echo date('d/m/Y H:i:s'); ?>
        </td>
      </tr>
      <tr>
        <td colspan="1" class="bleft bbottom"><b>EMPRESA:</b> <?php echo $emp." [PISO DE VENTA]"; ?></td>
        <td colspan="1" class="bleft bright bbottom"><b>CATEGORIA:</b> <?php echo $cat; ?></td>
        <td colspan="1" class="bleft bright bbottom"><b>PRESENTACION:</b> <?php echo $unit; ?></td>
        <td colspan="1" class="bleft bright bbottom"><b>TIPO:</b> <?php echo $tipo; ?></td>
      </tr>
      <tr>
        <td colspan="2" class="bleft bbottom"><b>DESDE:</b> <?php list($annoD, $mesD, $diaD)=explode("-",$desde); echo $diaD."/".$mesD."/".$annoD?></td>
        <td colspan="2" class="bleft bright bbottom"><b>HASTA:</b> <?php list($annoH, $mesH, $diaH)=explode("-",$hasta); echo $diaH."/".$mesH."/".$annoH?></td>
      </tr>
      <tr>
        <td colspan="4"><br/><br/></td>
      </tr>
      <tr style="background-color: #b3afafab;">
        <td class="bleft btop" colspan="2"><b>NOMBRE</b></td>
        <td class="bleft btop"><b>SERIAL</b></td>
        <td class="bleft btop"><b>EXISTENCIA</b></td>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($prods as $prod): ?>
      <?php if(empty($ventasData[$prod["id"]])): ?>
        <tr>
          <td class="btop bleft bright" colspan="2"><?php echo $prod["nombre"]; $entrada=0; $salida=0;?></td>
          <td class="btop bright"><?php echo $prod["serial"]; ?></td>
          <td class="btop bright"><?php echo $prod["existencia"]; ?></td>
        </tr>
      <?php endif; ?>
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
