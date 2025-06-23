<?php
 
  $emp="";
  if(!empty($empid=$sf_params->get('eid'))) {
    $results = Doctrine_Query::create()
      ->select('e.nombre as ename')
      ->from('Empresa e')
      ->Where('e.id =?', $empid)
      ->execute();
    foreach ($results as $result) {
      $emp=$result["ename"];
    }
  }

 
  $desde="--"; $desdeQuery="";
  if(!empty($sf_params->get("desde"))) {
    $desde=$sf_params->get("desde");
   // $desdeQuery=" && p.fecha >= '$desde"." 00:00:00'";
  }

  $hasta="--"; $hastaQuery="";
  if(!empty($sf_params->get("hasta"))) {
    $hasta=$sf_params->get("hasta");
    //$hastaQuery=" && k.fecha <= '$hasta"." 00:00:00'";
  }

  $fecha=date('Y')."/01/01 00:00:00";
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $cxps = $q->execute("SELECT fc.id as idfc, fc.fecha as fechae, fc.fecha_recepcion as fechar, fc.dias_credito as diasc,
    fc.num_factura as nfactura, fc.ncontrol as ncontrol, fc.base_imponible as baseimp, fc.iva_monto as ivam, fc.estatus, fc.total2 as total2, p.total as total, p.tasa_cambio as tasac, fg.id as idfg, fg.fecha as fechaeg, fg.fecha_recepcion as fecharg, fg.dias_credito as diascg, fg.num_factura as nfacturag, fg.ncontrol as ncontrolg, fg.base_imponible as baseimpg, fg.iva_monto as ivamg, fg.total2 as total2g
    FROM cuentas_pagar as p
    LEFT JOIN factura_compra as fc ON p.factura_compra_id=fc.id
    LEFT JOIN factura_gastos as fg ON p.factura_gastos_id=fg.id
    WHERE p.empresa_id=$empid && p.estatus<>4 && p.fecha >= '$desde' && p.fecha <= '$hasta'
    ORDER BY p.fecha ASC");
 
    
?>
<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>
<div>
  <table style="border-spacing: 0px; width: 100%; font-size: 12px" id="tabla_export">
    <thead>
      <tr>
        <td colspan="10" style="text-align:center">
          <b>EMPRESA: <?php echo $emp; ?> <br> FACTURAS REGISTRADAS</b>
        </td>
      </tr>

      <tr>
        <td colspan="8" style="text-align:center"></td>
        <td colspan="2" style="text-align:center">
          <b>FECHA: <?php echo date('d/m/Y H:i:s'); ?></b>
        </td>
      </tr>
     
      <tr>
        <td colspan="2" ><b>DESDE:</b> <?php list($annoD, $mesD, $diaD)=explode("-",$desde); echo $diaD."/".$mesD."/".$annoD?></td>
        <td colspan="2" ><b>HASTA:</b> <?php list($annoH, $mesH, $diaH)=explode("-",$hasta); echo $diaH."/".$mesH."/".$annoH?>
        <td colspan="6"></td>
      </tr>
      <tr>
        <td colspan="10"><br/><br/></td>
      </tr>
      <tr style="font-size: 11px !important">
        <td class="bbottom tcenter"><b>NUM.</b></td>
        <td class="bbottom tleft"><b>FECHA EMISION</b></td>
        <td class="bbottom tleft"><b>FECHA RECEPCION</b></td>
        <td class="bbottom tleft"><b>FECHA VENCIM</b></td>
        <td class="bbottom tleft"><b>NUM FACTURA</b></td>
        <td class="bbottom tleft"><b>NUM CONTROL</b></td>
        <td class="bbottom tleft"><b>TOTAL</b></td>
        <td class="bbottom tleft"><b>EXENTO</b></td>
        <td class="bbottom tleft"><b>BASE IMP</b></td>
        <td class="bbottom tleft"><b>IVA</b></td>
        
      </tr>
      
    </thead>
    <tbody>
    <?php $i=1;
      foreach ($cxps as $cxp): 
        if($cxp["idfc"]) {
        list($annoD2, $mesD2, $diaD2)=explode("-",$cxp["fechar"]);
        $fechave = $diaD2."-".$mesD2."-".$annoD2;
        $diasc = intval($cxp["diasc"]); 

        $exento=$cxp["total2"]-($cxp["baseimp"]+$cxp["ivam"]); ?>
      <tr>
        <tr style="font-size: 11px !important" >
        <td class="bbottom tcenter clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
        <td class="bbottom tleft"><?php list($annoD, $mesD, $diaD)=explode("-",$cxp["fechae"]); echo $diaD."/".$mesD."/".$annoD?></td>
        <td class="bbottom tleft"><?php list($annoD1, $mesD1, $diaD1)=explode("-",$cxp["fechar"]); echo $diaD1."/".$mesD1."/".$annoD1?></td>
        <td class="bbottom tleft"><?php echo date("d/m/Y",strtotime($fechave." + ".$diasc." days")); ?></td>
        <td class="bbottom tleft"><?php echo $cxp["nfactura"] ?></td>
        <td class="bbottom tleft"><?php echo $cxp["ncontrol"]  ?></td>
        <td class="bbottom tleft"><?php echo $cxp["total2"] ?></td>
        <td class="bbottom tleft"><?php echo $exento ?></td>
        <td class="bbottom tleft"><?php echo $cxp["baseimp"] ?></td>
        <td class="bbottom tleft"><?php echo $cxp["ivam"] ?></td>
      </tr>
      </tr>
    <?php }
      else {  
        list($annoD2, $mesD2, $diaD2)=explode("-",$cxp["fecharg"]);
        $fechave = $diaD2."-".$mesD2."-".$annoD2;
        $diasc = intval($cxp["diascg"]); 

        $exento=$cxp["total2g"]-($cxp["baseimpg"]+$cxp["ivamg"]); ?>

      <tr>
        <tr style="font-size: 11px !important" >
        <td class="bbottom tcenter clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
        <td class="bbottom tleft"><?php list($annoD, $mesD, $diaD)=explode("-",$cxp["fechaeg"]); echo $diaD."/".$mesD."/".$annoD?></td>
        <td class="bbottom tleft"><?php list($annoD1, $mesD1, $diaD1)=explode("-",$cxp["fecharg"]); echo $diaD1."/".$mesD1."/".$annoD1?></td>
        <td class="bbottom tleft"><?php echo date("d/m/Y",strtotime($fechave." + ".$diasc." days")); ?></td>
        <td class="bbottom tleft"><?php echo $cxp["nfacturag"] ?></td>
        <td class="bbottom tleft"><?php echo $cxp["ncontrolg"]  ?></td>
        <td class="bbottom tleft"><?php echo $cxp["total2g"] ?></td>
        <td class="bbottom tleft"><?php echo $exento ?></td>
        <td class="bbottom tleft"><?php echo $cxp["baseimpg"] ?></td>
        <td class="bbottom tleft"><?php echo $cxp["ivamg"] ?></td>
      </tr>
      </tr>        


        
    <?php } endforeach; ?>
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
    var css = '@page { size: 279mm 216mm; margin: 5mm 5mm 5mm 5mm; }',
    //var css = '@page { size: 297mm 210mm; margin: 2mm 2mm 2mm 2mm; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    document.title='fact_'+fecha+'.pdf';
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
      filename: 'fact_'+fecha+'.xls',
      preserveColors: true 
    });
  }
  /* Función que suma o resta días a una fecha, si el parámetro
   días es negativo restará los días*/
</script>
