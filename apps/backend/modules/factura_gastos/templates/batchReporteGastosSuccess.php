<?php  $q = Doctrine_Manager::getInstance()->getCurrentConnection(); ?>
<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>
<table style="border-spacing: 0px; width: 100%;" id="tabla_export">
  <thead>
    <tr>
      <td colspan="13" style="text-align: center; text-decoration: underline;">
        <p style="margin-top: 0px !important">
          <b>REPORTE DE GASTOS</b>
          <b><?php echo date('d/m/Y') ?></b>
        </p>
      </td>
    </tr>
    <tr style="font-size: 11px !important">
      <td class="bbottom"></td>
      <td class="bbottom tleft"><b>EMPRESA</b></td>
      <td colspan="2" class="bbottom tleft"><b>RAZON SOCIAL</b></td>
      <td class="bbottom tleft"><b>TIPO GASTOS</b></td>
      <td class="bbottom tleft"><b>TIPO FACTURA</b></td>
      <td class="bbottom tleft"><b>FACTURA</b></td>
      <td class="bbottom tleft"><b>TOTAL BsS</b></td>
      <td class="bbottom tleft"><b>TOTAL USD</b></td>
      <td class="bbottom tleft"><b>ESTATUS</b></td>
    </tr>
  </thead>
  <tbody>
    <?php $i=1;
    foreach ($factura_gastoss as $gastos) {
     if($gastos->getEstatus()==1 || $gastos->getEstatus()==2) {  // saldo pendiente o abonado
        if($gastos->getEstatus()==1)
          $estatus="PENDIENTE";
        else
          $estatus="ABONADO";

        if($gastos->getTipo()==1) {
          $tipo="FACTURA DE GASTOS";
         } else if($gastos->getTipo()==2) {
          $tipo="NOTA DE DEBITO";
         } 
   
     ?>
      <tr style="font-size: 11px !important" >
        <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
        <td class="bbottom tleft tcaps" ><?php echo $gastos->getCompany();?></td>
        <td colspan="2" class="bbottom tleft tcaps" ><?php echo mb_strtolower($gastos->getRazonSocial());?></td>
        <td class="bbottom tleft"><?php echo $gastos->getTgastos(); ?></td>
        <td class="bbottom tleft"><?php echo $tipo; ?></td>
        <td class="bbottom tleft"><?php echo $gastos->getNumFactura(); ?></td>
        <td class="bbottom tleft"><?php echo $gastos->getTotalbs(); ?></td>
        <td class="bbottom tleft"><?php echo $gastos->getTotalCoin(); ?></td>
        <td class="bbottom tleft"><?php echo $estatus; ?></td>
      </tr>
    <?php   } // if estatus pendiente 
      } // foreach ?>
  </tbody>
</table>

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

<script>
  function toPdf() {
    $("#botones").hide();
    <?php $dt = new DateTime(); ?>
    var fecha = "<?php echo $dt->format('Y-m-d_H:i:s'); ?>";
    var css = '@page { size: 297mm 210mm; margin: 2mm 2mm 2mm 2mm; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    document.title='gastos_'+fecha+'.pdf';
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
      filename: 'gastos_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>
<script src="/js/jquery.table2excel.min.js"></script>