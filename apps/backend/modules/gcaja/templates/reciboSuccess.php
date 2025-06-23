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

.table-sm th,
.table-sm td {
  padding: 0.1rem;
  border: 1;

}
div {
  font-family: sans-serif;
}
</style>


<?php

  $empresa = Doctrine_Query::create()
             ->select('e.id, e.nombre, e.rif, e.direccion, e.telefono, e.email, eu.user_id')
             ->from('Empresa e, e.EmpresaUser eu')
             ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
             ->orderBy('e.nombre ASC')
             ->fetchOne();
                            

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
     </div>

 <!-- <div class="card card-primary" id="datos">-->
    <!-- <div class="card-body">-->
      <br>
      <?php   $dia=date("Y-m-d"); 
              $hoy = date("d-m-Y");  $aefectb=0; $aefectd=0;
                 $efectbs = Doctrine_Query::create()
                    ->select('ca.id, ca.monto')
                    ->from('CajaArqueo ca')
                    ->where('ca.fecha = ?', $dia)
                    ->andWhere('ca.forma_pago_id = ?', 10001)
                    ->execute();
                  foreach ($efectbs as $efectb) { 
                    $efect = str_replace(' ', '', $efectb->getMonto());
                    $aefectb = $aefectb+$efect;
                  }

                  $efectdol = Doctrine_Query::create()
                    ->select('ca.id, ca.monto')
                    ->from('CajaArqueo ca')
                    ->where('ca.fecha = ?', $dia)
                    ->andWhere('ca.forma_pago_id = ?', 10011)
                    ->execute();
                  foreach ($efectdol as $efectdo) { 
                    $efec = str_replace(' ', '', $efectdo->getMonto());
                    $aefectd = $aefectd+$efec;
                  }   ?>
     <!-- </div> -->
      <div class="row">
       <div class="col-md-2"></div>
        <div class="col-md-6">
          <div class="card card-primary" id="fact">
            <div class="card-header">
               <h6 class="card-title" style="text-align: center"> RECIBO DE PAGO  <?php echo "  FECHA: ".$hoy  ?></h6>
             </div>
          <table class="table" style="border: 1">
            <thead>
              <tr>
                <th><b>TOTAL BS</b></th>
                <th><?php echo number_format($aefectb, 2, ',', '.');  ?></th>
                <th>TOTAL USD</th>
                <th><?php echo number_format($aefectd, 2, ',', '.');  ?></th>
              </tr>
           </thead>
            <tbody>
              
              <tr>
                <td colspan="2"><b>BENEFICIARIO:</b></td>
                <td colspan="2">Farmacia Santa María</td>
              </tr>
              <tr>
                <td colspan="2"><b>CONCEPTO</b></td>
                <td colspan="2">Ventas del día: <?php echo $hoy; ?></td>
              </tr>

               <tr>
                <th colspan="2"><b>CAJA</b></th>
                <th><b>MONTO BS.</b></th>
                <th><b>MONTO USD</b></th>
                
              </tr>
          <?php  
             
        $cajas = Doctrine_Query::create()
         ->select('c.id as cid, c.nombre as nombre, c.updated_at')
         ->from('Caja c')
         ->where('DATE_FORMAT(c.updated_at, "%Y-%m-%d") = ?', $dia)
         ->andwhere('c.empresa_id = ?', $empresa->getId())
         ->execute();
        foreach ($cajas as $caja) { 
          $efectivob=0;$efectivod=0;
        $arqueos = Doctrine_Query::create()
         ->select('ca.id as caid, ca.moneda as mon, ca.forma_pago_id, ca.monto')
         ->from('CajaArqueo ca')
         ->where('ca.fecha = ?', $dia)
         ->andWhere('ca.caja_id = ?', $caja->getId())
         ->execute();
        foreach ($arqueos as $arqueo) { 
          
            if($arqueo->getFormaPagoId()=='10001')
             $efectivob = str_replace(' ', '', $arqueo->getMonto());
            if($arqueo->getFormaPagoId()=='10011')
             $efectivod = str_replace(' ', '', $arqueo->getMonto());
        }
        ?>
            
             <tr>
              <td colspan="2"><?php echo $caja->getNombre(); ?></td>
              <td><?php echo $efectivob; ?></td>
              <td><?php echo $efectivod; ?></td>
            </tr>
           
           <?php } ?>
                
           </tbody>
           </table>
          </div> 
        </div>
      </div>  
        
   
 <br><br>
       <div class="row">
         <div class="col-md-5">
          <p align="center">________________________________</p>
           <p align="center"><b>RECIBIDO POR:</b></p>
         </div>
         <div class="col-md-1"></div>
         <div class="col-md-5">
          <p align="center">________________________________</p>
           <p align="center"><b>ENTREGADO POR:</b></p>
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