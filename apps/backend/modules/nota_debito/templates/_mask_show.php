<?php $proveedor=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$form->getObject()->get('proveedor_id'));?>
<?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
</div></div></div>
  <div class="invoice p-3 mb-3" id="invoice" <?php if($form->getObject()->get('estatus')==3) { echo 'style="background: #f1daa759 !important;"'; }?>>
    <div class="row">
      <div class="col-md-6">
        <h4>
          <img src='/images/<?php echo $empresa->getId()?>.png' height="60"/>
        </h4>
      </div>
      <div class="col-md-6">
        <?php if($form->getObject()->get('estatus')==3) { ?>
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
        <b class="float-right">NC: <?php echo ($form->getObject()->get('quien_paga')); ?></b><br/>
        <b class="float-right">N° Control: <?php echo ($form->getObject()->get('num_recibo')); ?></b><br/>
      </div>
    </div>
    <div class="row" style="margin-top: 2rem">
      <?php if($nota_debito->getMoneda()==1) { ?>
        <div class="col-md-3" style="margin-bottom: 0.7rem;">
          <b>CANTIDAD EN BS: </b><span style="text-decoration: underline;" class="moneyStr"><?php echo number_float($nota_debito->getMonto())*number_float($nota_debito->getTasaCambio()); ?></span>
        </div>
      <?php } ?>
      <div class="col-md-3" style="margin-bottom: 0.7rem;">
        <b>CANTIDAD EN USD: </b><span style="text-decoration: underline;" class="moneyStr"><?php echo number_float($nota_debito->getMonto()); ?></span>
      </div>
      <div class="col-md-12" style="margin-bottom: 2rem;">
        <b>DESCRIPCION:</b>
        <?php echo htmlspecialchars_decode(stripslashes($form->getObject()->get('descripcion'))) ?>
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
      <h3 class="card-title">Estatus</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>TOTAL</th>
                <th>MONTO PENDIENTE</th>
                <th>ESTATUS</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="vertical-align: middle"><?php echo "USD <span class='moneyStr'>".$nota_debito->getMonto()."</span>"; ?></td>
                <?php if($nota_debito->getMontoFaltante()>0): ?>
                  <td style="vertical-align: middle"><?php echo "USD <span class='moneyStr'>".$nota_debito->getMontoFaltante()."</span>"; ?></td>
                <?php else: ?>
                  <td style="vertical-align: middle"><?php echo "USD 0.0000"; ?></td>
                <?php endif; ?>
                <td>
                  <?php
                    if($nota_debito->getEstatus()==1) {
                      echo "<span class='badge bg-info'>PENDIENTE</span>";
                    } else if($nota_debito->getEstatus()==2) {
                      echo "<span class='badge bg-warning'>PROCESADO</span>";
                    } else if($nota_debito->getEstatus()==3) {
                      echo "<span class='badge bg-success'>ANULADO</span>";
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
      <h3 class="card-title">Detalles</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>DOCUMENTO</th>
                <th>FECHA</th>
                <th>MONTO</th>
                <th>ESTATUS</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $results = Doctrine_Query::create()
                  ->select('ncd.id as ncdid, ncd.monto as ncdmonto, ncd.anulado as ncdanulado, ncd.created_at,
                  cc.id as ccid, cc.factura_compra_id as ccfid, cc.estatus as ccestatus,
                  f.id as fid, f.num_factura as numfact')
                  ->from('NotaDebitoDet ncd')
                  ->leftJoin('ncd.CuentasPagar cc')
                  ->leftJoin('cc.FacturaCompra f')
                  ->where('ncd.nota_debito_id = ?', $nota_debito->getId())
                  ->orderBy('ncd.id DESC')
                  ->execute();
                $total=0;
                  foreach ($results as $result):
              ?>
              <tr>
                <td style="vertical-align: middle">
                  <?php
                    echo "FACTURA: <a target='_blank' href='".url_for("factura_compra")."/show?id=".$result["ccfid"]."'>".$result["numfact"]."</a>";
                  ?>
                </td>
                <td style="vertical-align: middle"><?php echo $result->getCreatedAtTxt(); ?></td>
                <td style="vertical-align: middle">USD <span class="number"><?php echo $result["ncdmonto"]; ?></span></td>
                <td>
                <?php
                  if($result["ncdanulado"]==1) {
                    echo "<span class='badge bg-danger'>ANULADO</span>";
                  } else {
                    echo "<span class='badge bg-success'>PROCESADO</span>";
                  }
                 ?>
               </td>
               <td>
                 <?php
                 if($result["ncdanulado"]==1) { ?>
                   <a href="#" onclick="anular_item(<?php echo $nota_debito->getId().','.$result->getId(); ?>)" class="btn btn-danger float-right disabled">
                     <i class="fas fa-minus-circle"></i> Anular
                   </a>
                 <?php } else { ?>
                   <a href="#" onclick="anular_item(<?php echo $nota_debito->getId().','.$result->getId(); ?>)" class="btn btn-danger float-right">
                     <i class="fas fa-minus-circle"></i> Anular
                   </a>
                 <?php } ?>
               </td>
              </tr>
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
        location.href = "<?php echo url_for("nota_debito")."/anular?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
  }
  function anular_item(ndid, id) {
    var retVal = confirm("¿Estas seguro de anular el detalle de la nota de debito?");
    if( retVal == true ){
        location.href = "<?php echo url_for("nota_debito")."/anularItem?ndid="?>"+ndid+"&id="+id;
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
