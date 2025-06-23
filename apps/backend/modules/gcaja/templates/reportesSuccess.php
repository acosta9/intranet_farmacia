<?php
$cid=$sf_params->get('cid');
$empre=$sf_params->get('eid');
$userid = $sf_user->getGuardUser()->getId();
if(!$sf_params->get('cid')=='0') {
  
  $caja = Doctrine_Query::create()
      ->select('c.nombre')
      ->from('Caja c')
      ->Where('c.empresa_id =?', $empre)
      ->andWhere('c.id =?', $cid)
      ->fetchOne(); 
if($caja) {
?>
  
    <div class="row">
        <div class="col-md-4 "> 
         <div class="form-group">
           <label class=" control-label"><?php echo $caja->getNombre(); ?> - Arqueo-Cierre </label>
            <select name="rep_x" class="form-control" id="rep_x">
             <?php   
              $repsx = Doctrine_Query::create()
                    ->select('cc.*')
                    ->from('CajaCorte cc')
                    ->where('cc.caja_id = ?', $cid)
                    ->andWhere('cc.tipo = ?', true)
                    ->orderBy('cc.id DESC')
                    ->limit(15)
                    ->execute(); ?>
                     <option value="NULL"></option>
               <?php
                      foreach ($repsx as $repx) { 
                          $fechx = $repx->getFechaIni();
                          list($annox, $mesx, $dix) = explode('-',$repx->getFechaIni());
                          $diax=substr($dix, 0,2);
                          $horax = date("h:i", strtotime($fechx));
                          echo "<option value='".$repx->getId()."'>".$diax."/".$mesx."/".$annox." ".$horax."</option>";
                          }
                      ?>
              </select>
            </div>
          </div>

        <div class="col-md-4 "> 
         <div class="form-group">
           <label class=" control-label"><?php echo $caja->getNombre(); ?> - Ventas</label>
            <select name="rep_z" class="form-control" id="rep_z">
             <?php   
              $repsz = Doctrine_Query::create()
                    ->select('cc.*')
                    ->from('CajaCorte cc')
                    ->where('cc.caja_id = ?', $cid)
                    ->andWhere('cc.tipo = ?', true)
                    ->orderBy('cc.id DESC')
                    ->limit(15)
                    ->execute(); ?>
                     <option value="NULL"></option>
                <?php
                      foreach ($repsz as $repz) { 
                          $fechz = $repz->getFechaIni();
                          list($annoz, $mesz, $diz) = explode('-',$repz->getFechaIni());
                          $diaz=substr($diz, 0,2);
                          $horaz = date("h:i", strtotime($fechz));
                          echo "<option value='".$repz->getId()."'>".$diaz."/".$mesz."/".$annoz." ".$horaz."</option>";
                          }
                      ?>
              </select>
            </div>
          </div>     

          <div class="col-md-4 "> 
         <div class="form-group">
           <label class=" control-label"><?php echo $caja->getNombre(); ?> - Facturas</label>
            <select name="fact" class="form-control" id="fact">
             <?php   
              $facs = Doctrine_Query::create()
                    ->select('cd.id as cdid, cd.fecha as fe')
                    ->from('CajaDet cd')
                    ->where('cd.caja_id = ?', $cid)
                    ->andWhere('cd.status = ?', 1)
                    ->orderBy('cd.id DESC')
                    ->limit(15)
                    ->execute(); ?>
                     <option value="NULL"></option>
                <?php
                      foreach ($facs as $fac) { 
                         // $fechac = $fac->getFe();
                          list($annof, $mesf, $dif) = explode('-',$fac->getFe());
                          $diaf=substr($dif, 0,2);
                          $fechac = $annof."-".$mesf."-".$diaf;
                          echo "<option value='".$fechac."'>".$diaf."/".$mesf."/".$annof."</option>";
                          }
                      ?>
              </select>
            </div>
          </div>   

 <div class="col-md-2 col-sm-6 hide">
    
 </div>

     </div>
<?php } } ?>

<script type="text/javascript">
  $( document ).ready(function() {
    $("#rep_x").select2({ width: '100%'});
    $("#rep_z").select2({ width: '100%'});
    $("#fact").select2({ width: '100%'});
    $("[data-mask]").inputmask();

     $("#rep_z").on('change', function(event){
      var idz = $("#rep_z").val();
      GetImprimir(idz);
  });
     $("#rep_x").on('change', function(event){
      var idx = $("#rep_x").val();
      GetImprimirz(idx);
  });

   $("#fact").on('change', function(event){
      var fact = $("#fact").val();
      GetImprimirf(fact);
  });   

  });

  function GetImprimir(idz) {
    var retVal = confirm("¿Estas seguro de visualizar el reporte de ventas de la caja?");
    if( retVal == true ){
        location.href = "<?php echo url_for('gcaja/imprimir') ?>?idz="+idz, target="_blank";
    }else{
     return false;
    }
  }
  function GetImprimirz(id) {
    var retVal = confirm("¿Estas seguro de visualizar el reporte Z?");
    if( retVal == true ){
        var id = id;
    location.href = "<?php echo url_for('gcaja/imprimirz') ?>?id="+id;
    }else{
     return false;
    }
  }
function GetImprimirf(fecha) {
    var retVal = confirm("¿Estas seguro de visualizar las facturas?");
    if( retVal == true ){
        var cid = <?php echo $cid ?>;
        var fecha = fecha;
    location.href = "<?php echo url_for('gcaja/imprimirf') ?>?cid="+cid+"&fecha="+fecha;
    }else{
     return false;
    }
  }
</script>
