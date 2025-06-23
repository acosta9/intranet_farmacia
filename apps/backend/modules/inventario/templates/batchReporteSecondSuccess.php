<?php
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT o.nombre as tipo, FORMAT(REPLACE(o.valor, ' ', ''), 4, 'de_DE') as formatNumber,
  REPLACE(o.valor, ' ', '') as numero
  FROM otros o
  INNER JOIN empresa e ON o.empresa_id=e.id
  WHERE e.tipo=3 && (o.nombre='T01' || o.nombre='T02')
  ORDER BY o.id DESC
  LIMIT 2");
  $tasa=array();
  foreach ($results as $result) {
    $tasa[$result["tipo"]]["format"]=$result["formatNumber"];
    $tasa[$result["tipo"]]["number"]=$result["numero"];
  }  
?>
<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>

<div style="font-size: 12px;">
  <table id="tabla_export" style="border-spacing: 0px; width: 100%;">
    <thead>
      <tr>
        <td colspan="12" style="text-align: center; text-decoration: underline;">
          <p style="margin-top: 0px !important">
            <b>REPORTE DE PRECIOS</b>
            <b><?php echo date('d/m/Y H:i:s'); //." - ".ini_get('date.timezone') ?></b>
          </p>
        </td>
      </tr>
      <tr style="">
        <td class="bbottom" style="width: 1cm;"></td>
        <td class="bbottom tleft"><b>EMP.</b></td>
        <td class="bbottom tleft"><b>DEP.</b></td>
        <td class="bbottom tleft"><b>SERIAL</b></td>
        <td class="bbottom tleft"><b>NOMBRE</b></td>
        <td class="bbottom tleft"><b>PRESENTACION</b></td>
        <td class="bbottom tright"><b>QTY.</b></td>
        <td class="bbottom tright"><b>COSTO</b></td>
        <td class="bbottom tright"><b>UTIL. (8)</b></td>
        <td class="bbottom tright"><b>PRECIO (8)</b></td>
        <td class="bbottom tright"><b>TASA CAMBIO</b></td>
        <td class="bbottom tright"><b>PRECIO BS</b></td>
      </tr>
    </thead>
    <tbody>
      <?php
        $i=1;
        foreach ($inventarios as $inventario):
          $background="background-color: #fff";
          if ($i & 1) {
            $background="background-color: #dcdada";
          }
          if (strpos(mb_strtolower($inventario["pcname"]), 'farmacia') !== false) {
            $tasaProd="T01";
          } else {
            $tasaProd="T02";
          }
          if(!empty($inventario["p8"])) {
            $price=$inventario["p8"];
            $priceFormat=number_format($price,4,",",".");
            $price_bs=number_format($price*$tasa[$tasaProd]["number"],4,",",".");
          } else {
            $priceFormat="0,0000";
            $price_bs="0,0000";
          }

          if(!empty($inventario["util8"])) {
            $utilFormat=number_format($inventario["util8"],4,",",".");
          } else {
            $utilFormat="0,0000";
          }

          if(!empty($inventario["costo"])) {
            $costoFormat=number_format($inventario["costo"],4,",",".");
          } else {
            $costoFormat="0,0000";
          }
      ?>
          <tr style="<?php echo $background; ?>">
            <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
            <td class="bbottom tleft tcaps"><?php echo $inventario["emin"];?></td>
            <td class="bbottom tleft tcaps"><?php echo $inventario["idname"];?></td>
            <td class="bbottom tleft"><?php echo $inventario["sname"];?></td>
            <td class="bbottom tleft tcaps"><?php echo mb_strtolower($inventario["pname"]);?></td>
            <td class="bbottom tleft tcaps"><?php echo mb_strtolower($inventario["unit"]);?></td>
            <td class="bbottom tright"><?php echo $inventario["qty"];?></td>
            <td class="bbottom tright" ><?php echo "$".$costoFormat;?></td>
            <td class="bbottom tright" ><?php echo $utilFormat."%";?></td>
            <td class="bbottom tright" ><?php echo "$".$priceFormat;?></td>
            <td class="bbottom tright" ><?php echo $tasa[$tasaProd]["format"];?></td>
            <td class="bbottom tright" ><?php echo $price_bs;?></td>
          </tr>
      <?php
        endforeach;
      ?>
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
    border: 1px solid #b3b3b38a !important;
  }

  .bright {
    border-right: 1px solid #b3b3b38a !important;
  }

  .bleft {
    border-left: 1px solid #b3b3b38a !important;
  }

  .bbottom {
    border-bottom: 1px solid #b3b3b38a !important;
  }

  .btop {
    border-top: 1px solid #b3b3b38a !important;
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

    document.title='reporte_precios_inventario_'+fecha+'.pdf';
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
      filename: 'reporte_precios_inventario_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>
