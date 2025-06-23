<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Inventario  <small style="font-size: 60%;"> listado </small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage"); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for("inventario"); ?>">Inventario </a></li>
          <li class="breadcrumb-item active"> listado </li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content" id="filtros" style="">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-body">
        <form action="#" method="post" id="form_filter">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Empresa</label>
                <select class="form-control" multiple id="empresa_id" required>
                  <?php
                    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
                    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
                    $userid=$sf_user->getGuardUser()->getId();
                    $eid=$ename["srvid"];
                    if($ename["tipo"]=="1") {
                      $results = $q->execute("SELECT e.id as eid, e.nombre as nombre, e.acronimo as acronimo 
                        FROM empresa as e
                        LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
                        WHERE eu.user_id=$userid && e.id IN ($eid)
                        ORDER BY e.nombre ASC");
                    } else {
                      $results = $q->execute("SELECT e.id as eid, e.nombre as nombre, e.acronimo as acronimo 
                        FROM empresa as e
                        LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
                        WHERE eu.user_id=$userid
                        ORDER BY e.nombre ASC");
                    }
                    $i=0;
                      foreach ($results as $result) {
                        if($i==0) {
                          echo "<option value='".$result["eid"]."' selected>".$result["acronimo"]."</option>";
                          $i++;
                        } else {
                          echo "<option value='".$result["eid"]."'>".$result["acronimo"]."</option>";
                        }
                      }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group" id="deposito_form">
                <label for="">Deposito</label>
                <select class="form-control" multiple id="deposito_id" required>
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
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Estatus</label>
                <select class="form-control" id="estatus_id">
                  <option value="z" selected="selected"></option>
                  <option value="0">DES-HABILITADO</option>
                  <option value="1">HABILITADO</option>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="">Cantidad Mayor que</label>
                <input class="form-control" type="text" id="qty_mayor">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="">Cantidad Menor que</label>
                <input class="form-control" type="text" id="qty_menor">
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="">Vencidos</label>
                <select class="form-control" id="vencidos">
                  <option value="z" selected="selected"></option>
                  <option value="0">NO</option>
                  <option value="1">SI</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Proximo a vencerse</label>
                <input class="form-control dateonly" type="text" id="proximo_vencer" readonly>
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
                <label for="prod_vendidos_filters_cod">Compuesto</label>
                <select class="form-control" id="compuesto_id" multiple>
                <?php
                  $results = Doctrine_Query::create()
                    ->select('id, nombre')
                    ->from('Compuesto')
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
                <label for="prod_vendidos_filters_cod">Laboratorio</label>
                <select class="form-control" id="laboratorio_id" multiple>
                <?php
                  $results = Doctrine_Query::create()
                    ->select('id, nombre')
                    ->from('ProdLaboratorio')
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
            <div class="col-md-4"></div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="prod_vendidos_filters_cod">Cantidad de filas a mostrar</label>
                <select class="form-control" id="cant">
                  <option value="200">200</option>
                  <option value="500">500</option>
                  <option value="1000">1000</option>
                  <option value="todos">Todos</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="ml-2">
              <a class="btn btn-success text-uppercase" href="<?php echo url_for("inventario"); ?>/new"><i class="fas fa-folder-plus mr-2"></i>Nuevo</a>
              <a class="btn btn-warning ml-3" href='javascript:void(0)' onclick="print()"><i class="fas fa-print mr-2"></i>Imprimir</a>
            </div>
            <div class="ml-auto">
              <a class="btn btn-default btn-sm ml-3" href="<?php echo url_for("producto"); ?>">LIMPIAR BUSQUEDA</a>
              <input type="submit" class="btn btn-primary ml-3 btn-sm" value="BUSCAR" />
            </div>
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
    $("#empresa_id").select2({ width: '100%' });
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

    $("#compuesto_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inventario")."/getCompuestos"; ?>',
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
      placeholder: 'Busca un compuesto',
      minimumInputLength: 2,
    });

    $("#laboratorio_id").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("inventario")."/getLaboratorios"; ?>',
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
      placeholder: 'Busca un laboratorio',
      minimumInputLength: 2,
    });

    loadDeposito();
  });

  $("#form_filter").submit(function( event ) {
    cargar();
    event.preventDefault();
  });

  $("#empresa_id").on('change', function(event){
    loadDeposito();
  });

  function loadDeposito() {
    $('#deposito_id').empty();
    var emps = [];
    $.each($("#empresa_id option:selected"), function(){
      emps.push($(this).val());
    });
    var deposito_id=$('#deposito_id').val();
    $('#deposito_form').load('<?php echo url_for('inventario/depositoFilters') ?>?id='+emps.join(",")+'&did='+deposito_id).fadeIn("slow");
  }

  function cargar() {
    var emp = [];
    $.each($("#empresa_id option:selected"), function(){
      emp.push($(this).val());
    });

    var dep = [];
    $.each($("#deposito_id option:selected"), function(){
      dep.push($(this).val());
    });

    var st = "";
    if ($("#estatus_id").val()) {
      st = $("#estatus_id").val();
    }

    var qtyMy = "";
    if ($("#qty_mayor").val()) {
      qtyMy = $("#qty_mayor").val();
    }

    var qtyMn = "";
    if ($("#qty_menor").val()) {
      qtyMn = $("#qty_menor").val();
    }

    var venc = "";
    if ($("#vencidos").val()) {
      venc = $("#vencidos").val();
    }

    var pvenc = "";
    if ($("#vencidos").val()) {
      pvenc = $("#proximo_vencer").val();
    }

    var cat = "";
    if ($("#categoria_id").val()) {
      cat = $("#categoria_id").val();
    }

    var com = [];
    $.each($("#compuesto_id option:selected"), function(){
      com.push($(this).val());
    });

    var lab = [];
    $.each($("#laboratorio_id option:selected"), function(){
      lab.push($(this).val());
    });

    var pre = [];
    $.each($("#unidad_id option:selected"), function(){
      pre.push($(this).val());
    });

    var tipo = "";
    if ($("#tipo_id").val()) {
      tipo = $("#tipo_id").val();
    }

    var cant = "";
    if ($("#cant").val()) {
      cant = $("#cant").val();
    }

    var prodId = "";
    if ($("#producto_id").val()) {
      prodId = $("#producto_id").val();
    }

    $('#loading').fadeIn( "slow", function() {});
    //console.log('<?php echo url_for('inventario/result') ?>?emp='+emp.join(",")+'&dep='+dep.join(",")+'&st='+st+'&qtyMy='+qtyMy+'&qtyMn='+qtyMn+'&venc='+venc+'&pvenc='+pvenc+'&cat='+cat.replace(/ /g,"_")+'&com='+com.join(",")+'&lab='+lab.join(",")+'&pre='+pre.join(",")+'&tipo='+tipo+'&cant='+cant+'&prodId='+prodId);
    $('#results').load('<?php echo url_for('inventario/result') ?>?emp='+emp.join(",")+'&dep='+dep.join(",")+'&st='+st+'&qtyMy='+qtyMy+'&qtyMn='+qtyMn+'&venc='+venc+'&pvenc='+pvenc+'&cat='+cat.replace(/ /g,"_")+'&com='+com.join(",")+'&lab='+lab.join(",")+'&pre='+pre.join(",")+'&tipo='+tipo+'&cant='+cant+'&prodId='+prodId).fadeIn("slow");
  };

  function print() {
    var emp = [];
    $.each($("#empresa_id option:selected"), function(){
      emp.push($(this).val());
    });

    var dep = [];
    $.each($("#deposito_id option:selected"), function(){
      dep.push($(this).val());
    });

    var st = "";
    if ($("#estatus_id").val()) {
      st = $("#estatus_id").val();
    }

    var qtyMy = "";
    if ($("#qty_mayor").val()) {
      qtyMy = $("#qty_mayor").val();
    }

    var qtyMn = "";
    if ($("#qty_menor").val()) {
      qtyMn = $("#qty_menor").val();
    }

    var venc = "";
    if ($("#vencidos").val()) {
      venc = $("#vencidos").val();
    }

    var pvenc = "";
    if ($("#vencidos").val()) {
      pvenc = $("#proximo_vencer").val();
    }

    var cat = "";
    if ($("#categoria_id").val()) {
      cat = $("#categoria_id").val();
    }

    var com = [];
    $.each($("#compuesto_id option:selected"), function(){
      com.push($(this).val());
    });

    var lab = [];
    $.each($("#laboratorio_id option:selected"), function(){
      lab.push($(this).val());
    });

    var pre = [];
    $.each($("#unidad_id option:selected"), function(){
      pre.push($(this).val());
    });

    var tipo = "";
    if ($("#tipo_id").val()) {
      tipo = $("#tipo_id").val();
    }

    var cant = "";
    if ($("#cant").val()) {
      cant = $("#cant").val();
    }

    var prodId = "";
    if ($("#producto_id").val()) {
      prodId = $("#producto_id").val();
    }

    window.open('<?php echo url_for('inventario/print') ?>?emp='+emp.join(",")+'&dep='+dep.join(",")+'&st='+st+'&qtyMy='+qtyMy+'&qtyMn='+qtyMn+'&venc='+venc+'&pvenc='+pvenc+'&cat='+cat.replace(/ /g,"_")+'&com='+com.join(",")+'&lab='+lab.join(",")+'&pre='+pre.join(",")+'&tipo='+tipo+'&cant='+cant+'&prodId='+prodId).fadeIn("slow");
  };
</script>