<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Turnover  <small style="font-size: 60%;"> filtros </small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage"); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for("turnover"); ?>">Turnover </a></li>
          <li class="breadcrumb-item active"> filtros </li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content" id="filtros">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-body">
        <form action="#" method="post" id="form_filter">
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="prod_vendidos_filters_empresa_id">Deposito</label>
                <select class="form-control" id="deposito_id">
                  <?php
                  $userid=$sf_user->getGuardUser()->getId();
                  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
                  $results = $q->execute("SELECT dep.id as did, e.acronimo as ename, dep.nombre as dname
                    FROM server_conf as sc
                    LEFT JOIN empresa as e ON sc.empresa_id=e.id
                    LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
                    LEFT JOIN inv_deposito as dep ON e.id=dep.empresa_id
                    WHERE eu.user_id='$userid' && dep.tipo=1
                    GROUP BY dep.nombre
                    ORDER BY e.nombre ASC");
                    foreach ($results as $result) {
                      echo "<option value='".$result["did"]."'>".$result["ename"]." [".$result["dname"]."]"."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="prod_vendidos_filters_cod">Producto</label>
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
                    echo "<option value='".$result["id"]."'>".$result["nombre"]."</option>";
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
            <div class="col-md-4">
              <div class="form-group">
                <label for="prod_vendidos_filters_cod">Fabricante</label>
                <select class="form-control" id="proveedor_idd">
                <?php
                  $results = Doctrine_Query::create()
                    ->select('id, nombre')
                    ->from('ProdLaboratorio')
                    ->orderBy('nombre ASC')
                    ->execute();
                    echo "<option value=''></option>";
                  foreach ($results as $result) {
                    echo "<option value='".$result["id"]."'>".$result["nombre"]."</option>";
                  }
                ?>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha">Fecha</label>
                <select class="form-control" id="fecha_m">
                  <option value="z" selected="selected"></option>
                  <option value="0">ENERO</option>
                  <option value="1">FEBRERO</option>
                  <option value="2">MARZO</option>
                  <option value="3">ABRIL</option>
                  <option value="4">MAYO</option>
                  <option value="5">JUNIO</option>
                  <option value="6">JULIO</option>
                  <option value="7">AGOSTO</option>
                  <option value="8">SEPTIEMBRE</option>
                  <option value="9">OCTUBRE</option>
                  <option value="10">NOVIEMBRE</option>
                  <option value="11">DICIEMBRE</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="fecha">Año</label>
                <select class="form-control" id="fecha_a">
                  <option value="z" selected="selected"></option>
                 <?php
                  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
                  $results = $q->execute("SELECT year(fecha) as ano FROM factura group by 1");
                  foreach ($results as $result) {
                    echo "<option value='".$result["ano"]."'>".$result["ano"]."</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            
          </div>
          <div class="row float-sm-right">
            <a class="btn btn-default" href="<?php echo url_for("turnover"); ?>">LIMPIAR BUSQUEDA</a>
            <input class="btn btn-primary ml-3" type="submit" value="BUSCAR">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="card card-default" style="border-radius: 0px !important;">
      <div class="card-body table-responsive p-2" style="border-bottom: 1px solid rgba(0,0,0,.125);">
        <div class="row">
          <div class="col-md-12">
            <div id="results"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
            
<script type="text/javascript">
  $( document ).ready(function() {
    $('.onlyqty_intern').mask("###0", {reverse: true});

    $("#categoria_id").select2({ width: '100%' });

    $("#unidad_id").select2({ width: '100%' });

    
    $("#producto_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("turnover")."/getProductos"; ?>',
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

   $("#proveedor_id").select2({
      width: '100%',
      allowClear: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("turnover")."/getProveedor"; ?>',
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
      placeholder: 'Busca un proveedor',
      minimumInputLength: 2,
    });
    
  });

  $("#form_filter").submit(function( event ) {
    cargar();
    event.preventDefault();
  });

  function cargar() {
    var fhoy = new Date();

    var mesh = fhoy.getMonth();

    did = $("#deposito_id").val();

    var prodId = "";
    if ($("#producto_id").val()) {
      prodId = $("#producto_id").val();
    }

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

    var fecham = "";
    if ($("#fecha_m").val()) {
      
      if ($("#fecha_m").val() == "z") {
        window.alert("Debe seleccionar una fecha");        
      } 
      
      else {

        if (parseInt($("#fecha_m").val(),10) > mesh) {
          window.alert("El mes seleccionado sobrepasa al mes actual");
        } 
        else {
          fecham = $("#fecha_m").val();
        }
      
      }
    }

    var fechaa = "";
    if ($("#fecha_a").val()) {
        fechaa = $("#fecha_a").val();
    }


    var provId = "";
    if ($("#proveedor_idd").val()) {
      provId = $("#proveedor_idd").val();
    }

    $('#loading').fadeIn( "slow", function() {});
    //console.log('<?php echo url_for('turnover/result') ?>?dep='+did+'&prodId='+prodId+'&cat='+cat.replace(/ /g,"_")+'&pre='+pre.join(",")+'&tipo='+tipo+'&fdesde='+fdesde+'&fhasta='+fhasta+'&tiempo='+tiempo);
    $('#results').load('<?php echo url_for('turnover/result') ?>?dep='+did+'&prodId='+prodId+'&cat='+cat+'&pre='+pre.join(",")+'&tipo='+tipo+'&fecham='+fecham+'&fechaa='+fechaa+'&provId='+provId).fadeIn("slow");
  }
</script>

<script>
  $('#loading').fadeOut( "slow", function() {});
</script>