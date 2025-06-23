<div class="col-md-4">
  <div class="form-group">
    <label>EMPRESA</label>
    <input type="text" value="<?php echo $form->getObject()->get('Empresa') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>DEPOSITO</label>
    <input type="text" value="<?php echo $form->getObject()->get('InvDeposito') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>CODIGO</label>
    <input type="text" value="<?php echo $form->getObject()->get('id') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>NOMBRE</label>
    <input type="text" value="<?php echo strtoupper($form->getObject()->get('nombre')) ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>FECHA DE INICIO</label>
    <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('fecha'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>FECHA DE VENCIMIENTO</label>
    <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('fecha_venc'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>ESTATUS</label>
    <input type="text" value="<?php echo $form->getObject()->get('Estatus') ?>" class="form-control <?php if($oferta->getActivo()==0){echo "anuladoo";}?>" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>TIPO DE OFERTA</label>
    <?php if($form->getObject()->get('tipo_oferta')==2) { ?>
      <input type="text" value="<?php echo "LLEVATE ".$oferta->getQty()." PAGA 1"; ?>" class="form-control" readonly="">
    <?php } else { ?>
      <input type="text" value="<?php echo $form->getObject()->get('Tipo') ?>" class="form-control" readonly="">
    <?php } ?>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>EXENTO</label>
    <input type="text" value="<?php if($form->getObject()->get('exento')) { echo "SI"; } else {echo "NO";} ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6"></div>
<div class="col-md-3">
  <div class="form-group">
    <label>PRECIO USD</label>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">USD</span>
      </div>
      <input class="form-control money" type="text" value="<?php echo $form->getObject()->get('precio_usd') ?>" readonly="">
    </div>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>TIPO DE TASA</label>
    <input type="text" value="<?php echo $oferta->getTipoTasa() ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>TASA</label>
    <?php
    $results = Doctrine_Query::create()
      ->select('o.id, o.valor')
      ->from('Otros o')
      ->where('o.empresa_id = ?', $form->getObject()->get('empresa_id'))
      ->AndWhere('o.nombre = ?', $form->getObject()->get('tasa'))
      ->orderBy('o.id DESC')
      ->limit(1)
      ->execute();
      $tasa=0;
      foreach ($results as $result) {
        $tasa=$result->getValor();
      }
    ?>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">BS</span>
      </div>
      <input class="form-control money" type="text" value="<?php echo $tasa ?>" readonly="">
    </div>
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>PRECIO BS</label>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">BS</span>
      </div>
      <input class="form-control money" type="text" value="<?php echo number_float($form->getObject()->get('precio_usd'))*number_float($tasa) ?>" readonly="">
    </div>
  </div>
</div>

<?php if ($form['oferta_det']): ?>
  </div></div></div></div>
  <?php
  $results = Doctrine_Query::create()
    ->select('od.id as odid, i.id as iid, i.cantidad as qty, p.id as pid, p.nombre as name, p.serial as serial, p.codigo as codi')
    ->from('OfertaDet od, od.Inventario i, i.Producto p')
    ->where('od.oferta_id = ?', $form->getObject()->get('id'))
    ->orderBy('od.id DESC')
    ->execute();
      $num=1;
    foreach ($results as $result):
?>
<div class="card card-primary" id="sf_fieldset_detalles_<?php echo $numero?>">
  <div class="card-header">
    <h3 class="card-title">PRODUCTO #<?php echo $num++;?></h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label>PRODUCTO</label>
          <input type="text" value="<?php echo $result["name"]." [".$result["serial"]."] (".$result["qty"].")"; ?>" class="form-control" readonly="">
        </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>
<div><div><div><div>
<?php endif; ?>
<div class="row no-print">
  <div class="col-12">
    <button onclick="anular()" class="btn btn-danger float-right" style="margin-right: 5px;">
      <i class="fas fa-minus-circle"></i> Des-Habilitar
    </button>
    <button type="button" id="bfactura" class="btn btn-warning float-right" style="margin-right: 40px;" data-toggle="modal" data-target="#modalQuickBf"><i class="fas fa-pen"></i> Modificar Fecha</button>
  </div>
</div>
<br/>

<!-- MODAL MODIFICAR FECHA EXP -->
<div class="modal fade" id="modalQuickBf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="margin: top 160px;">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          
          <div class="col-lg-12">
            <div class="small-box bg-warning ">
              <div class="container">
                <h4 class="h3-responsive product-name">
                   Fecha de Vencimiento de la Oferta 
                </h4>
             </div>
           </div>
             <!-- Accordion card -->
              <div class="card">

                <!-- Card header -->
                <div class="card-header" role="tab" id="headingOne1">
                    <h6 class="mb-0">
                      Modificar Fecha 
                    </h6>
                </div>
                 <div class="card-body">
                       
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                     <input type="text" name="fechav" id="fechav" value="<?php echo strtoupper(format_datetime($form->getObject()->get('fecha_venc'), 'D', 'es_ES')) ?>" class="form-control dateonly" readonly="readonly">
                    </div>
                                
                  </div>
                  <br>
                  <div class="row">
                <div class="col-md-12 text-center">
                    <!--  voy a la funcion que lleva a la accion -->
                      
                     <button onclick="modfecha()"  class="btn btn-warning">Cambiar</button>
                                        
                    <button type="button" class="btn btn-secondary cerrar_modal" data-dismiss="modal" id="cbfecha">Cancelar</button>
         
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

<!-- FIN MODAL REIMPRIMIR --> 

<?php
function number_float($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return floatval($number);
}
?>
<script>
  $( document ).ready(function() {
   $(".dateonly").datepicker({
        language: 'es',
        format: "yyyy-mm-dd"
      });
  });
  function anular() {
    var retVal = confirm("¿Estas seguro de des-habilitar la oferta?");
    if( retVal == true ){
      location.href = "<?php echo url_for("oferta")."/anular?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
  }
  function modfecha() {
    
    var fechav= $('#fechav').val();
    $('#cbfecha').click();
     location.href = "<?php echo url_for("oferta")."/modificarf?id=".$form->getObject()->get('id')?>&fecha_venc="+fechav;
  } 
</script>
