<?php $proveedor=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$form->getObject()->get('proveedor_id'));?>
<?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
</div></div></div>
  <div class="invoice p-3 mb-3" id="invoice" <?php if($form->getObject()->get('anulado')==1) { echo 'style="background: #f1daa759 !important;"'; }?>>
    <div class="row">
      <div class="col-md-6">
        <h4>
          <img src='/images/<?php echo $empresa->getId()?>.png' height="60"/>
        </h4>
      </div>
      <div class="col-md-6">
        <?php if($form->getObject()->get('anulado')==1) { ?>
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
          <strong><?php echo $proveedor->getFullName(); ?> | <?php echo $proveedor->getDocId(); ?></strong><br>
          <span class="tcaps"><?php echo mb_strtolower($proveedor->getDireccion())?></span><br/>
          <b>Telf:</b> <?php echo $proveedor->getTelf(); ?><br>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <small class="float-right">FECHA: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('fecha')))); ?></small><br/>
        <b class="float-right">RECIBO DE PAGO</b><br/>
        <b class="float-right">#<?php echo ($form->getObject()->get('ncontrol')); ?><br/></b><br>
      </div>
    </div>
    <div class="row" style="margin-top: 2rem">
      <div class="col-md-12" style="margin-bottom: 0.7rem;">
        <b>RECIBI DE: </b><span style="text-decoration: underline;"><?php echo $form->getObject()->get('quien_paga'); ?></span>
      </div>
      <div class="col-md-6" style="margin-bottom: 0.7rem;">
        <b>BAJO LA FORMA DE PAGO: </b><span style="text-decoration: underline;"><?php echo $recibo_pago_compra->getFormaPago()." (".$recibo_pago_compra->getCoin().")"; ?></span>
      </div>
      <?php if($recibo_pago_compra->getMoneda()==1) { ?>
        <div class="col-md-3" style="margin-bottom: 0.7rem;">
          <b>CANTIDAD EN BS: </b><span style="text-decoration: underline;" class="moneyStr"><?php echo number_float($recibo_pago_compra->getMonto2()); ?></span>
        </div>
      <?php } ?>
      <div class="col-md-3" style="margin-bottom: 0.7rem;">
        <b>CANTIDAD EN USD: </b><span style="text-decoration: underline;" class="moneyStr"><?php echo number_float($recibo_pago_compra->getMonto()); ?></span>
      </div>
      <div class="col-md-12" style="margin-bottom: 2rem;">
        <b>POR CONCEPTO DE:</b>
        <?php echo htmlspecialchars_decode(stripslashes($form->getObject()->get('descripcion'))) ?>
      </div>
      <div class="col-md-6" style="margin-bottom: 0.7rem;">
        <b>RECIBIDO POR: </b> <span style="text-decoration: underline;"><?php echo $recibo_pago_compra->getCreator() ?></span>
      </div>
      <div class="col-md-6" style="margin-bottom: 0.7rem;">
        <b>FIRMA DEL USUARIO: </b> _____________________
      </div>
      <div class="col-md-6" style="margin-bottom: 0.7rem;">
          <b>FIRMA: </b> _____________________
      </div>
    </div>
  </div>
  <div class="row no-print">
    <div class="col-12">
      <a href="#" target="_blank" class="btn btn-info" onclick="printDiv('invoice')" >
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
      <h3 class="card-title">Detalles</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>DOCUMENTO</th>
                <th>FECHA EMISION DOC.</th>
                <th>ESTATUS DOC.</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $results = Doctrine_Query::create()
                  ->select('rp.id as rpdid, rp.monto as rpmonto, rp.anulado as rpanulado, rp.created_at,
                  cc.id as ccid, cc.factura_compra_id as ccfid, cc.estatus as ccestatus,
                  f.id as fid, f.num_factura as numfact, f.fecha as ffecha,
                  fg.id as fgid, fg.num_factura as numfactg, fg.fecha as fgfecha')
                  ->from('ReciboPagoCompra rp')
                  ->leftJoin('rp.CuentasPagar cc')
                  ->leftJoin('cc.FacturaCompra f')
                  ->leftJoin('cc.FacturaGastos fg')
                  ->where('rp.cuentas_pagar_id = ?', $recibo_pago_compra->getCuentasPagarId())
                  ->orderBy('rp.id DESC')
                  ->execute();
                $total=0;
                  foreach ($results as $result):
              ?>
              <?php if(!empty($result["fid"])): ?>
                <tr>
                  <?php
                      echo "<td style='vertical-align: middle'>FACT. COMPRA: <a target='_blank' href='".url_for("factura_compra")."/show?id=".$result["ccfid"]."'>".$result["numfact"]."</a></td>";
                      echo "<td style='vertical-align: middle'>".mb_strtoupper(format_datetime($result["ffecha"], 'D', 'es_ES'))."</a></td>";
                  ?>
                  <td>
                    <?php
                    if($result["ccestatus"]==1) {
                      echo "<span class='badge bg-info'>PENDIENTE</span>";
                    } else if($result["ccestatus"]==2) {
                      echo "<span class='badge bg-warning'>ABONADO</span>";
                    } else if($result["ccestatus"]==3) {
                      echo "<span class='badge bg-success'>CANCELADO</span>";
                    } else if($result["ccestatus"]==4) {
                      echo "<span class='badge bg-danger'>ANULADO</span>";
                    }
                    ?>
                  </td>
                </tr>
              <?php else: ?>
                <tr>
                  <?php
                      echo "<td style='vertical-align: middle'>FACT. GASTOS: <a target='_blank' href='".url_for("factura_gastos")."/show?id=".$result["fgid"]."'>".$result["numfactg"]."</a></td>";
                      echo "<td style='vertical-align: middle'>".mb_strtoupper(format_datetime($result["fgfecha"], 'D', 'es_ES'))."</a></td>";
                  ?>
                  <td>
                    <?php
                    if($result["ccestatus"]==1) {
                      echo "<span class='badge bg-info'>PENDIENTE</span>";
                    } else if($result["ccestatus"]==2) {
                      echo "<span class='badge bg-warning'>ABONADO</span>";
                    } else if($result["ccestatus"]==3) {
                      echo "<span class='badge bg-success'>CANCELADO</span>";
                    } else if($result["ccestatus"]==4) {
                      echo "<span class='badge bg-danger'>ANULADO</span>";
                    }
                    ?>
                  </td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<div><div><div>

<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
  function anular() {
    var retVal = confirm("¿Estas seguro de anular el recibo de pago?");
    if( retVal == true ){
        location.href = "<?php echo url_for("recibo_pago_compra")."/anular?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
  }
</script>


<?php
function number_float($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return floatval($number);
}
?>
