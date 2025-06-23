<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Productos  <small style="font-size: 60%;"> listado </small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage"); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for("producto"); ?>">Productos </a></li>
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
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Nombre o serial</label>
                <input class="form-control" type="text" id="nombre">
              </div>
            </div>
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
              <a class="btn btn-success text-uppercase" href="<?php echo url_for("producto"); ?>/new"><i class="fas fa-folder-plus mr-2"></i>Nuevo</a>
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
    $("#categoria_id").select2({ width: '100%' });
    $("#compuesto_id").select2({ width: '100%' });
    $("#laboratorio_id").select2({ width: '100%' });
    $("#unidad_id").select2({ width: '100%' });
    cargar();
  });

  $("#form_filter").submit(function( event ) {
    cargar();
    event.preventDefault();
  });

  function cargar() {
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

    var nombre = "";
    if ($("#nombre").val()) {
      nombre = $("#nombre").val();
    }

    $('#loading').fadeIn( "slow", function() {});
    //console.log('<?php echo url_for('producto/result') ?>?cat='+cat.replace(/ /g,"_")+'&com='+com.join(",")+'&lab='+lab.join(",")+'&pre='+pre.join(",")+'&tipo='+tipo+'&cant='+cant);
    $('#results').load('<?php echo url_for('producto/result') ?>?cat='+cat.replace(/ /g,"_")+'&com='+com.join(",")+'&lab='+lab.join(",")+'&pre='+pre.join(",")+'&tipo='+tipo+'&cant='+cant+'&nombre='+nombre).fadeIn("slow");
  };

  function print() {
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

    var nombre = "";
    if ($("#nombre").val()) {
      nombre = $("#nombre").val();
    }

    window.open('<?php echo url_for("producto")."/print"?>?cat='+cat.replace(/ /g,"_")+'&com='+com.join(",")+'&lab='+lab.join(",")+'&pre='+pre.join(",")+'&tipo='+tipo+'&cant='+cant+'&nombre='+nombre, '_blank');
  };
</script>