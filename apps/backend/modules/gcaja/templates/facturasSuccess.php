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
  
  list($cid, $fecha) = explode(';',$sf_params->get('cid'));

  $caja=Doctrine_Core::getTable('Caja')->findOneBy('id',$cid);
  $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$caja->getEmpresaId());
  //$fe=date("Y-m-d");
  list($anno, $mes, $dia) = explode('-',$fecha);
  $fecha2=$dia."-".$mes."-".$anno;
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
          <h5 style="text-align: center;">Facturas <?php echo $caja->getNombre()."  del día: ".$fecha2;  ?>   </h5>
         </div><br></div>
     <!-- </div> -->
      <div class="row">
        <div class="col-11 table-responsive-sm">
          
          <table class="table table-sm">
             <thead>
            <tr>
              <th width="10 px">Nº</th>
              <th>FACTURA</th>
              <th>DOC.ID</th>
              <th>RAZON SOCIAL</th>
              <th>MONTO FACTURADO</th>
              <th>ESTATUS</th>
             </tr>
          </thead>
          <tbody>
         <?php $i=0; 
          
          $facs = Doctrine_Query::create()
                    ->select('f.id as fid, f.doc_id as docid, f.razon_social as rsocial, f.ndespacho as ndespacho, f.num_fact_fiscal as numff, f.estatus as estatus')
                    ->from('Factura f')
                    ->where('DATE_FORMAT(f.fecha, "%Y-%m-%d") = ?', $fecha)
                    ->andWhere('f.caja_id = ?', $cid)
                    ->orderBy('f.id ASC')
                    ->execute(); 
                   foreach ($facs as $fac) { 
                    
                    $numero_fact=$fac->getNdespacho().$fac->getNumff();
                    $esta=$fac->getEstatus();
                    if($esta==4)
                      $estatus="Anulada";
                    else
                      $estatus="Procesada";
                    $i++;
                  $monto=0;$monto2=0;                      
                     $dets = Doctrine_Query::create()
                    ->select('fd.id as fdid, fd.price_tot as ptot, fd.tasa_cambio as tasa')
                    ->from('FacturaDet fd')
                    ->Where('fd.factura_id = ?', $fac->getFid())
                    ->orderBy('fd.id ASC')
                    ->execute(); 
                   foreach ($dets as $det) { 
                      
                     $ptot = str_replace(' ', '', $det->getPtot());
                     $ptota = str_replace(" ", "", $ptot);
                     $ptota1 = str_replace(',', '', $ptota);
                     $ptotal =  floatval($ptota1); 

                     $ta = str_replace(' ', '', $det->getTasa());
                     $tas = str_replace(" ", "", $ta);
                     $tas1 = str_replace(',', '', $tas);
                     $tasa =  floatval($tas1);

                    $monto=$ptotal*$tasa;
                    $monto2=$monto2+$monto;
                 }


                 ?>
                     
                      <tr> 
                      <td><?php echo $i; ?></td>
                      <td><?php echo str_pad($numero_fact, 8, "0", STR_PAD_LEFT); ?></td>
                      <td><?php echo $fac->getDocid() ?></td>
                      <td><?php echo $fac->getRsocial() ?></td>
                      <td><?php echo number_format($monto2, 2, ',', '.'); ?></td>
                      <td><?php echo $estatus; ?></td>
                      <tr>

                <?php   
                    }
                  ?>
         
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
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>
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
