<?php use_helper('Date') ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Perfil</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage"); ?>">Inicio</a></li>
          <li class="breadcrumb-item active">Perfil de cliente</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2">
        <div class="card card-<?php echo $class ?> card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="/images/user_icon.png" alt="User profile picture">
            </div>
            <h3 class="profile-username text-center"><?php echo $client->getFullName() ?></h3>
            <p class="text-muted text-center"><?php echo $client->getDocId() ?></p>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Servicios</b> <a class="float-right"><?php echo $cant_contrato ?></a>
              </li>
              <li class="list-group-item">
                <b>Pagos</b> <a class="float-right"><?php echo $cant_rec ?></a>
              </li>
              <li class="list-group-item">
                <b>Facturas</b> <a class="float-right"><?php echo $cant_fact ?></a>
              </li>
            </ul>
            <a target="_blank" href="<?php echo url_for("@client")."/".$client->getId()."/show" ?>" class="btn btn-<?php echo $class ?> btn-block">
              <b>Editar</b>
            </a>
          </div>
        </div>
        <div class="card card-<?php echo $class ?>">
          <div class="card-header">
            <h3 class="card-title">Mas Info</h3>
          </div>
          <div class="card-body">
            <strong><i class="fas fa-mobile-alt mr-1"></i> Telefonos</strong>
            <p class="text-muted">
              <?php echo $client->getTelf()." / ".$client->getCelular() ?>
            </p>
            <hr>
            <strong><i class="far fa-envelope-alt mr-1"></i> Correo Electronico</strong>
            <p class="text-muted">
              <?php echo $client->getEmail() ?>
            </p>
            <hr>
            <strong><i class="fas fa-map-marker-alt mr-1"></i> Direccion</strong>
            <p class="text-muted"><?php echo $client->getDireccion() ?></p>
            <hr>
            <strong><i class="far fa-file-alt mr-1"></i> +Detalles</strong>
            <p class="text-muted"><?php echo $client->getDescripcion() ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-10">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#contratos" data-toggle="tab">Contratos</a></li>
              <li class="nav-item"><a class="nav-link" href="#recibos" data-toggle="tab">Pagos</a></li>
              <li class="nav-item"><a class="nav-link" href="#facturas" data-toggle="tab">Facturas</a></li>
              <li class="nav-item"><a class="nav-link" href="#retenciones" data-toggle="tab">Retenciones</a></li>
              <li class="nav-item"><a class="nav-link" href="#estaciones" data-toggle="tab">Estaciones</a></li>
              <li class="nav-item"><a class="nav-link disabled" href="#add_notas" data-toggle="tab">Notas</a></li>
              <li class="nav-item"><a class="nav-link disabled" href="#add_notas" data-toggle="tab">Tickets</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="contratos">
                <table class="table table-striped" id="tacontratos">
                  <thead>
                    <tr>
                      <th>Contrato #</th>
                      <th>Serv. Contratado</th>
                      <th>Precio</th>
                      <th>Act.</th>
                      <th>+Detalles</th>
                      <th>Ult. Act</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $contratos = Doctrine_Query::create()
                      ->select('c.id as cid, c.ncontrol as ncontrol, p.nombre as pname,
                      cd.id as cdid, cd.precio as precio, cd.orden as orden, cd.activo as activo, cd.updated_at as updated,
                      sa.nombre as saname, cd.adicionales_id as said, cd.precio_adicional as saprecio')
                      ->from('ContratoDet cd')
                      ->leftJoin('cd.Contrato c')
                      ->leftJoin('cd.Planes p')
                      ->leftJoin('cd.ServAdicionales sa')
                      ->Where('c.client_id =?', $client->getId())
                      ->orderBy('cd.id ASC')
                      ->execute();
                    $total=0;
                    foreach ($contratos as $contrato):
                    ?>
                    <tr>
                      <td>
                        <a target="_blank" href="<?php echo url_for("contrato")."/".$contrato["cid"]."/show" ?>">
                          <?php echo str_pad((int)$contrato["ncontrol"], 5, '0', STR_PAD_LEFT)."-".$contrato["orden"]; ?>
                        </a>
                      </td>
                      <?php
                        list($tipop, $mb) = explode("/", $contrato["pname"]);
                        $class_tipo="bg-primary";
                        if(strcmp($tipop,"RESIDENCIAL")==0) {
                          $class_tipo="bg-success";
                        } else if(strcmp($tipop,"EMPRESARIAL")==0) {
                          $class_tipo="bg-warning";
                        } else if(strcmp($tipop,"SIMETRICO")==0) {
                          $class_tipo="bg-danger";
                        }
                       ?>
                      <td>
                        <span class="badge <?php echo $class_tipo; ?>">
                          <?php echo mb_strtolower($contrato["pname"]) ?>
                        </span>
                      </td>
                      <td><?php echo "USD ".number_format($contrato["precio"], 2, '.', ','); $total+=$contrato["precio"]; ?></td>
                      <td>
                        <?php
                          if($contrato["activo"]==1) {
                            echo "<i class='fas fa-check-circle' style='color: #28a745'></i>";
                          } else {
                            echo "<i class='fas fa-minus-circle'></i>";
                          }
                        ?>
                      </td>
                      <td><?php echo mb_strtolower($contrato["descripcion"]) ?></td>
                      <td><?php echo format_datetime($contrato["updated"], 'f', 'es_ES'); ?></td>
                    </tr>
                    <?php if(!empty($contrato["said"])): ?>
                      <tr>
                        <td></td>
                        <td>
                          <span class="badge bg-black">
                            <?php echo mb_strtolower($contrato["saname"]) ?>
                          </span>
                        </td>
                        <td><?php echo "USD ".number_format($contrato["saprecio"], 2, '.', ','); $total+=$contrato["saprecio"]; ?></td>
                        <td colspan="3"></td>
                      </tr>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <tr>
                      <td colspan="2"></td>
                      <td><?php echo "USD ".number_format($total, 2, '.', ',') ?></td>
                      <td colspan="3"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="recibos">
                <table class="table table-striped" id="trecibos">
                  <thead>
                    <tr>
                      <th>Recibo #</th>
                      <th>Forma de pago</th>
                      <th>Monto</th>
                      <th>Por Procesar</th>
                      <th>Creado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $pagos = Doctrine_Query::create()
                      ->select('rp.id, rp.ncontrol, rp.forma_pago, rp.pendiente_monto2, rp.monto2, rp.created_at')
                      ->from('ReciboPago rp')
                      ->Where('rp.client_id =?', $client->getId())
                      ->orderBy('rp.id DESC')
                      ->execute();
                    $total=0;
                    foreach ($pagos as $pago):
                    ?>
                    <tr>
                      <td>
                        <a target="_blank" href="<?php echo url_for("recibo_pago")."/".$pago["id"]."/show" ?>">
                          <?php echo $pago["ncontrol"]; ?>
                        </a>
                      </td>
                      <td><?php echo $pago->getFormaDePago(); ?></td>
                      <td><?php echo "USD ".number_format($pago->getMonto2(), 2, '.', ',') ?></td>
                      <td>
                        <?php if(strlen(trim($pago["pendiente_monto2"]))>0){
                          echo "<span class='badge bg-success'>USD ".number_format(0+trim($pago["pendiente_monto2"]), 2, '.', ',')."</span>";
                        } else {
                          echo number_format(0+trim($pago["pendiente_monto2"]), 2, '.', ',');
                        } ?>
                      </td>
                      <td><?php echo format_datetime($pago["created_at"], 'f', 'es_ES'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="facturas">
                <table class="table table-striped" id="tfacturas">
                  <thead>
                    <tr>
                      <th>N° Control</th>
                      <th>N° Fact</th>
                      <th>Total</th>
                      <th>Pendiente</th>
                      <th>Anulada</th>
                      <th>Creado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $facts = Doctrine_Query::create()
                      ->select('pf.id as pfid, pf.ncontrol as ncontrol, pf.subtotal as pftot, pf.has_invoice as has_invoice,
                      pf.monto_pagado as moneypay, pf.anulado as anulado, pf.pagado as pagado,
                      f.id as fid, f.num_factura as nfact, f.total as ftot, pf.created_at as created')
                      ->from('PreFactura pf')
                      ->leftJoin('pf.Factura f')
                      ->Where('pf.client_id =?', $client->getId())
                      ->orderBy('pf.id DESC')
                      ->execute();
                    foreach ($facts as $fact):
                    ?>
                    <?php if($fact["has_invoice"]==1){ ?>
                    <tr>
                      <td>
                        <a target="_blank" href="<?php echo url_for("pre_factura")."/".$fact["pfid"]."/show" ?>">
                          <?php echo $fact["ncontrol"]; ?>
                        </a>
                      </td>
                      <td>
                        <a target="_blank" href="<?php echo url_for("factura")."/".$fact["fid"]."/show" ?>">
                          <?php echo $fact["nfact"]; ?>
                        </a>
                      </td>
                      <td><?php echo "USD ".number_format($total=$fact["ftot"], 2, '.', ',') ?></td>
                      <td>
                        <?php
                          if($fact["pagado"]==1 || $fact["anulado"]==1) {
                            echo number_format(0, 2, '.', ',');
                          } else {
                            $total-=$fact["moneypay"];
                            echo "<span class='badge bg-danger'>USD ".number_format($total, 2, '.', ',')."</span>";
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if($fact["anulado"]==1) {
                            echo "<i class='fas fa-check-circle' style='color: #c30000'></i>";
                          } else {
                            echo "<i class='fas fa-minus-circle'></i>";
                          }
                        ?>
                      </td>
                      <td><?php echo format_datetime($fact["created"], 'f', 'es_ES'); ?></td>
                    </tr>
                    <?php } else { ?>
                      <tr>
                        <td>
                          <a target="_blank" href="<?php echo url_for("pre_factura")."/".$fact["pfid"]."/show" ?>">
                            <?php echo $fact["ncontrol"]; ?>
                          </a>
                        </td>
                        <td></td>
                        <td><?php echo "USD ".number_format($total=$fact["pftot"], 2, '.', ',') ?></td>
                        <td>
                          <?php
                            if($fact["pagado"]==1 || $fact["anulado"]==1) {
                              echo number_format(0, 2, '.', ',');
                            } else {
                              $total-=$fact["moneypay"];
                              echo "<span class='badge bg-danger'>USD ".number_format($total, 2, '.', ',')."</span>";
                            }
                          ?>
                        </td>
                        <td>
                          <?php
                            if($fact["anulado"]==1) {
                              echo "<i class='fas fa-check-circle' style='color: #c30000'></i>";
                            } else {
                              echo "<i class='fas fa-minus-circle'></i>";
                            }
                          ?>
                        </td>
                        <td><?php echo format_datetime($fact["created"], 'f', 'es_ES'); ?></td>
                      </tr>
                    <?php } ?>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="retenciones">
                <table class="table table-striped" id="tretenciones">
                  <thead>
                    <tr>
                      <th>Comprabante #</th>
                      <th>Factura #</th>
                      <th>Tipo</th>
                      <th>Monto</th>
                      <th>Anulado</th>
                      <th>Creado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $retenciones = Doctrine_Query::create()
                      ->select('r.id as rid, r.comprobante, r.tipo, r.monto, r.anulado as disable, r.created_at as created,
                       f.id as fid, f.num_factura as num_factura, f.anulado as fanulado, pf.anulado as pfanulado')
                      ->from('Retenciones r')
                      ->leftJoin('r.Factura f')
                      ->leftJoin('f.PreFactura pf')
                      ->Where('pf.client_id =?', $client->getId())
                      ->orderBy('r.created_at DESC')
                      ->execute();
                    foreach ($retenciones as $retencion):
                    ?>
                    <tr>
                      <td>
                        <a target="_blank" href="<?php echo url_for("retenciones")."/".$retencion["rid"]."/show" ?>">
                          <?php echo $retencion["comprobante"]; ?>
                        </a>
                      </td>
                      <td>
                        <a target="_blank" href="<?php echo url_for("factura")."/".$retencion["fid"]."/show" ?>">
                          <?php echo $retencion["num_factura"]; ?>
                        </a>
                      </td>
                      <td><?php echo $retencion->getTipoRetencion(); ?></td>
                      <td><?php echo "USD ".number_format($total=$retencion["monto"], 2, '.', ',') ?></td>
                      <td>
                        <?php
                          if($retencion["disable"]==1) {
                            echo "<i class='fas fa-check-circle' style='color: #c30000'></i>";
                          } else {
                            echo "<i class='fas fa-minus-circle'></i>";
                          }
                        ?>
                      </td>
                      <td><?php echo format_datetime($retencion["created"], 'f', 'es_ES'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="estaciones">
                <table class="table table-striped" id="testaciones">
                  <thead>
                    <tr>
                      <th>ST #</th>
                      <th>Nodo</th>
                      <th>Puerto</th>
                      <th>Tipo</th>
                      <th>Vid</th>
                      <th>Ip</th>
                      <th>+Detalles</th>
                      <th>Ult. Act</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $estaciones = Doctrine_Query::create()
                        ->select('ed.id as edid, ed.ip as ip, ed.vlan as vlan, ed.updated_at as updated, ed.descripcion as desc,
                        ro.id as roid, ra.id as raid, sw.id as swid, dr.nombre as drname, dr.switchh_num as drnum, l.acronimo as acronimo,
                        e.id as eid, e.ncontrol as ncontrol, c.ncontrol as nccontrato, cd.orden as orden')
                        ->from('EstacionesDet ed')
                        ->leftJoin('ed.DocRed dr')
                        ->leftJoin('dr.Switchh sw')
                        ->leftJoin('sw.Rack ra')
                        ->leftJoin('ra.Room ro')
                        ->leftJoin('ro.Localizacion l')
                        ->leftJoin('ed.Estaciones e')
                        ->leftJoin('e.ContratoDet cd')
                        ->leftJoin('cd.Contrato c')
                        ->Where('c.client_id =?', $client->getId())
                        ->orderBy('ed.id ASC')
                        ->execute();
                      $total=0;
                      foreach ($estaciones as $estacion):
                    ?>
                    <tr>
                      <td>
                        <a target="_blank" href="<?php echo url_for("estaciones")."/".$estacion["eid"]."/show" ?>">
                          <?php
                            $ncontrato=str_pad((int)$estacion["nccontrato"], 5, '0', STR_PAD_LEFT);
                            $ncontrato=$ncontrato."-".$estacion["orden"];
                            $ncontrato=$ncontrato."-".str_pad((int)$estacion["ncontrol"], 5, '0', STR_PAD_LEFT);
                            echo $ncontrato;
                          ?>
                        </a>
                      </td>
                      <td><?php echo $estacion["acronimo"]; ?></td>
                      <td><?php echo $estacion["drname"]." [".$estacion["drnum"]."]"; ?></td>
                      <td>
                        <?php
                        if($estacion["tipo_ip"]==0) {
                          echo "INTERNET";
                        } else if($estacion["tipo_ip"]==0) {
                          echo "DATOS";
                        } else {
                          echo "ACCESO";
                        }
                        ?>
                      </td>
                      <td><?php echo $estacion["vlan"]; ?></td>
                      <td><?php echo $estacion["ip"]; ?></td>
                      <td><?php echo $estacion["desc"]; ?></td>
                      <td><?php echo format_datetime($estacion["updated"], 'f', 'es_ES'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="add_notas">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap4.css">
<script src="/plugins/datatables/jquery.dataTables.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $('#tfacturas').DataTable({
      "lengthMenu": [[20, 40, 60, -1], [20, 40, 60, "All"]],
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
    $('#trecibos').DataTable({
      "lengthMenu": [[20, 40, 60, -1], [20, 40, 60, "All"]],
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
    $('#testaciones').DataTable({
      "lengthMenu": [[20, 40, 60, -1], [20, 40, 60, "All"]],
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
    $('#tretenciones').DataTable({
      "lengthMenu": [[20, 40, 60, -1], [20, 40, 60, "All"]],
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
</script>
