<?php
use_helper('Date');
if(!empty($sf_params->get('id'))) {
  $client=Doctrine_Core::getTable('Cliente')->findOneBy('id',$sf_params->get('id'));
}
?>
<div class="card card-primary">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php
        $results = Doctrine_Query::create()
          ->select('c.id as cid, c.total as mtot, c.monto_pagado as mpag, c.monto_faltante as mfal, c.tasa_cambio as tasa,
          f.id as fid, f.num_factura as fnum, f.fecha as ffecha, ne.id as neid, ne.ncontrol as nenum, ne.fecha as nefecha')
          ->from('CuentasCobrar c')
          ->leftJoin('c.Factura f')
          ->leftJoin('c.NotaEntrega ne')
          ->where('c.cliente_id = ?', $client->getId())
          ->andWhere('c.estatus <>3')
          ->andWhere('c.estatus <>4')
          ->orderBy('c.id DESC')
          ->execute();
        ?>
        <h4>Cuentas por cobrar</h4>
        <table class="table table-hover table-striped" id="cuentas_cobrar_table">
          <thead>
            <tr role="row">
              <th>Fecha</th>
              <th>Documento</th>
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
                if($result["fid"]) {
                  echo "<td>".strtoupper(format_datetime($result["ffecha"], 'D', 'es_ES'))."</td>";
                  echo "<td>FACTURA - <a target='_blank' href='".url_for("factura")."/show?id=".$result["fid"]."'>".$result["fnum"]."</a></td>";
                } else {
                  echo "<td>".strtoupper(format_datetime($result["nefecha"], 'D', 'es_ES'))."</td>";
                  echo "<td>NOTA EN - <a target='_blank' href='".url_for("nota_entrega")."/show?id=".$result["neid"]."'>".$result["nenum"]."</a></td>";
                }
                ?>
                <td><?php echo "USD ".number_format(number_float($result["mtot"]), 4, ',', '.')?></td>
                <td><?php echo "USD ".number_format(number_float($result["mpag"]), 4, ',', '.')?></td>
                <td ><?php echo "USD <span class='pendiente_".$result["cid"]."'>".$result["mfal"]?></span></td>
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

<?php
$results_cred = Doctrine_Query::create()
  ->select('nc.id as ncid, nc.fecha as fecha, nc.monto as monto, nc.monto_faltante as mfalta')
  ->from('NotaCredito nc')
  ->where('nc.cliente_id = ?', $sf_params->get('id'))
  ->andWhere('nc.estatus = 1')
  ->orderBy('nc.id DESC')
  ->execute();
if(count($results_cred)>0):
?>
<div class="card card-primary">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <h4>Notas de credito</h4>
        <table class="table table-hover table-striped" id="nota_credito_table">
          <thead>
            <tr role="row">
              <th>Fecha</th>
              <th>Total</th>
              <th>Pendiente</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($results_cred as $result_cred)  { ?>
              <tr>
                <?php
                  echo "<td>".strtoupper(format_datetime($result_cred["fecha"], 'D', 'es_ES'))."</td>";
                ?>
                <td><?php echo "USD ".$result_cred["monto"]?></td>
                <td><?php echo "USD ".$result_cred["mfalta"]?></td>
                <td>
                  <div class="form-group">
                    <select class="form-control" id="nota_credito_ccid">
                      <?php foreach ($results as $result)  {
                        if($result["fid"]) {
                          echo "<option value='".$result["cid"]."'>FACTURA - ".$result["fnum"]."</option>";
                        } else {
                          echo "<option value='".$result["cid"]."'>NOTA EN - ".$result["nenum"]."</option>";
                        }
                      } ?>
                    </select>
                  </div>
                </td>
                <td>
                  <a href="#" onclick="procesar_credito(<?php echo $result_cred["ncid"]; ?>)" class="btn btn-success float-right">
                    <i class="fas fa-check"></i> Procesar
                  </a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="card card-primary">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_cuentas_cobrar_id">Seleccione una opción</label>
          <select name="recibo_pago[cuentas_cobrar_id]" class="form-control" id="recibo_pago_cuentas_cobrar_id">
            <?php foreach ($results as $result)  {
              if($result["fid"]) {
                echo "<option value='".$result["cid"]."'>FACTURA - ".$result["fnum"]."</option>";
              } else {
                echo "<option value='".$result["cid"]."'>NOTA EN - ".$result["nenum"]."</option>";
              }
            } ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_fecha">Fecha</label>
          <input type="text" name="recibo_pago[fecha]" id="recibo_pago_fecha" value="<?php $date2 = new DateTime(); echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" readonly="readonly">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_quien_paga">Emisor</label>
          <input type="text" name="recibo_pago[quien_paga]" class="form-control" id="recibo_pago_quien_paga"/>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_num_recibo">N° de Referencia</label>
          <input type="text" name="recibo_pago[num_recibo]" class="form-control" id="recibo_pago_num_recibo"/>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_moneda">Moneda</label>
          <select name="recibo_pago[moneda]" class="form-control" id="recibo_pago_moneda">
            <option value="1">BOLIVARES</option>
            <option value="2" selected>DOLARES</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group" id="form_pago">
        </div>
      </div>
      <div class="col-md-6"></div>
      <div class="col-md-3">
        <label for="recibo_pago_tasa_cambio">Monto</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <input class="form-control money_intern" type="text" name="recibo_pago[monto]" id="recibo_pago_monto">
        </div>
      </div>
      <div class="col-md-3">
        <label for="recibo_pago_tasa_cambio">Monto</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BS</span>
          </div>
          <input class="form-control money_intern" type="text" id="monto_bs">
        </div>
      </div>
      <div class="col-md-3">
        <label for="recibo_pago_tasa_cambio">Tasa</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BS</span>
          </div>
          <input class="form-control money_intern" type="text" name="recibo_pago[tasa_cambio]" id="recibo_pago_tasa_cambio">
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$( document ).ready(function() {
  $('#loading').fadeOut( "slow", function() {});
  $('.money_intern').mask("#.##0,0000", {
    clearIfNotMatch: true,
    placeholder: "#,####",
    reverse: true
  });
  $('#form_pago').load('<?php echo url_for('recibo_pago/getForma') ?>?id='+$("#recibo_pago_moneda").val()).fadeIn("slow");
  getTasa();
  sumar();
});

$("#recibo_pago_cuentas_cobrar_id").on('change', function(event){
  getTasa();
});

$("#recibo_pago_moneda").on('change', function(event){
  $('#form_pago').load('<?php echo url_for('recibo_pago/getForma') ?>?id='+this.value).fadeIn("slow");
});

$('#recibo_pago_monto').keyup(function(){
  sumar();
});

$('#monto_bs').keyup(function(){
  sumar();
});

$('#recibo_pago_tasa_cambio').keyup(function(){
  sumar();
});

function getTasa() {
  var cc_id=$('#recibo_pago_cuentas_cobrar_id').val();
  var tasa = number_float($("#cuentas_cobrar_table").find('.tasa_'+cc_id).text());
  if(tasa) {
    $('#recibo_pago_tasa_cambio').val(SetMoney(tasa));
  } else {
    $('#recibo_pago_tasa_cambio').val("0");
  }
}

function sumar() {
  var tasa = 0;
  var monto = 0;
  var monto_bs = 0;
  if($("#recibo_pago_tasa_cambio").val()) {
    tasa = number_float($("#recibo_pago_tasa_cambio").val());
  }
  if($("#recibo_pago_monto").val()) {
    monto = number_float($("#recibo_pago_monto").val());
  }
  if($("#monto_bs").val()) {
    monto_bs = number_float($("#monto_bs").val());
  }

  if($("#recibo_pago_moneda").val()==1) {
    var total=monto_bs/tasa;
    $("#recibo_pago_monto").val(SetMoney(total));
  } else {
    var total=monto*tasa;
    $("#monto_bs").val(SetMoney(total));
  }

}

function procesar_credito(ncid) {
  var ccid=$("#nota_credito_ccid").val();
  location.href = "<?php echo url_for("nota_credito")."/procesar?ccid="?>"+ccid+"&ncid="+ncid;
}
</script>
