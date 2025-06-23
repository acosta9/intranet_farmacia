<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>
<div>
  <table style="border-spacing: 0px; width: 100%; font-size: 12px" id="tabla_export">
    <thead>
      <tr>
        <td colspan="7" class="ball">
          <p style="margin-top: 0px !important; text-align: center">
            <b>REPORTE RANKING DE CLIENTES</b>
            <b><?php echo date('d/m/Y H:i:s'); //." - ".ini_get('date.timezone') ?></b>
          </p>
        </td>
      </tr>
      <tr style="background-color: #b3afafab;">
        <td class="bleft"></td>
        <td class="bleft"><b>EMPRESA</b></td>
        <td class="bleft"><b>DEPOSITO</b></td>
        <td class="bleft"><b>CLIENTE</b></td>
        <td class="bleft"><b>CI/RIF</b></td>
        <td class="bleft tright"><b>CANT.</b></td>
        <td class="bleft tright"><b>TOTAL</b></td>
      </tr>
    </thead>
    <tbody>
    <?php
    $i=0;
        foreach ($prod_vendidos as $prod):
    ?>
          <tr>
            <td class="bleft btop"><?php echo $i; $i++; ?></td>
            <td class="bleft btop"><?php echo $prod["emin"]; ?></td>
            <td class="bleft btop"><?php echo trim($prod["idname"]); ?></td>
            <td class="bleft btop"><?php echo mb_strtoupper($prod["cname"]); ?></td>
            <td class="bleft btop"><?php echo mb_strtoupper($prod["docid"]); ?></td>
            <td class="bleft btop tright"><?php echo $prod["qty"]; ?></td>
            <td class="bleft btop tright"><?php echo $prod["total"]; ?></td>
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

    document.title='reporte_ranking_clientes_'+fecha+'.pdf';
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
      filename: 'reporte_ranking_clientes_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>
