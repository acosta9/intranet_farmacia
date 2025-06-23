<?php $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$form->getObject()->get('cliente_id'));?>
<?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
</div></div></div>
<div class="invoice p-3 mb-3" id="invoice" <?php if($form->getObject()->get('orden_compra_estatus_id')==3) { echo 'style="background: #f1daa759 !important;"'; }?>>
  <div class="row">
    <div class="col-6">
      <h4>
        <img src='/images/<?php echo $empresa->getId()?>.png' height="60"/>
      </h4>
    </div>
    <div class="col-md-6">
      <?php if($form->getObject()->get('orden_compra_estatus_id')==3) { ?>
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
      <small class="float-right">Emision: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('created_at')))); ?></small><br/>
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
            <th style="text-align: right">P. UNITARIO</th>
            <th style="text-align: right">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $results = Doctrine_Query::create()
            ->select('ocd.qty as qty, ocd.price_unit as punit, ocd.price_tot as ptot, 
            i.id as iid, p.nombre as nombre, p.serial as serial, ofer.id as oferid, ofer.nombre as ofname, ofer.ncontrol as ofserial')
            ->from('OrdenCompraDet ocd, ocd.Inventario i, i.Producto p, ocd.Oferta ofer')
            ->where('ocd.orden_compra_id = ?', $form->getObject()->get('id'))
            ->orderBy('ocd.id ASC')
            ->execute();
          $total=0;
            foreach ($results as $result) {
              $items = explode(';', $result["descripcion"]);
              $total+=number_float($result["ptot"]);
          ?>
          <tr>
            <td style="vertical-align: middle" class="number2"><?php echo $result["qty"] ?></td>
            <td style="vertical-align: middle">
              <?php echo $result["nombre"].$result["ofname"] ?><br/>
              <small><b>s/n: <?php echo $result["serial"].$result["ofserial"]; ?></b></small>
            </td>
            <td style="vertical-align: middle; text-align: right"><?php echo "USD ".number_format(number_float($result["punit"]), 4, ',', '.');?></td>
            <td style="vertical-align: middle; text-align: right"><?php echo "USD ".number_format(number_float($result["ptot"]), 4, ',', '.');?></td>
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
                <?php echo "USD ".number_format(number_float($form->getObject()->get('total')), 4, ',', '.');?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="row no-print">
  <div class="col-12">
    <a href="<?php echo url_for("@orden_compra")."/print?id=".$form->getObject()->get('id')?>" target="_blank" class="btn btn-default" >
      <i class="fas fa-print"></i> Imprimir
    </a>
    <?php if($form->getObject()->get('orden_compra_estatus_id')==1): ?>
      <a href="<?php echo url_for("@factura")."/new?oc=1&id=".$form->getObject()->get('id')?>" class="btn btn-warning" >
        <i class="fas fa-file-invoice"></i> Convertir a Factura
      </a>
    <?php endif; ?>
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
              if($fact=Doctrine_Core::getTable('Factura')->findOneBy('orden_compra_id', $form->getObject()->get('id'))):
                $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('factura_id', $fact->getId());
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
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
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
    var retVal = confirm("¿Estas seguro de anular la orden de compra?");
    if( retVal == true ){
        location.href = "<?php echo url_for("orden_compra")."/anular?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
  }
</script>
