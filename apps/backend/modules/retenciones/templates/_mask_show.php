<?php $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$form->getObject()->get('cliente_id'));?>
<?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
<?php $cuentas_cobrar=Doctrine_Core::getTable('CuentasCobrar')->findOneBy('id',$form->getObject()->get('cuentas_cobrar_id'));?>
<?php $factura=Doctrine_Core::getTable('Factura')->findOneBy('id',$cuentas_cobrar->getFacturaId());?>
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
          <strong><?php echo $cliente->getFullName(); ?> | <?php echo $cliente->getDocId(); ?></strong><br>
          <span class="tcaps"><?php echo mb_strtolower($cliente->getDireccion())?></span><br/>
          <b>Telf:</b> <?php echo $cliente->getTelf(); ?><br>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <small class="float-right">FECHA: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('fecha')))); ?></small><br/>
        <b class="float-right">COMPROBANTE</b><br/>
        <b class="float-right">#<?php echo ($form->getObject()->get('comprobante')); ?><br/></b><br>
      </div>
    </div>
    <div class="row" style="margin-top: 2rem">
      <div class="col-md-3">
        <div class="form-group">
          <label>FACTURA</label>
          <div class="input-group margin">
            <input type="text" class="form-control" value="<?php echo $factura->getNumFactura(); ?>" readonly="">
            <span class="input-group-btn">
              <a href="<?php echo url_for("factura")."/show?id=".$factura->getId(); ?>" class="btn btn-info btn-flat" target="_blank">Ver Factura!</a>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>TIPO</label>
          <input type="text" value="<?php echo $retenciones->getTipoTxt(); ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>MONTO RETENIDO BS</label>
          <input type="text" value="<?php echo number_format(number_float($retenciones->getMonto()), 4, '.', ','); ?>" class="form-control number" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>MONTO RETENIDO USD</label>
          <input type="text" value="<?php echo number_format(number_float($retenciones->getMontoUsd()), 4, '.', ','); ?>" class="form-control number" readonly="">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group">
          <label>ADJUNTO</label><br/>
          <?php if($retenciones->getUrlImagen()) { ?>
            <a class="btn btn-default" href="/uploads/retenciones/<?php echo $retenciones->getUrlImagen(); ?>" target="_blank">
              <i class="fas fa-file-alt"></i>
            </a>
          <?php } else {?>
            <a class="btn btn-default" href="#"><i class="fas fa-file-alt"></i></a>
          <?php }?>
        </div>
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
    var retVal = confirm("¿Estas seguro de anular el comprobante de retencion?");
    if( retVal == true ){
        location.href = "<?php echo url_for("retenciones")."/anular?id=".$form->getObject()->get('id')?>";
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
