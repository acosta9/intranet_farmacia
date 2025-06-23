<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Comparar Depósitos  <small style="font-size: 60%;"> filtros </small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage"); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for("comparar_depositos"); ?>">Comparar Depósitos </a></li>
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
            <div class="col-md-6">
              <div class="form-group">
                <label for="prod_vendidos_filters_depositoa">Deposito (A)</label>
                <select class="form-control" id="depositoa">
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
                    ORDER BY id.nombre ASC");

                    foreach ($results as $result) {
                      echo "<option value='".$result["idid"]."'>"."[".$result["acronimo"]."] ".$result["dname"]."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="prod_vendidos_filters_depositoa">Deposito (B)</label>
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
                    ORDER BY id.nombre ASC");

                    foreach ($results as $result) {
                      echo "<option value='".$result["idid"]."'>"."[".$result["acronimo"]."] ".$result["dname"]."</option>";
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
          </div>
          <div class="row float-sm-right">
            <a class="btn btn-default" href="<?php echo url_for("comparar_depositos"); ?>">LIMPIAR BUSQUEDA</a>
            <input class="btn btn-primary ml-3" type="submit" value="BUSCAR">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
            
<script type="text/javascript">
  $( document ).ready(function() {
    $("#depositoa").select2({ width: '100%' });

    $("#depositob").select2({ width: '100%' });

    $("#categoria_id").select2({ width: '100%' });

    $("#unidad_id").select2({ width: '100%' });
    
  });

  $("#form_filter").submit(function( event ) {
    dida = $("#depositoa").val();
    didb = $("#depositob").val();

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

    window.open("<?php echo url_for("comparar_depositos")."/reporte"?>?dida="+dida+"&cid="+cid+"&unit="+unit+"&tipo="+tipo+"&didb="+didb, '_blank');

    event.preventDefault();
  });
</script>

<script>
  $('#loading').fadeOut( "slow", function() {});
</script>