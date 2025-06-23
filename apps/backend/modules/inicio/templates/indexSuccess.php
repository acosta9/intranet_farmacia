<div class="content-header">
  <div class="container-fluid">
    <form action="#" id="buscar_dash">
      <div class="row mb-2">
        <div class="col-sm-4">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-chart-bar"></i></span>
              </div>
              <select id="dash_select" class="form-control">
                <?php 
                  if($sf_user->hasCredential("dashboard_farmacia")) {
                    echo "<option value='1'>Dash Farmacias</option>";
                  }
                  if($sf_user->hasCredential("dashboard_compras")) {
                    echo "<option value='2'>Dash Compras</option>";
                  }
                  if($sf_user->hasCredential("dashboard_compras")) {
                    echo "<option value='4'>Dash Incidencias Inventario</option>";
                  }
                  if($sf_user->hasCredential("dashboard_gerencia")) {
                    echo "<option value='3'>Dash Gerencia</option>";
                  }
                  echo "<option value='9999'>Inicio</option>";
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-sm-8">
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
              </div>
              <select id="dash_empresa" class="form-control" multiple required>
                <?php
                  $uid= $sf_user->getGuardUser()->getId();
                  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
                  $results = $q->execute("SELECT e.id, e.nombre, e.tipo
                    FROM empresa as e
                    LEFT JOIN empresa_user as eu ON (e.id=eu.empresa_id && eu.user_id=$uid)
                    WHERE 1
                    ORDER BY e.nombre ASC");
                  $i=0;
                  
                  $q->close();
                  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
                  $serverRs = $q->execute("SELECT srvid FROM server_name LIMIT 1");

                  $srvID = 0;

                  foreach($serverRs AS $srvRS){
                    $srvID = $srvRS["srvid"];
                  } 
                    
                  $srvID = explode(',', $srvID);
                  $srvID = $srvID[0];

                  foreach ($results as $result) {
                    $selected="";
                    /*if(($result["tipo"]==2 || $result["tipo"]==3) && $i==0) {
                      $selected="selected"; $i++; 
                    }*/

                    if($result["id"] == $srvID && $i == 0){
                      $selected="selected"; $i++;
                    }
                    echo "<option ".$selected." value='".$result["id"]."'>".$result["nombre"]."</option>";
                  }
                ?>
              </select>
              <span class="input-group-append">
                <input type="submit" value="Buscar!" class="btn btn-info btn-flat" />
              </span>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div id="dash_body">
    </div>
    <script>
      $(document).ready(function() {
        $("#dash_empresa").select2({ width: '70%', multiple: true });
        loadDash();
      });

      $("#buscar_dash").submit(function( event ) {
        loadDash();
        event.preventDefault();
      });

      function loadDash() {
        $('#loading').fadeIn( "slow", function() {});

        var id=$("#dash_select").val();
        var emp = [];
        $.each($("#dash_empresa option:selected"), function(){
          emp.push($(this).val());
        });
        switch(id) {
          case '1':
            $('#dash_body').load('<?php echo url_for('inicio/dashFarmacia') ?>?emp='+emp).fadeIn("slow");
            break;
          case '2':
            $('#dash_body').load('<?php echo url_for('inicio/dashCompras') ?>?emp='+emp).fadeIn("slow");
            break;
          case '3':
            $('#dash_body').load('<?php echo url_for('inicio/dashGerencia') ?>?emp='+emp).fadeIn("slow");
            break;
          case '4':
            $('#dash_body').load('<?php echo url_for('inicio/dashIncidenciaInv') ?>?emp='+emp).fadeIn("slow");
            break;
          case '9999':
            $('#dash_body').load('<?php echo url_for('inicio/dashHome') ?>?emp='+emp).fadeIn("slow");
            break;
        }
      }
      function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
          var k = Math.pow(10, prec);
          return '' + Math.round(n * k) / k;
        };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
      }
    </script>
    <style>
      .select2-container--default .select2-selection--multiple {
        border-radius: 0px !important;
      }
    </style>
  </div>
</section>
<script src="/js/moment.min2.js"></script>
<script src="/js/chart@next.js"></script>
<script src="/js/chartjs-adapter-moment@0.1.2.js"></script>