<?php
 function array_sort_by(&$arrIni, $col, $order = SORT_ASC)
{
    $arrAux = array();
    foreach ($arrIni as $key=> $row)
    {
        $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
        $arrAux[$key] = strtolower($arrAux[$key]);
    }
    array_multisort($arrAux, $order, $arrIni);
}


  $emp="";
  if(!empty($empid=$sf_params->get('eid'))) {
    $results = Doctrine_Query::create()
      ->select('e.nombre as ename, e.acronimo')
      ->from('Empresa e')
      ->Where('e.id =?', $empid)
      ->execute();
    foreach ($results as $result) {
      $emp=$result["ename"];
      $empresa=$result["acronimo"];
    }
  }

 
  $desde="--"; $desdeQuery="";
  if(!empty($sf_params->get("desde"))) {
    $desde=$sf_params->get("desde");
  }

  $hasta="--"; $hastaQuery="";
  if(!empty($sf_params->get("hasta"))) {
    $hasta=$sf_params->get("hasta");
  }

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $cxps = $q->execute("SELECT p.id as cxpid, p.estatus as estatus, p.fecha as femision, f.id as fid, f.razon_social as fpname, f.doc_id as fdocid, f.num_factura as fnum, f.ncontrol as ncontrol,
       f.total2 as ftotal2, f.base_imponible as base_imponible, f.subtotal as subtotal, f.subtotal_desc as subtotal_desc, f.iva as iva, f.iva_monto as ivamonto, f.libro_compras as flibro_compras,

       fg.id as fgid, fg.razon_social as fgpname, fg.doc_id as fgdocid, fg.num_factura as fgnum, fg.ncontrol as gncontrol,fg.total2 as gtotal2,
      fg.base_imponible as gbase_imponible, fg.subtotal as gsubtotal, fg.subtotal_desc as gsubtotal_desc,
      fg.iva as giva, fg.iva_monto as givamonto, fg.libro_compras as libro_compras, fg.tipo as tipo

    FROM cuentas_pagar as p
    LEFT JOIN factura_compra as f ON p.factura_compra_id=f.id
    LEFT JOIN factura_gastos as fg ON p.factura_gastos_id=fg.id
    WHERE p.empresa_id=$empid && p.estatus<>4 && p.fecha >= '$desde' && p.fecha <= '$hasta'
    ORDER BY p.fecha ASC");
  $libro=array();$atotalBs=0; $acompras_siniva=0; $abase_imponibleBs=0; $aivamontoBs=0;
  foreach ($cxps as $item): 

    if(($item["flibro_compras"]==1 || $item["libro_compras"]==1) && $item["estatus"]!=4):
            $totalBs=0; $compras_siniva=0; $base_imponibleBs=0; $ivamontoBs=0;$subtotal_desc=0;$base_imponible=0;$ivamonto=0;
            $tipo_doc="";$estatuss="";$ncontrol="";$razon_social="";$docid="";
        
      
            $id=$item["cxpid"]; 
            if(!empty($item["fid"])) {
              $docid=$item["fdocid"];
              $razon_social=$item["fpname"];
              $num_fact=$item["fnum"];
              $ncontrol=$item["ncontrol"];
              $totalBs=$item["ftotal2"];
              $subtotal_desc=$item["subtotal_desc"];
              $base_imponible=$item["base_imponible"];
              $iva=$item["iva"]; 
              $ivamonto=$item["ivamonto"];
              $tipo_doc="FACT-1";$estatuss="01-REG";
            } else {
              $docid=$item["fgdocid"];
              $razon_social=$item["fgpname"];
              $num_fact=$item["fgnum"];
              $ncontrol=$item["gncontrol"];
              $totalBs=$item["gtotal2"];
              $subtotal_desc=$item["gsubtotal_desc"];
              $base_imponible=$item["gbase_imponible"];
              $iva=$item["giva"];  
              $ivamonto=$item["givamonto"];
              if($item["tipo"]==1){
                $tipo_doc="FACT-1";
                $estatuss="01-REG";
              }
              elseif($item["tipo"]==2){
                $tipo_doc="ND-2";
                $estatuss="02-REG";
              }
            }
            if($base_imponible>0){
              $compras_siniva=$totalBs-($base_imponible+$ivamonto);
            }
            else {
              $compras_siniva=$totalBs;
            }

           // $compras_siniva=$subtotal_desc-$base_imponible;
            $base_imponibleBs=$base_imponible;
            $ivamontoBs=$ivamonto;


            ///////// cargo el arreglo con la info de fact compra y gastos /////
            $libro[$id]["id"]=$id;
            $libro[$id]["femision"]=$item["femision"];
            $libro[$id]["docid"]=$docid;
            $libro[$id]["razon_social"]=$razon_social;
            $libro[$id]["tipo_doc"]=$tipo_doc;
            $libro[$id]["num_fact"]=$num_fact;
            $libro[$id]["ncontrol"]=$ncontrol;
            $libro[$id]["fafectada"]="";
            $libro[$id]["estatus"]=$estatuss;
            $libro[$id]["totalBs"]=$totalBs;
            $libro[$id]["compras_siniva"]=$compras_siniva;
            $libro[$id]["base_imponibleBs"]=$base_imponibleBs;
            $libro[$id]["ivamontoBs"]=$ivamontoBs;

             ///// totales ////
            $atotalBs=$atotalBs+$totalBs;
            $acompras_siniva=$acompras_siniva+$compras_siniva;
            $abase_imponibleBs=$abase_imponibleBs+$base_imponibleBs;
            $aivamontoBs=$aivamontoBs+$ivamontoBs;

     endif;
    endforeach;
 /////// ahora busco las notas de credito durante ese periodo //////
$idnc=1;
$ncs = $q->execute("SELECT d.id as did, d.estatus as estatus, d.fecha as femision, d.moneda as moneda, d.num_recibo as nrecibo, d.ncontrol as ncontrol, d.monto as monto, d.tasa_cambio as tasa, d.libro_compras as libro_compras, p.full_name as pname, p.doc_id as docid, cp.factura_compra_id as cpfcid, cp.factura_gastos_id as cpfgid
    FROM nota_debito as d
    LEFT JOIN nota_debito_det as dd ON d.id=dd.nota_debito_id
    LEFT JOIN cuentas_pagar as cp ON dd.cuentas_pagar_id=cp.id
    LEFT JOIN proveedor as p ON d.proveedor_id=p.id
    WHERE d.empresa_id=$empid && d.estatus<>3 && d.fecha >= '$desde' && d.fecha <= '$hasta'
    ORDER BY d.fecha ASC");
    
  foreach ($ncs as $nc): 
    $fafectada="";$totalBsnc=0;
    if($nc["libro_compras"]==1  && $nc["estatus"]!=3):
           
       $totalBsnc=$nc["monto"]*$nc["tasa"];
       $totalBsnc="-".$totalBsnc;

       //// busco en las tablas factura_compra y factura_gastos cual es el num de la factura afectada con la NC /////
       $fcidnc=$nc["cpfcid"];
       if($fcidnc){
          $fcs = $q->execute("SELECT f.num_factura as nfacturaa
          FROM factura_compra as f
          WHERE f.id='$fcidnc'");
          foreach ($fcs as $fc) { 
            $fafectada=$fc["nfacturaa"];
          }
       }
       $fgidnc=$nc["cpfgid"];
        if($fgidnc){
          $fgs = $q->execute("SELECT g.num_factura as nfacturaa
          FROM factura_gastos as g
          WHERE g.id='$fgidnc'");
          foreach ($fgs as $fg) { 
            $fafectada=$fg["nfacturaa"];
          }
       }

       ///////// cargo el arreglo con la info de notas de credito /////
            $libro[$idnc]["id"]=$idnc;
            $libro[$idnc]["femision"]=$nc["femision"];
            $libro[$idnc]["docid"]=$nc["docid"];
            $libro[$idnc]["razon_social"]=$nc["pname"];
            $libro[$idnc]["tipo_doc"]="NC-3";
            $libro[$idnc]["num_fact"]=$nc["nrecibo"];
            $libro[$idnc]["ncontrol"]=$nc["ncontrol"];
            $libro[$idnc]["fafectada"]=$fafectada;
            $libro[$idnc]["estatus"]="03-REG";
            $libro[$idnc]["totalBs"]=$totalBsnc;
            $libro[$idnc]["compras_siniva"]="0.0000";
            $libro[$idnc]["base_imponibleBs"]="0.0000";
            $libro[$idnc]["ivamontoBs"]="0.0000";

            $idnc++;

             ///// totales ////
            $atotalBs=$atotalBs+$totalBsnc;
           
    endif;
  endforeach;   

  array_sort_by($libro, 'femision', $order = SORT_ASC);
    
?>
<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>
<div id="tabla_export" style="font-size: 12px;">
  <table style="border-spacing: 0px; width: 100%;">
    <thead>
      <tr>
        <td colspan="14" style="text-align: center; text-decoration: underline;">
          <p style="margin-top: 0px !important">
            <b>LIBRO DE COMPRAS</b>
            <b>DESDE:</b> <?php list($annoD, $mesD, $diaD)=explode("-",$desde); echo $diaD."/".$mesD."/".$annoD?>
            <b>HASTA:</b> <?php list($annoH, $mesH, $diaH)=explode("-",$hasta); echo $diaH."/".$mesH."/".$annoH?>
            <br><b>Fecha:</b><?php echo date('d/m/Y H:i'); ?>
          </p>

        </td>
      </tr>
     
      <tr style="">
        <td class="bbottom" style="width: 1cm;"></td>
        <td class="bbottom tleft"><b>EMP.</b></td>
        <td class="bbottom tleft"><b>FECHA EMISION</b></td>
        <td class="bbottom tleft"><b>RIF</b></td>
        <td class="bbottom tleft"><b>NOMBRE O RAZON SOCIAL</b></td>
        <td class="bbottom tleft"><b>TIPO DOC.</b></td>
        <td class="bbottom tleft"><b>NUM. DOC.</b></td>
        <td class="bbottom tright"><b>NUMERO CONTROL</b></td>
        <td class="bbottom tright"><b>FAC. AFECTADA</b></td>
        <td class="bbottom tright"><b>ESTATUS</b></td>
        <td class="bbottom tright"><b>TOTAL</b></td>
        <td class="bbottom tright"><b>COMPRAS EXENTAS</b></td>
        <td class="bbottom tright"><b>BASE IMPONIBLE</b></td>
        <td class="bbottom tright"><b>IMPUESTO IVA</b></td>
      </tr>
    </thead>
    <tbody>
    <?php $i=1;
      foreach ($libro as $lib): 
           $background="background-color: #fff";
           if ($i & 1) {
              $background="background-color: #F2F0F0";  //#dcdada  #EBE8E8
            }

        ?>
      <tr style="<?php echo $background; ?>">
              <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
              <td class="bbottom tleft"><?php echo $empresa;?></td>
              <td class="bbottom tleft"><?php echo date("d/m/Y", strtotime($lib["femision"]));?></td>
              <td class="bbottom tleft"><?php echo $lib["docid"];?></td>
              <td class="bbottom tleft tcaps"><?php echo mb_strtolower($lib["razon_social"]);?></td>
              <td class="bbottom tcenter"><?php echo $lib["tipo_doc"];?></td>
              <td class="bbottom tleft"><?php echo $lib["num_fact"];?></td>
              <td class="bbottom tright"><?php echo $lib["ncontrol"];?></td>
              <td class="bbottom tright"><?php echo $lib["fafectada"]; ?></td>
              <td class="bbottom tcenter"><?php echo $lib["estatus"];?></td>
              <td class="bbottom tright"><?php echo number_format($lib["totalBs"], 4, ',', '.');?></td>
              <td class="bbottom tright"><?php echo number_format($lib["compras_siniva"], 4, ',', '.'); ?></td>
              <td class="bbottom tright"><?php echo number_format($lib["base_imponibleBs"], 4, ',', '.'); ?></td>
              <td class="bbottom tright"><?php echo number_format($lib["ivamontoBs"], 4, ',', '.'); ?></td>
            </tr>
     
    <?php  endforeach; ?>
      <tr>
        <td colspan="14">.</td>
      </tr>
      <tr>
        <td colspan="14">.</td>
      </tr>

      <tr style="<?php echo $background; ?>">
              <td class="bbottom tright clight" style="padding-right: 10px"></td>
              <td class="bbottom tleft"></td>
              <td class="bbottom tleft"></td>
              <td class="bbottom tleft"></td>
              <td class="bbottom tleft tcaps"></td>
              <td class="bbottom tleft"></td>
              <td class="bbottom tleft"></td>
              <td colspan="2" class="bbottom tright"><b>Totales</b></td>
              <td class="bbottom tright"></td>
              <td class="bbottom tright"><b><?php echo number_format($atotalBs, 4, ',', '.');?></b></td>
              <td class="bbottom tright"><b><?php echo number_format($acompras_siniva, 4, ',', '.'); ?></b></td>
              <td class="bbottom tright"><b><?php echo number_format($abase_imponibleBs, 4, ',', '.'); ?></b></td>
              <td class="bbottom tright"><b><?php echo number_format($aivamontoBs, 4, ',', '.'); ?></b></td>
            </tr>

    </tbody>
  </table>
  <div class="row">
  <p><b><em>RESUMEN DE COMPRAS</em></b></p>
  <br>
</div>
<?php $ventasdebitos=$acompras_siniva+$abase_imponibleBs; ?>
<div class="row">  
  <div class="col-md-9">
    <table style="border: ridge;">
       <tr>
        <th style="text-align: left;">Creditos Fiscales</th>
        <th></th>
        <th style="text-align: left;">Base Imponible</th>
        <th colspan="2" style="text-align: left;">CREDITO FISCAL</th>
       </tr>
     <tbody>
       <tr>
         <td>Compras Internas no gravadas</td>
         <td>40</td>
         <td><?php echo number_format($acompras_siniva, 4, ',', '.'); ?></td>
         <td></td>
         <td></td>
       </tr>
       <tr>
         <td>Compras de exportacion</td>
         <td>41</td>
         <td></td>
         <td></td>
         <td></td>
       </tr>
       <tr>
         <td>Compras internas grabadas por alicuotas general</td>
         <td>42</td>
         <td><?php echo number_format($abase_imponibleBs, 4, ',', '.'); ?></td>
         <td>43</td>
         <td><?php echo number_format($aivamontoBs, 4, ',', '.'); ?></td>
       </tr>
       <tr>
         <td>Compras internas gravadas por alicuota general mas adicional</td>
         <td>442</td>
         <td></td>
         <td>452</td>
         <td></td>
       </tr>
       <tr>
         <td>Compras internas grabadas por alicuota reducida</td>
         <td>443</td>
         <td></td>
         <td>453</td>
         <td></td>
       </tr>       
       <tr>
         <td>Total ventas y debitos fiscales para efectos de determinacion</td>
         <td>46</td>
         <td><?php echo number_format($ventasdebitos, 4, ',', '.'); ?></td>
         <td>47</td>
         <td><?php echo number_format($aivamontoBs, 4, ',', '.'); ?></td>
       </tr>
       <tr>
         <td style="width: 40%">Ajustes a los creditos fiscales de periodos anteriores.. Si la operación 47+-48=0, indique el monto del ajust si la operación 47+-48=0, repita con signo negativo hasta la ocurrencia del itm 47 y la diferncia ajustela en periodos futuros.</td>
         <td>48</td>
         <td></td>
         <td></td>
         <td>0.00</td>
       </tr>
       <tr>
         <td>Certificados de creditos Fiscales Exonerados (recibidos de entes exonerados), registro del periodo</td>
         <td>80</td>
         <td></td>
         <td></td>
         <td></td>
       </tr>
       <tr>
         <td>Total debitos fiscales realice la operación (item 47 +- item 48 - item 80)</td>
         <td>49</td>
         <td></td>
         <td></td>
         <td><?php echo number_format($aivamontoBs, 4, ',', '.'); ?></td>
       </tr>
     </tbody>
   </table>  
     
  </div>
 </div>
</div>
<br><br>
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

    document.title='libro_de_compras_'+fecha+'.pdf';
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
      filename: 'libro_de_compras_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>