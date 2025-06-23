<?php
  $emp=$sf_params->get('emp');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex p-0">
        <h3 class="card-title p-3">
          <i class="fas fa-chart-line mr-1"></i>
          Compras vs Ventas (Unidades)
        </h3>
      </div>
      <div class="card-body">
        <canvas id="revenue-chart" width="800px" height="160px"></canvas>
        <?php
          $fecha2=date('2021/01'."/01", strtotime("-6 months"))." 00:00:00";
          $mes = [1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'];
          $facts = $q->execute("SELECT SUM(pv.price_tot) as total, SUM(pv.cantidad) as cant, MONTH(pv.fecha) as mes
            FROM prod_vendidos as pv
            WHERE pv.anulado=0 && pv.fecha>='$fecha2' && pv.empresa_id IN ($emp)
            GROUP by mes
            ORDER BY pv.fecha ASC");
          $data_fact=""; $data_fact2="";
          $meses="";
          foreach ($facts as $fact) {
            $meses=$meses."'".$mes[$fact["mes"]]."', ";
            $data_fact=$data_fact.number_format(($fact["cant"]), 0, '', '').", ";
            $data_fact2=$data_fact2.number_format(($fact["total"]), 0, '', '').", ";
          }
          $recibos = $q->execute("SELECT SUM(fcd.price_tot) as total, SUM(fcd.qty) as cant, MONTH(fc.fecha_recepcion) as mes
            FROM factura_compra_det as fcd
            LEFT JOIN factura_compra as fc ON fcd.factura_compra_id=fc.id
            WHERE fc.estatus<>4 && fc.fecha_recepcion>='$fecha2' && fc.empresa_id IN ($emp) && fcd.price_unit<=5000
            GROUP by mes
            ORDER BY fc.fecha_recepcion ASC");
          $data_recibo=""; $data_recibo2="";
          foreach ($recibos as $recibo) {
            $data_recibo=$data_recibo.number_format(($recibo["cant"]), 0, '', '').", ";
            $data_recibo2=$data_recibo2.number_format(($recibo["total"]), 0, '', '').", ";
          }
        ?>
        <script>
          $(function() {
            'use strict';
            var config = {
              type: 'line',
              maintainAspectRatio: true,
              responsive: true,
              data: {
                labels: [<?php echo $meses; ?>],
                datasets: [{
                  label               : 'Compras',
                  backgroundColor     : 'rgb(220, 53, 69, 0.4)',
                  borderColor         : 'rgba(220, 53, 69, 1)',
                  data                : [<?php echo $data_recibo; ?>],
                  borderWidth: 1.2,
                  fill: true,
                  lineTension: 0.2,
                  radius: 4
                },{
                  label               : 'Ventas',
                  backgroundColor     : 'rgba(40, 167, 69, 0.3)',
                  borderColor         : 'rgba(40, 167, 69, 1)',
                  data                : [<?php echo $data_fact; ?>],
                  borderWidth: 1.2,
                  fill: true,
                  lineTension: 0.2,
                  radius: 4
                }]
              },
              options: {
                scales: {
                  x: {
                    gridLines : {
                      display : false,
                    }
                  },
                  y: {
                    gridLines : {
                      display : true,
                    }
                  }
                },
                plugins: {
                  title:{
                    display:false,
                    text:'Facturacion'
                  },
                  tooltip: {
                    mode: 'nearest',
                    intersect: false,
                    callbacks: {
                      label: function(context) {
                        var label = context.dataset.label || '';
                        if (label) {
                          label += ': ';
                        }
                        if (context.parsed.y !== null) {
                          label += context.parsed.y;
                        }
                        return number_format(context.parsed.y, 0, '', ',')+" Units";
                      }
                    },
                  },
                },
                hover: {
                  mode: 'nearest',
                  intersect: true
                }
              }
            };

            var ctx = document.getElementById("revenue-chart").getContext("2d");
            var line = new Chart(ctx, config);
            line.draw();
          });
        </script>
      </div>
    </div>
  </div>
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex p-0">
        <h3 class="card-title p-3">
          <i class="fas fa-chart-line mr-1"></i>
          Compras vs Ventas (Dinero)
        </h3>
      </div>
      <div class="card-body">
        <canvas id="revenue-chart2" width="800px" height="160px"></canvas>
        <script>
          $(function() {
            'use strict';
            var config = {
              type: 'line',
              maintainAspectRatio: true,
              responsive: true,
              data: {
                labels: [<?php echo $meses; ?>],
                datasets: [{
                  label               : 'Compras',
                  backgroundColor     : 'rgb(220, 53, 69, 0.4)',
                  borderColor         : 'rgba(220, 53, 69, 1)',
                  data                : [<?php echo $data_recibo2; ?>],
                  borderWidth: 1.2,
                  fill: true,
                  lineTension: 0.2,
                  radius: 4
                },{
                  label               : 'Ventas',
                  backgroundColor     : 'rgba(40, 167, 69, 0.3)',
                  borderColor         : 'rgba(40, 167, 69, 1)',
                  data                : [<?php echo $data_fact2; ?>],
                  borderWidth: 1.2,
                  fill: true,
                  lineTension: 0.2,
                  radius: 4
                }]
              },
              options: {
                scales: {
                  x: {
                    gridLines : {
                      display : false,
                    }
                  },
                  y: {
                    gridLines : {
                      display : true,
                    }
                  }
                },
                plugins: {
                  title:{
                    display:false,
                    text:'Facturacion'
                  },
                  tooltip: {
                    mode: 'nearest',
                    intersect: false,
                    callbacks: {
                      label: function(context) {
                        var label = context.dataset.label || '';
                        if (label) {
                          label += ': ';
                        }
                        if (context.parsed.y !== null) {
                          label += context.parsed.y;
                        }
                        return number_format(context.parsed.y, 0, '', ',')+"$";
                      }
                    },
                  },
                },
                hover: {
                  mode: 'nearest',
                  intersect: true
                }
              }
            };

            var ctx = document.getElementById("revenue-chart2").getContext("2d");
            var line = new Chart(ctx, config);
            line.draw();
          });
        </script>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>