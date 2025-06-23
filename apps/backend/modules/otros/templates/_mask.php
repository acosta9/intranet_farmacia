<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="otros[empresa_id]" class="form-control" id="otros_empresa_id">
      <?php
        $results = Doctrine_Query::create()
          ->select('e.id, e.nombre, eu.user_id')
          ->from('Empresa e')
          ->leftJoin('e.EmpresaUser eu')
          ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
          ->orderBy('e.nombre ASC')
          ->execute();
        foreach ($results as $result) {
          echo "<option value='".$result->getId()."'>".$result->getNombre()."</option>";
        }
      ?>
    </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['nombre']->renderLabel()?>
    <select name="otros[nombre]" class="form-control" id="otros_nombre">
      <option value="T01">TASA MEDICAMENTOS</option>
      <option value="T02">TASA MISCELANEOS</option>
      <option value="T03">TASA DEL DIA</option>
    </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['valor']->renderLabel()?>
    <?php echo $form['valor']->render(array('type' => 'text', 'min' => 1))?>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    $( "form" ).submit(function( event ) {
      $('#loading').fadeIn( "slow", function() {});
    });
  });
</script>
