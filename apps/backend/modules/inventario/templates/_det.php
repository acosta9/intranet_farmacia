<script type="text/javascript">
  function addDet(num) {
    var r = $.ajax({
      type: 'GET',
      url: '<?php echo url_for('inventario')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num,
      async: false
    }).responseText;
    return r;
  }
  $( document ).ready(function() {
    $('.add_item').click(function() {
     var items = $(".items").length + 1;
     var retVal = confirm("¿Estas seguro de agregar un lote nuevo?");
     if( retVal == true ){
       $("#item").append(addDet(items));
       items = items + 1;
       return true;
     }else{
      return false;
     }
    });
  });
</script>

</div></div></div>

<?php if ($form['inventario_det']) : ?>
    <?php $numero=1 ?>
    <?php foreach ($form['inventario_det'] as $det){ ?>
      <div class="card card-primary items" id="sf_fieldset_det_<?php echo $numero?>">
        <div class="card-header">
          <h3 class="card-title">lote [<?php echo $numero?>]</h3>
        </div>
        <div class="card-body">
          <?php if ($form->getObject()->isNew()){ ?>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <?php echo $det['lote']->renderLabel()?>
                  <?php echo $det['lote']->render(array('class' => 'form-control', 'required' => 'required'))?>
                  <?php if ($det['lote']->renderError())  { echo $det['descripcion']->renderError(); } ?>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <?php echo $det['fecha_venc']->renderLabel()?>
                  <?php echo $det['fecha_venc']->render(array('class' => 'form-control', 'required' => 'required'))?>
                  <?php if ($det['fecha_venc']->renderError())  { echo $det['fecha_venc']->renderError(); } ?>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <?php echo $det['cantidad']->renderLabel()?>
                  <?php echo $det['cantidad']->render(array('class' => 'form-control qty number2', 'required' => 'required'))?>
                  <?php if ($det['cantidad']->renderError())  { echo $det['cantidad']->renderError(); } ?>
                </div>
              </div>
            </div>
          <?php } else { ?>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <?php echo $det['lote']->renderLabel()?>
                  <?php echo $det['lote']->render(array('class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly'))?>
                  <?php if ($det['lote']->renderError())  { echo $det['lote']->renderError(); } ?>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <?php echo $det['fecha_venc']->renderLabel()?>
                  <?php echo $det['fecha_venc']->render(array('class' => 'form-control update_fecha', 'required' => 'required', 'readonly' => 'readonly'))?>
                  <?php if ($det['fecha_venc']->renderError())  { echo $det['fecha_venc']->renderError(); } ?>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <?php echo $det['cantidad']->renderLabel()?>
                  <?php echo $det['cantidad']->render(array('class' => 'form-control qty number2', 'required' => 'required', 'readonly' => 'readonly'))?>
                  <?php if ($det['cantidad']->renderError())  { echo $det['cantidad']->renderError(); } ?>
                  <script>
                    $("#inventario_inventario_det_<?php echo $numero?>_cantidad").on('change', function(event){
                      sumarCantidad();
                    });
                    $("#inventario_inventario_det_<?php echo $numero?>_cantidad").keyup(function(){
                      sumarCantidad();
                    });
                  </script>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
      <?php $numero=$numero+1; ?>
  <?php } ?>
<?php endif; ?>
<script type="text/javascript">
  $(document).ready(function() {
    $( "form" ).submit(function( event ) {
      $('#loading').fadeIn( "slow", function() {});
    });
  });
</script>
<div id="item"></div>

<div><div><div>
