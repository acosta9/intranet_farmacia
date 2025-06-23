<?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
</div></div></div>
  <div class="invoice p-3 mb-3" id="invoice" <?php if($form->getObject()->get('anulado')) { echo 'style="background: #f1daa759 !important;"'; }?>>
    <div class="row">
      <div class="col-6">
        <h4>
          <img src='/images/<?php echo $empresa->getId()?>.png' height="60"/>
        </h4>
      </div>
      <div class="col-md-6">
        <?php if($form->getObject()->get('anulado')) { ?>
          <img src='/images/anulado.png' style="float:right"/>
        <?php } ?>
      </div>
    </div>
    <div class="row invoice-info">
      <div class="col-sm-5 invoice-col">
        <address>
          <strong><?php echo $empresa->getNombre()?> | <?php echo $empresa->getRif()?></strong><br/>
          <span class="tcaps"><?php echo mb_strtolower($empresa->getDireccion())?></span><br/>
          <b>Telf:</b> <?php echo $empresa->getTelefono()?><br/>
          <b>Email:</b> <?php echo mb_strtolower($empresa->getEmail())?>
        </address>
      </div>
      <div class="col-sm-5 invoice-col">
        <address>
          <p><?php echo "<b>Descripcion:</b> ".$inv_entrada->getDescripcion(); ?></p>
          <?php
            $entid=$form->getObject()->get('id');
            $q = Doctrine_Manager::getInstance()->getCurrentConnection();
            $results = $q->execute("SELECT e.nombre as emin, id.nombre as idname
            FROM inv_entrada ie
            LEFT JOIN empresa e ON ie.empresa_id=e.id
            LEFT JOIN inv_deposito id ON ie.deposito_id=id.id
            WHERE ie.id=$entid
            LIMIT 1");
          ?>
          <?php foreach ($results as $result): ?>
            <p><?php echo "<b>Deposito:</b> ".$result["emin"]." [".$result["idname"]."]"; ?></p>
          <?php endforeach; ?>
        </address>
      </div>
      <div class="col-sm-2 invoice-col">
        <small class="float-right">Fecha: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('created_at')))); ?></small><br/>
        <b class="float-right">Codigo: <?php echo ($form->getObject()->get('id')); ?></b><br>
      </div>
    </div>
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>CANT.</th>
              <th>CONCEPTO O DESCRIPCIÓN</th>
              <th>SERIAL</th>
              <th style="text-align: right">FECHA VENC.</th>
              <th style="text-align: right">LOTE</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $results = Doctrine_Query::create()
              ->select('ied.qty as qty, ied.fecha_venc as fvenc, ied.lote as lote, i.id as iid, p.nombre as nombre, p.serial as serial')
              ->from('InvEntradaDet ied, ied.Inventario i, i.Producto p')
              ->where('ied.inv_entrada_id = ?', $form->getObject()->get('id'))
              ->orderBy('ied.id ASC')
              ->execute();
              foreach ($results as $result) {
            ?>
            <tr>
              <td style="vertical-align: middle" class="number2"><?php echo $result["qty"] ?></td>
              <td style="vertical-align: middle"><?php echo $result["nombre"] ?></td>
              <td style="vertical-align: middle"><?php echo $result["serial"] ?></td>
              <td style="vertical-align: middle; text-align: right"><?php echo date("d/m/Y", strtotime($result["fecha_venc"]));?></td>
              <td style="vertical-align: middle; text-align: right"><?php echo $result["lote"];?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row no-print">
    <div class="col-12">
      <a href="#" class="btn btn-default" onclick="printDiv('invoice')" >
        <i class="fas fa-print"></i> Imprimir
      </a>
      <?php if($form->getObject()->get('anulado')==0): ?>
        <button onclick="anular()" class="btn btn-danger float-right" style="margin-right: 5px;">
          <i class="fas fa-minus-circle"></i> Anular
        </button>
      <?php endif; ?>
    </div>
  </div>
<br/><br/>
<div><div><div>
<script src="/plugins/printThis/printThis.js"></script>
<script>
  function printDiv(divName) {
    document.title='inv_entrada_<?php echo $form->getObject()->get('id'); ?>.pdf';
    $("#"+divName).printThis({
      pageTitle: 'inv_entrada_<?php echo $form->getObject()->get('id'); ?>.pdf',
    });
  }
  function anular() {
    var retVal = confirm("¿Estas seguro de anular este documento?");
    if( retVal == true ){
        location.href = "<?php echo url_for("inv_entrada")."/anular?id=".$form->getObject()->get('id')?>";
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
