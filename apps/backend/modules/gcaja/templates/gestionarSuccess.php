<style type="text/css">
.form-control {
  height: calc(2rem + 2px);
  padding: 0.275rem 0.70rem;
  font-size: 0.85rem;
  font-weight: 300;
  line-height: 1;
}
.select2-selection {
  height: calc(2rem + 2px);
  padding: 0.275rem 0.50rem;
  font-size: 0.85rem;
  font-weight: 300;
  line-height: 1;
}
.form-control:focus {
  background-color: #ffff99;
  /*box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);*/
}
 .select2-selection:focus {
  background-color: #ffff99;
  /*box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);*/
  padding: 0.175rem 0.25rem;
}
 
.select2-container--default .select2-selection--single,
.select2-selection .select2-selection--single {
 /* border: 1px solid #28a745;*/
  padding: 4px 8px;
  height: 24px;
}
/*
.select2-container--default.select2-container--open {
  border-color: #28a745;
}*/
.select2-results__option {
  padding: 4px 8px;
}


.dropdown-item {
    color: #212529 !important;
}

</style>
  <section class = "content-header">
    <div class = "container"> 
      <div class="row mb-1">
        <div class="col-sm-3">
          <h1 style="text-align: left;">CAJA<small> Gestionar</small></h1>
        </div>
        <div class="col-sm-7"></div>
    <!--    <div class="col-sm-2">
        <button type="button" id="fallas" class="btn btn-danger btn-block" onclick="limpiar_cola()"><i class="fa fa-th-list"></i> Limpiar Cola</button>
      </div>-->
      </div>
    </div>
  </section> 


  <section class = "content">
    <div class="container-fluid">
     
           
      <div class="card card-primary" id="datos">
        <div class="card-header">
          <h3 class="card-title">Reportes Caja</h3>
        </div>

        <div class="card-body">
          <!-- aqui estaba el form -->
          <div class="row">

                <div class="col-md-6 ">
                  <div class="form-group">
                     <label class=" control-label">Empresa</label>
                     <select name="empresa_id" class="form-control empresa_id" id="empresa_id">
                      <?php   // $sf_user  ojo hacer query para buscar la empresa asociada al usuario
                        $emps = Doctrine_Query::create()
                          ->select('e.id, eu.user_id')
                          ->from('Empresa e, e.EmpresaUser eu')
                          ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
                          ->orderBy('e.nombre ASC')
                          ->execute();
                            foreach($emps as $emp) {
                          ?>
                            <option value="NULL"></option> <?php
                            echo "<option value='".$emp->getId()."'>".$emp->getNombre()."</option>"; }
                       ?>
                    </select>
                  </div>
                 </div>
              </div>
              <div class="row">
                 <div class="col-md-2 "> 
                  <div class="form-group">
                    
                     <div id="caja">
                     
                    </div>
                  </div>
                 </div>
                 <div class="col-md-1"></div>
                 <div class="col-md-6 "> 
                  <div id="caja_reportes"> </div>  
                 </div>
                  <div class="col-md-1"></div>
                 <div class="col-sm-2">
                   <button type="button" id="vventas" class="btn btn-warning btn-block" onclick="ver_ventas()"><i class="fab fa-hotjar"></i> Ventas Hoy</button>
                   <button type="button" id="bfallas" class="btn btn-info btn-block" data-toggle="modal" data-target="#modalQuickBfallas"><i class="fa fa-th-list"></i> Ver Fallas</button>
                   <button type="button" id="fallas" class="btn btn-primary btn-block" onclick="ver_recibo()"><i class="fas fa-file-invoice-dollar"></i> Recibo</button>
                   <button type="button" id="bmaestro" class="btn btn-success btn-block" data-toggle="modal" data-target="#modalQuickBmaestro"><i class="fas fa-print"></i> Maestro de Ventas</button>
                 </div>
                 

          </div> 
          
        </div>
      </div>
 <div id="caja_header"> </div>  
 

   </div> <!--container del contenido  -->
 </section> <!--section del contenido  -->

<!-- MODAL MAESTRO -->
<div class="modal fade" id="modalQuickBmaestro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="margin: top 160px;">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          
          <div class="col-lg-12">
            <div class="small-box bg-success ">
              <div class="container">
                <h4 class="h3-responsive product-name">
                   REPORTE MAESTRO 
                </h4>
             </div>
           </div>
             <!-- Accordion card -->
              <div class="card">

                <!-- Card header -->
                <div class="card-header" role="tab" id="headingOne1">
                    <h6 class="mb-0">
                      Seleccione el rango de fechas para visualizar el Maestro 
                    </h6>
                </div>
                 <div class="card-body">
        
                                    
                  <div class="row">
                   <div class="col-md-2"></div>
                   <div class="form-group">
                     <label>Fecha de Inicio</label>
                     <input type="text" id = "fecha_ini" name="fecha_ini" value="" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask required />
                  </div>
                  <div class="col-md-2"></div>
                  <div class="form-group">
                    <label>Fecha de Fin</label>
                     <input type="text" id = "fecha_fin" name="fecha_fin" value="" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask required />
                  </div>                 
                                
                  </div>
                  <br>
                  <div class="row">
                <div class="col-md-12 text-center">
                    <!--  voy a la funcion que lleva el numero de la factura y la caja para la accion -->
                      
                     <button onclick="bmaestro()"  class="btn btn-success reimpri">Ver Maestro</button>
                                        
                    <button type="button" class="btn btn-secondary cerrar_modal" data-dismiss="modal" id="cbmaestro">Cancelar</button>
         
                  </div>
                 </div>  
                 <!--  </form> -->   
                 </div>
               </div>
              <!-- Accordion card -->
      
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FIN MODAL MAESTRO -->

<!-- MODAL FALLAS -->
<div class="modal fade" id="modalQuickBfallas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="margin: top 160px;">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          
          <div class="col-lg-12">
            <div class="small-box bg-info ">
              <div class="container">
                <h4 class="h3-responsive product-name">
                   REPORTE DE FALLAS 
                </h4>
             </div>
           </div>
             <!-- Accordion card -->
              <div class="card">

                <!-- Card header -->
                <div class="card-header" role="tab" id="headingOne1">
                    <h6 class="mb-0">
                      Seleccione el rango de fechas para visualizar las fallas reportadas 
                    </h6>
                </div>
                 <div class="card-body">
        
                 <?php $dia=date("d-m-Y");  ?>                  
                  <div class="row">
                   <div class="col-md-2"></div>
                   <div class="form-group">
                     <label>Fecha de Inicio</label>
                     <input type="text" id = "ffecha_ini" name="ffecha_ini" value="<?php echo $dia;  ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask required />
                  </div>
                  <div class="col-md-2"></div>
                  <div class="form-group">
                    <label>Fecha de Fin</label>
                     <input type="text" id = "ffecha_fin" name="ffecha_fin" value="<?php echo $dia;  ?>" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" data-mask required />
                  </div>                 
                                
                  </div>
                  <br>
                  <div class="row">
                <div class="col-md-12 text-center">
                    <!--  voy a la funcion que lleva el numero de la factura y la caja para la accion -->
                      
                     <button onclick="vfallas()"  class="btn btn-info ifallas">Ver Fallas</button>
                                        
                    <button type="button" class="btn btn-secondary cerrar_modal" data-dismiss="modal" id="cfallas">Cancelar</button>
         
                  </div>
                 </div>  
                 <!--  </form> -->   
                 </div>
               </div>
              <!-- Accordion card -->
      
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FIN MODAL MAESTRO -->

<script type="text/javascript">

  $( document ).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    
    $("#caja_id").select2({ width: '100%'});
    $("#empresa_id").select2({ width: '100%'});
    $('#empresa_id').select2('focus');
  //  var eid = $("#empresa_id").val(); 
  //  var cid = $("#caja_id").val();
  //  $('#caja_dia').hide();
   // $('#caja_header').hide();$('#caja_dia').hide();$('#caja').hide();
  //  $('#caja_header').load('<?php //echo url_for('gcaja/verheader')?>?eid='+eid+'&cid='+cid).fadeIn("slow");
    
    
    $("[data-mask]").inputmask();
  $("#empresa_id").on('change', function(event){
    var eid = $("#empresa_id").val(); 
    $('#caja').hide();
    $('#caja').load('<?php echo url_for('gcaja/caja')?>?eid='+eid).fadeIn("slow");
  });  
  $("#caja_id").on('change', function(event){
    var eid = $("#empresa_id").val(); 
    var cid = $("#caja_id").val();
    $('#caja_header').hide();$('#caja_reportes').hide();
    $('#caja_header').load('<?php echo url_for('gcaja/verheader')?>?eid='+eid+'&cid='+cid).fadeIn("slow");
    $('#caja_reportes').load('<?php echo url_for('gcaja/reportes') ?>?eid='+eid+'&cid='+cid).fadeIn("slow");
  });
  });
   function bmaestro() {
    
    var fecha_ini= $('#fecha_ini').val();
    var fecha_fin= $('#fecha_fin').val();
    $('#cbmaestro').click();
     location.href = "<?php  echo url_for('gcaja/maestro') ?>?fini="+fecha_ini+"&ffin="+fecha_fin;
  } 

  function vfallas() {
    
    var fecha_ini= $('#ffecha_ini').val();
    var fecha_fin= $('#ffecha_fin').val();
    $('#cfallas').click();
     location.href = "<?php  echo url_for('gcaja/vfallas') ?>?fini="+fecha_ini+"&ffin="+fecha_fin;
  } 
  
   function ver_ventas() {
     var cid = $("#caja_id").val();
     if(!caja_id){
       alert("Seleccione una Caja para visualizar las ventas del momento");
     }
     else {
      location.href = "<?php  echo url_for('gcaja/ventas') ?>?cid="+cid;
     }
  } 
  function ver_recibo() {
     
      location.href = "<?php  echo url_for('gcaja/recibo') ?>";
    
  } 
  function limpiar_cola() {
    var ya=0;
   
    console.log(caja_id);
    $.get("<?php echo url_for('gcaja/cola') ?>", function(cola) { 
         var ya=cola;
         if (ya==1) {
          alert("La cola se ha limpiado ");
         }
    });
}
</script>
<script src="/plugins/inputmask/jquery.inputmask.bundle.js"></script>
