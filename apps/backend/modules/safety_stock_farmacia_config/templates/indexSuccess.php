<?php

$q = Doctrine_Manager::getInstance()->getCurrentConnection();

$empresas = $q->execute("SELECT sn.srvid as id from server_name as sn");
$empresa_id;
foreach($empresas as $empresa){
  $empresa_id = $empresa['id'];
  break;
}

$configs = $q->execute("SELECT ssc.id as id,ssc.nivel_servicio_id as nivel,ssc.tiempo_entrega as tiempo, ssc.dias_analisis as dias,ssc.dias_calculo as calculo,ssc.correos_notificacion as correos, e.id as eid, e.nombre as nombre
FROM safety_stock_farmacia_config as ssc
inner join empresa as e on (e.id = ssc.empresa_id) where e.id = $empresa_id");

$configuracion;
foreach($configs as $config){
  $configuracion= $config;
  break;
}

?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Safety Stock Config<small style="font-size: 60%;"> <?php echo !empty($configuracion) ? 'editar':'nuevo'; ?></small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage"); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for("safety_stock_farmacia_config"); ?>">Safety Stock Config</a></li>
          <li class="breadcrumb-item active"> <?php echo !empty($configuracion) ? 'editar':'nuevo'; ?> </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content" id="filtros" style="">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-body">
        <form action="#" method="post" id="form_config">
          <input type="hidden" value="<?php echo $empresa_id ?>" class="form-control" id="empresa_id">
          <input type="hidden" value="<?php echo !empty($configuracion) ? $configuracion['id']:''; ?>" class="form-control" id="id">

          <div class="row">
            <div class="col-md-12">
              <div id="results"></div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="tiempo_emtrega">Tiempo de entraga (dias)</label>
                <input type="number" value="<?php echo !empty($configuracion) ? $configuracion['tiempo']:''; ?>" class="form-control" id="tiempo_entrega">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="dias_analisis">Dias de stock</label>
                <input type="number" value="<?php echo !empty($configuracion) ? $configuracion['dias']:''; ?>"class="form-control" id="dias_analisis">
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="nivel_servicio_id">Nivel de sevicio</label>
                <select class="form-control" id="nivel_servicio_id">
                <?php
                  $results = Doctrine_Query::create()
                    ->select('nv.porcentaje as porcentaje, nv.id id')
                    ->from('NivelServicio nv')
                    ->orderBy('nv.porcentaje ASC')
                    ->execute();
                  foreach($results as $result) {
                    if(!empty($configuracion) && $configuracion['nivel'] == $result["id"]){
                      echo "<option selected='true' value='" . $result["id"] . "'>" . $result["porcentaje"] . "</option>";
                    }else{
                      echo "<option value='". $result["id"] . "'>" . $result["porcentaje"] . "</option>";
                    }
                  }
                ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="dias_calaulo">Dias de calculo</label>
                <input type="number" value="<?php echo !empty($configuracion) ? $configuracion['calculo']:''; ?>"class="form-control" id="dias_calculo">
                </select>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="correos_notificacion">Correos a notificar</label>
                <select class="form-control" id="correos_notificacion" multiple="multiple">
                  <?php 
                  if(!empty($configuracion)){
                    $correos = explode(",",$configuracion['correos']);
                    foreach($correos as $correo){
                      echo '<option value="'.$correo.'" selected="selected"> '. $correo .' </option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row float-sm-right">
            <input class="btn btn-primary ml-3" type="submit" value="GUARDAR">
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


            
<script type="text/javascript">

  $( document ).ready(function() {
    $('.onlyqty_intern').mask("###0", {reverse: true});
    
    $("#correos_notificacion").select2({
      width: '100%',
      multiple: true,
      language: {
        inputTooShort: function () {
          return "por favor ingrese 2 o más caracteres...";
        }
      },
      ajax: {
        url: '<?php echo url_for("safety_stock_farmacia_config")."/getCorreos"; ?>',
        dataType: 'json',
        headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        delay: 250,
        type: 'GET',
        data: function (params) {
          var query = {
            search: params.term
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
      placeholder: 'Busca un correo',
      minimumInputLength: 2,
    });
  });

  $("#form_config").submit(function( event ) {
    cargar();
    event.preventDefault();
  });

  function cargar() {

    var id = $("#id").val();
    var empresa_id = $("#empresa_id").val();
    var tiempo_entrega = $("#tiempo_entrega").val();
    var dias_analisis = $("#dias_analisis").val();
    var nivel_servicio_id = $("#nivel_servicio_id").val();
    var dias_calculo = $("#dias_calculo").val();
    var correos_notificacion = $("#correos_notificacion").val();
    
    var pre = [];
    $.each($("#producto_id option:selected"), function(){
      pre.push($(this).val());
      console.log($(this).val())
    });

    $('#loading').fadeIn( "slow", function() {});
    $('#results').load('<?php echo url_for('safety_stock_farmacia_config/result') ?>?id='+id+'&empresa_id='+empresa_id+'&tiempo_entrega='+tiempo_entrega+'&dias_analisis='+dias_analisis+'&nivel_servicio_id='+nivel_servicio_id+'&dias_calculo='+dias_calculo+'&correos_notificacion='+correos_notificacion).fadeIn("slow");
  }
</script>

<script>
  $('#loading').fadeOut( "slow", function() {});
</script>