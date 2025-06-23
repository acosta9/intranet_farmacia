<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['creado_por']->renderLabel()?>
    <?php echo $form['creado_por']->render(array('class' => 'form-control'))?>
    <?php if ($form['creado_por']->renderError())  { echo $form['creado_por']->renderError(); } ?>
  </div>
</div>
