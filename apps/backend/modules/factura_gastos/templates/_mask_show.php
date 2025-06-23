<?php $cliente=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$form->getObject()->get('proveedor_id'));?>
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
        <b class="float-right">Factura: <?php echo ($form->getObject()->get('num_factura')); ?></b><br>
        <b class="float-right">N° control: <?php echo ($form->getObject()->get('ncontrol')); ?></b><br>
        <small class="float-right">Emision: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('fecha')))); ?></small><br/>
        <small class="float-right">Recepcion: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('fecha_recepcion')))); ?></small><br/>
        <small class="float-right">Dias de Credito: <?php echo $factura_gastos->getDiasCredito(); ?></small><br/>
      </div>
    </div>
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>CANT.</th>
              <th>CONCEPTO O DESCRIPCIÓN</th>
              <th style="text-align: right">P. UNITARIO</th>
              <th style="text-align: right">TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $results = Doctrine_Query::create()
              ->select("FORMAT(REPLACE(fd.qty, ' ', ''), 0, 'de_DE') as qty, 
              fd.price_unit as punit, fd.price_tot as ptot, fd.descripcion as desc, fd.exento as exento")
              ->from('FacturaGastosDet fd')
              ->where('fd.factura_gastos_id = ?', $form->getObject()->get('id'))
              ->orderBy('fd.id ASC')
              ->execute();
            $total=0;
            foreach ($results as $result) {
              $exento="G";
              if(str_replace(" ", "_", $result["exento"])=="EXENTO") {
                $exento="E";
              }
            ?>
            <tr>
              <td style="vertical-align: middle" class="number2"><?php echo $result["qty"] ?></td>
              <td style="vertical-align: middle">
                <?php echo $result["desc"]." (".$exento.")" ?>
              </td>
              <td style="vertical-align: middle; text-align: right"><?php echo "USD <span class='moneyStr'>".$result["punit"];?></span></td>
              <td style="vertical-align: middle; text-align: right"><?php echo "USD <span class='moneyStr'>".$result["ptot"];?></span></td>
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
                <td style="text-align: right">
                  <?php echo "Bs <span class='moneyStr'>".$subtotal=number_float($form->getObject()->get('subtotal'))."</span>";?>
                </td>
              </tr>
              <?php 
                $desc=$form->getObject()->get('descuento');
                $descPorcentaje=$form->getObject()->get('subtotal_desc');
                $classStr="moneyStr";
                if($desc<=0) {
                  $desc="0,0000";
                  $descPorcentaje="0,0000";
                  $classStr="";
                }
                $iva_monto=$form->getObject()->get('iva_monto');
                $classStr2="moneyStr";
                if($iva_monto<=0) {
                  $classStr2="";
                  $iva_monto="0,0000";
                }
              ?>
              <tr>
                <td style="text-align: right"><b>DESCUENTO</b></td>
                <td style="text-align: right">
                  <?php echo "<span class='".$classStr."'>".$desc."</span>%";?>
                </td>
                <td style="text-align: right">
                  <?php echo "Bs <span class='".$classStr."'>".$descPorcentaje."</span>";?>
                </td>
              </tr>
              <tr>
                <td style="text-align: right"><b>IVA</b></td>
                <td style="text-align: right">
                  <?php echo "<span class='moneyStr'>".$form->getObject()->get('iva')."</span>%";?>
                </td>
                <td style="text-align: right">
                  <?php echo "Bs <span class='".$classStr2."'>".$iva_monto."</span>";?>
                </td>
              </tr>
              <tr>
                <td style="text-align: right"><b>TOTAL BS</b></td>
                <td></td>
                <td style="text-align: right"><?php echo "Bs <span class='moneyStr'>".$form->getObject()->get('total2')."</span>";?>
              </tr>
              <tr>
                <td style="text-align: right"><b>TOTAL USD</b></td>
                <td></td>
                <td style="text-align: right"><?php echo "$ <span class='moneyStr'>".$form->getObject()->get('total')."</span>";?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row no-print">
    <div class="col-12">
      <a href="#" class="btn btn-default" onclick="printDiv('invoice')">
        <i class="fas fa-print"></i> Imprimir
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
                <th>TOTAL</th>
                <th>MONTO RESTANTE POR PAGAR</th>
                <th>MONTO PAGADO</th>
                <th>ESTATUS</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $cuentas_pagar = Doctrine_Core::getTable('CuentasPagar')->findOneBy('factura_gastos_id', $form->getObject()->get('id'));
              ?>
              <tr>
                <td style="vertical-align: middle"><?php echo "USD <span class='moneyStr'>".$cuentas_pagar->getTotal(); ?></span></td>
                <td style="vertical-align: middle"><?php echo "USD <span class='moneyStr'>".$cuentas_pagar->getMontoFaltante(); ?></span></td>
                <td style="vertical-align: middle"><?php echo "USD <span class='moneyStr'>".$cuentas_pagar->getMontoPagado(); ?></span></td>
                <td>
                <?php
                if($cuentas_pagar->getEstatus()==1) {
                  echo "<span class='badge bg-info'>PENDIENTE</span>";
                } else if($cuentas_pagar->getEstatus()==2) {
                  echo "<span class='badge bg-warning'>ABONADO</span>";
                } else if($cuentas_pagar->getEstatus()==3) {
                  echo "<span class='badge bg-success'>CANCELADO</span>";
                } else if($cuentas_pagar->getEstatus()==4) {
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
        ->from('ReciboPagoCompra rp, rp.FormaPago fp')
        ->where('rp.cuentas_pagar_id = ?', $cuentas_pagar->getId())
        ->orderBy('rp.fecha DESC')
        ->execute();
        $total=0;
        foreach ($results as $result):
      ?>
        <div class="card" <?php if($result["anulado"]==1) { echo 'style="background: #f1daa759 !important;"'; }?>>
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Recibo de pago <?php echo "<a href='".url_for("recibo_pago_compra")."/show?id=".$result["rpid"]."' target='_blank'>[".$result["cod"]."]</a>"; ?>
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
        ->from('NotaDebitoDet ncd, ncd.NotaDebito nc, nc.FormaPago fp')
        ->where('ncd.cuentas_pagar_id = ?', $cuentas_pagar->getId())
        ->orderBy('ncd.created_at DESC')
        ->execute();
        $total=0;
        foreach ($results as $result):
      ?>
        <div class="card" <?php if($result["anulado"]==1) { echo 'style="background: #f1daa759 !important;"'; }?>>
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-text-width"></i>
              Nota de debito <?php echo "<a href='".url_for("nota_debito")."/show?id=".$result["ncid"]."' target='_blank'>[".$result["cod"]."]</a>"; ?>
              <?php if($result["anulado"]==1) { echo "<span class='badge bg-danger'>ANULADO</span>"; }?>
            </h3>
          </div>
          <div class="card-body">
            <blockquote>
              <p>Se proceso la cantidad en <h3>USD <?php echo $result["monto"]; ?></h3> de la nota de debito indicada arriba</p>
              <small><cite title="Source Title"><?php echo mb_strtoupper(format_datetime($result["created_at"], 'f', 'es_ES')); ?></cite></small>
            </blockquote>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

<div><div><div>

<script src="/plugins/printThis/printThis.js"></script>
<script>
  function printDiv(divName) {
    document.title='factura_gastos_<?php echo $form->getObject()->get('ncontrol'); ?>.pdf';
    $("#"+divName).printThis({
      pageTitle: 'factura_gastos_<?php echo $form->getObject()->get('ncontrol'); ?>.pdf',
    });
  }
  function anular() {
    var retVal = confirm("¿Estas seguro de anular la factura de gastos?");
    if( retVal == true ){
        location.href = "<?php echo url_for("factura_gastos")."/anular?id=".$form->getObject()->get('id')?>";
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
