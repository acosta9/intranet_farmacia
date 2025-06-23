<?php
  $emp=$sf_params->get('emp');
?>

<?php
  $fecha=date('Y/m'."/01")." 00:00:00";
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $query = $q->execute("SELECT SUM(rp.monto) as money, COUNT(DISTINCT rp.cuentas_cobrar_id) as count
    FROM recibo_pago as rp
    WHERE rp.anulado=0 && rp.empresa_id IN($emp) && rp.created_at>='$fecha'
    ORDER BY rp.created_at ASC");
  $ventas = $query->fetchAll();

  $query = $q->execute("SELECT count(*) as total_records 
    FROM (SELECT count(*) as counts FROM cuentas_cobrar 
        WHERE estatus<>4 && empresa_id IN ($emp) && created_at >= '$fecha' group by cliente_id) tmp");
  $clientes = $query->fetchAll();

  $query = $q->execute("SELECT SUM(i.cantidad) as qty
    FROM inventario as i
    LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
    WHERE i.empresa_id IN ($emp) && id.tipo=1");
  $invPventa = $query->fetchAll();

  $query = $q->execute("SELECT SUM(i.cantidad) as qty
    FROM inventario as i
    LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
    WHERE i.empresa_id IN ($emp) && id.nombre LIKE '%transicion%'");
  $invTrans = $query->fetchAll();

//se agrega las estadistica del dia actual  MD
// Ventas del dia


  $fechan=date('Y/m/d')." 00:00:00";
    
    $query = $q->execute("SELECT SUM(rp.monto) as money, COUNT(DISTINCT rp.cuentas_cobrar_id) as count
    FROM recibo_pago as rp
    WHERE rp.anulado=0 && rp.empresa_id IN($emp) && rp.created_at>='$fechan'
    ORDER BY rp.created_at ASC");
    
    $ventash = $query->fetchAll();

    $query = $q->execute("SELECT count(*) as total_records 
    FROM (SELECT count(*) as counts FROM cuentas_cobrar 
    WHERE estatus<>4 && empresa_id IN ($emp) && created_at >= '".date('Y/m/d')." 00:00:00' "." group by cliente_id) tmp");
    
    $clientesh = $query->fetchAll();

    $query = $q->execute("SELECT 
    ROUND((SUM((fd.price_unit * fd.qty)) - SUM((p.costo_usd_1 * fd.qty))),4) AS util_usd,
    ROUND((SUM((fd.price_unit * fd.qty)) - SUM((p.costo_usd_1 * fd.qty))) / SUM((fd.price_unit * fd.qty)) * 100, 2) AS util_neta 
    from factura  AS f 
    INNER JOIN factura_det AS fd ON f.id = fd.factura_id
    INNER JOIN inventario  AS i ON fd.inventario_id = i.id
    INNER JOIN producto    AS p ON i.producto_id = p.id
    where f.empresa_id IN ($emp)
    AND f.created_at >= '".date('Y/m/d')." 00:00:00' ");

    $utilidah = $query->fetchAll();

?>

<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?php echo number_format($ventas[0]["money"], 2, '.', ',') ?><sup style="font-size: 20px">$</sup></h3>
        <h4><?php echo $ventas[0]["count"]; ?></h4>
        <p><b>FACTURAS EMITIDAS EN EL MES</b></p>
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
        <h3><?php echo number_format($clientes[0]["total_records"], 2, '.', ',') ?><sup style="font-size: 20px"></sup></h3>
        <h4>CLIENTES</h4>
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
        <h3><?php echo number_format($invPventa[0]["qty"], 2, '.', ',') ?><sup style="font-size: 20px"> Units</sup></h3>
        <h4>INVENTARIO</h4>
        <p><b>PISO DE VENTA</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="<?php echo url_for("@inventario"); ?>" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?php echo number_format($invTrans[0]["qty"], 2, '.', ',') ?><sup style="font-size: 20px"> Units</sup></h3>
        <h4>INVENTARIO</h4>
        <p><b>TRANSICION</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="<?php echo url_for("@inventario"); ?>" class="small-box-footer">Mas info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="row">    
    
      <div class="col-lg-4 col-6">
        <div class="small-box bg-secondary">
          <div class="inner">
            <h3><?php echo number_format($ventash[0]["money"], 2, '.', ',') ?><sup style="font-size: 20px">$</sup></h3>
            <h4><?php echo $ventash[0]["count"]; ?></h4>
            <p><b>FACTURAS EMITIDAS DEL DIA</b></p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
        </div>
      </div>

        <div class="col-lg-4 col-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3><?php echo number_format($clientesh[0]["total_records"], 2, '.', ',') ?><sup style="font-size: 20px"></sup></h3>
              <h4>CLIENTES</h4>
              <p><b>ATENDIDOS EN EL DIA</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo number_format($utilidah[0]["util_usd"], 2, '.', ',') ?><sup style="font-size: 20px">$</sup></h3>
              <h4><?php echo number_format($utilidah[0]["util_neta"], 2, '.', ',') ?>%</h4>
              <p><b>UTILIDAD DEL DIA</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
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
        <canvas id="revenue-chart" width="800px" height="160px"></canvas>
        <?php
          $fecha2=date('Y/m'."/01", strtotime("-6 months"))." 00:00:00";
          $mes = [1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'];
          $facts = $q->execute("SELECT SUM(cc.total) as money, MONTH(cc.created_at) as mes
            FROM cuentas_cobrar as cc
            WHERE cc.estatus<>4 && cc.created_at>='$fecha2' && cc.empresa_id IN ($emp)
            GROUP by mes
            ORDER BY cc.created_at ASC");
          $data_fact="";
          $meses="";
          foreach ($facts as $fact) {
            $meses=$meses."'".$mes[$fact["mes"]]."', ";
            $data_fact=$data_fact.number_format(($fact["money"]), 0, '', '').", ";
          }
          $recibos = $q->execute("SELECT SUM(rp.monto) as money, MONTH(rp.created_at) as mes
            FROM recibo_pago as rp
            WHERE rp.anulado=0 && rp.created_at>='$fecha2' && rp.empresa_id IN ($emp)
            GROUP by mes
            ORDER BY rp.created_at ASC");
          $data_recibo="";
          foreach ($recibos as $recibo) {
            $data_recibo=$data_recibo.number_format(($recibo["money"]), 0, '', '').", ";
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
                  label               : 'Recibos de pago',
                  backgroundColor     : 'rgba(60,141,188,0.2)',
                  borderColor         : 'rgba(60,141,188,1)',
                  data                : [<?php echo $data_recibo; ?>],
                  borderWidth: 1.2,
                  fill: true,
                  lineTension: 0.2,
                  radius: 4
                },{
                  label               : 'Facturacion',
                  backgroundColor     : 'rgba(40, 167, 69, 0.4)',
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

            var ctx = document.getElementById("revenue-chart").getContext("2d");
            var line = new Chart(ctx, config);
            line.draw();
          });
        </script>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header d-flex p-0">
        <h3 class="card-title p-3">
          <i class="fas fa-chart-line mr-1"></i>
          Facturacion x Cajero (Dinero)
        </h3>
      </div>
      <div class="card-body">
        <canvas id="barChartFactMoney"></canvas>
        <?php
          $query = $q->execute("SELECT count(f.id) as cant, SUM(f.total) as total, u.full_name as fname
            FROM factura as f
            LEFT JOIN sf_guard_user as u ON f.created_by=u.id
            WHERE f.empresa_id IN ($emp) && f.created_at>='$fecha'
            GROUP BY f.created_by");
          $users=""; $data_cant=""; $data_tot="";  
          foreach ($query as $item) {
            $users=$users."'".$item["fname"]."',";
            $data_cant=$data_cant.round($item["cant"]).",";
            $data_tot=$data_tot.round($item["total"]).",";
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
                labels: [<?php echo $users; ?>],
                datasets: [{
                  label: "Dinero",
                  backgroundColor     : 'rgba(40, 167, 69, 0.3)',
                  borderColor         : 'rgba(40, 167, 69, 1)',
                  data: [<?php echo substr_replace($data_cant, "", -1); ?>],
                  borderWidth: 1,
                }]
              },
              options: {
                indexAxis: 'y',
                scales: {
                  x: {
                    gridLines : {
                      display : true,
                    }
                  },
                  y: {
                    gridLines : {
                      display : false,
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
                        if (context.parsed.x !== null) {
                          label += context.parsed.x;
                        }
                        return number_format(context.parsed.x, 0, '', ',')+'$';
                      }
                    },
                  },
                }
              }
            };

            var ctx = document.getElementById("barChartFactMoney").getContext("2d");
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
          <i class="fas fa-chart-line mr-1"></i>
          Facturacion x Cajero (Cantidad)
        </h3>
      </div>
      <div class="card-body">
        <canvas id="barChartFactCant" style="height:100px"></canvas>
        <script>
          $(function() {
            'use strict';
            var config = {
              type: 'bar',
              maintainAspectRatio: true,
              responsive: true,
              data: {
                labels: [<?php echo $users; ?>],
                datasets: [{
                  label: "Cantidad",
                  backgroundColor     : 'rgba(60,141,188,0.2)',
                  borderColor         : 'rgba(60,141,188,1)',
                  data: [<?php echo substr_replace($data_tot, "", -1); ?>],
                  borderWidth: 1,
                }]
              },
              options: {
                indexAxis: 'y',
                scales: {
                  x: {
                    gridLines : {
                      display : true,
                    }
                  },
                  y: {
                    gridLines : {
                      display : false,
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
                        if (context.parsed.x !== null) {
                          label += context.parsed.x;
                        }
                        return number_format(context.parsed.x, 0, '', ',')+' Facturas';
                      }
                    },
                  },
                }
              }
            };

            var ctx = document.getElementById("barChartFactCant").getContext("2d");
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