<div class="col-md-6">
  <div class="form-group">
    <?php echo $form['empresa_id']->renderLabel()?>
    <select name="oferta[empresa_id]" class="form-control" id="oferta_empresa_id">
      <?php
        $results = Doctrine_Query::create()
          ->select('sc.id as scid, e.id as eid, e.nombre as nombre, eu.user_id')
          ->from('ServerConf sc')
          ->leftJoin('sc.Empresa e')
          ->leftJoin('e.EmpresaUser eu')
          ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
          ->orderBy('e.nombre ASC')
          ->groupBy('e.nombre')
          ->execute();
        foreach ($results as $result) {
          echo "<option value='".$result["eid"]."'>".$result["nombre"]."</option>";
        }
      ?>
    </select>
  </div>
</div>
<div class="col-md-6 col-sm-12">
  <div class="form-group" id="deposito_form">
    <label class="col-sm-12 control-label">Deposito</label>
    <div class="col-sm-12">
      <?php if ($form['deposito_id']->renderError())  { echo $form['deposito_id']->renderError(); } ?>
    </div>
  </div>
</div>