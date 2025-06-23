<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Productos no vendidos  <small style="font-size: 60%;"> filtros </small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage"); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for("prod_novendidos"); ?>">Productos no vendidos </a></li>
          <li class="breadcrumb-item active"> filtros </li>
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
                <label for="prod_vendidos_filters_empresa_id">Empresa</label>
                <select class="form-control" id="empresa_id">
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
                    echo "<option value='".$result["nombre"]."'>".$result["nombre"]."</option>";
                  }
                ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="prod_vendidos_filters_cod">Presentacion</label>
                <select class="form-control" id="unidad_id">
                <?php
                  $results = Doctrine_Query::create()
                    ->select('pu.id as puid, pu.nombre')
                    ->from('ProdUnidad pu')
                    ->orderBy('pu.nombre ASC')
                    ->execute();
                    echo "<option value=''></option>";
                  foreach ($results as $result) {
                    echo "<option value='".$result["puid"]."'>".$result["nombre"]."</option>";
                  }
                ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="prod_vendidos_filters_cod">Tipo</label>
                <select class="form-control" id="tipo_id">
                  <option value="" selected="selected"></option>
                  <option value="0">NACIONAL</option>
                  <option value="1">IMPORTADO</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="fecha">Fecha Desde</label>
                <input type="text" value="<?php $date2 = new DateTime(); echo $date2->format('Y')."-01-01"; ?>" class="form-control dateonly" id="fecha_desde" readonly="readonly">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="fecha">Fecha Hasta</label>
                <input type="text" value="<?php  echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" id="fecha_hasta" readonly="readonly">
              </div>
            </div>
          </div>
          <div class="row float-sm-right">
            <a class="btn btn-default" href="<?php echo url_for("prod_novendidos"); ?>">LIMPIAR BUSQUEDA</a>
            <input class="btn btn-primary ml-3" type="submit" value="BUSCAR">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
            
<script type="text/javascript">
  $( document ).ready(function() {
    $("#categoria_id").select2({ width: '100%' });

    $("#unidad_id").select2({ width: '100%' });
    
  });

  $("#form_filter").submit(function( event ) {
    eid = $("#empresa_id").val();

    var cid = "";
    if ($("#categoria_id").val()) {
      cid = $("#categoria_id").val();
    }

    var unit = "";
    if ($("#unidad_id").val()) {
      unit = $("#unidad_id").val();
    }

    var tipo = "";
    if ($("#tipo_id").val()) {
      tipo = $("#tipo_id").val();
    }

    var desde = "";
    if ($("#fecha_desde").val()) {
      desde = $("#fecha_desde").val();
    }

    var hasta = "";
    if ($("#fecha_hasta").val()) {
      hasta = $("#fecha_hasta").val();
    }
    

    window.open("<?php echo url_for("prod_novendidos")."/reporte"?>?eid="+eid+"&cid="+cid+"&unit="+unit+"&tipo="+tipo+"&desde="+desde+"&hasta="+hasta, '_blank');

    event.preventDefault();
  });
</script>

<script>
  $('#loading').fadeOut( "slow", function() {});
</script>