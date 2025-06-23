      <div class="col-md-4 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Nombre</label>
          <div class="col-sm-12">
            <?php echo $form['nombre']->render(array('class' => 'form-control'))?>
            <?php if ($form['nombre']->renderError())  { echo $form['nombre']->renderError(); } ?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Serial</label>
          <div class="col-sm-12">
            <?php echo $form['serial']->render(array('class' => 'form-control', "onkeypress" => "return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57)"))?>
            <?php if ($form['serial']->renderError())  { echo $form['serial']->renderError(); } ?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Serial Alterno (1)</label>
          <div class="col-sm-12">
            <?php echo $form['serial2']->render(array('class' => 'form-control', "onkeypress" => "return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57)"))?>
            <?php if ($form['serial2']->renderError())  { echo $form['serial2']->renderError(); } ?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Serial Alterno (2)</label>
          <div class="col-sm-12">
            <?php echo $form['serial3']->render(array('class' => 'form-control', "onkeypress" => "return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57)"))?>
            <?php if ($form['serial3']->renderError())  { echo $form['serial3']->renderError(); } ?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Serial Alterno (3)</label>
          <div class="col-sm-12">
            <?php echo $form['serial4']->render(array('class' => 'form-control', "onkeypress" => "return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57)"))?>
            <?php if ($form['serial4']->renderError())  { echo $form['serial4']->renderError(); } ?>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Categoria</label>
          <div class="col-sm-12">
            <?php echo $form['categoria_id']->render(array('class' => 'form-control'))?>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Laboratorio</label>
          <div class="col-sm-12">
            <?php echo $form['laboratorio_id']->render(array('class' => 'form-control'))?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Tipo</label>
          <div class="col-sm-12">
              <?php echo $form['tipo']->render(array('class' => 'form-control'))?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Presentacion</label>
          <div class="col-sm-12">
              <?php echo $form['unidad_id']->render(array('class' => 'form-control'))?>
          </div>
        </div>
      </div>
      <input value="1" type="hidden" name="producto[activo]" id="producto_activo">
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Exento</label>
          <div class="col-sm-12">
            <?php echo $form['exento']->render(array('class' => 'form-control'))?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Destacado</label>
          <div class="col-sm-12">
            <?php echo $form['destacado']->render(array('class' => 'form-control'))?>
          </div>
        </div>
      </div>
      <div class="col-md-8 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Compuesto(s)</label>
          <div class="col-sm-12">
            <?php echo $form['compuesto_list']->render(array('class' => 'form-control'))?>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Tag(s)</label>
          <div class="col-sm-12">
            <?php echo $form['tags']->render(array('class' => 'form-control'))?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card card-primary" id="sf_fieldset_subproducto">
  <div class="card-header">
    <h3 class="card-title">Sub-Producto</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-8 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Producto</label>
          <div class="col-sm-12">
            <?php echo $form['subproducto_id']->render(array('class' => 'form-control'))?>
            <?php echo $form['subproducto_id']->renderError()?>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Cantidad</label>
          <div class="col-sm-12">
            <?php echo $form['qty_desglozado']->render(array('class' => 'form-control money3'))?>
            <?php echo $form['qty_desglozado']->renderError()?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card card-primary" id="sf_fieldset_seriales" style="<?php if(!$sf_user->hasCredential("drogueria")) { echo "display: none"; } ?>">
  <div class="card-header">
    <h3 class="card-title">Detalles Bulto</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Serial Bulto (1)</label>
          <div class="col-sm-12">
            <?php echo $form['serial_bulto1']->render(array('class' => 'form-control'))?>
            <?php echo $form['serial_bulto1']->renderError()?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Cantidad</label>
          <div class="col-sm-12">
            <?php echo $form['cantidad_bulto1']->render(array('class' => 'form-control money3'))?>
            <?php echo $form['cantidad_bulto1']->renderError()?>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Serial Bulto (2)</label>
          <div class="col-sm-12">
            <?php echo $form['serial_bulto2']->render(array('class' => 'form-control'))?>
            <?php echo $form['serial_bulto2']->renderError()?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Cantidad</label>
          <div class="col-sm-12">
            <?php echo $form['cantidad_bulto2']->render(array('class' => 'form-control money3'))?>
            <?php echo $form['cantidad_bulto2']->renderError()?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card card-primary" id="sf_fieldset_precio">
  <div class="card-header">
    <h3 class="card-title">Precios</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-5">
        <div class="form-group">
          <label>EMPRESA</label>
          <select class="form-control" id="producto_empresa_id">
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
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Costo USD</label>
          <div class="col-sm-12">
            <?php echo $form['costo_usd_1']->render(array('class' => 'form-control money', 'required' => 'required'))?>
          </div>
        </div>
      </div>
      <div class="col-md-2 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">TIPO TASA</label>
          <div class="col-sm-12">
            <?php echo $form['tasa']->render(array('class' => 'form-control'))?>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-12">
        <div class="form-group">
          <label>TASA BS</label>
          <input type="text" class="form-control" readonly="" id="tasa">
        </div>
      </div>
      <div style="<?php if(!$sf_user->hasCredential("drogueria")) { echo "display: none"; } ?>" class="row">
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Utilidad % (1)</label>
            <div class="col-sm-12">
              <?php echo $form['util_usd_1']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio USD (1)</label>
            <div class="col-sm-12">
              <?php echo $form['precio_usd_1']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio BS (1)</label>
            <div class="col-sm-12">
              <input class="form-control" type="text" id="producto_precio_bs_1" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Utilidad % (2)</label>
            <div class="col-sm-12">
              <?php echo $form['util_usd_2']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio USD (2)</label>
            <div class="col-sm-12">
              <?php echo $form['precio_usd_2']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio BS (2)</label>
            <div class="col-sm-12">
              <input class="form-control" type="text" id="producto_precio_bs_2" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Utilidad % (3)</label>
            <div class="col-sm-12">
              <?php echo $form['util_usd_3']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio USD (3)</label>
            <div class="col-sm-12">
              <?php echo $form['precio_usd_3']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio BS (3)</label>
            <div class="col-sm-12">
              <input class="form-control" type="text" id="producto_precio_bs_3" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Utilidad % (4)</label>
            <div class="col-sm-12">
              <?php echo $form['util_usd_4']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio USD (4)</label>
            <div class="col-sm-12">
              <?php echo $form['precio_usd_4']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio BS (4)</label>
            <div class="col-sm-12">
              <input class="form-control" type="text" id="producto_precio_bs_4" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Utilidad % (5)</label>
            <div class="col-sm-12">
              <?php echo $form['util_usd_5']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio USD (5)</label>
            <div class="col-sm-12">
              <?php echo $form['precio_usd_5']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio BS (5)</label>
            <div class="col-sm-12">
              <input class="form-control" type="text" id="producto_precio_bs_5" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Utilidad % (6)</label>
            <div class="col-sm-12">
              <?php echo $form['util_usd_6']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio USD (6)</label>
            <div class="col-sm-12">
              <?php echo $form['precio_usd_6']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio BS (6)</label>
            <div class="col-sm-12">
              <input class="form-control" type="text" id="producto_precio_bs_6" readonly>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Utilidad % (7)</label>
            <div class="col-sm-12">
              <?php echo $form['util_usd_7']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio USD (7)</label>
            <div class="col-sm-12">
              <?php echo $form['precio_usd_7']->render(array('class' => 'form-control money'))?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">Precio BS (7)</label>
            <div class="col-sm-12">
              <input class="form-control" type="text" id="producto_precio_bs_7" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Utilidad % (8)</label>
          <div class="col-sm-12">
            <?php echo $form['util_usd_8']->render(array('class' => 'form-control money2'))?>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Precio USD (8)</label>
          <div class="col-sm-12">
            <?php echo $form['precio_usd_8']->render(array('class' => 'form-control money'))?>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12">
        <div class="form-group">
          <label class="col-sm-12 control-label">Precio BS (8)</label>
          <div class="col-sm-12">
            <input class="form-control" type="text" id="producto_precio_bs_8" readonly>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card card-primary" id="sf_fieldset_img_principal" style="<?php if($sf_user->hasCredential("farmacia")) { echo "display: none"; } ?>">
  <div class="card-header">
    <h3 class="card-title">Descripcion</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="producto_descripcion">Descripcion General</label>
          <?php echo $form['descripcion']->render(array('class' => 'form-control'))?>
        </div>
      </div>
      <div class="col-md-12">
        <div class="form-group">
          <label for="producto_mas_detalles">Mas Detalles</label>
          <?php echo $form['mas_detalles']->render(array('class' => 'form-control'))?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function () {
    $("#producto_mas_detalles").summernote();
  });
</script>
<link rel="stylesheet" href="/plugins/summernote/summernote-bs4.css">
<script src="/plugins/summernote/summernote-bs4.min.js"></script>


<div class="card card-primary" id="sf_fieldset_img_principal">
  <div class="card-header">
    <h3 class="card-title">Imagen Principal</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <div class="col-sm-12 control-label pl-0">
            <label for="producto_url_imagen">Imagen</label>
          </div>
          <div class="col-sm-12 foto2 pl-0">
            <?php echo $form['url_imagen']->render(array('class' => 'url_imagen form-control'))?>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="producto_url_imagen_desc">Descripcion</label>
          <?php echo $form['url_imagen_desc']->render(array('class' => 'form-control'))?>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="categorias" style="display:none">
  <span id="contador"></span>
  <?php
    $dets = Doctrine_Core::getTable('ProdCategoria')
      ->createQuery('a')
      ->select('id, nombre, codigo')
      ->execute();
      foreach ($dets as $det) {
        echo "<span id='".$det->getId()."'>".$det->getCodFull()."</span>";
      }
  ?>
</div>

<div><div><div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#producto_subproducto_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inventario")."/getProductos"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term
          }
          // Query parameters will be ?search=[term]&type=public
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
    //GetTasa();
    GetTasa2();
    $("#producto_laboratorio_id").select2({ width: '100%' });
    $("#producto_compuesto_list").select2({ width: '100%' });
    <?php if ($form->getObject()->getId()): ?>
      <?php $producto = Doctrine_Core::getTable('Producto')->findOneBy('id', $form->getObject()->getId()); ?>
      var data="<?php echo $producto->getTags(); ?>";
      var dataarray=data.split(";");
      $("#producto_tags").val(dataarray);
    <?php endif; ?>
    $("#producto_tags").select2({
      tags: true,
      tokenSeparators: [';', ' ']
    });
  });
  function GetTasa() {
    var empresa_id = $("#producto_empresa_id" ).val();
    var categoria_id = $("#producto_categoria_id" ).val();
    var json_obj = JSON.parse(Get("<?php echo url_for("producto");?>/tasa?id="+empresa_id+'&cat='+categoria_id));
    $('#tasa').val(json_obj);
    InitPrice();
  }
  function GetTasa2() {
    if($("#producto_tasa").val().length>2) {
      var empresa_id = $("#producto_empresa_id" ).val();
      var categoria_id = $("#producto_tasa").val();
      var json_obj = JSON.parse(Get("<?php echo url_for("producto");?>/tasa2?id="+empresa_id+'&cat='+categoria_id));
      $('#tasa').val(json_obj);
      InitPrice();
    } else {
      GetTasa();
    }
  }
  $("#producto_tasa").on('change', function(event){
    GetTasa2();
  });
  $("#producto_empresa_id").on('change', function(event){
    GetTasa();
    $("#producto_tasa").val("");
  });
  $("#producto_categoria_id").on('change', function(event){
    GetTasa();
    $("#producto_tasa").val("");
  });
  $('#producto_costo_usd_1').keyup(function(){
    PutPrice(this.value);
  });

  $('#producto_util_usd_1').keyup(function(){
    UsdPrice(1, number_float(this.value));
  });
  $('#producto_util_usd_2').keyup(function(){
    UsdPrice(2, number_float(this.value));
  });
  $('#producto_util_usd_3').keyup(function(){
    UsdPrice(3, number_float(this.value));
  });
  $('#producto_util_usd_4').keyup(function(){
    UsdPrice(4, number_float(this.value));
  });
  $('#producto_util_usd_5').keyup(function(){
    UsdPrice(5, number_float(this.value));
  });
  $('#producto_util_usd_6').keyup(function(){
    UsdPrice(6, number_float(this.value));
  });
  $('#producto_util_usd_7').keyup(function(){
    UsdPrice(7, number_float(this.value));
  });
  $('#producto_util_usd_8').keyup(function(){
    UsdPrice(8, number_float(this.value));
  });
  $('#producto_precio_usd_1').keyup(function(){
    UtilPrice(1, number_float(this.value));
  });
  $('#producto_precio_usd_2').keyup(function(){
    UtilPrice(2, number_float(this.value));
  });
  $('#producto_precio_usd_3').keyup(function(){
    UtilPrice(3, number_float(this.value));
  });
  $('#producto_precio_usd_4').keyup(function(){
    UtilPrice(4, number_float(this.value));
  });
  $('#producto_precio_usd_5').keyup(function(){
    UtilPrice(5, number_float(this.value));
  });
  $('#producto_precio_usd_6').keyup(function(){
    UtilPrice(6, number_float(this.value));
  });
  $('#producto_precio_usd_7').keyup(function(){
    UtilPrice(7, number_float(this.value));
  });
  $('#producto_precio_usd_8').keyup(function(){
    UtilPrice(8, number_float(this.value));
  });
  function UtilPrice(num, price) {
    price=parseFloat(price);
    if(price>0) {
      var costo = number_float($("#producto_costo_usd_1").val());
      var tasa = number_float($("#tasa").val());
      var util = parseFloat(((price*100)/costo)-100);
      $("#producto_util_usd_"+num).val(SetMoney(util));
      $("#producto_precio_bs_"+num).val(SetMoney(price*tasa));
    } else {
      $("#producto_util_usd_"+num).val("0,0000");
      $("#producto_precio_bs_"+num).val("0,0000");
    }
  }
  function UsdPrice(num, util2) {
    util2=parseFloat(util2);
    if(util2>0) {
      var costo = number_float(($("#producto_costo_usd_1" ).val()));
      var tasa = number_float($("#tasa").val());
      var util = setAndFormat(util2*costo/100);
      var precio_usd = setAndFormat(costo+util);
      $("#producto_precio_usd_"+num).val(SetMoney(precio_usd));
      $("#producto_precio_bs_"+num).val(SetMoney(precio_usd*tasa));
    } else {
      $("#producto_precio_usd_"+num).val("0,0000");
      $("#producto_precio_bs_"+num).val("0,0000");
    }
  }
  function InitPrice() {
    var tasa = number_float($("#tasa").val());
    $("#producto_precio_bs_1").val(SetMoney(number_float($("#producto_precio_usd_1").val())*tasa));
    $("#producto_precio_bs_2").val(SetMoney(number_float($("#producto_precio_usd_2").val())*tasa));
    $("#producto_precio_bs_3").val(SetMoney(number_float($("#producto_precio_usd_3").val())*tasa));
    $("#producto_precio_bs_4").val(SetMoney(number_float($("#producto_precio_usd_4").val())*tasa));
    $("#producto_precio_bs_5").val(SetMoney(number_float($("#producto_precio_usd_5").val())*tasa));
    $("#producto_precio_bs_6").val(SetMoney(number_float($("#producto_precio_usd_6").val())*tasa));
    $("#producto_precio_bs_7").val(SetMoney(number_float($("#producto_precio_usd_7").val())*tasa));
    $("#producto_precio_bs_8").val(SetMoney(number_float($("#producto_precio_usd_8").val())*tasa));
  }
  function PutPrice(costo) {
    costo = number_float(costo);
    var tasa = number_float($("#tasa").val());
    var util1 = setAndFormat(number_float($("#producto_util_usd_1").val())*costo/100);
    var util2 = setAndFormat(number_float($("#producto_util_usd_2").val())*costo/100);
    var util3 = setAndFormat(number_float($("#producto_util_usd_3").val())*costo/100);
    var util4 = setAndFormat(number_float($("#producto_util_usd_4").val())*costo/100);
    var util5 = setAndFormat(number_float($("#producto_util_usd_5").val())*costo/100);
    var util6 = setAndFormat(number_float($("#producto_util_usd_6").val())*costo/100);
    var util7 = setAndFormat(number_float($("#producto_util_usd_7").val())*costo/100);
    var util8 = setAndFormat(number_float($("#producto_util_usd_8").val())*costo/100);

    var precio_1_usd = setAndFormat(costo+util1);
    var precio_2_usd = setAndFormat(costo+util2);
    var precio_3_usd = setAndFormat(costo+util3);
    var precio_4_usd = setAndFormat(costo+util4);
    var precio_5_usd = setAndFormat(costo+util5);
    var precio_6_usd = setAndFormat(costo+util6);
    var precio_7_usd = setAndFormat(costo+util7);
    var precio_8_usd = setAndFormat(costo+util8);

    $("#producto_precio_usd_1").val(SetMoney(precio_1_usd));
    $("#producto_precio_usd_2").val(SetMoney(precio_2_usd));
    $("#producto_precio_usd_3").val(SetMoney(precio_3_usd));
    $("#producto_precio_usd_4").val(SetMoney(precio_3_usd));
    $("#producto_precio_usd_5").val(SetMoney(precio_5_usd));
    $("#producto_precio_usd_6").val(SetMoney(precio_6_usd));
    $("#producto_precio_usd_7").val(SetMoney(precio_7_usd));
    $("#producto_precio_usd_8").val(SetMoney(precio_8_usd));

    $("#producto_precio_bs_1").val(SetMoney(precio_1_usd*tasa));
    $("#producto_precio_bs_2").val(SetMoney(precio_2_usd*tasa));
    $("#producto_precio_bs_3").val(SetMoney(precio_3_usd*tasa));
    $("#producto_precio_bs_4").val(SetMoney(precio_3_usd*tasa));
    $("#producto_precio_bs_5").val(SetMoney(precio_5_usd*tasa));
    $("#producto_precio_bs_6").val(SetMoney(precio_6_usd*tasa));
    $("#producto_precio_bs_7").val(SetMoney(precio_7_usd*tasa));
    $("#producto_precio_bs_8").val(SetMoney(precio_8_usd*tasa));
  }
  function GetCodigoTipo() {
    var codigo =$("#producto_codigo" ).val();
    var cod_new="";
    if($("#producto_tipo" ).val()==1) {
      cod_new=codigo.replace("NAC", "IMP");
    } else {
      cod_new=codigo.replace("IMP", "NAC");
    }
    $("#producto_codigo").val(cod_new);
  }
  $( "form" ).submit(function( event ) {
    var cont=0;

    if(!$("#producto_nombre").val()) {
      $("#producto_nombre").addClass("is-invalid");
      $("#producto_nombre").parent().find(".error").remove();
      $("#producto_nombre").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      $("#producto_nombre").parent().find(".error").remove();
      $("#producto_nombre").removeClass("is-invalid");
    }

    if(!$("#producto_serial").val()) {
      $("#producto_serial").addClass("is-invalid");
      $("#producto_serial").parent().find(".error").remove();
      $("#producto_serial").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Requerido.</li></ul></div>" );
      cont++;
    }else {
      <?php if($form->getObject()->isNew()) { ?>
        var json_obj = JSON.parse(Get("<?php echo url_for("producto");?>/getSerial?id="+$("#producto_serial").val()));
        console.log(json_obj);
        if(json_obj>0) {
          $("#producto_serial").addClass("is-invalid");
          $("#producto_serial").parent().find(".error").remove();
          $("#producto_serial").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Serial ya existente.</li></ul></div>" );
          cont++;
        } else {
          $("#producto_serial").parent().find(".error").remove();
          $("#producto_serial").removeClass("is-invalid");
        }
      <?php } else { ?>
        $("#producto_serial").parent().find(".error").remove();
        $("#producto_serial").removeClass("is-invalid");
      <?php } ?>
    }

    if(cont>0) {
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, REVISA LOS DATOS INTRODUCIDOS.</div>');
      event.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, 1000);
    } else {
      $('#loading').fadeIn( "slow", function() {});
    }
  });
  $('#loading').fadeOut( "slow", function() {});
</script>
<style>
.dropdown-item {
    color: #212529 !important;
}
</style>