<?php
$empre=$sf_params->get('eid');
$cid=$sf_params->get('cid');
$userid = $sf_user->getGuardUser()->getId();

if(!$sf_params->get('cid')=='0') {
  
  $caja = Doctrine_Query::create()
      ->select('c.*')
      ->from('Caja c')
      ->Where('c.empresa_id =?', $empre)
      ->andWhere('c.id =?', $cid)
      ->limit(1)
      ->fetchOne();
  $dia = date("Y-m-d");
// ->andWhere('DATE_FORMAT(cd.fecha, "%Y-%m-%d") = ?', $dia)
  $caja_det = Doctrine_Query::create()
      ->select('cd.id, cd.status, cd.sf_guard_user_id as uid')
      ->from('CajaDet cd')
      ->Where('cd.caja_id =?', $cid)
      ->orderBy('cd.id DESC')
      ->limit(1)
      ->fetchOne(); 

}
if($caja_det) {
$detstatus = $caja_det->getStatus(); }
if($caja) { ?>
<div class="card card-primary caja">
    <div class="card-body">
  <div class="container">  
    <div class="row">
      <div class="col-md-4 hide">
        <div class="form-group">
         <label for="caja_empresa_id">Empresa</label>
         <input value="<?php echo $caja->getId()?>" type="text" name="caja_id" class="form-control hide" readonly="readonly" id="caja_id">
          <input value="<?php echo $caja->getEmpresaName()?>" type="text" name="caja_empresa_id" class="form-control" readonly="readonly" id="caja_empresa_id" />
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="caja_nombre">Nombre Caja</label>
          <input value="<?php echo $caja->getNombre()?>" type="text" name="caja_nombre" class="form-control" readonly="readonly" id="caja_nombre" />
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="caja_tipo">Tipo de Impresora</label>
          <input value="<?php echo $caja->getTipoImp()?>" type="text" name="caja_tipo" class="form-control" readonly="readonly" id="caja_tipo" />
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
         <label for="caja_status">Estatus</label>
          <input value="<?php echo ($caja->getEstatus()) ?>" type="text" name="caja_status" class="form-control" readonly="readonly" id="caja_status" />
        </div>
      </div>
    
     <div class="col-md-6">
        <div class="form-group">
         <label for="caja_descripcion">Descripción</label>
          <input value="<?php echo $caja->getDescripcion() ?>" type="text" name="caja_descripcion" class="form-control" readonly="readonly" id="caja_descripcion"/>
         </div>
      </div>
    </div>
    
   
  </div>
  </div>
</div>
<?php }  ?>
  
<script type="text/javascript">



</script>