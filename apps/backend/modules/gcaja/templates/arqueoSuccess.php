<style>
.dropdown-item {
    color: #212529 !important;
}

}
 
table {
  font-family: sans-serif;
  width: 100%;
  margin: 0.1rem;
  padding: 0.1rem;
  border-top: 1;
}
.table th,
.table td {
  padding: 0.1rem;
  border-width: 1;

}
.table-responsive-lg {
    padding: 0.1rem;
    width: 100%;
    
}
.table-sm th,
.table-sm td {
  padding: 0.1rem;
  border: 1;

}
div {
  font-family: sans-serif;
}
</style>

<!-- <section class = "content-header">
    <div class = "container"> 
      <div class="row mb-1">
        <div class="col-sm-3">
          <h1 style="text-align: left;">CAJA<small> Ventas</small></h1>
        </div>
      </div>
    </div>
  </section> -->
<?php
  
  $corte = Doctrine_Query::create()
      ->select('cc.*')
      ->from('CajaCorte cc')
      ->Where('cc.id =?', $sf_params->get('id'))
      ->limit(1)
      ->fetchOne();

  $caja=Doctrine_Core::getTable('Caja')->findOneBy('id',$corte->getCajaId());
  $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$caja->getEmpresaId());
  $fe=substr($corte->getFechaIni(), 0,10);
  list($anno, $mes, $dia) = explode('-',$fe);
  $fecha=$dia."-".$mes."-".$anno;
 ?>
<section class = "content">
<div class="container-fluid">
<div class="invoice p-3 mb-3" id="invoice">
  <div class="row">
      <div class="col-6">
        <h4>
          <img src='/images/<?php echo $empresa->getId()?>.png' height="60"/>
        </h4>
      </div>
      <div class="col-md-6"></div>
    </div>

      <div class="row invoice-info">
      <div class="col-sm-5 invoice-col">
        <address>
          <strong><?php echo $empresa->getNombre()?> | <?php echo $empresa->getRif()?></strong><br/>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
       
      </div>
      <div class="col-sm-4 invoice-col">
       
      </div>
    </div>

 <!-- <div class="card card-primary" id="datos">-->
    <!-- <div class="card-body">-->
      
       <div class="row">
         <div class="col-md-12">
          <h4 style="text-align: center;">Informe de Cierre de Ventas <?php echo $caja->getNombre();  ?> del día: <?php echo $fecha." Hora de Cierre: ".substr($corte->getFechaFin(), 11,5);  ?> </h4>
         </div>
       </div>
    
     <!-- </div> -->
      <div class="row">
       <div class="col-md-1"></div>
        <div class="col-md-4">
          <div class="card card-light" id="fact">
            <div class="card-header">
               <h6 class="card-title" style="text-align: center"> VENTAS</h6>
             </div>
          <table class="table">
           
            <tbody>
                         
            <tr>
              <td class="tleft">#Facturas del día</td>
              <td class="tright"><?php echo $corte->getCantFact(); ?></td>
            </tr>
            <tr>
              <td class="tleft">#Ultima Factura:</td>
              <td class="tright"><?php echo str_pad($corte->getUltFact(), 8, "0", STR_PAD_LEFT); ?></td>
            </tr>
           
            <tr>
              <td class="tleft">Exento</td>
              <td class="tright"><?php 
              if($caja->getTipo()==true || $caja->getTipo()==1){
                 $ent_exento = floatval(substr($corte->getExentoFact(), 0, -2));
                 $d_exento = substr($corte->getExentoFact(), -2);
                 $exento = $ent_exento.",".$d_exento;
                 $ex=$exento;
                 echo "Bs. ".$exento; }
                 else {
                  $ex=$corte->getExentoFact();
                  $exento = number_format($corte->getExentoFact(), 2, ',', '.');
                  echo "Bs. ".$exento;
                 } ?> </td>
            </tr>
             <tr>
              <td class="tleft">Base Imponible</td>
              <td class="tright"><?php 
              if($caja->getTipo()==true || $caja->getTipo()==1){
               $ent_bit1f = floatval(substr($corte->getBaseImpt1Fact(), 0, -2));
               $d_bit1f = substr($corte->getBaseImpt1Fact(), -2);
               $bit1f = $ent_bit1f.",".$d_bit1f;  
               echo "Bs. ".$bit1f; } 
                else {
                  $bit1f = number_format($corte->getBaseImpt1Fact(), 2, ',', '.');
                  echo "Bs. ".$bit1f;
                 } ?></td>
            </tr>
             <tr>
              <td class="tleft">Monto Iva</td>
              <td class="tright"><?php 
              if($caja->getTipo()==true || $caja->getTipo()==1){
               $ent_ivat1f = floatval(substr($corte->getIvaT1Fact(), 0, -2));
               $d_ivat1f = substr($corte->getIvaT1Fact(), -2);
               $ivat1f = $ent_ivat1f.",".$d_ivat1f;
               echo "Bs. ".$ivat1f; }
               else {
                  $ivat1f = number_format($corte->getIvaT1Fact(), 2, ',', '.');
                  echo "Bs. ".$ivat1f;
                 } ?></td>
            </tr>
           </tbody>
           </table>
          </div> 
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4">
          <div class="card card-light" id="fact">
            <div class="card-header">
               <h6 class="card-title" style="text-align: center"> NOTAS DE CREDITO</h6>
             </div>
          <table class="table">
           <tbody>
            
            <tr>
              <td class="tleft">#Notas de Crédito del día</td>
              <td class="tright"><?php echo $corte->getCantNc(); ?></td>
            </tr>
            <tr>
              <td class="tleft">#Ultima Nota de Crédito:</td>
              <td class="tright"><?php if($corte->getUltNc()) echo str_pad($corte->getUltNc(), 8, "0", STR_PAD_LEFT); ?></td>
            </tr>
            <tr>
              <td class="tleft">Exento</td>
              <td class="tright"><?php 
              if($caja->getTipo()==true || $caja->getTipo()==1){
               $ent_exentoNc = floatval(substr($corte->getExentoNc(), 0, -2));
               $d_exentoNc = substr($corte->getExentoNc(), -2);
               $exentoNc = $ent_exentoNc.",".$d_exentoNc;
               $exNc=$exentoNc;
               echo "Bs. ".$exentoNc; }
               else {
                 $exNc=$corte->getExentoNc();
                  $exentoNc = number_format($corte->getExentoNc(), 2, ',', '.');
                  echo "Bs. ".$exentoNc;
                 } ?></td>
            </tr>
             <tr>
              <td class="tleft">Base Imponible</td>
              <td class="tright"><?php 
              if($caja->getTipo()==true || $caja->getTipo()==1){
               $ent_bit1Nc = floatval(substr($corte->getBaseImpt1Nc(), 0, -2));
               $d_bit1Nc = substr($corte->getBaseImpt1Nc(), -2);
               $bit1Nc = $ent_bit1Nc.",".$d_bit1Nc;
               echo "Bs. ".$bit1Nc; }
               else {
                  $bit1Nc = number_format($corte->getBaseImpt1Nc(), 2, ',', '.');
                  echo "Bs. ".$bit1Nc;
                 } ?></td>
            </tr>
             <tr>
              <td class="tleft">Monto Iva</td>
              <td class="tright"><?php 
              if($caja->getTipo()==true || $caja->getTipo()==1){
               $ent_ivat1Nc = floatval(substr($corte->getIvaT1Nc(), 0, -2));
               $d_ivat1Nc = substr($corte->getIvaT1Nc(), -2);
               $ivat1Nc = $ent_ivat1Nc.",".$d_ivat1Nc;
               echo "Bs. ".$ivat1Nc; }
               else {
                  $ivat1Nc = number_format($corte->getIvaT1Nc(), 2, ',', '.');
                  echo "Bs. ".$ivat1Nc;
                 } ?></td>
            </tr>
           
        </tbody>
      </table>

     </div> 
     </div>
     
    </div>  
    <div class="row">
      <div class="col-md-12">
        
     <p style="text-align: center"><b><?php echo "Neto:  ".number_format($neto=floatval($ex)-floatval($exNc), 2, ',', '.'); ?></b></p>
      </div>
    </div>
        
    <div class="row">
      <!--<div class="col-md-1"></div>-->
     
         <?php $ausd=0; $abs=0; $i=0; $a10001=0;$a10002=0; $a10003=0;$a10004=0;$a10005=0;$a10006=0;$a10011=0;$a10012=0;$a10013=0;$difbs=0; $difusd=0;$netobs=0;$monto2=0;
          $anuusd=0; $anubs=0;$monto=0;$montobs=0;$total_netos=0;$total_netoc=0;$total_netod=0;
          $cxcs = Doctrine_Query::create()
                    ->select('cc.id as ccid, cc.fecha, cc.estatus as estatus, f.id as fid, f.ndespacho as ndespacho, f.num_fact_fiscal as numff')
                    ->from('CuentasCobrar cc, cc.Factura f')
                    ->where('DATE_FORMAT(cc.fecha, "%Y-%m-%d") = ?', $fe)
                    ->andWhere('f.caja_id = ?', $corte->getCajaId())
                    ->orderBy('cc.id ASC')
                    ->execute(); 
                   foreach ($cxcs as $cxc) { 
                    $numero_fact=$cxc->getNdespacho().$cxc->getNumff();
                    $estatus=$cxc->getEstatus();
                                      // ->andWhere('rp.anulado = ?', 0)    
                     $rps = Doctrine_Query::create()
                    ->select('rp.id as rpid, rp.moneda as mon, rp.num_recibo as recibo, rp.fecha f2, rp.monto as monto, rp.monto2 as monto2, rp.tasa_cambio as tasarp, fp.id as fpid, fp.acronimo as acronimo')
                    ->from('ReciboPago rp, rp.FormaPago fp')
                    ->where('DATE_FORMAT(rp.fecha, "%Y-%m-%d") = ?', $fe)
                    ->andWhere('rp.cuentas_cobrar_id = ?', $cxc->getCcid())
                    ->orderBy('rp.id ASC')
                    ->execute(); 
                   foreach ($rps as $rp) { 
                     $i++;   
                     $monto = str_replace(' ', '', $rp->getMonto());
                     $tcobro = str_replace(" ", "", $rp->getTasarp());
                     $tcobro1 = str_replace(',', '', $tcobro);
                     $tacobro =  floatval($tcobro1); 

                     $monto2=$rp->getMonto2();
                     
                     
                     $moneda=$rp->getMon(); $fpago=$rp->getFpid();
                     if($moneda==1) {
                     // $montobs = round($monto*$tacobro,2);
                      $montobs = $monto2;
                      $moneda="BS."; 
                      if($estatus==4)
                        $anubs=round($anubs+$montobs,2);
                      else
                      $abs=round($abs+$montobs,2);
                     }
                     else {
                      $moneda="USD";
                       if($estatus==4)
                         $anuusd=round($anuusd+$monto,4);
                       else
                         $ausd=round($ausd+$monto,4);
                     }
        // si cxc estatus == 4 debo colocarlo tachado y no totalizar o totalizar ese monto
                     //// acumulados por tipo de pago  ////
                    if($estatus != 4) {
                     if($fpago==10001)
                      $a10001=$a10001+$montobs;
                     elseif($fpago==10002)
                      $a10002=$a10002+$montobs;
                     elseif($fpago==10003)
                      $a10003=$a10003+$montobs;
                     elseif($fpago==10004)
                      $a10004=$a10004+$montobs;
                     elseif($fpago==10005)
                      $a10005=$a10005+$montobs;
                     elseif($fpago==10006)
                      $a10006=$a10006+$montobs;
                     elseif($fpago==10011)
                      $a10011=$a10011+$monto;
                     elseif($fpago==10012)
                      $a10012=$a10012+$monto;
                     elseif($fpago==10013)
                      $a10013=$a10013+$monto;

                      $netobs=$netobs+$monto2;
                    }  
                   } // foreach rp
                    } // cxc
                  
            // totales CAJA //

              $ausdb=0; $absb=0; $a10001b=0;$a10002b=0; $a10003b=0;$a10004b=0;$a10005b=0;$a10006b=0;$a10011b=0;$a10012b=0;$a10013b=0;$d1=0;$d2=0;$d3=0;$d4=0;$d5=0;$d6=0;$d11=0;$d12=0;$d13=0;
         
        $arqueos = Doctrine_Query::create()
            ->select('ca.id, ca.caja_id, ca.moneda, ca.forma_pago_id, ca.monto, fp.nombre')
            ->from('CajaArqueo ca, ca.FormaPago fp')
            ->Where('ca.caja_id =?', $corte->getCajaId())
            ->andWhere('ca.fecha =?', $fe)
            ->orderBy('ca.id ASC')
            ->execute(); 

           foreach ($arqueos as $arqueo) {
            $amonto = str_replace(' ', '', $arqueo->getMonto());
             if($arqueo->getFormaPagoId()==10001)
              $a10001b=$amonto;
             if($arqueo->getFormaPagoId()==10002)
              $a10002b=$amonto;
             if($arqueo->getFormaPagoId()==10003)
              $a10003b=$amonto;
             if($arqueo->getFormaPagoId()==10004)
              $a10004b=$amonto;
             if($arqueo->getFormaPagoId()==10005)
              $a10005b=$amonto;
             if($arqueo->getFormaPagoId()==10006)
              $a10006b=$amonto;
             if($arqueo->getFormaPagoId()==10011)
              $a10011b=$amonto;
             if($arqueo->getFormaPagoId()==10012)
              $a10012b=$amonto;
             if($arqueo->getFormaPagoId()==10013)
              $a10013b=$amonto;

             if($arqueo->getMoneda()==1)
              $absb=round($absb+$amonto,4);
             else
              $ausdb=round($ausdb+$amonto,4);

           } 
           // FIN TOTALES CAJA      

           ?>
        <!-- primera card -->   
        <div class="col-md-5"> 
         <div class="card card-light" id="fact">
          <div class="card-header">
            <h6 class="card-title" style="text-align: center"> TOTALES MEDIOS DE PAGO (SISTEMA)</h6>
          </div>
          <table class="table">
            <tbody>
           
            <tr>
              <th colspan="2" style="text-align: center;"><b>Bolívares</b></th>
              <th colspan="2" style="text-align: center;"><b>Dólares</b></th>
             </tr>
             <?php if(($a10001 != 0) || ($a10011 != 0)); { ?>
            <tr>
              <td><b>Efectivo</b> </td>
              <td><?php echo number_format($a10001, 4, ',', '.'); ?></td>
              <td><b>Efectivo </b></td>
              <td><?php echo number_format($a10011, 4, ',', '.');   ?></td>
            </tr> 
            <?php } if(intval($a10002) > 0 || intval($a10012) > 0) { ?>
            <tr>
              <td><b>Transferencia</b> </td>
              <td><?php echo number_format($a10002, 4, ',', '.'); ?></td>
              <td><b>Transferencia </b></td>
              <td><?php echo number_format($a10012, 4, ',', '.');   ?></td>
            </tr> 

            <?php } if($a10003>0 || $a10013> 0) { ?>
            <tr>
              <td><b>Pago Movil </b></td>
              <td><?php echo number_format($a10003, 4, ',', '.'); ?></td>
              <td><b>Otros </b></td>
              <td><?php echo number_format($a10013, 4, ',', '.');   ?></td>
            </tr>
            <?php } if($a10004>0 ) { ?>
            <tr>
              <td><b>Punto Venta</b> </td>
              <td><?php echo number_format($a10004, 4, ',', '.'); ?></td>
              <td></td>
              <td></td>
            </tr>
            <?php } if(intval($a10005) > 0 ) { ?>
            <tr>
              <td><b>Biopago </b></td>
              <td><?php echo number_format($a10005, 4, ',', '.'); ?></td>
              <td></td>
              <td></td>
            </tr>
            <?php } if($a10006>0) { ?>
            <tr>
              <td><b>Otros </b></td>
              <td><?php echo number_format($a10006, 4, ',', '.'); ?></td>
              <td></td>
              <td></td>
            </tr>
            <?php } ?>
            <tr>
              <td><b>Total BS</b> </td>
              <td><?php echo number_format($abs, 4, ',', '.');   ?></td>
              <td><b>Total USD</b> </td>
              <td><?php echo number_format($ausd, 4, ',', '.');   ?></td>
            </tr>
            <tr>
              <td><b>Neto BS</b> </td>
              <td><?php $total_netos=$abs+($ausd*$tacobro);
              echo number_format($netobs, 2, ',', '.');   ?></td>
              <td></td>
              <td></td>
            </tr>
            </tbody>
           
          </table>
        </div>
       </div>


<!-- segunda card -->   
        <div class="col-md-5"> 
         <div class="card card-light" id="fact">
          <div class="card-header">
            <h6 class="card-title" style="text-align: center"> TOTALES MEDIOS DE PAGO (CAJA)</h6>
          </div>
          <table class="table">
            <tbody>
           
            <tr>
              <th colspan="2" style="text-align: center;"><b>Bolívares</b></th>
              <th colspan="2" style="text-align: center;"><b>Dólares</b></th>
             </tr>
             <?php if(($a10001b != 0) || ($a10011b != 0)); { ?>
            <tr>
              <td><b>Efectivo</b> </td>
              <td><?php echo number_format($a10001b, 4, ',', '.'); ?></td>
              <td><b>Efectivo </b></td>
              <td><?php echo number_format($a10011b, 4, ',', '.');   ?></td>
            </tr>
            <?php } if(intval($a10002b) > 0 || intval($a10012b) > 0) { ?>
            <tr>
              <td><b>Transferencia</b> </td>
              <td><?php echo number_format($a10002b, 4, ',', '.'); ?></td>
              <td><b>Transferencia </b></td>
              <td><?php echo number_format($a10012b, 4, ',', '.');   ?></td>
            </tr>
            <?php } if($a10003b>0 || $a10013b> 0) { ?>
            <tr>
              <td><b>Pago Movil </b></td>
              <td><?php echo number_format($a10003b, 4, ',', '.'); ?></td>
              <td><b>Otros </b></td>
              <td><?php echo number_format($a10013b, 4, ',', '.');   ?></td>
            </tr>
            <?php } if($a10004b>0 ) { ?>
            <tr>
              <td><b>Punto Venta</b> </td>
              <td><?php echo number_format($a10004b, 4, ',', '.'); ?></td>
              <td></td>
              <td></td>
            </tr>
            <?php } if($a10005b>0 ) { ?>
            <tr>
              <td><b>Biopago </b></td>
              <td><?php echo number_format($a10005b, 4, ',', '.'); ?></td>
              <td></td>
              <td></td>
            </tr>
            <?php } if($a10006b>0 ) { ?>
            <tr>
              <td><b>Otros </b></td>
              <td><?php echo number_format($a10006b, 4, ',', '.'); ?></td>
              <td></td>
              <td></td>
            </tr>
            <?php }  ?>
            <tr>
              <td><b>Total BS</b> </td>
              <td><?php echo number_format($absb, 4, ',', '.');   ?></td>
              <td><b>Total USD</b> </td>
              <td><?php echo number_format($ausdb, 4, ',', '.');   ?></td>
            </tr>
             <tr>
              <td><b>Neto BS</b> </td>
              <td><?php $total_netoc=round($absb+($ausdb*$tacobro),4);
              echo number_format($total_netoc, 4, ',', '.');   ?></td>
              <td></td>
              <td></td>
            </tr>
            </tbody>
           
          </table>
        </div>
       </div>

<!-- tercer card -->   
        <div class="col-md-2"> 
         <div class="card card-light" id="fact">
          <div class="card-header">
            <h6 class="card-title" style="text-align: center"> DIFERENCIA</h6>
          </div>
          <table class="table">
            <tbody>
           
            <tr>
              <th style="text-align: left;"><b>Bolívares</b></th>
              <th style="text-align: left;"><b>Dólares</b></th>
             </tr>
             <?php if(($a10001b != 0) || ($a10011b != 0)); { ?>
            <tr>
              <td><?php echo  number_format($d1=$a10001b-$a10001, 2, ',', '.');  ?></td>
              <td><?php echo  number_format($d11=$a10011b-$a10011, 2, ',', '.');  ?></td>
            </tr>
            <?php } if(intval($a10002b) > 0 || intval($a10012b) > 0) { ?>
            <tr>
              <td><?php echo  number_format($d2=$a10002b-$a10002, 2, ',', '.');  ?></td>
              <td><?php echo  number_format($d12=$a10012b-$a10012, 2, ',', '.');  ?></td>
            </tr>
            <?php } if($a10003b>0 || $a10013b> 0) { ?>
            <tr>
              <td><?php echo  number_format($d3=$a10003b-$a10003, 2, ',', '.');  ?></td>
              <td><?php echo  number_format($d13=$a10013b-$a10013, 2, ',', '.');  ?></td>
            </tr>
            <?php } if($a10004b>0 ) { ?>
            <tr>
              <td><?php echo  number_format($d4=$a10004b-$a10004, 2, ',', '.');  ?></td>
              <td></td>
            </tr>
            <?php } if($a10005b>0 ) { ?>
            <tr>
              <td><?php echo  number_format($d5=$a10005b-$a10005, 2, ',', '.');  ?></td>
              <td></td>
            </tr>
            <?php } if($a10006b>0 ) { ?>
            <tr>
              <td><?php echo  number_format($d6=$a10006b-$a10006, 2, ',', '.');  ?></td>
              <td></td>
            </tr>
            <?php }  ?>
           
           <?php $difbs=$absb-$abs;
               $difusd=$ausdb-$ausd; ?>
               <tr>
                 <td><?php echo number_format($difbs, 2, ',', '.');   ?></td>
                 <td><?php echo number_format($difusd, 2, ',', '.');   ?></td>
               </tr>
              <tr>
                <td><b>Neto BS</b> </td>
                <td><?php $total_netod=$difbs+($difusd*$tacobro);
                echo number_format($total_netod, 2, ',', '.');   ?></td>
              </tr>
              </tbody>  
          </table>
        </div>
       </div>

      </div>
      
      <div class="row">
        <div class="col-md-4">
           <b>Anulaciones BS: </b> <?php echo number_format($anubs, 2, ',', '.');   ?>
        </div>
        <div class="col-md-4">
          <b>Anulaciones USD</b> <?php echo number_format($anuusd, 2, ',', '.');   ?>
        </div>
      </div> 
      <div class="row">
        <div class="col-md-12">
          <h6 style="text-align: center"><b>DESGLOSE</b></h6>
        </div>
      </div><br>
          
  
      <!-- Ahora muestro la información del efectivo de la caja  -->
      <div class="row">
       <div class="col-md-1"></div>
        <div class="col-md-4"> 
          <div class="card card-light" id="fact">
            <div class="card-header">
               <h6 class="card-title" style="text-align: center"> Efectivo en Bolívares</h6>
             </div>
         <table class="table">
          <thead>
           
          <tr>
            <th style="text-align: center;">Billete</th>
            <th style="text-align: center;">Cantidad</th>
            <th style="text-align: center;">Total</th>
          </tr>
          </thead>
 
          <tbody>
  <?php
        $sumbs=0; $sumusd=0;
        $efectivos = Doctrine_Query::create()
            ->select('ce.id, ce.caja_id, ce.billete, ca.cantidad')
            ->from('CajaEfectivo ce')
            ->Where('ce.caja_id =?', $corte->getCajaId())
            ->andWhere('ce.fecha =?', $fe)
            ->andWhere('ce.moneda =?', 1)
            ->orderBy('ce.moneda, ce.billete ASC')
            ->execute(); 
           foreach ($efectivos as $efectivo) { ?>
           <tr>
            <th style="text-align: center;"><?php echo $efectivo->getBillete()  ?></th>
            <th style="text-align: center;"><?php echo $efectivo->getCantidad()  ?></th>
            <th style="text-align: center;"><?php $cant=$efectivo->getBillete()* $efectivo->getCantidad(); 
            echo $cant; 
            $sumbs=$sumbs+$cant;
            ?></th>
           </tr>
     
        <?php  }  ?>
          <tr>
            <td colspan="2" style="text-align: center;"><b>Total BS.</b></td>
            <td style="text-align: center;"><b><?php  echo $sumbs;  ?></b></td>
          </tr>
          </tbody>
         </table>
       </div>
      </div> <!-- tabla de bs  -->

     
       <div class="col-md-2"></div>
        <div class="col-md-4"> 
         <div class="card card-light" id="fact">
            <div class="card-header">
               <h6 class="card-title" style="text-align: center"> Efectivo en Dólares</h6>
             </div>
         <table class="table">
          <thead>
          
          <tr>
            <th style="text-align: center;">Billete</th>
            <th style="text-align: center;">Cantidad</th>
            <th style="text-align: center;">Total</th>
          </tr>
          </thead>
 
          <tbody>
  <?php
  
         
        $efectivos2 = Doctrine_Query::create()
            ->select('ce.id, ce.caja_id, ce.billete, ca.cantidad')
            ->from('CajaEfectivo ce')
            ->Where('ce.caja_id =?', $corte->getCajaId())
            ->andWhere('ce.fecha =?', $fe)
            ->andWhere('ce.moneda =?', 2)
            ->orderBy('ce.moneda, ce.billete ASC')
            ->execute(); 
           foreach ($efectivos2 as $efectivo2) { ?>
           <tr>
            <th style="text-align: center;"><?php echo $efectivo2->getBillete()  ?></th>
            <th style="text-align: center;"><?php echo $efectivo2->getCantidad()  ?></th>
            <th style="text-align: center;"><?php $cant2=$efectivo2->getBillete()* $efectivo2->getCantidad(); 
            echo $cant2; 
            $sumusd=$sumusd+$cant2;  ?></th>
           </tr>
            


         <?php  }  ?>
           <tr>
            <td colspan="2" style="text-align: center;"><b>Total USD.</b></td>
            <td style="text-align: center;"><b><?php  echo $sumusd;  ?></b></td>
          </tr>
          </tbody>
         </table>
       </div>
        </div> <!-- tabla de usd  -->

        <?php $det = Doctrine_Query::create()
                    ->select('cd.id as cdid, cd.descripcion as desc')
                    ->from('CajaDet cd')
                    ->where('DATE_FORMAT(cd.fecha, "%Y-%m-%d") = ?', $fe)
                    ->andWhere('cd.caja_id = ?', $corte->getCajaId())
                    ->andWhere('cd.status = ?', false)
                    ->fetchOne(); 
        ?>

       </div> 
       <div class="row">
         <div class="col-md-11">
           <p><b>Observación:</b>
            <?php if($det) echo $det->getDesc(); ?>
           </p><br>
         </div>
       </div> 

       <div class="row">
         <div class="col-md-5">
          <p align="center">________________________________</p>
           <p align="center"><b>Firma del Cajero</b></p>
         </div>
         <div class="col-md-1"></div>
         <div class="col-md-5">
          <p align="center">________________________________</p>
           <p align="center"><b>Firma del Supervisor</b></p>
         </div>

       </div>           

      </div>   <!-- invoice  -->
       

</div> 

  <div class="row no-print">
    <div class="col-12">
      <a href="#" target="_blank" class="btn btn-default" onclick="printDiv('invoice')" >
        <i class="fas fa-print"></i> Imprimir
      </a>
      
      <a href="<?php echo url_for('gcaja/gestionar') ?>" class="btn btn-warning" >
         Volver
      </a>
    
    </div>
  </div>
  <br/><br/>

 </div>
 </section>
<style>
  
  .tcaps {
    text-transform: capitalize;
  }
  .tpadd {
    padding: 0.1cm;
  }
  .clight {
    color: #adadad;
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

<?php
function number_float($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return $number;
}

?>

<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
  
</script>
<script type="text/javascript">

  function Volver() {
     location.href = "<?php echo url_for('gcaja/gestionar') ?>";
  } 
</script>
<script>
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>