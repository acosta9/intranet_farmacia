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
          <b>EXPORTAR A BANCO</b>
          <b><?php echo date('d/m/Y') ?></b>
        </p>
      </td>
    </tr>
    <tr style="font-size: 11px !important">
      <td class="bbottom"></td>
      <td class="bbottom tleft"><b>EMPRESA</b></td>
      <td colspan="2" class="bbottom tleft"><b>BENEFICIARIO</b></td>
      <td class="bbottom tleft"><b>TIPO</b></td>
      <td class="bbottom tleft"><b>REFERENCIA</b></td>
      <td class="bbottom tleft"><b>FECHA DE PAGO</b></td>
      <td class="bbottom tleft"><b>TOTAL BsS</b></td>
      <td class="bbottom tleft"><b>BANCO</b></td>
    </tr>
  </thead>
  <tbody>
    <?php $i=1;
    foreach ($recibo_pago_compras as $compras) {
     if($compras->getAnulado()==0) {  
      $tipo="NOTA DE DEBITO";
      list($anno, $mes, $dia) = explode('-',$compras->getFecha());
      $fecha=$dia."/".$mes."/".$anno;  
   
     ?>
      <tr style="font-size: 11px !important" >
        <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
        <td class="bbottom tleft tcaps" ><?php echo $compras->getCompany();?></td>
        <td colspan="2" class="bbottom tleft tcaps" ><?php echo mb_strtolower($compras->getPname());?></td>
        <td class="bbottom tleft"><?php echo "NOTA DE DEBITO"; ?></td>
        <td class="bbottom tleft"><?php echo $compras->getNumRecibo(); ?></td>
        <td class="bbottom tleft"><?php echo $fecha; ?></td>
        <td class="bbottom tleft"><?php echo $compras->getTotalbs(); ?></td>
        <td class="bbottom tleft"><?php echo $compras->getNbanco(); ?></td>
      </tr>
    <?php   } // if 
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

    document.title='banco_'+fecha+'.pdf';
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
      filename: 'banco_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>
<script src="/js/jquery.table2excel.min.js"></script>