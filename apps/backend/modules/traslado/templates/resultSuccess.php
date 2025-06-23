<?php
  $dida=$sf_params->get('dida');
  $didb=$sf_params->get('didb');
  $cat=str_replace("_"," ",str_replace("-","/",$sf_params->get('cat')));
  $pre=$sf_params->get('pre');
  $tipo=$sf_params->get('tipo');
  $min=$sf_params->get('min');
  $prodId=$sf_params->get('prodId');
  $qty_mayor=$sf_params->get('qty_mayor');
  $minQuery=$sf_params->get('min');

  $didaQuery="";
  if(!empty($dida)) {
    $didaQuery=" inv.deposito_id='$dida'";
  }

  $didbQuery="";
  if(!empty($dida)) {
    $didbQuery=" inv.deposito_id='$didb'";
  }

  $catQuery="";
  if(!empty($cat)) {
    $catQuery=" && pc.nombre LIKE '$cat%' ";
  }

  $preQuery="";
  if(!empty($pre)) {
    $pre=str_replace(",","','",$pre);
    $preQuery=" && p.unidad_id IN ('$pre')";
  }

  $tipoQuery="";
  if($tipo!="z") {
    $tipoQuery=" && p.tipo='$tipo' ";
  }

  $prodQuery="";
  if(!empty($prodId)) {
    $prodId=str_replace(",","','",$prodId);
    $prodQuery=" && inv.producto_id IN ('$prodId')";
  }

  $qtyMayorQuery="";
  if(!empty($qty_mayor)) {
    $qtyMayorQuery=" && inv.cantidad>=$qty_mayor";
  }

  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  $query = $q->execute("SELECT empresa_id as eid FROM inv_deposito WHERE id='$dida'");
  $empresa = $query->fetchAll();
  $eida=$empresa[0]["eid"];

  $query = $q->execute("SELECT empresa_id as eid FROM inv_deposito WHERE id='$didb'");
  $empresa = $query->fetchAll();
  $eidb=$empresa[0]["eid"];

  $results = $q->execute("SELECT o.valor as tasa
    FROM otros as o
    LEFT JOIN empresa as e ON o.empresa_id=e.id
    LEFT JOIN inv_deposito as id ON e.id=id.empresa_id
    WHERE id.id=$dida
    ORDER BY o.created_at DESC
    LIMIT 1");
  $tasa = "0"; 
  foreach ($results as $result) {
    $tasa = $result["tasa"];
  }

  $confs = $q->execute("SELECT s.tipo as stipo
    FROM server_name as s
    LIMIT 1");
  $stipo = 0; 
  foreach ($confs as $conf) {
    $stipo = $conf["stipo"];
  }

  $results = $q->execute("SELECT p.id as pid, inv.limite_stock as minimo
    FROM inventario as inv
    LEFT JOIN producto as p ON inv.producto_id=p.id
    LEFT JOIN inv_deposito as id ON inv.deposito_id=id.id
    WHERE id.tipo=1 && inv.empresa_id='$eidb'");
  $min = array();
  foreach ($results as $result) {
    $min[$result["pid"]]=$result["minimo"];
  }

  $results = $q->execute("SELECT inv.id as invId, inv.cantidad as qty, p.id as pid
    FROM inventario as inv
    LEFT JOIN producto as p ON inv.producto_id=p.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    WHERE $didbQuery $catQuery $preQuery $tipoQuery
    GROUP BY inv.id
    ORDER BY p.nombre ASC");
  $invB = array();
  foreach ($results as $result) {
    $invB[$result["pid"]]["qty"]=$result["qty"];
    $invB[$result["pid"]]["inv"]=$result["invId"];
  }

  $results = $q->execute("SELECT p2.id as pid
    FROM producto as p
    LEFT JOIN producto as p2 ON p.subproducto_id=p2.id
    WHERE p2.serial IS NOT NULL");
  $hijos = array();
  foreach ($results as $result) {
    $hijos[$result["pid"]]=1;
  }

  $query = $q->execute("SELECT inv.id as invId, inv.cantidad as qty,
    p.id as pid, LOWER(p.nombre) as nombre, p.serial as serial, FORMAT(REPLACE(p.costo_usd_1, ' ', ''), 4, 'de_DE') as costo,
    LOWER(pu.nombre) as puname, LOWER(pu2.nombre) as pu2name,
    inv2.id as inv2Id,
    p2.id as p2id, LOWER(p2.nombre) as p2nombre, p2.serial as p2serial, p.qty_desglozado
    FROM inventario as inv
    LEFT JOIN producto as p ON inv.producto_id=p.id
    LEFT JOIN prod_unidad as pu ON p.unidad_id=pu.id
    LEFT JOIN producto as p2 ON p.subproducto_id=p2.id
    LEFT JOIN prod_unidad as pu2 ON p2.unidad_id=pu2.id
    LEFT JOIN inventario as inv2 ON (p2.id=inv2.producto_id && inv2.deposito_id=$didb)
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    WHERE $didaQuery $catQuery $preQuery $tipoQuery $prodQuery $qtyMayorQuery
    GROUP BY inv.id
    ORDER BY p.nombre ASC
    LIMIT 1500");
  $i=1;
?>
<table class="table table-sm table-hover" id="listadoProd">
  <thead class="thead-dark">
    <tr>
      <th>#</th>
      <th>Producto</th>
      <th>Serial</th>
      <th>Presen.</th>
      <th>Exist.(A)</th>
      <th>Exist.(B)</th>
      <th>Min. Ideal(B)</th>
      <th>Cant.</th>
      <th>Sub(Prod)</th>
      <th>Costo</th>
      <th>Total</th>
      <th>Total Bs</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($query as $item): ?>
   <?php  if($stipo == 2) { ?>
    <?php if(array_key_exists($item["pid"], $invB) && array_key_exists($item["pid"], $min) && !array_key_exists($item["pid"], $hijos)){
   
    ?>
      <?php
        if(!empty($item["p2nombre"])) {
          $exisB=$invB[$item["p2id"]]["qty"]; 
          $minB=$min[$item["p2id"]];
        } else {
          $exisB=$invB[$item["pid"]]["qty"]; 
          $minB=$min[$item["pid"]];
        }
      ?>
      <?php if(($minQuery=="1" && $exisB<=$minB) || ($minQuery=="2" && $exisB>=$minB) || $minQuery=="z"): ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td>
            <?php echo ucwords($item["nombre"]); ?>
            <small>
              <?php 
                if(!empty($item["p2nombre"])) {
                  echo "<br/><b>&emsp;".$item["p2nombre"]." [".$item["p2serial"]."] [".$item["pu2name"]."]</b>";
                }
              ?>
            </small>
          </td>
          <td><?php echo $item["serial"]; ?></td>
          <td><?php echo ucwords($item["puname"]); ?></td>
          <td class="exist"><?php echo $item["qty"]; $readonly=""; if($item["qty"]<=0) { $readonly="readonly"; } ?></td>
          <td><?php echo $exisB; ?></td>
          <td><?php echo $minB; ?></td>
          <td>
            <input id="<?php echo $item["invId"]; ?>" class="nm" type="text" value="0" <?php echo $readonly; ?> />
          </td>
          <td class="sub">0</td>
          <td class="cst"><?php echo $item["costo"]; ?></td>
          <td class="tusd">0,0000</td>
          <td class="tbs">0,0000</td>
          <td style="display: none" class="invid"><?php echo $item["invId"].";".$item["pid"]; ?></td>
          <?php if(!empty($item["p2nombre"])): ?>
            <td style="display: none" class="subid"><?php echo $invB[$item["p2id"]]["inv"].";".$item["p2id"].";".$item["qty_desglozado"]; ?></td>
          <?php else: ?>
            <td style="display: none" class="subid"><?php echo $invB[$item["pid"]]["inv"].";".$item["pid"].";0"; ?></td>
          <?php endif; ?>
        </tr>
      <?php endif; ?>
    <?php } 
    }
    else {
       if(array_key_exists($item["pid"], $invB) && array_key_exists($item["pid"], $min)){
   
    ?>
      <?php
        if(!empty($item["p2nombre"])) {
          $exisB=$invB[$item["p2id"]]["qty"]; 
          $minB=$min[$item["p2id"]];
        } else {
          $exisB=$invB[$item["pid"]]["qty"]; 
          $minB=$min[$item["pid"]];
        }
      ?>
      <?php if(($minQuery=="1" && $exisB<=$minB) || ($minQuery=="2" && $exisB>=$minB) || $minQuery=="z"): ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td>
            <?php echo ucwords($item["nombre"]); ?>
            <small>
              <?php 
                if(!empty($item["p2nombre"])) {
                  echo "<br/><b>&emsp;".$item["p2nombre"]." [".$item["p2serial"]."] [".$item["pu2name"]."]</b>";
                }
              ?>
            </small>
          </td>
          <td><?php echo $item["serial"]; ?></td>
          <td><?php echo ucwords($item["puname"]); ?></td>
          <td class="exist"><?php echo $item["qty"]; $readonly=""; if($item["qty"]<=0) { $readonly="readonly"; } ?></td>
          <td><?php echo $exisB; ?></td>
          <td><?php echo $minB; ?></td>
          <td>
            <input id="<?php echo $item["invId"]; ?>" class="nm" type="text" value="0" <?php echo $readonly; ?> />
          </td>
          <td class="sub">0</td>
          <td class="cst"><?php echo $item["costo"]; ?></td>
          <td class="tusd">0,0000</td>
          <td class="tbs">0,0000</td>
          <td style="display: none" class="invid"><?php echo $item["invId"].";".$item["pid"]; ?></td>
          <?php if(!empty($item["p2nombre"])): ?>
            <td style="display: none" class="subid"><?php echo $invB[$item["p2id"]]["inv"].";".$item["p2id"].";".$item["qty_desglozado"]; ?></td>
          <?php else: ?>
            <td style="display: none" class="subid"><?php echo $invB[$item["pid"]]["inv"].";".$item["pid"].";0"; ?></td>
          <?php endif; ?>
        </tr>
      <?php endif; ?>
    <?php } 
    }

     ?>
  <?php endforeach; ?>
  </tbody>
</table>
<div style="float: right; border: 1px solid #000; padding: 0.25rem;">
  <h5 style="border-bottom: 1px solid #000">Tasa: <span style="margin-left: 0.5rem; float: right"><?php echo number_format($tasa,4,",","."); ?></span></h5>
  <h5 style="border-bottom: 1px solid #000">Total USD: <span id="tusd" style="margin-left: 0.5rem; float: right"></span></h5>
  <h5>Total BS: <span id="tbs" style="margin-left: 0.5rem; float: right"></span></h5>
</div>

<div class="icon-bar">
  <a class="btn btn-small btn-success text-uppercase" href="javascript:void(0)" onclick="guardar()"><i class="fa fa-save mr-2"></i>Guardar</a>
</div>

<script>
  $(document).ready(function(){
    $('#alert').fadeOut( "slow", function() {});
    $('#loading').fadeOut( "slow", function() {});
    $('.nm').mask("###0", {reverse: true});
    $('.nm').keyup(function(){
      sumar();
    });
    $('.nm').keypress(function (e) {
      if (e.which == 13) {
        if(!this.value) {
          this.value=0;
        }
        $(this).closest('tr').nextAll('tr:not(.group)').first().find('.nm').focus();
        return false;
      }
    });
  })
  function sumar() {
    $(".nm").each(function() {
      var tasa = <?php echo $tasa; ?>;
      var qty=number_float(this.value);
      var qty_exist=number_float($(this).parent().parent().find('.exist').text());
      if(qty>qty_exist) {
        qty=qty_exist;
        $(this).val(qty);
      }
      var punit=number_float($(this).parent().parent().find('.cst').text());
      var total=qty*punit;
      var total_bs = total*tasa;
      $(this).parent().parent().find('.tusd').text(SetMoney(total));
      $(this).parent().parent().find('.tbs').text(SetMoney(total_bs));

      var subtxt = $(this).parent().parent().find('.subid').text();
      var result = subtxt.split(';');
      if(result[2]>0) {
        var qty_desgloze=qty*number_float(result[2]);
        $(this).parent().parent().find('.sub').text(qty_desgloze);
      }
    });
    totUSD();
    toBs();
  }
  function totUSD() {
    var tot=0;
    $(".tusd").each(function() {
      if($(this).text()) {
        tot+=number_float($(this).text());
      }
    });
    $("#tusd").text(SetMoney(tot));
  }
  function toBs() {
    var tot=0;
    $(".tbs").each(function() {
      if($(this).text()) {
        tot+=number_float($(this).text());
      }
    });
    $("#tbs").text(SetMoney(tot));
  }
  function guardar() {
    var eida=<?php echo $eida; ?>;
    var eidb=<?php echo $eidb; ?>;
    var dida=<?php echo $dida; ?>;
    var didb=<?php echo $didb; ?>;
    var tasa=<?php echo $tasa; ?>;
    var totusd=number_float($("#tusd").text());
    var origen="";
    var destino="";

    var cant=0;
    $(".nm").each(function() {
      var qty=number_float(this.value);
      if(qty>0) {
        var inv_origen = $(this).parent().parent().find('.invid').text();
        var cst = number_float($(this).parent().parent().find('.cst').text());
        var tusd = number_float($(this).parent().parent().find('.tusd').text());

        var subtxt = $(this).parent().parent().find('.subid').text();
        var result = subtxt.split(';');
        if(result[2]>0) {
          var qty_destino=$(this).parent().parent().find('.sub').text();
        } else {
          var qty_destino=qty;
        }
        var inv_destino=result[0]+";"+result[1]+";"+result[2];
        

        origen+=qty+";"+inv_origen+";"+cst+";"+tusd+"|";
        destino+=qty_destino+";"+inv_destino+"|";
        cant++;
      }
    });
    if(cant==0) {
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4> DEBE INTRODUCIR AL MENOS 1 ITEM</div>');
      $("html, body").animate({ scrollTop: 0 }, 1000);
    } else {
      var json_obj = JSON.parse(Get("<?php echo url_for("traslado");?>/prefijo?search="+origen));
      var cont=0;
      if(json_obj !== "") {
        var res = json_obj.split("|");
        console.log(res);
        for (index = 0; index < res.length; index++) {
          if(res[index].length>1) {
            var str = res[index].split(";");
            showError(str[0],str[2]);
            cont++;
          }
        }
      }
      if(cont>0) {
        $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4> UNO DE LOS ELEMENTOS HA CAMBIADO DE EXISTENCIA VERIFICAR</div>');
        $("html, body").animate({ scrollTop: 0 }, 1000);
      } else {
        var url = '?eida='+eida+'&eidb='+eidb+'&dida='+dida+'&didb='+didb+'&tasa='+tasa+'&totusd='+totusd+'&origen='+origen+'&destino='+destino;
        window.location = '<?php echo url_for("traslado")."/guardar"; ?>'+url;
      }
    }
  }
  function showError(id, cant) {
    console.log(id);
    console.log(cant);
    $(".nm").each(function() {
      var idprod=$(this).attr('id');
      if(idprod==id){
        $(this).addClass("is-invalid");
        $(this).parent().parent().find(".exist").text(cant);
        $(this).parent().parent().find(".exist").addClass("is-invalid");
      }
    });
  }
</script>

<style>
  .icon-bar {
    position: fixed;
    top: 95%;
    right: 0;
    -webkit-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
  }

  .nm {
    width: 4rem !important;
    text-align: center;
    height: calc(1.8125rem);
    padding: .25rem .5rem;
    font-size: .875rem;
    line-height: 1;
    font-weight: 400;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }
  .exist.is-invalid {
    color: #dc3545;
    font-weight: 600;
  }
  .nm[readonly] {
    background-color: #e9ecef;
    opacity: 1;
  }
  .nm.is-invalid {
    border: 3px solid #dc3545;
  }
  .nm.is-valid {
    border: 3px solid #28a745;
  }
  table#listadoProd tbody tr td:nth-child(8),
  table#listadoProd thead tr th:nth-child(8),
  table#listadoProd tbody tr td:nth-child(9),
  table#listadoProd thead tr th:nth-child(9) {
    text-align: center;
  }


  table#listadoProd thead tr th:nth-child(5),
  table#listadoProd thead tr th:nth-child(6),
  table#listadoProd thead tr th:nth-child(7),
  table#listadoProd thead tr th:nth-child(10),
  table#listadoProd thead tr th:nth-child(11),
  table#listadoProd thead tr th:nth-child(12) {
    text-align: right;
  }

  table#listadoProd tbody tr td:nth-child(5),
  table#listadoProd tbody tr td:nth-child(6),
  table#listadoProd tbody tr td:nth-child(7),
  table#listadoProd tbody tr td:nth-child(10),
  table#listadoProd tbody tr td:nth-child(11),
  table#listadoProd tbody tr td:nth-child(12) {
    text-align: right;
  }
</style>