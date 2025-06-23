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
        <small class="float-right">Dias de Credito: <?php echo $nota_entrega->getDiasCredito(); ?></small><br/>
        <b class="float-right">N° Control: <?php echo ($form->getObject()->get('ncontrol')); ?></b><br>
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
              ->select('ned.exento as exento, ned.qty as qty, ned.price_unit as punit, ned.price_tot as ptot, 
              i.id as iid, p.nombre as nombre, p.serial as serial, ofer.id as oferid, ofer.nombre as ofname, ofer.ncontrol as ofserial')
              ->from('NotaEntregaDet ned, ned.Inventario i, i.Producto p, ned.Oferta ofer')
              ->where('ned.nota_entrega_id = ?', $form->getObject()->get('id'))
              ->orderBy('ned.id ASC')
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
                  <?php echo "USD ".number_format(($desc*$subtotal)/100, 2, '.', ' ');?>
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
      <a href="<?php echo url_for("@nota_entrega")."/print?id=".$form->getObject()->get('id')?>" target="_blank" class="btn btn-default" >
        <i class="fas fa-print"></i> Imprimir
      </a>
      <a href="<?php echo url_for("@nota_entrega")."/print2?id=".$form->getObject()->get('id')?>" target="_blank" class="btn btn-success" >
        <i class="fas fa-stamp"></i> Forma Libre
      </a>
      <a href="<?php echo url_for("@nota_entrega")."/convertir?id=".$form->getObject()->get('id')?>" class="btn btn-warning" >
        <i class="fas fa-file-invoice"></i> Convertir a Factura
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
              <th>FACTURA</th>
              <th>TOTAL</th>
              <th>MONTO RESTANTE POR PAGAR</th>
              <th>MONTO PAGADO</th>
              <th>ESTATUS</th>
            </tr>
          </thead>
          <tbody>
            <?php
              if($fact=Doctrine_Core::getTable('Factura')->findOneBy('nota_entrega_id', $form->getObject()->get('id'))) {
                $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('factura_id', $fact->getId());
              } else {
                $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('nota_entrega_id', $form->getObject()->get('id'));
              }
            ?>
            <tr>
              <td style="vertical-align: middle">
                <?php
                if($fact) {
                  echo "<a href='".url_for("factura")."/show?id=".$fact->getId()."' target='_blank'>".$fact->getNumFactura()."</a>";
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
<?php
  function number_float($str) {
    $stripped = str_replace(' ', '', $str);
    $number = str_replace(',', '', $stripped);
    return floatval($number);
  }
?>
<script>
  function anular() {
    var retVal = confirm("¿Estas seguro de anular la nota de entrega?");
    if( retVal == true ){
        location.href = "<?php echo url_for("nota_entrega")."/anular?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
  }
</script>
