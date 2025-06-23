<?php $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$form->getObject()->get('cliente_id'));?>
<?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
</div></div></div>
  <div class="invoice p-3 mb-3" id="invoice" <?php if($form->getObject()->get('estatus')==4) { echo 'style="background: #f1daa759 !important;"'; }?>>
    <div class="row">
      <div class="col-6">
        <h4>
          <img src='/images/<?php echo $empresa->getId()?>.png' height="60"/>
        </h4>
      </div>
      <div class="col-md-6">
        <?php if($form->getObject()->get('estatus')==4) { ?>
          <img src='/images/anulado.png' style="float:right"/>
        <?php } ?>
      </div>
    </div>
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <address>
          <strong><?php echo $empresa->getNombre()?> | <?php echo $empresa->getRif()?></strong><br/>
          <span class="tcaps"><?php echo mb_strtolower($empresa->getDireccion())?></span><br/>
          <b>Telf:</b> <?php echo $empresa->getTelefono()?><br/>
          <b>Email:</b> <?php echo $empresa->getEmail()?>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <address>
          <strong><?php echo $form->getObject()->get('razon_social'); ?> | <?php echo $form->getObject()->get('doc_id'); ?></strong><br>
          <span class="tcaps"><?php echo mb_strtolower($form->getObject()->get('direccion'))?></span><br/>
          <b>Telf:</b> <?php echo $form->getObject()->get('telf'); ?><br>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <small class="float-right">Emision: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('fecha')))); ?></small><br/>
        <small class="float-right">Dias de Credito: <?php echo $factura->getDiasCredito(); ?></small><br/>
        <?php if(!empty($form->getObject()->get('ndespacho'))): ?>
          <b class="float-right">Nota Despacho: <?php echo ($form->getObject()->get('ndespacho')); ?></b><br>
          <?php $caja=Doctrine_Core::getTable('Caja')->findOneBy('id',$form->getObject()->get('caja_id'));?>
          <b class="float-right">N° Caja: <?php echo $caja->getNombre(); ?></b><br>
        <?php else: ?>
          <b class="float-right">Factura: <?php echo ($form->getObject()->get('num_factura')); ?></b><br>
          <b class="float-right">N° Control: <?php echo ($form->getObject()->get('ncontrol')); ?></b><br>
        <?php endif; ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>CANT.</th>
              <th>CONCEPTO O DESCRIPCIÓN</th>
              <th>LOTE y VENC</th>
              <th style="text-align: right">P. UNITARIO</th>
              <th style="text-align: right">TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $results = Doctrine_Query::create()
              ->select('fd.exento as exento, fd.qty as qty, fd.price_unit as punit, fd.price_tot as ptot, i.id as iid, 
              p.nombre as nombre, p.serial as serial, ofer.id as oferid, ofer.nombre as ofname, ofer.id as ofserial')
              ->from('FacturaDet fd, fd.Inventario i, i.Producto p, fd.Oferta ofer')
              ->where('fd.factura_id = ?', $form->getObject()->get('id'))
              ->orderBy('fd.id ASC')
              ->execute();
            $total=0;
            foreach ($results as $result) {
              $items = explode(';', $result["descripcion"]);
              $total+=number_float($result["ptot"]);
              $exento="G";
              if(str_replace(" ", "_", $result["exento"])=="EXENTO") {
                $exento="E";
            }
            ?>
            <tr>
              <td style="vertical-align: middle" class="number2"><?php echo $result["qty"] ?></td>
              <td style="vertical-align: middle">
                <?php echo $result["nombre"].$result["ofname"]." (".$exento.")" ?><br/>
                <small><b>s/n: <?php echo $result["serial"].$result["ofserial"]; ?></b></small>
              </td>
              <td style="vertical-align: middle">
                <?php
                  foreach ($items as $item) {
                    if(strlen($item)>0) {
                      list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
                      $phpdate = strtotime($fvenc);
                      echo "<b>".$lote."</b> <small>".date('M-Y', $phpdate)."</small><br/>";
                    }
                  }
                ?>
              </td>
              <td style="vertical-align: middle; text-align: right"><?php echo "USD ".number_format(number_float($result["punit"]), 4, '.', ',');?></td>
              <td style="vertical-align: middle; text-align: right"><?php echo "USD ".number_format(number_float($result["ptot"]), 4, '.', ',');?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-6"></div>
      <div class="col-6">
        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <td style="text-align: right"><b>SUB-TOTAL</b></td>
                <td></td>
                <td></td>
                <td style="text-align: right">
                  <?php echo "USD ".number_format($subtotal=number_float($form->getObject()->get('subtotal')), 4, '.', ',');?>
                </td>
              </tr>
              <tr>
                <td style="text-align: right"><b>DESCUENTO</b></td>
                <td style="text-align: right">
                  <?php echo "% ".number_format($desc=number_float($form->getObject()->get('descuento')), 4, '.', ',');?>
                </td>
                <td style="text-align: right">
                  <?php echo "USD ".number_format(($desc*$subtotal)/100, 4, '.', ' ');?>
                </td>
                <td style="text-align: right">
                  <?php echo "USD ".number_format(number_float($form->getObject()->get('subtotal_desc')), 4, '.', ',');?>
                </td>
              </tr>
              <tr>
                <td style="text-align: right"><b>IVA</b></td>
                <td style="text-align: right">
                  <?php echo "% ".number_format(number_float($form->getObject()->get('iva')), 4, '.', ',');?>
                </td>
                <td style="text-align: right">
                  <?php echo "USD ".number_format(number_float($form->getObject()->get('base_imponible')), 4, '.', ',');?>
                </td>
                <td style="text-align: right">
                  <?php echo "USD ".number_format(number_float($form->getObject()->get('iva_monto')), 4, '.', ',');?>
                </td>
              </tr>
              <tr>
                <td style="text-align: right"><b>TOTAL</b></td>
                <td></td>
                <td></td>
                <td style="text-align: right"><?php echo "USD ".number_format(number_float($form->getObject()->get('total')), 4, '.', ',');?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row no-print">
    <div class="col-12">
      <a href="#" target="_blank" class="btn btn-default" onclick="printDiv('invoice')">
        <i class="fas fa-print"></i> Imprimir
      </a>
      <a href="<?php echo url_for("@factura")."/print?id=".$form->getObject()->get('id')?>" target="_blank" class="btn btn-success" >
        <i class="fas fa-stamp"></i> Forma Libre
      </a>
      <button onclick="anular()" class="btn btn-danger float-right" style="margin-right: 5px;">
        <i class="fas fa-minus-circle"></i> Anular
      </button>
    </div>
  </div>
  <br/><br/>

  <div class="card card-primary" id="sf_fieldset_otros">
    <div class="card-header">
      <h3 class="card-title">Estatus</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ORDEN COMPRA</th>
                <th>NOTA ENTREGA</th>
                <th>TOTAL</th>
                <th>MONTO RESTANTE POR PAGAR</th>
                <th>MONTO PAGADO</th>
                <th>ESTATUS</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if($form->getObject()->get('nota_entrega_id')) {
                  $ne=Doctrine_Core::getTable('NotaEntrega')->findOneBy('id', $form->getObject()->get('nota_entrega_id'));
                }
                $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('factura_id', $form->getObject()->get('id'));
              ?>
              <tr>
                <td style="vertical-align: middle">
                  <?php
                  if($form->getObject()->get('orden_compra_id')) {
                    echo "<a href='".url_for("orden_compra")."/show?id=".$factura->getOrdenCompraId()."' target='_blank'>".$factura->getOrdenCompraId()."</a>";
                  } else {
                    echo "<i class='fas fa-minus-circle'></i>";
                  }?>
                </td>
                <td style="vertical-align: middle">
                  <?php
                  if($form->getObject()->get('nota_entrega_id')) {
                    echo "<a href='".url_for("nota_entrega")."/show?id=".$ne->getId()."' target='_blank'>".$ne->getNcontrol()."</a>";
                  } else {
                    echo "<i class='fas fa-minus-circle'></i>";
                  }?>
                </td>
                <td style="vertical-align: middle"><?php echo "USD ".$cuentas_cobrar->getTotal(); ?></td>
                <td style="vertical-align: middle"><?php echo "USD ".$cuentas_cobrar->getMontoFaltante(); ?></td>
                <td style="vertical-align: middle"><?php echo "USD ".$cuentas_cobrar->getMontoPagado(); ?></td>
                <td>
                <?php
                if($cuentas_cobrar->getEstatus()==1) {
                  echo "<span class='badge bg-info'>PENDIENTE</span>";
                } else if($cuentas_cobrar->getEstatus()==2) {
                  echo "<span class='badge bg-warning'>ABONADO</span>";
                } else if($cuentas_cobrar->getEstatus()==3) {
                  echo "<span class='badge bg-success'>CANCELADO</span>";
                } else if($cuentas_cobrar->getEstatus()==4) {
                  echo "<span class='badge bg-danger'>ANULADO</span>";
                }
                 ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="card card-primary" id="sf_fieldset_otros">
    <div class="card-header">
      <h3 class="card-title">Historial de pagos</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <?php
        $results = Doctrine_Query::create()
        ->select('rp.id as rpid, rp.ncontrol as cod, rp.fecha, rp.anulado, rp.monto, rp.descripcion as desc, rp.created_at,
        fp.id as fpid, fp.nombre as fpago,')
        ->from('ReciboPago rp, rp.FormaPago fp')
        ->where('rp.cuentas_cobrar_id = ?', $cuentas_cobrar->getId())
        ->orderBy('rp.fecha DESC')
        ->execute();
        $total=0;
        foreach ($results as $result):
      ?>
        <div class="card" <?php if($result["anulado"]==1) { echo 'style="background: #f1daa759 !important;"'; }?>>
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Recibo de pago <?php echo "<a href='".url_for("recibo_pago")."/show?id=".$result["rpid"]."' target='_blank'>[".$result["cod"]."]</a>"; ?>
              <?php if($result["anulado"]==1) { echo "<span class='badge bg-danger'>ANULADO</span>"; }?>
            </h3>
          </div>
          <div class="card-body">
            <blockquote>
              <p>Recibi de: <b><?php echo mb_strtolower($result->getQuienPaga()); ?></b>,
                bajo la forma de pago <b><?php echo mb_strtolower($result->getForPagoCoin()); ?></b>,
              la cantidad en <h3>USD <?php echo $result["monto"]; ?></h3></p>
              <small><cite title="Source Title"><?php echo mb_strtoupper(format_datetime($result["created_at"], 'f', 'es_ES')); ?></cite></small>
            </blockquote>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="col-md-4">
      <?php
        $results = Doctrine_Query::create()
        ->select('ncd.*, nc.id as ncid, nc.ncontrol as cod,
        fp.id as fpid, fp.nombre as fpago')
        ->from('NotaCreditoDet ncd, ncd.NotaCredito nc, nc.FormaPago fp')
        ->where('ncd.cuentas_cobrar_id = ?', $cuentas_cobrar->getId())
        ->orderBy('ncd.created_at DESC')
        ->execute();
        $total=0;
        foreach ($results as $result):
      ?>
        <div class="card" <?php if($result["anulado"]==1) { echo 'style="background: #f1daa759 !important;"'; }?>>
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Nota de credito <?php echo "<a href='".url_for("nota_credito")."/show?id=".$result["ncid"]."' target='_blank'>[".$result["cod"]."]</a>"; ?>
              <?php if($result["anulado"]==1) { echo "<span class='badge bg-danger'>ANULADO</span>"; }?>
            </h3>
          </div>
          <div class="card-body">
            <blockquote>
              <p>Se proceso la cantidad en <h3>USD <?php echo $result["monto"]; ?></h3> de la nota de credito indicada arriba</p>
              <small><cite title="Source Title"><?php echo mb_strtoupper(format_datetime($result["created_at"], 'f', 'es_ES')); ?></cite></small>
            </blockquote>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="col-md-4">
      <?php
        $results = Doctrine_Query::create()
        ->select('r.*')
        ->from('Retenciones r')
        ->where('r.cuentas_cobrar_id = ?', $cuentas_cobrar->getId())
        ->orderBy('r.created_at DESC')
        ->execute();
        $total=0;
        foreach ($results as $result):
      ?>
        <div class="card" <?php if($result["anulado"]==1) { echo 'style="background: #f1daa759 !important;"'; }?>>
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Retencion <?php echo "<a href='".url_for("retenciones")."/show?id=".$result["id"]."' target='_blank'>[".$result["comprobante"]."]</a>"; ?>
              <?php if($result["anulado"]==1) { echo "<span class='badge bg-danger'>ANULADO</span>"; }?>
            </h3>
          </div>
          <div class="card-body">
            <blockquote>
              <p>Se registro la retencion por la cantidad en <h3>USD <?php echo $result["monto_usd"]; ?></h3></p>
              <small><cite title="Source Title"><?php echo mb_strtoupper(format_datetime($result["created_at"], 'f', 'es_ES')); ?></cite></small>
            </blockquote>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<div><div><div>

<?php $despacho = Doctrine_Core::getTable('AlmacenTransito')->findOneBy('factura_id', $factura->getId()); ?>
<div class="card card-primary" id="sf_fieldset_otros">
  <div class="card-header">
    <h3 class="card-title">Historial del traslado</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <main>
          <div class="main-timeline4">
            <div class="timeline">
              <span class="timeline-icon"></span>
              <span class="year"><?php echo(date("d/m/Y H:m", strtotime($factura->getCreatedAt()))); ?></span>
              <div class="timeline-content">
                <h3 class="title">Creacion de la factura</h3>
                <p class="description">
                 Con n° de control <b><?php echo $factura->getNcontrol(); ?></b>
                </p>
              </div>
            </div>
            <div class="timeline">
              <span class="timeline-icon"></span>
              <span class="year" style="background: #88948e;"><?php echo(date("d/m/Y H:m", strtotime($despacho->getCreatedAt()))); ?></span>
              <div class="timeline-content">
                <h3 class="title">Creacion de orden de despacho</h3>
                <p class="description">
                  N° de orden de despacho <b><?php echo $despacho->getId(); ?></b> se inicia en <br><b style="font-size: 15px;">(1) <?php echo $factura->getEmpresa(); ?></b><br>
                  procedente de <b style="font-size: 15px; text-decoration: underline;"><?php echo $factura->getInvDeposito(); ?></b><br>
                  ha <b style="font-size: 15px;">(2) <?php echo $factura->getRazonSocial(); ?><br></b>
                </p>
              </div>
            </div>
            <?php if($despacho->getEstatus()==1): ?>
              <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year" style="background: #f39c12;"><?php echo(date("d/m/Y H:m", strtotime($despacho->getCreatedAt()))); ?></span>
                <div class="timeline-content">
                  <h3 class="title">Despacho (PENDIENTE)</h3>
                  <p class="description">
                    En espera de inicio de proceso de despacho.
                  </p>
                </div>
              </div>
            <?php endif; ?>
            <?php if($despacho->getFechaEmbalaje()): ?>
              <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year" style="background: #f39c12;"><?php echo(date("d/m/Y H:m", strtotime($despacho->getFechaEmbalaje()))); ?></span>
                <div class="timeline-content">
                  <h3 class="title">Registro de despacho (EMBALADO)</h3>
                  <p class="description">
                    Se realizo el embalado de los items previamente nombrados en la factura.
                  </p>
                </div>
              </div>
            <?php endif; ?>
            <?php if($despacho->getFechaDespacho()): ?>
              <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year" style="background: #008d4c;"><?php echo(date("d/m/Y H:m", strtotime($despacho->getFechaDespacho()))); ?></span>
                <div class="timeline-content">
                  <h3 class="title">Registro de despacho (DESPACHADO)</h3>
                  <p class="description">
                    Se realizo el despacho de la mercancia previamente nombrados en la factura.
                  </p>
                </div>
              </div>
            <?php endif; ?>
            <?php if($despacho->getEstatus()==4): ?>
              <div class="timeline">
                <span class="timeline-icon"></span>
                <span class="year" style="background: #bd1424;"><?php echo(date("d/m/Y H:m", strtotime($despacho->getUpdatedAt()))); ?></span>
                <div class="timeline-content">
                  <h3 class="title">Registro de despacho (ANULADO)</h3>
                  <p class="description">
                    Se anulo el proceso de despacho de mercancia y se regreso a existencia al almacen correspondiente los productos señalados en este documento
                  </p>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </main>
      </div>
    </div>
  </div>
</div>


<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
  function anular() {
    var retVal = confirm("¿Estas seguro de anular la factura?");
    if( retVal == true ){
        location.href = "<?php echo url_for("factura")."/anular?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
  }
</script>


<?php
function number_float($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return $number;
}
?>
<style>
  .timeline:before {
    content: none !important;
  }

  .main-timeline4 {
      overflow: hidden;
      position: relative
  }

  .main-timeline4:after,
  .main-timeline4:before {
      content: "";
      display: block;
      width: 100%;
      clear: both
  }

  .main-timeline4:before {
      content: "";
      width: 3px;
      height: 100%;
      background: #d6d5d5;
      position: absolute;
      top: 30px;
      left: 50%
  }

  .main-timeline4 .timeline {
      width: 50%;
      float: left;
      padding-right: 30px;
      position: relative
  }

  .main-timeline4 .timeline-icon {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #fff;
      border: 3px solid #00acd6;
      position: absolute;
      top: 5.5%;
      right: -17.5px
  }

  .main-timeline4 .year {
      display: block;
      padding: 10px;
      margin: 0;
      font-size: 30px;
      color: #fff;
      border-radius: 0 50px 50px 0;
      background: #00acd6;
      text-align: center;
      position: relative
  }

  .main-timeline4 .year:before {
      content: "";
      border-top: 35px solid #00acd6ad;
      border-left: 35px solid transparent;
      position: absolute;
      bottom: -35px;
      left: 0
  }

  .main-timeline4 .timeline-content {
      padding: 30px 20px;
      margin: 0 45px 0 35px;
      background: #f2f2f2
  }

  .main-timeline4 .title {
      font-size: 19px;
      font-weight: 700;
      color: #504f54;
      margin: 0 0 10px
  }

  .main-timeline4 .description {
      font-size: 14px;
      color: #7d7b7b;
      margin: 0
  }

  .main-timeline4 .timeline:nth-child(2n) {
      padding: 0 0 0 30px
  }

  .main-timeline4 .timeline:nth-child(2n) .timeline-icon {
      right: auto;
      left: -14.5px
  }

  .main-timeline4 .timeline:nth-child(2n) .year {
      border-radius: 50px 0 0 50px;
      background: #f39c12
  }

  .main-timeline4 .timeline:nth-child(2n) .year:before {
      border-left: none;
      border-right: 35px solid transparent;
      left: auto;
      right: 0
  }

  .main-timeline4 .timeline:nth-child(2n) .timeline-content {
      text-align: right;
      margin: 0 35px 0 45px
  }

  .main-timeline4 .timeline:nth-child(2) {
      margin-top: 170px
  }

  .main-timeline4 .timeline:nth-child(odd) {
      margin: -175px 0 0
  }

  .main-timeline4 .timeline:nth-child(even) {
      margin-bottom: 80px
  }

  .main-timeline4 .timeline:first-child,
  .main-timeline4 .timeline:last-child:nth-child(even) {
      margin: 0
  }

  .main-timeline4 .timeline:nth-child(2n) .timeline-icon {
      border-color: #88948e;
  }

  .main-timeline4 .timeline:nth-child(2n) .year:before {
      border-top-color: #88948ead;
  }

  .main-timeline4 .timeline:nth-child(3n) .timeline-icon {
      border-color: #f39c12;
  }

  .main-timeline4 .timeline:nth-child(3n) .year:before {
      border-top-color: #f39c12ad;
  }

  <?php if($despacho->getEstatus()==4){ ?>
    .main-timeline4 .timeline:nth-child(4n) .year:before {
      border-top-color: #da1225ba !important;
    }
    .main-timeline4 .timeline:nth-child(4n) .timeline-icon {
        border-color: #bd1424;
    }
  <?php } else { ?>
    .main-timeline4 .timeline:nth-child(4n) .year:before {
      border-top-color: #008d4cba;
    }
    .main-timeline4 .timeline:nth-child(4n) .timeline-icon {
        border-color: #008d4c;
    }
  <?php } ?>

  @media only screen and (max-width:767px) {
      .main-timeline4 {
          overflow: visible
      }
      .main-timeline4:before {
          top: 0;
          left: 0
      }
      .main-timeline4 .timeline:nth-child(2),
      .main-timeline4 .timeline:nth-child(even),
      .main-timeline4 .timeline:nth-child(odd) {
          margin: 0
      }
      .main-timeline4 .timeline {
          width: 100%;
          float: none;
          padding: 0 0 0 30px;
          margin-bottom: 20px!important
      }
      .main-timeline4 .timeline:last-child {
          margin: 0!important
      }
      .main-timeline4 .timeline-icon {
          right: auto;
          left: -14.5px
      }
      .main-timeline4 .year {
          border-radius: 50px 0 0 50px
      }
      .main-timeline4 .year:before {
          border-left: none;
          border-right: 35px solid transparent;
          left: auto;
          right: 0
      }
      .main-timeline4 .timeline-content {
          margin: 0 35px 0 45px
      }
  }
</style>
