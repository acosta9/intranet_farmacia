<?php
  $emp=$sf_params->get('emp');
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $results = $q->execute("SELECT COUNT(i.id) as qty, SUBSTRING(cat.codigo_full, 1, 2) as cod
    FROM inventario as i 
    LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
    LEFT JOIN producto as p on i.producto_id=p.id
    LEFT JOIN prod_categoria as cat ON p.categoria_id=cat.id
    WHERE id.tipo=1 && i.empresa_id IN($emp)
    GROUP BY cod");
  $data=array();
  foreach ($results as $result) {
    $cod=$result["cod"];
    $data[$cod]=$result["qty"];
  }

  $triggers = $q->execute("SELECT LOWER(e.acronimo) as ename, LOWER(id.acronimo) as idname,
    t.did as did, t.prodid as prodid,
    LOWER(cat.nombre) as catname, SUBSTRING(cat.codigo_full, 1, 2) as cod,
    SUM(i.cantidad>0) as invbajo, SUM(i.cantidad=0) as inv0
    FROM triggers as t 
    LEFT JOIN inventario as i ON (t.did=i.deposito_id && t.prodid=i.producto_id)
    LEFT JOIN empresa as e ON t.eid=e.id
    LEFT JOIN inv_deposito as id ON t.did=id.id
    LEFT JOIN producto as p on t.prodid=p.id
    LEFT JOIN prod_categoria as cat ON p.categoria_id=cat.id
    WHERE t.tipo=1 && t.estatus=1 && t.eid IN($emp)
    GROUP BY t.did, cod");
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <table class="table table-sm" id="listadoProd">
          <thead>
            <tr>
              <th>Empresa</th>
              <th>Deposito</th>
              <th>Categoria</th>
              <th style="text-align: center">Prods Inv Bajo</th>
              <th style="text-align: center">Prods Inv Cero</th>
              <th style="text-align: center">Prods Total</th>
              <th>Estatus</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($triggers as $item): ?>
              <tr>
                <td><small><?php echo $item["ename"]; ?></small></td>
                <td><small><?php echo $item["idname"]; ?></small></td>
                <td><small><?php echo ucwords(current(explode("/",$item["catname"]))); ?></small></td>
                <td style="text-align: center">
                  <a href='javascript:void(0)' onclick="incidencias(<?php echo $item['did'].','.$item['cod']; ?>,1)">
                    <?php echo $warning=$item["invbajo"]; ?>
                  </a>
                </td>
                <td style="text-align: center">
                  <a href='javascript:void(0)' onclick="incidencias(<?php echo $item['did'].','.$item['cod']; ?>,2)">
                    <?php echo $offline=$item["inv0"]; ?>
                  </a>
                </td>
                <td style="text-align: center"><?php echo $total=$data[$item["cod"]]; ?></td>
                <td class="project_progress">
                  <?php 
                    $warningPercent=round(($warning*100)/$total);
                    $offlinePercent=round(($offline*100)/$total);
                    $successPercent=100-($warningPercent+$offlinePercent);
                  ?>
                  <span style="display:none"><?php echo $successPercent; ?></span>
                  <div class="progress">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $warningPercent."%"; ?>" aria-valuenow="<?php echo $warningPercent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $offlinePercent."%"; ?>" aria-valuenow="<?php echo $offlinePercent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $successPercent."%"; ?>" aria-valuenow="<?php echo $successPercent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
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
          Historico incidencias inventario
        </h3>
      </div>
      <div class="card-body">
        <canvas id="incidencias-inventario-dia" width="800px" height="160px"></canvas>
        <?php
          $mes = [1=>'Ene', 2=>'Feb', 3=>'Mar', 4=>'Abr', 5=>'May', 6=>'Jun', 7=>'Jul', 8=>'Ago', 9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Dic'];
        
          $fecha3=strtotime("-1 months");
          $query = $q->execute("SELECT DAYOFYEAR(FROM_UNIXTIME(open_unixtime)) as dia, 
            SUM(cantidad>0) as warning, SUM(cantidad=0) as danger,
            closed.invbajo as closewarning, closed.inv0 as closedanger
            FROM triggers, 
              (
                SELECT DAYOFYEAR(FROM_UNIXTIME(t.close_unixtime)) as cdia, 
                SUM(t.cantidad>0) as invbajo, SUM(t.cantidad=0) as inv0
                FROM triggers as t 
                WHERE t.tipo=1 && t.open_unixtime>=$fecha3 && t.eid IN($emp)
                GROUP BY DAYOFYEAR(FROM_UNIXTIME(t.close_unixtime))
              ) as closed
            WHERE DAYOFYEAR(FROM_UNIXTIME(open_unixtime))=closed.cdia && open_unixtime>=$fecha3 && eid IN($emp)
            GROUP BY dia");

          $data_mes=array(); $data_warning = array(); $data_danger = array();
          $oldW=0; $oldD=0;
          foreach ($query as $item) {
            $dia=$item["dia"];

            $data_mes[$dia]=dayofyear2date($item["dia"]-1);
            $data_warning[$dia]=($item["warning"]-$item["closewarning"])+$oldW;
            $data_danger[$dia]=($item["danger"]-$item["closedanger"])+$oldD;

            $oldW=$data_warning[$dia];
            $oldD=$data_danger[$dia];
          }
          array_pop($data_mes);
          array_pop($data_warning);
          array_pop($data_danger);
        ?>
        <script>
          $(function() {
            'use strict';
            var config = {
              type: 'line',
              maintainAspectRatio: true,
              responsive: true,
              data: {
                labels: [<?php echo "'".implode("','",$data_mes)."'"; ?>],
                datasets: [{
                  label               : 'Inv Cero',
                  backgroundColor     : 'rgb(220, 53, 69, 0.3)',
                  borderColor         : 'rgba(220, 53, 69, 1)',
                  data                : [<?php echo implode(",",$data_danger); ?>],
                  borderWidth: 1.5,
                  fill: true,
                  lineTension: 0.2,
                  radius: 4
                },{
                  label               : 'Inv Bajo',
                  backgroundColor     : 'rgba(255,205,6,0.3)',
                  borderColor         : 'rgba(255,205,6,1)',
                  data                : [<?php echo implode(",",$data_warning); ?>],
                  borderWidth: 1.5,
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
                    text:'Incidencias inventario por dia'
                  },
                  tooltip: {
                    mode: 'nearest',
                    intersect: true,
                  },
                },
                hover: {
                  mode: 'nearest',
                  intersect: true
                }
              }
            };
            var ctx = document.getElementById("incidencias-inventario-dia").getContext("2d");
            var line = new Chart(ctx, config);
            line.draw();
          });
        </script>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_procesar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="container-fluid" id="procesar">
        </div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="/plugins/datatables/datatables.min.css">
<script src="/plugins/datatables/datatables.min.js"></script>
<script src="/plugins/datatables/ellipsis.js"></script>
<script src="/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="/plugins/datatables/jszip.min.js"></script>
<script src="/plugins/datatables/buttons.html5.min.js"></script>

<script>
  $(document).ready(function(){
    $('#listadoProd').DataTable( {
      columnDefs: [
        {
          targets: 6,
          "visible": true,
          "searchable": false,
          "orderable": false,
          render: function ( data, type, row ) {
            if ( type === 'display' || type === 'filter' ) {
              return data;
            }
            return "";
          }
        },
      ],
      "lengthMenu": [[20, 50, 100, 200, 500, -1], [20, 50, 100, 200, 500, "Todos"]],
      "order": [],
      "language": {
        "lengthMenu": "Mostrar _MENU_ registros",
        "zeroRecords":    "No se encontraron resultados",
        "info": "Mostrando pagina _PAGE_ de _PAGES_ de _TOTAL_ registro(s)",
        "infoFiltered": "(filtrado de _MAX_ total de registro(s))",
        "search": "",
        "paginate": {
          "first":    "Primero",
          "last":     "Último",
          "next":     "Siguiente",
          "previous": "Anterior"
        },
      },
      dom: 'lBfrtip',
      buttons: [
        {
          extend: 'excelHtml5',
          className: 'btn btn-success ml-3',
          text: 'Exportar Excel',
          title: 'Incidencias Inventario',
          exportOptions: {
            columns: ':visible',
            orthogonal: 'export' 
          }
        },
      ]
    });

    $('#listadoProd_filter input').addClass('form-control');
    $("#listadoProd_filter input").attr("placeholder", "Buscar...");
    $('#loading').fadeOut( "slow", function() {});
  });
  function incidencias(did, cod, tipo) {
    $('#procesar').hide();
    $('#procesar').load('<?php echo url_for('inicio/incidencias') ?>?did='+did+'&cod='+cod+'&tipo='+tipo).fadeIn("slow");
  }
</script>

<style>
  .buttons-html5 {
    border-radius: 0px !important;
  }
  .dt-buttons {
    float: right;
  }
  #listadoProd_filter input {
    width: 20rem !important;
  }
  #detalle_incidencia_filter input {
    width: 15rem !important;
  }
  .modal-lg {
    max-width: 80% !important;
  }
</style>
<?php
  function dayofyear2date( $tDay, $tFormat = 'd/m' ) {
    $day = intval( $tDay );
    $day = ( $day == 0 ) ? $day : $day - 1;
    $offset = intval( intval( $tDay ) * 86400 );
    $str = date( $tFormat, strtotime( 'Jan 1, ' . date( 'Y' ) ) + $offset );
    return( $str );
  }
?>