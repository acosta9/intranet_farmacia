<div class="col-md-6">
  <div class="form-group">
    <label for="depositoa">Deposito (A)</label>
    <select class="form-control" id="depositoa">
      <?php         
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
        $userid=$sf_user->getGuardUser()->getId();
        $eid=$ename["srvid"];
        $results = $q->execute("SELECT e.acronimo as acronimo, id.id as idid, id.nombre as dname
          FROM empresa as e
          LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
          LEFT JOIN inv_deposito as id ON e.id=id.empresa_id
          WHERE eu.user_id=$userid && e.id IN ($eid)
          ORDER BY e.nombre ASC, id.nombre ASC");
        foreach ($results as $result) {
          echo "<option value='".$result["idid"]."'>"."[".$result["acronimo"]."] ".$result["dname"]."</option>";
        }
      ?>
    </select>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label for="depositob">Deposito (B)</label>
    <select class="form-control" id="depositob">
      <?php
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $uid=$sf_user->getGuardUser()->getId();
        $results = $q->execute("SELECT e.acronimo as acronimo, id.id as idid, id.nombre as dname
        FROM server_conf as sc
        LEFT JOIN empresa as e ON sc.empresa_id=e.id
        LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
        LEFT JOIN inv_deposito as id ON e.id=id.empresa_id
        WHERE eu.user_id = '$uid'
        GROUP BY id.nombre
        ORDER BY e.nombre ASC, id.nombre ASC");

        foreach ($results as $result) {
          echo "<option value='".$result["idid"]."'>"."[".$result["acronimo"]."] ".$result["dname"]."</option>";
        }
      ?>
    </select>
  </div>
</div>
<div class="col-md-12">
  <div class="form-group">
    <label for="">Producto</label>
    <select class="form-control" id="producto_id">
    </select>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="prod_vendidos_filters_cod">Categoria</label>
    <select class="form-control" id="categoria_id">
    <?php
      $results = Doctrine_Query::create()
        ->select('pc.nombre')
        ->from('ProdCategoria pc')
        ->orderBy('pc.nombre ASC')
        ->execute();
        echo "<option value=''></option>";
      foreach ($results as $result) {
        echo "<option value='".mb_strtolower(str_replace("/","-",$result["nombre"]))."'>".$result["nombre"]."</option>";
      }
    ?>
    </select>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="prod_vendidos_filters_cod">Presentacion</label>
    <select class="form-control" id="unidad_id" multiple>
    <?php
      $results = Doctrine_Query::create()
        ->select('id, nombre')
        ->from('ProdUnidad')
        ->orderBy('nombre ASC')
        ->execute();
      foreach ($results as $result) {
        echo "<option value='".$result["id"]."'>".$result["nombre"]."</option>";
      }
    ?>
    </select>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="prod_vendidos_filters_cod">Tipo</label>
    <select class="form-control" id="tipo_id">
      <option value="z" selected="selected"></option>
      <option value="0">NACIONAL</option>
      <option value="1">IMPORTADO</option>
    </select>
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="">Cantidad Mayor que</label>
    <input class="form-control qtyintern" type="text" id="qty_mayor">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label for="prod_vendidos_filters_cod">Menor a Minimo Ideal</label>
    <select class="form-control" id="min">
      <option value="z" selected="selected"></option>
      <option value="1">SI</option>
      <option value="2">NO</option>
    </select>
  </div>
</div>
<div class="col-md-12">
  <div class="row">
    <div class="ml-auto">
      <a class="btn btn-default btn-sm ml-3" href="<?php echo url_for("traslado/new"); ?>">LIMPIAR BUSQUEDA</a>
      <a href='javascript:void(0)' class="btn btn-primary ml-3 btn-sm" onclick="buscar()">BUSCAR</a>
    </div>
  </div>
</div>
</div></div></div>


    <div class="card card-default" style="border-radius: 0px !important;">
      <div class="card-body table-responsive" style="border-bottom: 1px solid rgba(0,0,0,.125);">
        <div class="row">
          <div class="col-md-12">
            <div id="results"></div>
          </div>
        </div>
      </div>
    </div>

<div><div><div>

<script type="text/javascript">
  $( document ).ready(function() {
    $('.qtyintern').mask("###0", {reverse: true});
    $("#depositoa").select2({ width: '100%' });
    $("#depositob").select2({ width: '100%' });

    $("#categoria_id").select2({ width: '100%'});
    $("#unidad_id").select2({ width: '100%'});
    $("#tipo_id").select2({ width: '100%'});
    $("#minimo").select2({ width: '100%'});

    $("#producto_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("traslado")."/getProductos"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term,
            did: $("#depositoa").val()
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

    $('#loading').fadeOut( "slow", function() {});
  });
  function buscar() {
    var dida=$("#depositoa").val();
    var didb=$("#depositob").val();

    var prodId = [];
    $.each($("#producto_id option:selected"), function(){
      prodId.push($(this).val());
    });
    
    var cat = "";
    if ($("#categoria_id").val()) {
      cat = $("#categoria_id").val();
    }

    var pre = [];
    $.each($("#unidad_id option:selected"), function(){
      pre.push($(this).val());
    });

    var tipo = "";
    if ($("#tipo_id").val()) {
      tipo = $("#tipo_id").val();
    }

    var min = "";
    if ($("#minimo").val()) {
      min = $("#minimo").val();
    }

    var qty_mayor = "";
    if ($("#qty_mayor").val()) {
      qty_mayor = $("#qty_mayor").val();
    }

    var min = "";
    if ($("#min").val()) {
      min = $("#min").val();
    }

    if(dida==didb) {
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>EL DEPOSITO DESTINO NO PUEDE SER IGUAL AL ORIGEN</div>');
      $("html, body").animate({ scrollTop: 0 }, 1000);
    } else {
      $('#loading').fadeIn( "slow", function() {});
      $('#results').load('<?php echo url_for('traslado/result') ?>?dida='+dida+'&didb='+didb+'&cat='+cat.replace(/ /g,"_")+'&pre='+pre.join(",")+'&tipo='+tipo+'&min='+min+'&prodId='+prodId.join(",")+'&qty_mayor='+qty_mayor+'&min='+min).fadeIn("slow");
    }
  }
</script>