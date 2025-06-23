</div></div></div>
<div class="card card-primary items" id="sf_fieldset_det_<?php echo $num?>">
  <div class="card-header">
    <h3 class="card-title">lote [<?php echo $num?>]</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <?php echo $form['inventario_det'][$num]['lote']->renderLabel()?>
          <?php echo $form['inventario_det'][$num]['lote']->render(array('class' => 'form-control', 'required' => 'required'))?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <?php echo $form['inventario_det'][$num]['fecha_venc']->renderLabel()?>
          <?php echo $form['inventario_det'][$num]['fecha_venc']->render(array('class' => 'form-control', 'required' => 'required'))?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <?php echo $form['inventario_det'][$num]['cantidad']->renderLabel()?>
          <?php echo $form['inventario_det'][$num]['cantidad']->render(array('class' => 'form-control qty', 'required' => 'required'))?>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#inventario_inventario_det_<?php echo $num?>_cantidad").on('change', function(event){
      sumarCantidad();
    });
    $("#inventario_inventario_det_<?php echo $num?>_cantidad").keyup(function(){
      sumarCantidad();
    });
  });
</script>
