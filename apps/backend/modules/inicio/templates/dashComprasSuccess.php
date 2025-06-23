
<?php
  $emp=$sf_params->get('emp');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $fecha=date('Y/m'."/01")." 00:00:00";
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex p-0">
        <h3 class="card-title p-3">
          <i class="fas fa-map-signs mr-1"></i>
          Productos mas vendidos
        </h3>
      </div>
      <div class="card-body">
        <canvas id="top_productos" width="800px" height="260px"></canvas>
        <?php
          $results = $q->execute("SELECT SUM(pv.cantidad) as qty, p.id as pid, LOWER(p.nombre) as pname
            FROM prod_vendidos as pv
            LEFT JOIN producto as p ON pv.producto_id=p.id
            WHERE pv.anulado=0 && pv.fecha>='$fecha' && pv.empresa_id IN ($emp)
            GROUP by pv.producto_id
            ORDER BY qty DESC
            LIMIT 12");
          $contrat_zns = array();
          foreach ($results as $result) {
            @$contrat_zns[$result["pid"]]["nombre"]=ucwords($result["pname"]);
            @$contrat_zns[$result["pid"]]["tot"]+=$result["qty"];
          }
        ?>
        <script>
          $(function() {
            'use strict';
            var config = {
              type: 'bar',
              maintainAspectRatio: true,
              responsive: true,
              data: {
                labels: [<?php
                    foreach($contrat_zns as $contrat_zn) {
                      echo "'".$contrat_zn["nombre"]."', ";
                    }
                  ?>],
                datasets: [{
                  backgroundColor : ['#ffc107', '#007bff', '#28a745', '#dc3545', '#6610f2', '#3c8dbc', '#ff851b', '#39cccc', '#e83e8c', '#001f3f', '#39cccc', '#d81b60'],
                  data: [<?php
                      foreach($contrat_zns as $contrat_zn) {
                        echo "".$contrat_zn["tot"].", ";
                      }
                    ?>],
                  borderWidth: 1,
                }]
              },
              options: {
                scales: {
                  x: {
                    gridLines : {
                      display : false,
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 45
                    }
                  },
                  y: {
                    gridLines : {
                      display : true,
                    }
                  }
                },
                plugins: {
                  legend: {
                    display: false,
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
                        return number_format(context.parsed.y, 0, '', ',');
                      }
                    },
                  },
                }
              }
            };

            var ctx = document.getElementById("top_productos").getContext("2d");
            var line = new Chart(ctx, config);
            line.draw();
          });          
        </script>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header d-flex p-0">
        <h3 class="card-title p-3">
          <i class="fas fa-chart-pie mr-1"></i>
          Ventas por categoria
        </h3>
        <ul class="nav nav-pills ml-auto p-2">
          <li class="nav-item">
            <a class="nav-link active" href="#vcategoria-principales" data-toggle="tab">Principales</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#vcategoria-desglosado" data-toggle="tab">Desglosado</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content p-0">
          <div class="chart tab-pane active" id="vcategoria-principales" >
            <canvas id="ventas_categoriap_chart" height="175"></canvas>
            <?php
              $results = $q->execute("SELECT SUM(pv.cantidad) as qty, LOWER(c.nombre) as cname, SUBSTRING(c.codigo_full, 1, 2) as cod
                FROM prod_vendidos as pv
                LEFT JOIN producto as p ON pv.producto_id=p.id
                LEFT JOIN prod_categoria as c on p.categoria_id=c.id
                WHERE pv.anulado=0 && pv.fecha>='$fecha' && pv.empresa_id IN ($emp)
                GROUP by cod
                ORDER BY qty DESC
                LIMIT 12");
              $data = ""; $label="";
              foreach ($results as $result) {
                $nombre=explode("/",$result["cname"]);
                $data=$data.$result["qty"].", ";    
                $label=$label."'".ucwords(current($nombre))."',";
              }
            ?>
            <script>
              $(function() {
                'use strict';
                var config = {
                  type: 'pie',
                  data: {
                    labels: [<?php echo substr_replace($label, "", -1); ?>],
                    datasets: [{
                      backgroundColor : ['#39cccc', '#ff851b'],
                      data: [<?php echo substr_replace($data, "", -2); ?>],
                      hoverOffset: 2
                    }]
                  },
                  options: {
                    plugins: {
                      legend: {
                        display: true,
                        position: 'left',
                      },
                    }
                  }
                };                

                var ctx = document.getElementById("ventas_categoriap_chart").getContext("2d");
                var line = new Chart(ctx, config);
                line.draw();
              });
            </script>
          </div>
          <div class="chart tab-pane" id="vcategoria-desglosado">
            <canvas id="ventas_categoria_chart" height="175"></canvas>
            <?php
              $results = $q->execute("SELECT SUM(pv.cantidad) as qty, LOWER(c.nombre) as cname
                FROM prod_vendidos as pv
                LEFT JOIN producto as p ON pv.producto_id=p.id
                LEFT JOIN prod_categoria as c on p.categoria_id=c.id
                WHERE pv.anulado=0 && pv.fecha>='$fecha' && pv.empresa_id IN ($emp) && c.codigo_full LIKE '%-%'
                GROUP by p.categoria_id
                ORDER BY qty DESC
                LIMIT 12");
              $data = ""; $label="";
              foreach ($results as $result) {
                $nombre=explode("/",$result["cname"]);
                $data=$data.$result["qty"].", ";    
                $label=$label."'".ucwords(end($nombre))."',";
              }
            ?>
            <script>
              $(function() {
                'use strict';
                var config = {
                  type: 'pie',
                  data: {
                    labels: [<?php echo substr_replace($label, "", -1); ?>],
                    datasets: [{
                      backgroundColor : ['#ffc107', '#007bff', '#28a745', '#dc3545', '#6610f2', '#3c8dbc', '#ff851b', '#39cccc', '#e83e8c', '#001f3f', '#39cccc', '#d81b60'],
                      data: [<?php echo substr_replace($data, "", -2); ?>],
                      hoverOffset: 2
                    }]
                  },
                  options: {
                    plugins: {
                      legend: {
                        display: true,
                        position: 'left',
                      },
                    }
                  }
                };                

                var ctx = document.getElementById("ventas_categoria_chart").getContext("2d");
                var line = new Chart(ctx, config);
                line.draw();
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header d-flex p-0">
        <h3 class="card-title p-3">
          <i class="fas fa-chart-pie mr-1"></i>
          Ventas por
        </h3>
        <ul class="nav nav-pills ml-auto p-2">
          <li class="nav-item">
            <a class="nav-link active" href="#venta-presentacion" data-toggle="tab">Presentacion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#venta-tipo" data-toggle="tab">Tipo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#venta-lab" data-toggle="tab">Laboratorio</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content p-0">
          <div class="chart tab-pane active" id="venta-presentacion">
            <canvas id="ventas-presentacion-chart" height="175"></canvas>
            <?php
              $results = $q->execute("SELECT SUM(pv.cantidad) as qty, LOWER(pu.nombre) as puname
                FROM prod_vendidos as pv
                LEFT JOIN producto as p ON pv.producto_id=p.id
                LEFT JOIN prod_unidad as pu on p.unidad_id=pu.id
                WHERE pv.anulado=0 && pv.fecha>='$fecha' && pv.empresa_id IN ($emp)
                GROUP by puname
                ORDER BY qty DESC
                LIMIT 12");
              $data = ""; $label="";
              foreach ($results as $result) {
                $data=$data.$result["qty"].", ";    
                $label=$label."'".ucwords($result["puname"])."',";
              }
            ?>
            <script>
              $(function() {
                'use strict';
                var config = {
                  type: 'doughnut',
                  data: {
                    labels: [<?php echo substr_replace($label, "", -1); ?>],
                    datasets: [{
                      backgroundColor : ['#ffc107', '#007bff', '#28a745', '#dc3545', '#6610f2', '#3c8dbc', '#ff851b', '#39cccc', '#e83e8c', '#001f3f', '#39cccc', '#d81b60'],
                      data: [<?php echo substr_replace($data, "", -2); ?>],
                      hoverOffset: 2
                    }]
                  },
                  options: {
                    plugins: {
                      legend: {
                        display: true,
                        position: 'left',
                      },
                    }
                  }
                };                

                var ctx = document.getElementById("ventas-presentacion-chart").getContext("2d");
                var line = new Chart(ctx, config);
                line.draw();
              });
            </script>
          </div>
          <div class="chart tab-pane" id="venta-tipo">
            <canvas id="ventas-tipo-chart" height="175"></canvas>
            <?php
              $results = $q->execute("SELECT SUM(pv.cantidad) as qty, p.tipo as tipo
                FROM prod_vendidos as pv
                LEFT JOIN producto as p ON pv.producto_id=p.id
                WHERE pv.anulado=0 && pv.fecha>='$fecha' && pv.empresa_id IN ($emp)
                GROUP by tipo
                ORDER BY qty DESC
                LIMIT 12");
              $data = ""; $label="";
              foreach ($results as $result) {
                if($result["tipo"]=="1") {
                  $nombre="Importado";
                } else {
                  $nombre="Nacional";
                }

                $data=$data.$result["qty"].", ";    
                $label=$label."'".$nombre."',";
              }
            ?>
            <script>
              $(function() {
                'use strict';
                var config = {
                  type: 'pie',
                  data: {
                    labels: [<?php echo substr_replace($label, "", -1); ?>],
                    datasets: [{
                      backgroundColor : ['#39cccc', '#ff851b'],
                      data: [<?php echo substr_replace($data, "", -2); ?>],
                      hoverOffset: 2
                    }]
                  },
                  options: {
                    plugins: {
                      legend: {
                        display: true,
                        position: 'left',
                      },
                    }
                  }
                };                

                var ctx = document.getElementById("ventas-tipo-chart").getContext("2d");
                var line = new Chart(ctx, config);
                line.draw();
              });
            </script>
          </div>
          <div class="chart tab-pane" id="venta-lab">
            <canvas id="ventas-lab-chart" height="175"></canvas>
            <?php
              $results = $q->execute("SELECT SUM(pv.cantidad) as qty, pl.nombre as plname
                FROM prod_vendidos as pv
                LEFT JOIN producto as p ON pv.producto_id=p.id
                LEFT JOIN prod_laboratorio as pl ON p.laboratorio_id=pl.id
                WHERE pv.anulado=0 && pv.fecha>='$fecha' && pv.empresa_id IN ($emp) && p.laboratorio_id IS NOT NULL
                GROUP by p.laboratorio_id
                ORDER BY qty DESC
                LIMIT 12");
              $data = ""; $label="";
              foreach ($results as $result) {
                $data=$data.$result["qty"].", ";    
                $label=$label."'".$result["plname"]."',";
              }
            ?>
            <script>
              $(function() {
                'use strict';
                var config = {
                  type: 'doughnut',
                  data: {
                    labels: [<?php echo substr_replace($label, "", -1); ?>],
                    datasets: [{
                      backgroundColor : ['#ffc107', '#007bff', '#28a745', '#dc3545', '#6610f2', '#3c8dbc', '#ff851b', '#39cccc', '#e83e8c', '#001f3f', '#39cccc', '#d81b60'],
                      data: [<?php echo substr_replace($data, "", -2); ?>],
                      hoverOffset: 2
                    }]
                  },
                  options: {
                    plugins: {
                      legend: {
                        display: true,
                        position: 'left',
                      },
                    }
                  }
                };                

                var ctx = document.getElementById("ventas-lab-chart").getContext("2d");
                var line = new Chart(ctx, config);
                line.draw();
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>