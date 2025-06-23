</div></div></div>
<div class="card card-primary items" id="sf_fieldset_det_<?php echo $num?>">
  <div class="card-header">
    <h3 class="card-title">imagen [<?php echo $num?>]</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <div class="col-sm-12 control-label pl-0">
            <?php echo $form['producto_img'][$num]['url_imagen']->renderLabel()?>
          </div>
          <div class="col-sm-12 foto2 pl-0">
            <?php echo $form['producto_img'][$num]['url_imagen']->render(array('class' => 'producto_img url_imagen', "style" => "width: 100% !important"))?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <?php echo $form['producto_img'][$num]['descripcion']->renderLabel()?>
          <?php echo $form['producto_img'][$num]['descripcion']->render(array('class' => 'form-control', 'required' => 'required'))?>
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div>
