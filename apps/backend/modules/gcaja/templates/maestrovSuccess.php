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
  border: 1;
}
div {
  font-family: sans-serif;
}
</style>
<!--
 <section class = "content-header">
    <div class = "container"> 
      <div class="row mb-1">
        <div class="col-sm-3">
          <h1 style="text-align: left;">CAJA<small> Ventas</small></h1>
        </div>
      </div>
    </div>
  </section> -->
<?php
  $fechas=$sf_params->get('id');
  $fini=substr($fechas, 0,10);
  list($dia, $mes, $anno) = explode('-',$fini);
  $fecha_ini=$anno."-".$mes."-".$dia;

  $ffin=substr($fechas, 10,10);
  list($dia, $mes, $anno) = explode('-',$ffin);
  $fecha_fin=$anno."-".$mes."-".$dia;
  
  $empresa = Doctrine_Query::create()
                ->select('e.id, e.nombre, e.rif, e.direccion, e.telefono, e.email, eu.user_id')
                ->from('Empresa e, e.EmpresaUser eu')
                ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
                ->fetchOne();  ?>

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
          <h3 style="text-align: center;">Libro de Ventas del <?php echo $fini;  ?> al <?php echo $ffin;  ?> </h3>
         </div><br></div>
     <!-- </div> -->
      <div class="row">
        <div class="col-12 table-responsive-sm">
          
          <table class="table">
             <thead></thead>
           
          <tbody>
         <?php
              $cajas = Doctrine_Query::create()
                    ->select('c.id as cid, c.nombre')
                    ->from('Caja c')
                    ->where('c.tipo = ?', true)
                    ->andWhere('c.empresa_id = ?', $empresa->getId())
                    ->orderBy('c.id ASC')
                    ->execute(); 
                   foreach ($cajas as $caja) {  $num_maquina="";?>
                     <tr>
                       <th colspan="10"><?php echo $caja->getNombre();  ?></th>
                     </tr>
                     <tr>
                      <th>FECHA</th>
                     <!-- <th>IMPRESORA</th>-->
                      <th>Nº CORTE</th>
                      <th>PRIM. FAC</th>
                      <th>ULT. FAC</th>
                      <th>EXENTO</th>
                      <th>BASE IMP.</th>
                      <th>IVA</th>
                      <th>EXENTO NC.</th>
                      <th>BASE IMP. NC</th>
                      <th>IVA NC.</th>
                     </tr>
          
             <?php  
             $cortes = Doctrine_Query::create()
                    ->select('cc.*')
                    ->from('CajaCorte cc')
                    ->where('cc.caja_id = ?', $caja->getCid())
                    ->andWhere('DATE_FORMAT(cc.fecha_ini, "%Y-%m-%d") >= ?', $fecha_ini)
                    ->andWhere('DATE_FORMAT(cc.fecha_ini, "%Y-%m-%d") <= ?', $fecha_fin)
                    ->orderBy('cc.id ASC')
                    ->execute(); 
                   $cexento=0;$cbit1f=0;$civat1f=0;$cexentoNc=0;$cbit1Nc=0;$civat1Nc=0;
                   $ccexento=0;$ccbit1f=0;$ccivat1f=0;$ccexentoNc=0;$ccbit1Nc=0;$ccivat1Nc=0;$tventas=0;
                 foreach ($cortes as $corte) { 
                   $fe=substr($corte->getFechaIni(), 0,10);
                   list($anno, $mes, $dia) = explode('-',$fe);
                   $fecha=$dia."-".$mes."-".$anno;

                   $ent_exento = floatval(substr($corte->getExentoFact(), 0, -2));
                   $d_exento = substr($corte->getExentoFact(), -2);
                   $exento = $ent_exento.".".$d_exento;
                   

                   $ent_bit1f = floatval(substr($corte->getBaseImpt1Fact(), 0, -2));
                   $d_bit1f = substr($corte->getBaseImpt1Fact(), -2);
                   $bit1f = $ent_bit1f.".".$d_bit1f;

                   $ent_ivat1f = floatval(substr($corte->getIvaT1Fact(), 0, -2));
                   $d_ivat1f = substr($corte->getIvaT1Fact(), -2);
                   $ivat1f = $ent_ivat1f.".".$d_ivat1f;

                   $ent_exentoNc = floatval(substr($corte->getExentoNc(), 0, -2));
                   $d_exentoNc = substr($corte->getExentoNc(), -2);
                   $exentoNc = $ent_exentoNc.".".$d_exentoNc;

                   $ent_bit1Nc = floatval(substr($corte->getBaseImpt1Nc(), 0, -2));
                   $d_bit1Nc = substr($corte->getBaseImpt1Nc(), -2);
                   $bit1Nc = $ent_bit1Nc.".".$d_bit1Nc;

                   $ent_ivat1Nc = floatval(substr($corte->getIvaT1Nc(), 0, -2));
                   $d_ivat1Nc = substr($corte->getIvaT1Nc(), -2);
                   $ivat1Nc = $ent_ivat1Nc.".".$d_ivat1Nc;
                   // sumo los totales //
                   $cexento=floatval($cexento)+floatval($exento);
                   $cbit1f=floatval($cbit1f)+floatval($bit1f);
                   $civat1f=floatval($civat1f)+floatval($ivat1f);
                   $cexentoNc=floatval($cexentoNc)+floatval($exentoNc);
                   $cbit1Nc=floatval($cbit1Nc)+floatval($bit1Nc);
                   $civat1Nc=floatval($civat1Nc)+floatval($ivat1Nc);
                   
                   $factura = Doctrine_Core::getTable('Factura')->findOneBy('id',$caja->getCid());

                   $factura = Doctrine_Query::create()
                        ->select('f.id as fid, f.num_fact_fiscal as numfactf')
                        ->from('Factura f')
                        ->where('f.caja_id = ?', $caja->getCid())
                        ->andWhere('f.fecha = ?', $fe)
                        ->orderBy('f.id ASC')
                        ->fetchOne(); 

                   ?>

                     <tr> 
                      <td><?php echo $fecha; ?></td>
                      <td><?php echo $corte->getUltRepz(); ?></td>
                      <td><?php echo $factura->getNumfactf(); ?></td>
                      <td><?php echo $corte->getUltFact(); ?></td>
                      <td><?php echo $exento; ?></td>
                      <td><?php echo $bit1f; ?></td>
                      <td><?php echo $ivat1f; ?></td>
                      <td><?php echo $exentoNc; ?></td>
                      <td><?php echo $bit1Nc; ?></td>
                      <td><?php echo $ivat1Nc; ?></td>
                     <tr>
               <?php  $num_maquina=$corte->getCodigof();   
                     } // cortes
               ?> 
                     <tr> 
                      <td colspan="2"><b>Número Maquina</b></td>
                      <td><b><?php echo $num_maquina; ?></b></td>
                      <td></td>
                      <td><b><?php echo $cexento; ?></b></td>
                      <td><b><?php echo $cbit1f; ?></b></td>
                      <td><b><?php echo $civat1f; ?></b></td>
                      <td><b><?php echo $cexentoNc; ?></b></td>
                      <td><b><?php echo $cbit1Nc; ?></b></td>
                      <td><b><?php echo $civat1Nc; ?></b></td>
                     <tr>
                

                <?php 
                   $ccexento=floatval($ccexento)+floatval($cexento);
                   $ccbit1f=floatval($ccbit1f)+floatval($cbit1f);
                   $ccivat1f=floatval($ccivat1f)+floatval($civat1f);
                   $ccexentoNc=floatval($ccexentoNc)+floatval($cexentoNc);
                   $ccbit1Nc=floatval($ccbit1Nc)+floatval($cbit1Nc);
                   $ccivat1Nc=floatval($ccivat1Nc)+floatval($civat1Nc);

                    } // foreach cajas
                  ?>
                   <tr> 
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><b>TOTALES</b></td>
                      <td><b><?php echo $ccexento; ?></b></td>
                      <td><b><?php echo $ccbit1f; ?></b></td>
                      <td><b><?php echo $ccivat1f; ?></b></td>
                      <td><b><?php echo $ccexentoNc; ?></b></td>
                      <td><b><?php echo $ccbit1Nc; ?></b></td>
                      <td><b><?php echo $ccivat1Nc; ?></b></td>
                     <tr>
          <!--</tbody>-->
         
          </table>
        </div>
      </div>   
      <div class="row">
        <p><b><em>Resúmen de Ventas:</em></b></p>
        <br>
      </div>
      <div class="row">  
        <div class="col-md-12">
          <table class="table">
            <tr>
             <td>1.</td>
             <td>Débitos Fiscales</td>
             <td>40</td>
             <td>0,00</td>
            </tr>
            <tr>
             <td>2.</td>
             <td>Ventas Internas no Gravadas</td>
             <td>41</td>
             <td><?php echo $ccexento; ?></td>
            </tr>
            <tr>
             <td>3.</td>
             <td>Ventas Internas por Alicuota General</td>
             <td>42</td>
             <td><?php echo $ccbit1f; ?></td>
            </tr>
            <tr>
             <td>4.</td>
             <td>Ventas Internas Gravadas por Alícuota General</td>
             <td>442</td>
             <td>0,00</td>
            </tr>
            <tr>
             <td>5.</td>
             <td>Ventas Internas Gravadas por Alícuota General más Adicional</td>
             <td>443</td>
             <td>0,00</td>
            </tr>
            <tr>
             <td>6.</td>
             <td>Ventas Internas Gravadas por Alícuota Rreducidas</td>
             <td>46</td>
             <td><?php echo $tventas=$ccexento+$ccbit1f; ?></td>
            </tr>
            <tr>
             <td>7.</td>
             <td>Total ventas y Débitos Fisales para Efectos de Determinación</td>
             <td>48</td>
             <td><?php echo $tventas; ?></td>
            </tr>
            <tr>
             <td>8.</td>
             <td>Si la operación (47±48)<0,repita con signo negativo hasta la ocurrencia del item 47 y la diferenci ajustela en periodos futuros.</td>
             <td>80</td>
             <td></td>
            </tr>
            <tr>
             <td>9.</td>
             <td>Certificados de Débitos Fiscales Exonerados (Recibidos de entes exonerados), registro del período</td>
             <td>49</td>
             <td></td>
            </tr>
            <tr>
             <td>10.</td>
             <td>Total Débitos Fiscales. Realice la operación (item 47 ± item 48 - item 80)</td>
             <td>40</td>
             <td></td>
            </tr>
            <tr>
             <td></td>
             <td>Total Ventas - Notas de Crédito</td>
             <td></td>
             <td><b><?php echo $tventas-$ccexentoNc; ?></b></td>
            </tr>
          <tbody>
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