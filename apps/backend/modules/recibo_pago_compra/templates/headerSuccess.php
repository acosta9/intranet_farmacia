<?php
$empresa_id=$sf_params->get('emp');
use_helper('Date');
if(!empty($sf_params->get('id'))) {
  $proveedor=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$sf_params->get('id'));
}
?>
<div class="card card-primary">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php
        $results = Doctrine_Query::create()
          ->select('c.id as cid, c.total as mtot, c.monto_pagado as mpag, c.monto_faltante as mfal, c.monto_faltante_bs as mfalbs, c.tasa_cambio as tasa,
          f.id as fid, f.num_factura as fnum, f.fecha as ffecha, f.total2 as ftotal2,
          fg.id as fgid, fg.num_factura as fgnum, fg.fecha as fgfecha, fg.total2 fgtotal2')
          ->from('CuentasPagar c')
          ->leftJoin('c.FacturaCompra f')
          ->leftJoin('c.FacturaGastos fg')
          ->where('c.proveedor_id = ?', $proveedor->getId())
          ->andWhere('c.empresa_id = ?', $empresa_id)
          ->andWhere('c.estatus <>3')
          ->andWhere('c.estatus <>4')
          ->orderBy('c.id DESC')
          ->execute();
        ?>
        <h4>Cuentas por pagar</h4>
        <table class="table table-hover table-striped" id="cuentas_pagar_table">
          <thead>
            <tr role="row">
              <th>Fecha Emision</th>
              <th>Documento</th>
              <th style="text-align: right">Total BS</th>
              <th style="text-align: right">Total</th>
              <th style="text-align: right">Pagado</th>
              <th style="text-align: right">Pendiente</th>
              <th style="text-align: right">Pendiente</th>
              <th style="text-align: right">Tasa</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($results as $result)  { ?>
              <?php if(!empty($result["fid"])): ?>
                <tr>
                  <?php
                    echo "<td>".strtoupper(format_datetime($result["ffecha"], 'D', 'es_ES'))."</td>";
                    echo "<td>FACT. COMPRA - <a target='_blank' href='".url_for("factura_compra")."/show?id=".$result["fid"]."'>".$result["fnum"]."</a></td>";
                  ?>
                  <td style="text-align: right"><?php echo "BS <span class='moneyStr2'>".$result["ftotal2"]?></span></td>
                  <td style="text-align: right"><?php echo "USD <span class='moneyStr2'>".$result["mtot"]?></span></td>
                  <?php if($result["mpag"]>0): ?>
                    <td style="text-align: right"><?php echo "USD <span class='moneyStr2'>".$result["mpag"]; ?></span></td>
                  <?php else: ?>
                    <td style="text-align: right">USD <span>0,0000</span></td>
                  <?php endif; ?>
                  <td style="text-align: right"><?php echo "USD <span class='pendiente_".$result["cid"]." moneyStr2'>".$result["mfal"]?></span></td>
                  <td style="text-align: right"><?php echo "BSS <span class='pendientebs_".$result["cid"]." moneyStr2'>".$result["mfalbs"]?></span></td>
                  <td style="text-align: right" class="tasa_<?php echo $result["cid"]; ?> moneyStr2"><?php echo $result["tasa"]?></td>
                </tr>
              <?php else: ?>
                <tr>
                  <?php
                    echo "<td>".strtoupper(format_datetime($result["fgfecha"], 'D', 'es_ES'))."</td>";
                    echo "<td>FACT. GASTOS - <a target='_blank' href='".url_for("factura_gastos")."/show?id=".$result["fgid"]."'>".$result["fgnum"]."</a></td>";
                  ?>
                  <td style="text-align: right"><?php echo "BS <span class='moneyStr2'>".$result["fgtotal2"]?></span></td>
                  <td style="text-align: right"><?php echo "USD <span class='moneyStr2'>".$result["mtot"]?></span></td>
                  <?php if($result["mpag"]>0): ?>
                    <td style="text-align: right"><?php echo "USD <span class='moneyStr2'>".$result["mpag"]; ?></span></td>
                  <?php else: ?>
                    <td style="text-align: right">USD <span>0,0000</span></td>
                  <?php endif; ?>
                  <td style="text-align: right"><?php echo "USD <span class='pendiente_".$result["cid"]." moneyStr2'>".$result["mfal"]?></span></td>
                  <td style="text-align: right"><?php echo "BSS <span class='pendientebs_".$result["cid"]." moneyStr2'>".$result["mfalbs"]?></span></td>
                  <td style="text-align: right" class="tasa_<?php echo $result["cid"]; ?> moneyStr2"><?php echo $result["tasa"]?></td>
                </tr>
              <?php endif; ?>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php
$results_cred = Doctrine_Query::create()
  ->select('nc.id as ncid, nc.fecha as fecha, nc.monto as monto, nc.monto_faltante as mfalta')
  ->from('NotaDebito nc')
  ->where('nc.proveedor_id = ?', $sf_params->get('id'))
  ->andWhere('nc.estatus = 1')
  ->orderBy('nc.id DESC')
  ->execute();
if(count($results_cred)>0):
?>
<div class="card card-primary">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <h4>Notas de Cr&eacute;dito</h4>
        <table class="table table-hover table-striped" id="nota_debito_table">
          <thead>
            <tr role="row">
              <th>Fecha</th>
              <th style="text-align: right">Total</th>
              <th style="text-align: right">Pendiente</th>
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
                <td style="text-align: right"><?php echo "USD <span class='moneyStr2'>".$result_cred["monto"]?></span></td>
                <td style="text-align: right"><?php echo "USD <span class='moneyStr2'>".$result_cred["mfalta"]?></span></td>
                <td style="text-align: right">
                  <div class="form-group">
                    <select class="form-control" id="nota_debito_ccid">
                      <?php
                        foreach ($results as $result)  {
                          if(!empty($result["fid"])):
                            echo "<option value='".$result["cid"]."'>FACT. COMPRA - ".$result["fnum"]."</option>";
                          else:
                            echo "<option value='".$result["cid"]."'>FACT. GASTOS - ".$result["fgnum"]."</option>";
                          endif;
                        } 
                      ?>
                    </select>
                  </div>
                </td>
                <td>
                  <a href="#" onclick="procesar_debito(<?php echo $result_cred['ncid']; ?>)" class="btn btn-success float-right">
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
          <label for="recibo_pago_compra_cuentas_pagar_id">Seleccione una opción</label>
          <select name="recibo_pago_compra[cuentas_pagar_id]" class="form-control" id="recibo_pago_compra_cuentas_pagar_id">
            <?php 
              foreach ($results as $result)  {
                if(!empty($result["fid"])):
                  echo "<option value='".$result["cid"]."'>FACT. COMPRA - ".$result["fnum"]."</option>";
                else:
                  echo "<option value='".$result["cid"]."'>FACT. GASTOS - ".$result["fgnum"]."</option>";
                endif;
              }
            ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_compra_fecha">Fecha</label>
          <?php $date2 = date("d/m/Y"); ?>
          <input type="text" name="recibo_pago_compra[fecha]" value="<?php $date2 = new DateTime(); echo $date2->format('Y-m-d'); ?>" class="form-control dateonly" id="recibo_pago_compra_fecha" readonly="readonly" >
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_compra_quien_paga">Emisor</label>
          <input type="text" name="recibo_pago_compra[quien_paga]" value="<?php echo $sf_user->getGuardUser()->getFullName(); ?>" class="form-control" id="recibo_pago_compra_quien_paga"/>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_compra_banco">Banco</label><!--  OJO si es en bs que salga el combo del banco de lo contrario no    -->
          <select name="recibo_pago_compra[banco_id]" class="form-control" id="recibo_pago_compra_banco_id">
            <?php
            $results2 = Doctrine_Query::create()
              ->select('b.id, b.nombre')
              ->from('Banco b')
              ->where('b.empresa_id = ?', $empresa_id)
              ->andWhere('b.estatus=1')
              ->orderBy('b.nombre ASC')
              ->execute();
            foreach ($results2 as $result2) {
              echo "<option value='".$result2->getId()."'>".$result2->getNombre()."</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_compra_num_recibo">N° de Referencia</label>
          <input type="text" name="recibo_pago_compra[num_recibo]" class="form-control" id="recibo_pago_compra_num_recibo"/>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="recibo_pago_compra_moneda">Moneda</label>
          <select name="recibo_pago_compra[moneda]" class="form-control" id="recibo_pago_compra_moneda">
            <option value="1">BOLIVARES</option>
            <option value="2" selected>DOLARES</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group" id="form_pago">
        </div>
      </div>
      <div class="col-md-3"></div>
      <div class="col-md-3">
        <label for="recibo_pago_compra_tasa_cambio">Monto</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">USD</span>
          </div>
          <input class="form-control money_intern" type="text" name="recibo_pago_compra[monto]" id="recibo_pago_compra_monto">
        </div>
      </div>
      <div class="col-md-3">
        <label for="recibo_pago_compra_tasa_cambio">Monto</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BS</span>
          </div>
          <input class="form-control money_intern" type="text" name="recibo_pago_compra[monto2]" id="monto_bs">
        </div>
      </div>
      <div class="col-md-3">
        <label for="recibo_pago_compra_tasa_cambio">Tasa</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">BS</span>
          </div>
          <input class="form-control money_intern" type="text" name="recibo_pago_compra[tasa_cambio]" id="recibo_pago_compra_tasa_cambio">
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$( document ).ready(function() {
  $(".moneyStr2").each(function() {
    var str=$(this).text();
    var res = str.replace(/\s/g,'');
    var numero = parseFloat(res);
    var res2=SetMoney(numero);
    $(this).text( res2 !== '' ? res2 : '' );
  });

  $(".dateonly").datepicker({
        language: 'es',
        format: "yyyy-mm-dd"
      });

  $('.money_intern').mask("#.##0,0000", {
    clearIfNotMatch: true,
    placeholder: "#,####",
    reverse: true
  });

  $('#form_pago').load('<?php echo url_for('recibo_pago_compra/getForma') ?>?id='+$("#recibo_pago_compra_moneda").val()).fadeIn("slow");
  getTasa();
  sumar();
});

$("#recibo_pago_compra_cuentas_pagar_id").on('change', function(event){
  getTasa();
});

$("#recibo_pago_compra_moneda").on('change', function(event){
  $('#form_pago').load('<?php echo url_for('recibo_pago_compra/getForma') ?>?id='+this.value).fadeIn("slow");
});

$('#recibo_pago_compra_monto').keyup(function(){
  sumar();
});

$('#monto_bs').keyup(function(){
  sumar();
});

$('#recibo_pago_compra_tasa_cambio').keyup(function(){
  sumar();
});

function getTasa() {
  var cc_id=$('#recibo_pago_compra_cuentas_pagar_id').val();
  var tasa = number_float($("#cuentas_pagar_table").find('.tasa_'+cc_id).text());
  if(tasa) {
    $('#recibo_pago_compra_tasa_cambio').val(SetMoney(tasa));
  } else {
    $('#recibo_pago_compra_tasa_cambio').val(SetMoney("0"));
  }
  // limpio los montos
  $("#recibo_pago_compra_monto").val("#,####");
  $("#monto_bs").val("#,####");
}

function sumar() {
  var tasa = 0;
  var monto = 0;
  var monto_bs = 0;
  if($("#recibo_pago_compra_tasa_cambio").val()) {
    tasa = number_float($("#recibo_pago_compra_tasa_cambio").val());
  }
  if($("#recibo_pago_compra_monto").val()) {
    monto = number_float($("#recibo_pago_compra_monto").val());
  }
  if($("#monto_bs").val()) {
    monto_bs = number_float($("#monto_bs").val());
  }

  if($("#recibo_pago_compra_moneda").val()==1) {
    var total=monto_bs/tasa;
    $("#recibo_pago_compra_monto").val(SetMoney(total));
  } else {
    var total=monto*tasa;
    $("#monto_bs").val(SetMoney(total));
  }

}

function procesar_debito(ncid) {
  var ccid=$("#nota_debito_ccid").val();
  location.href = "<?php echo url_for("nota_debito")."/procesar?cpid="?>"+ccid+"&ndid="+ncid;
}
</script>
