<?php

$fecha=date('Y-m-d');
$dep=$sf_params->get('dep');
$cat=$sf_params->get('cat');
$pre=$sf_params->get('pre');
$tipo=$sf_params->get('tipo');
$prodId=$sf_params->get('prodId');
$fechames=$sf_params->get('fecham');
$fechaano=$sf_params->get('fechaa');
$proveedor=$sf_params->get('provId');
$tiempo=10;

switch ($fechames) {
  case 0:
      $fdesde=$fechaano.'-01-01';
      $fhasta=$fechaano.'-01-31';
  break;
  case 1:
    $fdesde=$fechaano.'-02-01';
    $fhasta=$fechaano.'-02-28'; 
  break;
  case 2:
    $fdesde=$fechaano.'-03-01';
    $fhasta=$fechaano.'-03-31';  
  break;

  case 3:
    $fdesde=$fechaano.'-04-01';
    $fhasta=$fechaano.'-04-30';
  break;

  case 4:
    $fdesde=$fechaano.'-05-01';
    $fhasta=$fechaano.'-05-31';
    break;
  
  case 5:
    $fdesde=$fechaano.'-06-01';
    $fhasta=$fechaano.'-06-30';
    break;

  case 6:
    $fdesde=$fechaano.'-07-01';
    $fhasta=$fechaano.'-07-31';
    break;
  
  case 7:
    $fdesde=$fechaano.'-08-01';
    $fhasta=$fechaano.'-08-31';
    break;

  case 8:
    $fdesde=$fechaano.'-09-01';
    $fhasta=$fechaano.'-09-30';
    break;
  
  case 9:
    $fdesde=$fechaano.'-10-01';
    $fhasta=$fechaano.'-10-31';
    break;
  
  case 10:
    $fdesde=$fechaano.'-11-01';
    $fhasta=$fechaano.'-11-30';    
    break;
  
  case 11:
    $fdesde=$fechaano.'-12-01';
    $fhasta=$fechaano.'-12-31';
    break;
  
  default:
    echo  "Error en la Fecha Seleccionada" ;
    break;
}


$depQuery=" i.deposito_id='$dep'";
//$depUltQuery=" && inv.deposito_id='$dep'";

$desdeQuery=" and f.fecha between '$fdesde' and '$fhasta' ";
//$hastaQueryOld=" && k.fecha < '$fdesde"." 00:00:00'";

$prodQuery=""; $prodQueryCD="";
if(!empty($prodId)) {
  $prodQuery=" && i.producto_id='$prodId'";
 // $prodQueryCD=" && i.producto_id='$prodId'";
}

$catQuery="";
if(!empty($cat)) {
  $catQuery=" && p.categoria_id = '$cat' ";
}

$preQuery="";
if(!empty($pre)) {
  $pre=str_replace(",","','",$pre);
  $preQuery=" && p.unidad_id IN ('$pre')";
}

$tipoQuery="";
if($tipo!="z") {
  $tipoQuery=" && p.tipo='$tipo' ";
}

$provQuery="";
if (!empty($proveedor)) {
  $provQuery = " && p.laboratorio_id = '$proveedor' ";
}
//$fdesde = "2021-08-01";
//$fhasta = "2021-08-31";
$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$kardex = $q->execute("SELECT p.nombre as pnombre, p.serial as pserial,
sum(case day(f.fecha) when 1 then fd.qty else 0 end) as dia_1,
sum(case day(f.fecha) when 2 then fd.qty else 0 end) as dia_2,
sum(case day(f.fecha) when 3 then fd.qty else 0 end) as dia_3,
sum(case day(f.fecha) when 4 then fd.qty else 0 end) as dia_4,
sum(case day(f.fecha) when 5 then fd.qty else 0 end) as dia_5,
sum(case day(f.fecha) when 6 then fd.qty else 0 end) as dia_6,
sum(case day(f.fecha) when 7 then fd.qty else 0 end) as dia_7,
sum(case day(f.fecha) when 8 then fd.qty else 0 end) as dia_8,
sum(case day(f.fecha) when 9 then fd.qty else 0 end) as dia_9,
sum(case day(f.fecha) when 10 then fd.qty else 0 end) as dia_10,
sum(case day(f.fecha) when 11 then fd.qty else 0 end) as dia_11,
sum(case day(f.fecha) when 12 then fd.qty else 0 end) as dia_12,
sum(case day(f.fecha) when 13 then fd.qty else 0 end) as dia_13,
sum(case day(f.fecha) when 14 then fd.qty else 0 end) as dia_14,
sum(case day(f.fecha) when 15 then fd.qty else 0 end) as dia_15,
sum(case day(f.fecha) when 16 then fd.qty else 0 end) as dia_16,
sum(case day(f.fecha) when 17 then fd.qty else 0 end) as dia_17,
sum(case day(f.fecha) when 18 then fd.qty else 0 end) as dia_18,
sum(case day(f.fecha) when 19 then fd.qty else 0 end) as dia_19,
sum(case day(f.fecha) when 20 then fd.qty else 0 end) as dia_20,
sum(case day(f.fecha) when 21 then fd.qty else 0 end) as dia_21,
sum(case day(f.fecha) when 22 then fd.qty else 0 end) as dia_22,
sum(case day(f.fecha) when 23 then fd.qty else 0 end) as dia_23,
sum(case day(f.fecha) when 24 then fd.qty else 0 end) as dia_24,
sum(case day(f.fecha) when 25 then fd.qty else 0 end) as dia_25, 
sum(case day(f.fecha) when 26 then fd.qty else 0 end) as dia_26,
sum(case day(f.fecha) when 27 then fd.qty else 0 end) as dia_27,
sum(case day(f.fecha) when 28 then fd.qty else 0 end) as dia_28,
sum(case day(f.fecha) when 29 then fd.qty else 0 end) as dia_29,
sum(case day(f.fecha) when 30 then fd.qty else 0 end) as dia_30,
sum(case day(f.fecha) when 31 then fd.qty else 0 end) as dia_31,
sum(fd.qty) as total
FROM factura as f 
inner join factura_det as fd on (f.id=fd.factura_id) 
inner join inventario as i on (fd.inventario_id = i.id)
inner join producto as p on (i.producto_id=p.id)
where $depQuery $desdeQuery $prodQuery $catQuery $tipoQuery $preQuery $provQuery
group by p.nombre, p.serial
order by p.nombre");

$i=0;

?>

<table id="listadoProd" class="cell-border compact stripe" style="width:100%">
  <thead>
    <tr>
      <th class="first-col">Serial</th>
      <th class="first-col">Nombre</th>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>4</th>
      <th>5</th>
      <th>6</th>
      <th>7</th>
      <th>8</th>
      <th>9</th>
      <th>10</th>
      <th>11</th>
      <th>12</th>
      <th>13</th>
      <th>14</th>
      <th>15</th>
      <th>16</th>
      <th>17</th>
      <th>18</th>
      <th>19</th>
      <th>20</th>
      <th>21</th>
      <th>22</th>
      <th>23</th>
      <th>24</th>
      <th>25</th>
      <th>26</th>
      <th>27</th>
      <th>28</th>
      <th>29</th>
      <th>30</th>
      <th>31</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($kardex as $item): ?>
      <?php
        $go=1;
        /*if(!empty($proveedor)) {
          if(empty($prodsInfo[$item["prodId"]]["provId"])) {
            $go=0;
          } else if($proveedor!=$prodsInfo[$item["prodId"]]["provId"]) {
            $go=0;
          }
        }
        $provId="0";
        if(!empty($prodsInfo[$item["prodId"]]["provId"])) {
          $provId=$prodsInfo[$item["prodId"]]["provId"];
          if($prodsInfo[$item["prodId"]]["provTipo"]=="1") {
            $provId="0";
          }
        }*/

      ?>
      <?php if($go==1): ?>
        <tr>
          <td><?php echo ucwords($item["pserial"]); ?></td>
          <td><?php echo $item["pnombre"]; ?></td>
          <td><?php echo $item["dia_1"];  ?></td>
          <td><?php echo $item["dia_2"];  ?></td>
          <td><?php echo $item["dia_3"];  ?></td>
          <td><?php echo $item["dia_4"];  ?></td>
          <td><?php echo $item["dia_5"];  ?></td>   
          <td><?php echo $item["dia_6"];  ?></td>   
          <td><?php echo $item["dia_7"];  ?></td>   
          <td><?php echo $item["dia_8"];  ?></td>   
          <td><?php echo $item["dia_9"];  ?></td>   
          <td><?php echo $item["dia_10"];  ?></td>
          <td><?php echo $item["dia_11"];  ?></td>
          <td><?php echo $item["dia_12"];  ?></td>
          <td><?php echo $item["dia_13"];  ?></td>
          <td><?php echo $item["dia_14"];  ?></td>
          <td><?php echo $item["dia_15"];  ?></td>   
          <td><?php echo $item["dia_16"];  ?></td>   
          <td><?php echo $item["dia_17"];  ?></td>   
          <td><?php echo $item["dia_18"];  ?></td>   
          <td><?php echo $item["dia_19"];  ?></td>   
          <td><?php echo $item["dia_20"];  ?></td> 
          <td><?php echo $item["dia_21"];  ?></td>
          <td><?php echo $item["dia_22"];  ?></td>
          <td><?php echo $item["dia_23"];  ?></td>
          <td><?php echo $item["dia_24"];  ?></td>
          <td><?php echo $item["dia_25"];  ?></td>   
          <td><?php echo $item["dia_26"];  ?></td>   
          <td><?php echo $item["dia_27"];  ?></td>   
          <td><?php echo $item["dia_28"];  ?></td>   
          <td><?php echo $item["dia_29"];  ?></td>   
          <td><?php echo $item["dia_30"];  ?></td> 
          <td><?php echo $item["dia_31"];  ?></td>   
          <td><?php echo $item["total"];  ?></td>
        </tr>
      <?php endif; ?>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
    <th>Serial</th>
      <th>Nombre</th>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>4</th>
      <th>5</th>
      <th>6</th>
      <th>7</th>
      <th>8</th>
      <th>9</th>
      <th>10</th>
      <th>11</th>
      <th>12</th>
      <th>13</th>
      <th>14</th>
      <th>15</th>
      <th>16</th>
      <th>17</th>
      <th>18</th>
      <th>19</th>
      <th>20</th>
      <th>21</th>
      <th>22</th>
      <th>23</th>
      <th>24</th>
      <th>25</th>
      <th>26</th>
      <th>27</th>
      <th>28</th>
      <th>29</th>
      <th>30</th>
      <th>31</th>
      <th>Total</th>
    </tr>
  </tfoot>
</table>

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
    $('.min').mask("###0", {reverse: true});

    $('#listadoProd').DataTable( {

      columnDefs: [
        {
          targets: 0,
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
        {
          targets: 10,
          "visible": true,
          "searchable": false,
          "orderable": false,
          render: function ( data, type, row ) {
            if ( type === 'export' ) {
              after = row[10].substring(row[10].indexOf('id=') + 3);
              before = after.substr(0, after.indexOf('value')); 
              id = before.replace('"','').replace('"','');
              return $("#"+id).val();
            }  else {
              return data;
            }          
          }
        },
        {
          targets: 13,
          "visible": true,
          "searchable": false,
          "orderable": false,
          render: function ( data, type, row ) {
            if ( type === 'export' ) {
              after = row[13].substring(row[13].indexOf('id=') + 3);
              before = after.substr(0, after.indexOf('value')); 
              id = before.replace('"','').replace('"','');
              return $("#"+id).val();
            }  else {
              return data;
            }          
          }
        },
        {
          targets: 1,
          render: $.fn.dataTable.render.ellipsis(40)
        },
        {
          targets: 14,
          render: $.fn.dataTable.render.ellipsis(15)
        },
      ],
      scrollX:        true,
      scrollCollapse: true,
      paging:         false,
      fixedColumns:   {
        leftColumns: 1
      },
      "lengthMenu": [[-1], ["Todos"]],
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
          title: 'TurnOver',
          exportOptions: {
            modifier: {
                    page: 'all'
                    },
                        format: {
                            header: function ( data, columnIdx ) {
                                if(columnIdx==1){
                                return 'Nombre';
                                }
                                else{
                                return data;
                                }
                            }
                        }
          
          
          }
        },
      ]
    });

    $('#listadoProd_filter input').addClass('form-control');
    $("#listadoProd_filter input").attr("placeholder", "Buscar...");
    $('#loading').fadeOut( "slow", function() {});

    $('.min').keypress(function (e) {
      if (e.which == 13) {
        if(!this.value) {
          this.value=0;
        }
        var id=this.id;
        id= id.replace('m','');
        var r = $.ajax({
          type: 'GET',
          url: '<?php echo url_for('turnover')?>/minimo?id='+id+'&min='+this.value,
          async: false
        }).responseText;
        if(r=="success") {
          $(this).removeClass("is-invalid");
          $(this).addClass("is-valid");
        } else {
          $(this).removeClass("is-valid");
          $(this).addClass("is-invalid");
        }
        $(this).closest('tr').find('.c').focus()
        return false;
      }
    });
    $('.c').keypress(function (e) {
      if (e.which == 13) {
        if(!this.value) {
          this.value=0;
        }
        $(this).removeClass("is-invalid");
        $(this).addClass("is-valid");        
        $(this).closest('tr').nextAll('tr:not(.group)').first().find('.min').focus();
        return false;
      }
    });
  });
  function d (id, provId, row) {
    $('#procesar').hide();
    depId = $("#deposito_id").val();
    fdesde = $("#fecha_desde").val();
    fhasta = $("#fecha_hasta").val();
    
    $('#procesar').load('<?php echo url_for('turnover/detalles') ?>?depId='+depId+'&prodId='+id+'&fdesde='+fdesde+'&fhasta='+fhasta+'&provId='+provId+'&row='+row).fadeIn("slow");
  }
</script>

<style>
  table#listadoProd tbody tr td:nth-child(3),
  table#listadoProd tbody tr td:nth-child(4),
  table#listadoProd tbody tr td:nth-child(5),
  table#listadoProd tbody tr td:nth-child(6),
  table#listadoProd tbody tr td:nth-child(7),
  table#listadoProd tbody tr td:nth-child(8),
  table#listadoProd tbody tr td:nth-child(9),
  table#listadoProd tbody tr td:nth-child(10),
  table#listadoProd tbody tr td:nth-child(11),
  table#listadoProd tbody tr td:nth-child(12),
  table#listadoProd tbody tr td:nth-child(13) {
    text-align: center;
  }
  .buttons-html5 {
    border-radius: 0px !important;
  }

  th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
  }

  .dt-buttons {
    float: right;
  }
  #listadoProd_filter input {
    width: 20rem !important;
  }
  .nm {
    width: 4rem !important;
    text-align: center;
    height: calc(1.8125rem + 2px);
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1.5;
    font-weight: 400;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }
  .blue {
    color: #007bff;
  }
  .blue.is-valid {
    color: #28a745;
  }
  .blue.is-invalid {
    color: #dc3545;
  }
  .nm.is-invalid {
    border: 3px solid #dc3545;
  }
  .nm.is-valid {
    border: 3px solid #28a745;
  }
  .nm.fill {
    border: 3px solid #007bff;
  }
  table.dataTable.compact tbody th, table.dataTable.compact tbody td {
    padding: 2px 1px;
  }
</style>