<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <?php
        $rec_pendings = Doctrine_Query::create()
          ->select('SUM(rp.monto) as money, COUNT(rp.id) as count')
          ->from('ReciboPago rp')
          ->Where('rp.anulado=0')
          ->andWhere('rp.created_at >= ?', date('Y/m'."/01")." 00:00:00")
          ->orderBy('rp.created_at ASC')
          ->execute();
          foreach ($rec_pendings as $rec_pending):
        ?>
        <h3><?php echo number_format($rec_pending["money"], 2, '.', ',') ?><sup style="font-size: 20px">$</sup></h3>
        <h4><?php echo $rec_pending["count"]; ?></h4>
        <?php endforeach; ?>
        <p><b>VENTAS EN EL MES</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-bag"></i>
      </div>
      <a href="<?php echo url_for("@recibo_pago")?>" class="small-box-footer">Mas Info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <?php
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $rec_pendings = $q->execute("select count(*) as total_records from (select count(*) as counts from cuentas_cobrar where estatus<>4 and created_at >= '".date('Y/m'."/01")." 00:00:00' "." group by cliente_id) tmp");
          foreach ($rec_pendings as $rec_pending):
        ?>
        <h3><?php echo number_format($rec_pending["total_records"], 2, '.', ',') ?><sup style="font-size: 20px"></sup></h3>
        <h4>CLIENTES</h4>
        <?php endforeach; ?>
        <p><b>ATENDIDOS EN EL MES</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-stats-bars"></i>
      </div>
      <a href="<?php echo url_for("@cuentas_cobrar")?>" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <?php
        $rec_pendings = Doctrine_Query::create()
          ->select('SUM(cc.monto_faltante) as money, COUNT(cc.id) as count')
          ->from('CuentasCobrar cc')
          ->Where('cc.estatus<3')
          ->andWhere('cc.created_at >= ?', date('Y/m'."/01")." 00:00:00")
          ->orderBy('cc.created_at ASC')
          ->execute();
          foreach ($rec_pendings as $rec_pending):
        ?>
        <h3><?php echo number_format($rec_pending["money"], 2, '.', ',') ?><sup style="font-size: 20px">$</sup></h3>
        <h4><?php echo $rec_pending["count"]; ?></h4>
        <?php endforeach; ?>
        <p><b>CUENTAS x COBRAR</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="<?php echo url_for("@cuentas_cobrar"); ?>" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
      <?php
        $rec_pendings = Doctrine_Query::create()
          ->select('SUM(cc.monto_faltante) as money, COUNT(cc.id) as count')
          ->from('CuentasPagar cc')
          ->Where('cc.estatus<3')
          ->andWhere('cc.created_at >= ?', date('Y/m'."/01")." 00:00:00")
          ->orderBy('cc.created_at ASC')
          ->execute();
          foreach ($rec_pendings as $rec_pending):
        ?>
        <h3><?php echo number_format($rec_pending["money"], 2, '.', ',') ?><sup style="font-size: 20px">$</sup></h3>
        <h4><?php echo $rec_pending["count"]; ?></h4>
        <?php endforeach; ?>
        <p><b>CUENTAS x PAGAR</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="<?php echo url_for("@cliente"); ?>" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex p-0">
        <h3 class="card-title p-3">
          <i class="fas fa-chart-line mr-1"></i>
          Facturación de ventas
        </h3>
      </div>
      <div class="card-body">
        <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
        <?php
        $mes = [1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'];
        $facts = Doctrine_Query::create()
          ->select('SUM(cc.total) as money, MONTH(cc.created_at) as mes')
          ->from('CuentasCobrar cc')
          ->Where('cc.estatus<>4')
          ->andWhere('cc.created_at >= ?', date('Y/m'."/01", strtotime("-6 months"))." 00:00:00")
          ->groupBy('mes')
          ->orderBy('cc.created_at ASC')
          ->execute();
          $data_fact="";
          $meses="";
          foreach ($facts as $fact) {
            $meses=$meses."'".$mes[$fact["mes"]]."', ";
            $data_fact=$data_fact.number_format(($fact["money"]), 0, '', '').", ";
          }
        $recibos = Doctrine_Query::create()
          ->select('SUM(rp.monto) as money, MONTH(rp.created_at) as mes')
          ->from('ReciboPago rp')
          ->Where('rp.anulado=0')
          ->andWhere('rp.created_at >= ?', date('Y/m'."/01", strtotime("-6 months"))." 00:00:00")
          ->groupBy('mes')
          ->orderBy('rp.created_at ASC')
          ->execute();
          $data_recibo="";
          foreach ($recibos as $recibo) {
            $data_recibo=$data_recibo.number_format(($recibo["money"]), 0, '', '').", ";
          }
        ?>
        <script>
          $(function() {
            'use strict';
            var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
            var salesChartData = {
              labels  : [<?php echo $meses ?>],
              datasets: [
                {
                  label               : 'Recibos de pago',
                  backgroundColor     : 'rgba(60,141,188,0.2)',
                  borderColor         : 'rgba(60,141,188,1)',
                  data                : [<?php echo $data_recibo; ?>]
                },
                {
                  label               : 'Facturacion',
                  backgroundColor     : 'rgba(40, 167, 69, 0.4)',
                  borderColor         : 'rgba(40, 167, 69, 1)',
                  data                : [<?php echo $data_fact; ?>]
                },
              ]
            }

            var salesChartOptions = {
              maintainAspectRatio : false,
              responsive : true,
              legend: {
                display: true
              },
              scales: {
                xAxes: [{
                  gridLines : {
                    display : false,
                  }
                }],
                yAxes: [{
                  gridLines : {
                    display : true,
                  }
                }]
              }
            }

            var salesChart = new Chart(salesChartCanvas, {
                type: 'line',
                data: salesChartData,
                options: salesChartOptions
              }
            )
          });
        </script>
      </div>
    </div>
  </div>
</div>

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
        <canvas id="contrato-zonas-chart" height="500" style="height: 500px;"></canvas>
        <?php
        $results = Doctrine_Query::create()
          ->select('pv.id as pvid, SUM(pv.cantidad) as qty, p.id as pid, p.nombre as pname')
          ->from('ProdVendidos pv')
          ->leftJoin('pv.Producto p')
          ->andWhere('pv.fecha >= ?', date('Y/m'."/01")." 00:00:00")
          ->AndWhere('pv.anulado=0')
          ->groupBy('pv.producto_id')
          ->orderBy('qty DESC')
          ->limit('12')
          ->execute();
        $contrat_zns = array();
        foreach ($results as $result) {
          @$contrat_zns[$result["pid"]]["nombre"]=$result["pname"];
          @$contrat_zns[$result["pid"]]["tot"]+=$result["qty"];
        }
        ?>
        <script>
          $(function () {
            'use strict'
            var pieChartCanvas = $('#contrato-zonas-chart').get(0).getContext('2d')
            var pieData        = {
                labels: [
                  <?php
                    foreach($contrat_zns as $contrat_zn) {
                      echo "'".$contrat_zn["nombre"]."', ";
                    }
                  ?>
                ],
                datasets: [
                  {
                    data: [<?php
                      foreach($contrat_zns as $contrat_zn) {
                        echo "".$contrat_zn["tot"].", ";
                      }
                    ?>],
                    backgroundColor : ['#ffc107', '#007bff', '#28a745', '#dc3545', '#6610f2', '#3c8dbc', '#ff851b', '#39cccc', '#e83e8c', '#001f3f', '#39cccc', '#d81b60'],
                  }
                ]
              }
              var pieOptions = {
                legend: {
                  display: false
                },
                maintainAspectRatio : false,
                responsive : true,
              }
              var pieChart = new Chart(pieChartCanvas, {
                type: 'bar',
                data: pieData,
                options: pieOptions
              });
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
          <div class="chart tab-pane active" id="vcategoria-principales" style="position: relative; height: 500px;">
            <canvas id="ventas-categoriap-chart" height="500" style="height: 500px;"></canvas>
            <?php
            $results = Doctrine_Query::create()
              ->select('pv.id as pvid, SUM(pv.cantidad) as qty, p.id as pid, c.id as cid, c.nombre as cname, SUBSTRING(c.codigo_full, 1, 2) as cod')
              ->from('ProdVendidos pv')
              ->leftJoin('pv.Producto p')
              ->leftJoin('p.ProdCategoria c')
              ->AndWhere('pv.fecha >= ?', date('Y/m'."/01")." 00:00:00")
              ->AndWhere('pv.anulado=0')
              ->groupBy('cod')
              ->orderBy('qty DESC')
              ->limit('12')
              ->execute();
            $contrat_zns = array();
            foreach ($results as $result) {
              $nombre=explode("/",$result["cname"]);
              @$contrat_zns[$result["pid"]]["nombre"]=current($nombre)." (".$result["qty"].")";
              @$contrat_zns[$result["pid"]]["tot"]+=$result["qty"];
            }
            ?>
            <script>
              $(function () {
                'use strict'
                var pieChartCanvas = $('#ventas-categoriap-chart').get(0).getContext('2d')
                var pieData        = {
                    labels: [
                      <?php
                        foreach($contrat_zns as $contrat_zn) {
                          echo "'".$contrat_zn["nombre"]."', ";
                        }
                      ?>
                    ],
                    datasets: [
                      {
                        data: [<?php
                          foreach($contrat_zns as $contrat_zn) {
                            echo "".$contrat_zn["tot"].", ";
                          }
                        ?>],
                        backgroundColor : ['#39cccc', '#ff851b'],
                      }
                    ]
                  }
                  var pieOptions = {
                    legend: {
                      display: true,
                      position: 'right'
                    },
                    maintainAspectRatio : false,
                    responsive : true,
                  }
                  var pieChart = new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                  });
              });
            </script>
          </div>
          <div class="chart tab-pane" id="vcategoria-desglosado" style="position: relative; height: 500px;">
            <canvas id="ventas-categoria-chart" height="500" style="height: 500px;"></canvas>
            <?php
            $results = Doctrine_Query::create()
              ->select('pv.id as pvid, SUM(pv.cantidad) as qty, p.id as pid, c.id as cid, c.nombre as cname')
              ->from('ProdVendidos pv')
              ->leftJoin('pv.Producto p')
              ->leftJoin('p.ProdCategoria c')
              ->AndWhere('pv.fecha >= ?', date('Y/m'."/01")." 00:00:00")
              ->AndWhere('pv.anulado=0')
              ->AndWhere('c.codigo_full LIKE "%-%"')
              ->groupBy('p.categoria_id')
              ->orderBy('qty DESC')
              ->limit('12')
              ->execute();
            $contrat_zns = array();
            foreach ($results as $result) {
              $nombre=explode("/",$result["cname"]);
              @$contrat_zns[$result["pid"]]["nombre"]=end($nombre)." (".$result["qty"].")";
              @$contrat_zns[$result["pid"]]["tot"]+=$result["qty"];
            }
            ?>
            <script>
              $(function () {
                'use strict'
                var pieChartCanvas = $('#ventas-categoria-chart').get(0).getContext('2d')
                var pieData        = {
                    labels: [
                      <?php
                        foreach($contrat_zns as $contrat_zn) {
                          echo "'".$contrat_zn["nombre"]."', ";
                        }
                      ?>
                    ],
                    datasets: [
                      {
                        data: [<?php
                          foreach($contrat_zns as $contrat_zn) {
                            echo "".$contrat_zn["tot"].", ";
                          }
                        ?>],
                        backgroundColor : ['#ffc107', '#007bff', '#28a745', '#dc3545', '#6610f2', '#3c8dbc', '#ff851b', '#39cccc', '#e83e8c', '#001f3f', '#39cccc', '#d81b60'],
                      }
                    ]
                  }
                  var pieOptions = {
                    legend: {
                      display: true,
                      position: 'right'
                    },
                    maintainAspectRatio : false,
                    responsive : true,
                  }
                  var pieChart = new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                  });
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
          <div class="chart tab-pane active" id="venta-presentacion" style="position: relative; height: 500px;">
            <canvas id="ventas-presentacion-chart" height="500" style="height: 500px;"></canvas>
            <?php
            $results = Doctrine_Query::create()
              ->select('pv.id as pvid, SUM(pv.cantidad) as qty, p.id as pid, pu.id as puid, pu.nombre as puname')
              ->from('ProdVendidos pv')
              ->leftJoin('pv.Producto p')
              ->leftJoin('p.ProdUnidad pu')
              ->AndWhere('pv.fecha >= ?', date('Y/m'."/01")." 00:00:00")
              ->AndWhere('pv.anulado=0')
              ->groupBy('puname')
              ->orderBy('qty DESC')
              ->limit('12')
              ->execute();
            $contrat_zns = array();
            foreach ($results as $result) {
              @$contrat_zns[$result["pid"]]["nombre"]=$result["puname"]." (".$result["qty"].")";
              @$contrat_zns[$result["pid"]]["tot"]+=$result["qty"];
            }
            ?>
            <script>
              $(function () {
                'use strict'
                var pieChartCanvas = $('#ventas-presentacion-chart').get(0).getContext('2d')
                var pieData        = {
                    labels: [
                      <?php
                        foreach($contrat_zns as $contrat_zn) {
                          echo "'".$contrat_zn["nombre"]."', ";
                        }
                      ?>
                    ],
                    datasets: [
                      {
                        data: [<?php
                          foreach($contrat_zns as $contrat_zn) {
                            echo "".$contrat_zn["tot"].", ";
                          }
                        ?>],
                        backgroundColor : ['#ffc107', '#007bff', '#28a745', '#dc3545', '#6610f2', '#3c8dbc', '#ff851b', '#39cccc', '#e83e8c', '#001f3f', '#39cccc', '#d81b60'],
                      }
                    ]
                  }
                  var pieOptions = {
                    legend: {
                      display: true,
                      position: 'right'
                    },
                    maintainAspectRatio : false,
                    responsive : true,
                  }
                  var pieChart = new Chart(pieChartCanvas, {
                    type: 'doughnut',
                    data: pieData,
                    options: pieOptions
                  });
              });
            </script>
          </div>
          <div class="chart tab-pane" id="venta-tipo" style="position: relative; height: 500px;">
            <canvas id="ventas-tipo-chart" height="500" style="height: 500px;"></canvas>
            <?php
            $results = Doctrine_Query::create()
              ->select('pv.id as pvid, SUM(pv.cantidad) as qty, p.id as pid, p.tipo as tipo')
              ->from('ProdVendidos pv')
              ->leftJoin('pv.Producto p')
              ->leftJoin('p.ProdUnidad pu')
              ->AndWhere('pv.fecha >= ?', date('Y/m'."/01")." 00:00:00")
              ->AndWhere('pv.anulado=0')
              ->groupBy('p.tipo')
              ->orderBy('qty DESC')
              ->execute();
            $contrat_zns = array();
            foreach ($results as $result) {
              if($result["tipo"]=="1") {
                $nombre="IMPORTADO";
              } else {
                $nombre="NACIONAL";
              }
              @$contrat_zns[$result["pid"]]["nombre"]=$nombre." (".$result["qty"].")";
              @$contrat_zns[$result["pid"]]["tot"]+=$result["qty"];
            }
            ?>
            <script>
              $(function () {
                'use strict'
                var pieChartCanvas = $('#ventas-tipo-chart').get(0).getContext('2d')
                var pieData        = {
                    labels: [
                      <?php
                        foreach($contrat_zns as $contrat_zn) {
                          echo "'".$contrat_zn["nombre"]."', ";
                        }
                      ?>
                    ],
                    datasets: [
                      {
                        data: [<?php
                          foreach($contrat_zns as $contrat_zn) {
                            echo "".$contrat_zn["tot"].", ";
                          }
                        ?>],
                        backgroundColor : ['#39cccc', '#ff851b'],
                      }
                    ]
                  }
                  var pieOptions = {
                    legend: {
                      display: true,
                      position: 'right'
                    },
                    maintainAspectRatio : false,
                    responsive : true,
                  }
                  var pieChart = new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: pieData,
                    options: pieOptions
                  });
              });
            </script>
          </div>
          <div class="chart tab-pane" id="venta-lab" style="position: relative; height: 500px;">
            <canvas id="ventas-lab-chart" height="500" style="height: 500px;"></canvas>
            <?php
            $results = Doctrine_Query::create()
              ->select('pv.id as pvid, SUM(pv.cantidad) as qty, p.id as pid, pl.id as plid, pl.nombre as plname')
              ->from('ProdVendidos pv')
              ->leftJoin('pv.Producto p')
              ->leftJoin('p.ProdLaboratorio pl')
              ->AndWhere('pv.fecha >= ?', date('Y/m'."/01")." 00:00:00")
              ->AndWhere('pv.anulado=0')
              ->andWhere('p.laboratorio_id IS NOT NULL')
              ->groupBy('p.laboratorio_id')
              ->orderBy('qty DESC')
              ->limit('12')
              ->execute();
            $contrat_zns = array();
            foreach ($results as $result) {
              @$contrat_zns[$result["pid"]]["nombre"]=$result["plname"]." (".$result["qty"].")";
              @$contrat_zns[$result["pid"]]["tot"]+=$result["qty"];
            }
            ?>
            <script>
              $(function () {
                'use strict'
                var pieChartCanvas = $('#ventas-lab-chart').get(0).getContext('2d')
                var pieData        = {
                    labels: [
                      <?php
                        foreach($contrat_zns as $contrat_zn) {
                          echo "'".$contrat_zn["nombre"]."', ";
                        }
                      ?>
                    ],
                    datasets: [
                      {
                        data: [<?php
                          foreach($contrat_zns as $contrat_zn) {
                            echo "".$contrat_zn["tot"].", ";
                          }
                        ?>],
                        backgroundColor : ['#ffc107', '#007bff', '#28a745', '#dc3545', '#6610f2', '#3c8dbc', '#ff851b', '#39cccc', '#e83e8c', '#001f3f', '#39cccc', '#d81b60'],
                      }
                    ]
                  }
                  var pieOptions = {
                    legend: {
                      display: true,
                      position: 'right'
                    },
                    maintainAspectRatio : false,
                    responsive : true,
                  }
                  var pieChart = new Chart(pieChartCanvas, {
                    type: 'doughnut',
                    data: pieData,
                    options: pieOptions
                  });
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<link rel="stylesheet" href="/plugins/datatables-old/dataTables.bootstrap4.css">
<script src="/plugins/datatables-old/jquery.dataTables.js"></script>
<script src="/plugins/datatables-old/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $('#data_inv_bajo').DataTable({
      "pageLength": 15,
      "lengthMenu": [[15, 30, 50, -1], [15, 30, 50, "∞"]],
       "order": [],
       "language": {
         "lengthMenu": "Mostrar _MENU_ registros",
         "zeroRecords":    "No se encontraron resultados",
         "info": "Mostrando pagina _PAGE_ de _PAGES_",
         "search": "Buscar:",
         "paginate": {
           "first":    "Primero",
           "last":     "Último",
           "next":     "Siguiente",
           "previous": "Anterior"
         },
         }
    });
  });
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>
<style>
  .tcaps {
    text-transform: capitalize;
  }
</style>