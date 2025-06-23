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
          <b>Email:</b> <?php echo $empresa->getEmail()?>
        </address>
      </div>
      <div class="col-sm-5 invoice-col">
        <address>
          <p><?php echo "<b>Descripcion:</b> ".$inv_ajuste->getDescripcion(); ?></p>
          <?php
            $ieid=$form->getObject()->get('id');
            $q = Doctrine_Manager::getInstance()->getCurrentConnection();
            $results = $q->execute("SELECT e.nombre as emin, id.nombre as idname
            FROM inv_ajuste ie
            LEFT JOIN empresa e ON ie.empresa_id=e.id
            LEFT JOIN inv_deposito id ON ie.deposito_id=id.id
            WHERE ie.id='$ieid'
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
              <th></th>
              <th colspan="3" style="text-align: center; border:1px solid #000">VALORES PREVIOS</th>
              <th colspan="3" style="text-align: center; border:1px solid #000">VALORES NUEVOS</th>
            </tr>
            <tr>
              <th>CONCEPTO O DESCRIPCIÓN</th>
              <th style="text-align: center; border-left:1px solid #000;">CANT.</th>
              <th style="text-align: center">F. VENC.</th>
              <th style="text-align: center">LOTE</th>
              <th style="text-align: center; border-left:1px solid #000">CANT.</th>
              <th style="text-align: center">F. VENC.</th>
              <th style="text-align: center; border-right:1px solid #000;">LOTE</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $results = Doctrine_Query::create()
              ->select('iad.qty as qty, id.id as idid, iad.lote as lote, iad.fecha_venc as fecha_venc, iad.devolucion as devolucion,
               i.id as iid, p.nombre as nombre, p.serial as serial')
              ->from('InvAjusteDet iad, iad.Inventario i, iad.InventarioDet id, i.Producto p')
              ->where('iad.inv_ajuste_id = ?', $form->getObject()->get('id'))
              ->orderBy('iad.id ASC')
              ->execute();
              foreach ($results as $result) {
                list($qty, $fvenc, $lote)=explode("|",$result["devolucion"]);
            ?>
            <tr>
              <td style="vertical-align: middle">
                <?php
          if($result->getTipo()==1)
          {
            $ttipo="=> SUMA DE INV. (+".$result["qty"].")";
            $qty_new=$qty+$result["qty"];
          }else
          {
            $ttipo="=> RESTA DE INV. (-".$result["qty"].")";
            $qty_new=$qty-$result["qty"];
          } ?>
                <?php echo $result["nombre"] ?>  <b><?php echo $ttipo; ?></b><br/><small>
                <?php echo $result["serial"] ?></small>
              </td>
              <td style="vertical-align: middle; border-left:1px solid #000; text-align: center" class="number2"><?php echo $qty ?></td>
              <td style="vertical-align: middle; text-align: center"><?php echo $fvenc ?></td>
              <td style="vertical-align: middle; text-align: center"><?php echo $lote ?></td>
              <td style="vertical-align: middle; border-left:1px solid #000; text-align: center" class="number2"><?php echo $qty_new ?></td>
              <td style="vertical-align: middle; text-align: center"><?php echo $result["fecha_venc"];?></td>
              <td style="vertical-align: middle; border-right:1px solid #000; text-align: center"><?php echo $result["lote"];?></td>
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
    </div>
  </div>
<br/><br/>
<div><div><div>
<script src="/plugins/printThis/printThis.js"></script>
<script>
  function printDiv(divName) {
    document.title='inv_ajuste_<?php echo $form->getObject()->get('id'); ?>.pdf';
    $("#"+divName).printThis({
      pageTitle: 'inv_ajuste_<?php echo $form->getObject()->get('id'); ?>.pdf',
    });
  }
</script>


<?php
function number_float($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return $number;
}
?>
