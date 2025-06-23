<?php if($form->getObject()->isNew()) { ?>
  <div class="col-md-6">
    <div class="form-group">
      <?php echo $form['empresa_id']->renderLabel()?>
      <select name="inventario[empresa_id]" class="form-control" id="inventario_empresa_id">
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
  <div class="col-md-6">
    <div class="form-group" id="deposito_form">
      <?php echo $form['deposito_id']->renderLabel()?>
      <select name="inventario[deposito_id]" class="form-control" id="inventario_deposito_id">
      </select>
    </div>
  </div>
  <div class="col-md-12 col-sm-12">
    <div class="form-group">
      <label class="col-sm-12 control-label">Producto</label>
      <div class="col-sm-12">
        <select class="form-control" name="inventario[producto_id]" id="inventario_producto_id">
        </select>
        <?php if ($form['producto_id']->renderError())  { echo $form['producto_id']->renderError(); } ?>
      </div>
    </div>
  </div>
  <input type="hidden" name="inventario[id]" id="cod" readonly value="1"/>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#deposito_form').load('<?php echo url_for('inventario/deposito') ?>?id='+$("#inventario_empresa_id").val()).fadeIn("slow");
      $("#inventario_producto_id").select2({
        width: '100%',
        multiple: false,
        language: {
          inputTooShort: function () {
            return "por favor ingrese 2 o más caracteres...";
          }
        },
        ajax: {
          url: '<?php echo url_for("inventario")."/getProductos2"; ?>',
          dataType: 'json',
          headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          delay: 250,
          type: 'GET',
          data: function (params) {
            var query = {
              search: params.term,
              did: $("#inventario_deposito_id").val()
            }
            return query;
          },
          processResults: function (data) {
            var arr = []
            $.each(data, function (index, value) {
              arr.push({
                id: index,
                text: value
              })
            })
            return {
              results: arr
            };
          },
          cache: false
        },
        placeholder: 'Busca un producto',
        minimumInputLength: 2,
      });
      $('#loading').fadeOut( "slow", function() {});
    });
    $('#inventario_empresa_id').change(function(){
      $('#deposito_form').load('<?php echo url_for('inventario/deposito') ?>?id='+this.value).fadeIn("slow");
    });
  </script>


<?php } else { ?>
  <div class="col-md-6">
    <div class="form-group">
      <?php echo $form['empresa_id']->renderLabel()?>
      <?php echo $form['empresa_id']->render()?>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group" id="deposito_form">
      <?php echo $form['deposito_id']->renderLabel()?>
      <?php echo $form['deposito_id']->render()?>
    </div>
  </div>
  <div class="col-md-12 col-sm-12">
    <div class="form-group">
      <label class="col-sm-12 control-label">Producto</label>
      <div class="col-sm-12">
        <?php echo $form['producto_id']->render()?>
        <?php if ($form['producto_id']->renderError())  { echo $form['producto_id']->renderError(); } ?>
      </div>
    </div>
  </div>
  <input type="hidden" name="inventario[id]" id="inventario_id" readonly value="<?php echo $form->getObject()->getId() ?>"/>
  <script>
    $(document).ready(function() {
      $("#inventario_producto_id").mousedown(function(e){
        e.preventDefault();
      });
      $("#inventario_empresa_id").mousedown(function(e){
        e.preventDefault();
      });
      $("#inventario_deposito_id").mousedown(function(e){
        e.preventDefault();
      });
    });
  </script>

<?php } ?>

<?php if ($form['id']->renderError())  { echo $form['id']->renderError(); } ?>
