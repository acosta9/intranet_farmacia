<?php
  $dida=$sf_params->get('dida');
  $didb=$sf_params->get('didb');
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  
  $didaData = $q->execute("SELECT id.nombre as idname, e.acronimo as ename
    FROM inv_deposito as id
    LEFT JOIN empresa as e ON id.empresa_id=e.id
    WHERE id.id=$dida");
  $dida_name="";
  foreach ($didaData as $didaD) {
    $dida_name="[".$didaD["ename"]."] ".$didaD["idname"];
  }

  $didbData = $q->execute("SELECT id.nombre as idname, e.acronimo as ename
    FROM inv_deposito as id
    LEFT JOIN empresa as e ON id.empresa_id=e.id
    WHERE id.id=$didb");
  $didb_name="";
  foreach ($didbData as $didbD) {
    $didb_name="[".$didbD["ename"]."] ".$didbD["idname"];
  }

  $tipo="--"; $tipoQuery="";
  if($sf_params->get('tipo')=="1") {
    $tipo="IMPORTADO";
    $tipoQuery=" && p.tipo='1' ";
  } else if ($sf_params->get('tipo')=="0") {
    $tipo="NACIONAL";
    $tipoQuery=" && p.tipo='0' ";
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

  $inv1 = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial, 
    i.cantidad as cantInv, i.id as iid
    FROM inventario as i
    LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
    LEFT JOIN producto as p ON i.producto_id=p.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    WHERE i.deposito_id=$dida $tipoQuery $catQuery $unitQuery
    GROUP BY i.producto_id
    ORDER BY p.nombre ASC");
  $prods1=array();
  foreach($inv1 as $data) {
    $prods1[$data["pid"]]["id"]=$data["pid"];
    $prods1[$data["pid"]]["nombre"]=$data["pname"];
    $prods1[$data["pid"]]["serial"]=$data["serial"];
    $prods1[$data["pid"]]["existencia"]=$data["cantInv"];
  }

  $inv2 = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial, 
    i.cantidad as cantInv, i.id as iid, i.limite_stock as minimo
    FROM inventario as i
    LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
    LEFT JOIN producto as p ON i.producto_id=p.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    WHERE i.deposito_id=$didb $tipoQuery $catQuery $unitQuery
    GROUP BY i.producto_id
    ORDER BY p.nombre ASC");
  $prods2=array();
  foreach($inv2 as $data) {
    $prods2[$data["pid"]]["id"]=$data["pid"];
    $prods2[$data["pid"]]["nombre"]=$data["pname"];
    $prods2[$data["pid"]]["serial"]=$data["serial"];
    $prods2[$data["pid"]]["existencia"]=$data["cantInv"];
    $prods2[$data["pid"]]["minimo"]=$data["minimo"];
  }
  $exis=0; $minimo=0;
?>
<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>
<div>
  <table style="border-spacing: 0px; width: 100%; font-size: 12px" id="tabla_export">
    <thead>
      <tr>
        <td colspan="7" class="ball" style="text-align:center">
          COMPARAR DEPOSITOS: <?php echo date('d/m/Y H:i:s'); ?>
        </td>
      </tr>
      <tr>
        <td colspan="1" class="bleft bbottom"><b>DEPOSITO (A):</b> <?php echo $dida_name; ?></td>
        <td colspan="1" class="bleft bbottom"><b>DEPOSITO (B):</b> <?php echo $didb_name; ?></td>
        <td colspan="2" class="bleft bright bbottom"><b>CATEGORIA:</b> <?php echo $cat; ?></td>
        <td colspan="2" class="bleft bright bbottom"><b>PRESENTACION:</b> <?php echo $unit; ?></td>
        <td colspan="1" class="bleft bright bbottom"><b>TIPO:</b> <?php echo $tipo; ?></td>
      </tr>
      <tr>
        <td colspan="7"><br/><br/></td>
      </tr>
      <tr style="background-color: #b3afafab;">
        <td class="bleft btop" colspan="2"><b>NOMBRE</b></td>
        <td class="bleft btop"><b>SERIAL</b></td>
        <td class="bleft btop"><b>EXISTENCIA (A)</b></td>
        <td class="bleft btop"><b>EXISTENCIA (B)</b></td>
        <td class="bleft btop"><b>MINIMO IDEAL (B)</b></td>
        <td class="bleft btop"><b>TRASLADO SUGERIDO</b></td>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($prods1 as $prod): ?>
        <tr>
          <td class="btop bleft bright" colspan="2"><?php echo $prod["nombre"];?></td>
          <td class="btop bright"><?php echo $prod["serial"]; ?></td>
          <td class="btop bright"><?php echo $prod["existencia"]; ?></td>
          <?php if(!empty($prods2[$prod["id"]]["nombre"])) { ?>
            <td class="btop bleft bright"><?php echo $exis=$prods2[$prod["id"]]["existencia"];?></td>
            <td class="btop bright"><?php echo $minimo=$prods2[$prod["id"]]["minimo"]; ?></td>
            <td class="btop bright">
              <?php 
                $tsug=round($minimo-$exis);
                if($tsug<0) {
                  echo "0";
                } else {
                  echo $tsug;
                } ?>
            </td>
          <?php } else { ?>
            <td class="btop bleft bright">--</td>
            <td class="btop bright">--</td>
            <td class="btop bright">--</td>
          <?php } ?>
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
