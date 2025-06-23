<style>
.dropdown-item {
    color: #212529 !important;
}

}
table {
  font-family: sans-serif;
  width: 90%;
  margin: 0.1rem;
}
.table-sm th,
.table-sm td {
  padding: 0.1rem;
}
div {
  font-family: sans-serif;
}
</style>

 <section class = "content-header">
    <div class = "container"> 
      <div class="row mb-1">
        <div class="col-sm-3">
        <!--  <h1 style="text-align: left;">CAJA<small> Ventas</small></h1>-->
        </div>
      </div>
    </div>
  </section> 
<?php
 if(!$sf_params->get('cid') || $sf_params->get('cid')== "NULL")
  volver();

  $caja=Doctrine_Core::getTable('Caja')->findOneBy('id',$sf_params->get('cid'));
  $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$caja->getEmpresaId());
  $fe=date("Y-m-d");
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
      <div class="col-md-6">
        
      </div>
    </div>

      <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <address>
          <strong><?php echo $empresa->getNombre()?> | <?php echo $empresa->getRif()?></strong><br/>
          <span class="tcaps"><?php echo mb_strtolower($empresa->getDireccion())?></span><br/>
          <b>Telf:</b> <?php echo $empresa->getTelefono()?><br/>
          <b>Email:</b> <?php echo $empresa->getEmail()?>
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
         <div class="col-md-11">
          <h3 style="text-align: center;">Informe de Ventas <?php echo $caja->getNombre();  ?> en progreso </h3>
         </div><br></div>
     <!-- </div> -->
      <div class="row">
        <div class="col-11 table-responsive-sm">
          
          <table class="table table-sm">
             <thead>
            <tr>
              <th width="10 px">Nº</th>
              <th>RECIBO</th>
              <th>FACTURA</th>
              <th>MONEDA</th>
              <th>FORMA PAGO</th>
              <th>MONTO</th>
             </tr>
          </thead>
          <tbody>
         <?php $ausd=0; $abs=0; $i=0; $a10001=0;$a10002=0; $a10003=0;$a10004=0;$a10005=0;$a10006=0;$a10011=0;$a10012=0;$a10013=0;
          $anuusd=0; $anubs=0;$monto=0;$montobs=0;$netobs=0;$monto2=0;
          $cxcs = Doctrine_Query::create()
                    ->select('cc.id as ccid, cc.fecha, cc.estatus as estatus, f.id as fid, f.ndespacho as ndespacho, f.num_fact_fiscal as numff')
                    ->from('CuentasCobrar cc, cc.Factura f')
                    ->where('DATE_FORMAT(cc.fecha, "%Y-%m-%d") = ?', $fe)
                    ->andWhere('f.caja_id = ?', $sf_params->get('cid'))
                    ->orderBy('cc.id ASC')
                    ->execute(); 
                   foreach ($cxcs as $cxc) { 
                    $numero_fact=$cxc->getNdespacho().$cxc->getNumff();
                    $estatus=$cxc->getEstatus();
                                          
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
                     $montobs = $monto2;
                      $moneda="BS."; 
                      if($estatus==4)
                        $anubs=round(($anubs+$montobs),2);
                      else
                        $abs=round(($abs+$montobs),2);
                     }
                     else {
                      $moneda="USD";
                       if($estatus==4)
                         $anuusd=round(($anuusd+$monto),4);
                       else
                         $ausd=round(($ausd+$monto),4);

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
                      $a10013=$a10013+$monto; }
                      if ($cxc->getEstatus()==4) { ?> 
                     <tr style="text-decoration:line-through;"> 
                      <td><?php echo $i; ?></td>
                      <td><?php echo $rp->getRecibo() ?></td>
                      <td><?php echo str_pad($numero_fact, 8, "0", STR_PAD_LEFT); ?></td>
                      <td><?php echo $moneda; ?></td>
                      <td><?php echo $rp->getAcronimo(); ?></td>
                      <td><?php if($moneda=="BS.") { 
                        echo number_format($montobs, 2, ',', '.'); }
                        else {
                          echo number_format($monto, 4, ',', '.');
                        } ?></td>
                     <tr>
                    <?php } else { ?>
                      <tr> 
                      <td><?php echo $i; ?></td>
                      <td><?php echo $rp->getRecibo() ?></td>
                      <td><?php echo str_pad($numero_fact, 8, "0", STR_PAD_LEFT); ?></td>
                      <td><?php echo $moneda; ?></td>
                      <td><?php echo $rp->getAcronimo(); ?></td>
                      <td><?php if($moneda=="BS.") {
                        echo number_format($montobs, 2, ',', '.'); }
                        else {
                          echo number_format($monto, 4, ',', '.');
                        } ?></td>
                     <tr>

                <?php  } }
                    }
                  ?>
            
          
          
            <tr>
              <td colspan="6" style="text-align: center"><b>TOTALES POR MEDIOS DE PAGO</b></td>
            </tr>
            <tr>
              <td colspan="6" style="text-align: left;"><b>Totales en Bolívares</b></td>
            </tr>
            <tr>
              <td><b>Efectivo</b> <?php echo number_format($a10001, 2, ',', '.'); ?></td>
              <td><b>Transferencia</b> <?php echo number_format($a10002, 2, ',', '.'); ?></td>
              <td><b>Pago Movil </b><?php echo number_format($a10003, 2, ',', '.'); ?></td>
              <td><b>Punto Venta</b> <?php echo number_format($a10004, 2, ',', '.'); ?></td>
              <td><b>Biopago </b><?php echo number_format($a10005, 2, ',', '.'); ?></td>
              <td><b>Otros </b><?php echo number_format($a10006, 2, ',', '.'); ?></td>
            </tr>
            <tr>
              <td colspan="6" style="text-align: left;"><b>Totales en Dólares </b></td>
            </tr> 
            <tr>
              <td><b>Efectivo </b><?php echo number_format($a10011, 4, ',', '.');   ?></td>
              <td><b>Transferencia </b><?php echo number_format($a10012, 4, ',', '.');   ?></td>
              <td><b>Otros </b><?php echo number_format($a10013, 2, ',', '.');   ?></td>
              <td colspan="3"></td>
            </tr>
            <tr>
              <td colspan="6" style="text-align: left;"><b>Totales Vs Anulaciones</b></td>
            </tr>
             <tr>
              <td><b>Anulaciones BS</b> <?php echo number_format($anubs, 2, ',', '.');   ?></td>
              <td><b>Anulaciones USD</b> <?php echo number_format($anuusd, 4, ',', '.');   ?></td>
              <td colspan="2"></td>
              <td><b>Total BS</b> <?php echo number_format($abs, 2, ',', '.');   ?></td>
              <td><b>Total USD</b> <?php echo number_format($ausd, 4, ',', '.');   ?></td>
             </tr>
             
          </tbody>
          </table>
        </div>
      </div>   
       

</div> <!-- </div>invoice -->

  <div class="row no-print">
    <div class="col-12">
      <a href="#" target="_blank" class="btn btn-default" onclick="printDiv('invoice')" >
        <i class="fas fa-print"></i> Imprimir
      </a>
      
      <a href="<?php echo url_for('gcaja/gestionar') ?>" class="btn btn-warning" >
         Volver
      </a>
     <!-- <button onclick="volver()" class="btn btn-warning" style="margin-left: 14px;">
          Volver
        </button> -->
    </div>
  </div>
  <br/><br/>

 </div>
 </section>
<style>
  .table {
  width: 100%;
  margin: 0.15rem;
 }
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
<?php function Volver() { ?>
<script type="text/javascript">
  alert("Seleccione una caja");
  location.href = "<?php echo url_for('gcaja/gestionar') ?>";
</script>
<?php } ?>
<script>
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>