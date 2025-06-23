<?php
use_helper('Date');
if(!$sf_params->get('id')=='0') {
  $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$sf_params->get('id'));
}
?>
<div class="card card-primary">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php
        $results = Doctrine_Query::create()
        ->select('c.id as cid, c.total as mtot, c.monto_pagado as mpag, c.monto_faltante as mfal, c.tasa_cambio as tasa,
        f.id as fid, f.num_factura as fnum, f.fecha as ffecha, c.nota_entrega_id')
          ->from('CuentasCobrar c')
          ->leftJoin('c.Factura f')
          ->where('f.cliente_id = ?', $cliente->getId())
          ->andWhere('c.estatus = 1 || c.estatus = 2')
          ->andWhere('c.nota_entrega_id IS NULL')
          ->orderBy('c.id DESC')
          ->execute();
        ?>
        <h4>Facturas pendientes</h4>
        <table class="table table-hover table-striped" id="cuentas_cobrar_table">
          <thead>
            <tr role="row">
              <th>Fecha</th>
              <th>Factura</th>
              <th>Total</th>
              <th>Pagado</th>
              <th>Pendiente</th>
              <th>Tasa</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($results as $result)  { ?>
              <tr>
                <?php
                  echo "<td>".strtoupper(format_datetime($result["ffecha"], 'D', 'es_ES'))."</td>";
                  echo "<td>FACTURA - <a target='_blank' href='".url_for("factura")."/show?id=".$result["fid"]."'>".$result["fnum"]."</a></td>";
                ?>
                <td><?php echo "USD ".number_format(number_float($result["mtot"]), 4, ',', '.')?></td>
                <td><?php echo "USD ".number_format(number_float($result["mpag"]), 4, ',', '.')?></td>
                <td ><?php echo "USD <span class='pendiente_".$result["cid"]."'>".number_format(number_float($result["mfal"]), 4, ',', '.')?></span></td>
                <td class="tasa_<?php echo $result["cid"]; ?>"><?php echo number_format(number_float($result["tasa"]), 4, ',', '.')?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
  function number_float($str) {
    $stripped = str_replace(' ', '', $str);
    $number = str_replace(',', '', $stripped);
    return floatval($number);
  }
?>
<div class="card card-primary">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="retenciones_cuentas_cobrar_id">Seleccione una opción</label>
          <select name="retenciones[cuentas_cobrar_id]" class="form-control" id="retenciones_cuentas_cobrar_id">
            <?php foreach ($results as $result)  {
                echo "<option value='".$result["cid"]."'>FACTURA - ".$result["fnum"]."</option>";
            } ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row" id="footer_reten">
    </div>
  </div>
</div>
<script>
  $( document ).ready(function() {
    $('#footer_reten').load('<?php echo url_for('retenciones/footer') ?>?id='+$("#retenciones_cuentas_cobrar_id").val()).fadeIn("slow");

    $("#retenciones_cuentas_cobrar_id").on('change', function(event){
      $('#footer_reten').load('<?php echo url_for('retenciones/footer') ?>?id='+$("#retenciones_cuentas_cobrar_id").val()).fadeIn("slow");
    });
  });
</script>
