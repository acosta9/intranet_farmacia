<script type="text/javascript">
  function addDet(num) {
    var r = $.ajax({
      type: 'GET',
      url: '<?php echo url_for('producto')?>'+'/addDetallesForm/<?php echo ($form->getObject()->isNew()?'':'?id='.$form->getObject()->getId()).($form->getObject()->isNew()?'?num=':'&num=')?>'+num,
      async: false
    }).responseText;
    return r;
  }
  $( document ).ready(function() {
    $('.add_item').click(function() {
     var items = $(".items").length + 1;
     var retVal = confirm("¿Estas seguro de agregar una imagen?");
     if( retVal == true ){
         $("#item").append(addDet(items));
         items = items + 1;
         return true;
     }else{
      return false;
     }
    });
    $('.del_servicio').click(function() {
      var id = ($(this).parent().parent().parent().find('.servicio_id').val());
      if(id > 0) {
        var r = $.ajax({
          type: 'GET',
          url: '<?php echo url_for('producto')?>/delServicio?id=<?php echo $form->getObject()->getId() ?>&num='+id,
          async: false
        }).responseText;
        if(r=="success") {
          window.location.replace("<?php echo url_for('producto')."/redirectServicio?id=".$form->getObject()->getId() ?>");
        }
      }
    });
  });
</script>

</div></div></div>

<?php if ($form['producto_img']) : ?>
  <?php $numero=1 ?>
  <?php foreach ($form['producto_img'] as $det){ ?>
      <div class="card card-primary items" id="sf_fieldset_det_<?php echo $numero?>">
        <?php echo $det['id']->render(array("class" => "servicio_id")); ?>
        <div class="card-header">
          <h3 class="card-title">imagen [<?php echo $numero?>]</h3>
          <div class="card-tools">
            <a href="javascript:void(0)" class="btn btn-tool del_servicio"><i class="fas fa-times"></i></a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <div class="col-sm-12 control-label pl-0">
                  <?php echo $det['url_imagen']->renderLabel()?>
                </div>
                <div class="col-sm-12 foto2 pl-0">
                  <?php echo $det['url_imagen']->render(array('class' => 'producto_img url_imagen form-control'))?>
                  <?php if ($det['url_imagen']->renderError())  { echo $det['url_imagen']->renderError(); } ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <?php echo $det['descripcion']->renderLabel()?>
                <?php echo $det['descripcion']->render(array('class' => 'producto_img_descripcion form-control'))?>
                <?php if ($det['descripcion']->renderError())  { echo $det['descripcion']->renderError(); } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php $numero=$numero+1; ?>
  <?php } ?>
<?php endif; ?>

<div id="item"></div>

<div><div><div>
