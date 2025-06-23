<?php
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $did=$sf_params->get('did');
  $tipo=$sf_params->get('tipo');
  $cod=$sf_params->get('cod');
  switch($tipo){
    case 1:
      $tipoTxt="Productos en deposito que estan por encima de cero(0) pero debajo del minimo ideal";
      $query=" i.cantidad>0";
      break;
    case 2:
      $tipoTxt="Productos en deposito que estan en cero(0)";
      $query=" i.cantidad=0";
      break;
  }

  $results = $q->execute("SELECT t.descripcion as descr,
    LOWER(e.acronimo) as ename, LOWER(id.acronimo) as idname, 
    p.serial as serial, lower(p.nombre) as pname, t.open_unixtime as unixtime, t.minimo as minimo,
    LOWER(cat.nombre) as catname, i.cantidad as qty
    FROM triggers as t 
    LEFT JOIN inventario as i ON (t.did=i.deposito_id && t.prodid=i.producto_id)
    LEFT JOIN empresa as e ON t.eid=e.id
    LEFT JOIN inv_deposito as id ON t.did=id.id
    LEFT JOIN producto as p on t.prodid=p.id
    LEFT JOIN prod_categoria as cat ON p.categoria_id=cat.id
    WHERE t.tipo=1 && t.estatus=1 && t.did=$did && SUBSTRING(cat.codigo_full, 1, 2)=$cod && $query
    GROUP BY t.prodid");
?>
<h5 style="text-align: center"><?php echo $tipoTxt; ?></h5>
<table class="table table-striped" style="font-size: 80%; width: 100%" id="detalle_incidencia">
  <thead>
    <tr>
      <th>Emp</th>
      <th>Dep</th>
      <th>Producto</th>
      <th>Serial</th>
      <th>Categoria</th>
      <th>Cant<br/>Actual</th>
      <th>Min<br/>Ideal</th>
      <th>Tiempo</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($results as $result): ?>
      <tr>
        <td><?php echo $result["ename"]; ?></td>
        <td><?php echo $result["idname"]; ?></td>
        <td><?php echo ucwords($result["pname"]); ?></td>
        <td><?php echo $result["serial"]; ?>]</td>
        <td><?php echo ucwords(current(explode("/",$result["catname"]))); ?></td>
        <td style="text-align: center"><?php echo $result["qty"]; ?></td>
        <td style="text-align: center"><?php echo $result["minimo"]; ?></td>
        <td style="text-align: center">
          <span style="display: none"><?php echo $result["unixtime"]; ?></span>
          <?php echo humanTiming($result["unixtime"]); ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script>
  $(function () {
    $('#detalle_incidencia').DataTable({
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
    $('#detalle_incidencia_filter input').addClass('form-control');
    $("#detalle_incidencia_filter input").attr("placeholder", "Buscar...");
  });
  $('#modal_procesar').modal('show');
  $('#modal_procesar').draggable({
    handle: ".modal-header"
  });
</script>
<style>
  table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 0.2rem !important;
  }
</style>
<?php
  function humanTiming ($time) {
    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
      31536000 => 'year',
      2592000 => 'month',
      604800 => 'week',
      86400 => 'day',
      3600 => 'hour',
      60 => 'minute',
      1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
      if ($time < $unit) continue;
      $numberOfUnits = floor($time / $unit);
      return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
  }
?>