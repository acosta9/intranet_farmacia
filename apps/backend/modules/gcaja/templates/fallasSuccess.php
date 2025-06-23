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
div {
  font-family: sans-serif;
}
</style>

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
                ->fetchOne(); 

                $dep = Doctrine_Query::create()
                          ->select('id.nombre, id.id')
                          ->from('InvDeposito id')
                          ->Where('id.empresa_id =?', $empresa->getId())
                          ->andWhere('id.tipo =?', 1)
                          ->andWhere('id.nombre =?', "ALMACEN DE VENTAS")
                          ->fetchOne();
                          $did=$dep->getId(); 

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
         <div class="col-md-12">
          <h3 style="text-align: center;">Reporte de Fallas del <?php echo $fini;  ?> al <?php echo $ffin;  ?> </h3>
         </div></div><br>
     <!-- </div> -->
      <div class="row">
        
        <div class="col-md-5">
          <div class="card card-primary" id="fact">
            <div class="card-header">
               <h6 class="card-title" style="text-align: center"> FALLAS REPORTADAS POR CAJEROS</h6>
             </div>
          <table class="table">
             <thead>
               <tr>
                 <th>NUM</th>
                 <th>NOMBRE DEL PRODUCTO</th>
               </tr>
             </thead>
           
          <tbody>
                  
             <?php  $i=0;
             $inexs = Doctrine_Query::create()
                    ->select('i.id as iid, i.nombre')
                    ->from('Inexistencia i')
                    ->where('i.fecha >= ?', $fecha_ini)
                    ->andWhere('i.fecha <= ?', $fecha_fin)
                    ->orderBy('i.id ASC')
                    ->execute(); 
                   
                 foreach ($inexs as $inex) { 
                  $i++;
                   ?>

                     <tr> 
                      <td><?php echo $i; ?></td>
                      <td><?php echo $inex->getNombre(); ?></td>
                      
                     

           <?php  } // inexs
               ?> 
                   
            
          <!--</tbody>-->
         
          </table>
        </div>
        </div>

        <div class="col-md-1"></div>
        <div class="col-md-6">
          <div class="card card-primary" id="fact">
            <div class="card-header">
               <h6 class="card-title" style="text-align: center"> FALLAS DE EXISTENCIA EN SISTEMA</h6>
             </div>
          <table class="table">
             <thead>
               <tr>
                 <th>NUM</th>
                 <th>&nbsp;&nbsp;NOMBRE DEL PRODUCTO</th>
               </tr>
             </thead>
           
          <tbody>
                  
             <?php  $ii=0;
             $producs = Doctrine_Query::create()
                            ->select('i.id as iid, i.cantidad as max, d.id as did, p.id as pid, p.nombre as pname, p.serial as serial, pc.codigo as codcat, pl.nombre as lab, pu.nombre as uni')
                            ->from('Inventario i')
                            ->leftJoin('i.InvDeposito d')
                            ->leftJoin('i.Producto p')
                            ->leftJoin('p.ProdCategoria pc')
                            ->leftJoin('p.ProdLaboratorio pl')
                            ->leftJoin('p.ProdUnidad pu')
                            ->Where('i.deposito_id =?', $did)
                            ->andWhere('i.activo =?', 1)
                            ->andWhere('i.cantidad =?', 0)
                            ->orderBy('p.nombre ASC')
                            ->execute();
                            foreach ($producs as $produc) {
                              $cod_cat=substr($produc->getCodcat(),0,2);
                              // busco la tasa del producto //
                              if($cod_cat=="01")
                              { 
                                $med_inex=$produc->getPname()." - ".$produc->getUni()." - ".$produc->getLab()." (".$produc->getSerial().")";
                          
                              $ii++;
                               ?>

                     <tr> 
                      <td><?php echo $ii; ?></td>
                      <td><?php echo $med_inex; ?></td>
                      
                     

           <?php  } } // producs
               ?> 
                   
            
          <!--</tbody>-->
         
          </table>
        </div>
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