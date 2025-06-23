<?php
  $prods = array();
  $i=0;
  foreach ($prod_vendidos as $prod_vendido):
    if(empty($prods[$prod_vendido["pid"]]["qty"])) {
      $prods[$prod_vendido["pid"]]["empresa"]=$prod_vendido["emin"];
      $prods[$prod_vendido["pid"]]["deposito"]=$prod_vendido["idname"];
      $prods[$prod_vendido["pid"]]["producto"]=$prod_vendido["pname"];
      $prods[$prod_vendido["pid"]]["serial"]=$prod_vendido["sname"];
      $prods[$prod_vendido["pid"]]["lab"]=$prod_vendido["labname"];
      $prods[$prod_vendido["pid"]]["unit"]=$prod_vendido["unit"];
      $prods[$prod_vendido["pid"]]["qty"]=$prod_vendido["qty"];
      $prods[$prod_vendido["pid"]]["total"]=str_replace(",",".",str_replace(".","",$prod_vendido["total"]));
    } else {
      $qty_old=$prods[$prod_vendido["pid"]]["qty"];
      $total_old=$prods[$prod_vendido["pid"]]["total"];
      $total_new=str_replace(",",".",str_replace(".","",$prod_vendido["total"]));
      $prods[$prod_vendido["pid"]]["qty"]=$prod_vendido["qty"]+$qty_old;
      $prods[$prod_vendido["pid"]]["total"]=$total_new+$total_old;
    }
    $i++;
  endforeach;
?>
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
</style>

<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>

<div style="font-size: 12px; max-width: 21cm;">
  <table style="border-spacing: 0px; width: 100%;" id="tabla_export">
    <thead>
      <tr>
        <td colspan="9" style="text-align: center; text-decoration: underline;">
          <p style="margin-top: 0px !important">
            <b>REPORTE DE PRODUCTOS MAS VENDIDOS</b>
            <b><?php echo date('d/m/Y H:i:s'); //." - ".ini_get('date.timezone') ?></b>
          </p>
        </td>
      </tr>
      <tr style="font-size: 10px !important">
        <td class="bbottom" style="width: 1cm;"></td>
        <td class="bbottom tleft" style="width: 1cm;"><b>EMP.</b></td>
        <td class="bbottom tleft" style="width: 1.4cm;"><b>DPSTO.</b></td>
        <td class="bbottom tleft" style="width: 2cm;"><b>SERIAL</b></td>
        <td class="bbottom tleft" style="width: 1.6cm;"><b>LAB</b></td>
        <td class="bbottom tleft" style="width: 2.5cm;"><b>PRESENTACION</b></td>
        <td class="bbottom tleft"><b>NOMBRE</b></td>
        <td class="bbottom tright" style="width: 1.5cm;"><b>QTY</b></td>
        <td class="bbottom tright" style="width: 1.5cm;"><b>TOTAL</b></td>
      </tr>
    </thead>
    <tbody>
    <?php
      $i=1;
      if (count($prods)>0):
        function cmp($a, $b) {
          return $b["qty"] - $a["qty"];
        }
        usort($prods, "cmp");
        
        $i=0;
        foreach ($prods as $prod):
          $background="background-color: #fff";
          if ($i & 1) {
            $background="background-color: #dcdada";
          }
    ?>
          <tr style="font-size: 11px !important; <?php echo $background; $i++;?>">
            <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; ?></td>
            <td class="bbottom tleft tcaps"><?php echo $prod["empresa"]; ?></td>
            <td class="bbottom tleft tcaps"><?php echo $prod["deposito"]; ?></td>
            <td class="bbottom tleft tcaps"><?php echo trim($prod["serial"]); ?></td>
            <td class="bbottom tleft tcaps"><?php echo $prod["lab"]; ?></td>
            <td class="bbottom tleft tcaps"><?php echo $prod["unit"]; ?></td>
            <td class="bbottom tleft tcaps"><?php echo $prod["producto"]; ?></td>
            <td class="bbottom tright"><?php echo $prod["qty"]; ?></td>
            <td class="bbottom tright"><?php echo number_format($prod["total"],4,",","."); ?></td>
          </tr>
    <?php 
        endforeach;
      endif; 
    ?>
    </tbody>
  </table>
</div>

<style>
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
    var css = '@page { size: 216mm 279mm; margin: 5mm 5mm 5mm 5mm; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    document.title='productos_vendidos_'+fecha+'.pdf';
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
    console.log(fecha);
    $("#tabla_export").table2excel({
      filename: 'productos_vendidos_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>
