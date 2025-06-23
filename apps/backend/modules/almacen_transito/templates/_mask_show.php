<?php $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$form->getObject()->get('cliente_id'));?>
<div class="col-md-4">
  <div class="form-group">
    <label>EMPRESA</label>
    <input type="text" value="<?php echo $almacen_transito->getEmpresa(); ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>DEPOSITO</label>
    <input type="text" value="<?php echo $almacen_transito->getInvDeposito(); ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>DESTINO</label>
    <input type="text" value="<?php echo $cliente->getFullName(); ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label><?php echo $almacen_transito->getTipoTxt(); ?></label>
    <input type="text" value="<?php echo $almacen_transito->getDocTxt(); ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>DIA DE CREACIÓN</label>
    <input type="text" value="<?php echo $almacen_transito->getCreatedAtTxt(); ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>DIA DE EMBALAJE</label>
    <input type="text" value="<?php echo $almacen_transito->getFechaEmbalajeTxt(); ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>DIA DE DESPACHO</label>
    <input type="text" value="<?php echo $almacen_transito->getFechaDespachoTxt(); ?>" class="form-control" readonly="">
  </div>
</div>
</div></div></div></div>
<div class="card card-primary" id="sf_fieldset_detalles">
  <div class="card-body" <?php if($form->getObject()->get('estatus')==4) { echo 'style="background: #f1daa759 !important;"'; }?>>
    <?php if($form->getObject()->get('estatus')==4) { ?>
      <img src='/images/anulado.png'/>
    <?php } ?>
    <?php if($almacen_transito->getEstatus()==1){ ?>
      <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4">
          <div class="form-group">
            <label>BUSCADOR</label>
            <input id="buscador_prod" type="text" class="form-control">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>CONCEPTO O DESCRIPCIÓN</th>
                <th style="text-align: left">LOTE</th>
                <th style="text-align: right;">CANT.</th>
                <th style="text-align: right"></th>
                <th style="text-align: right"></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $k=0;
                $results = $almacen_transito->getProds();
                foreach ($results as $result) {
              ?>
                <tr class="sn_<?php echo $result["serial"] ?> item" id="item_<?php echo $k; ?>">
                  <td style="vertical-align: middle;">
                    <?php echo $result["nombre"] ?><br/><small><?php echo $result["serial"] ?></small>
                  </td>
                  <td style="vertical-align: middle;">
                    <?php
                      $i=1;
                      foreach ($result["lote"] as $index => $dato) {
                        echo "<span>(".$dato.") ".$index."</span><br/>";
                        $i++;
                      }
                    ?>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                    <span class="badge bg-primary number2 max" style="font-size: 3rem; line-height: 1rem; padding: 1rem 0.5rem;">
                      <?php echo $result["qty"] ?>
                    </span>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                    <span class="badge bg-info number2 qty" style="font-size: 3rem; line-height: 1rem; padding: 1rem 0.5rem;">0</span>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                      <a href="javascript:void(0)" class="badge bg-danger" onclick="restar(<?php echo $k; $k++;?>)">-</a>
                  </td>
                </tr>
              <?php } ?>
              <?php
                $results = $almacen_transito->getProdsOfer();
                foreach ($results as $result) {
                  ?>
                  <tr style="background-color: #fffdcb">
                    <td style="vertical-align: middle;">
                      <strong><?php echo $result["ofername"] ?><br/></strong>
                    </td>
                    <td style="vertical-align: middle;">
                    </td>
                    <td style="vertical-align: middle; text-align: right">
                      
                    </td>
                    <td style="vertical-align: middle; text-align: right">                    
                    </td>
                    <td style="vertical-align: middle; text-align: right">
                    </td>
                  </tr>
                  <?php
                  $items = explode(';', $result["desc"]);
                  $prods=array();
                  foreach ($items as $item) {
                    if(strlen($item)>0) {
                      list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
                      $query = Doctrine_Query::create()
                      ->select('id.id as fdid, i.id as iid, p.id as pid, p.nombre as pname, p.serial as serial')
                      ->from('InventarioDet id')
                      ->leftJoin('id.Inventario i')
                      ->leftJoin('i.Producto p')
                      ->Where('id.id =?', $InvDetId)
                      ->orderBy('p.nombre ASC');
                      $invDet=$query->fetchOne();
                      if(empty($prods[$invDet["iid"]][$invDet["serial"]])) {
                        $prods[$invDet["iid"]]["id"]=$invDet["iid"];
                        $prods[$invDet["iid"]]["serial"]=$invDet["serial"];
                        $prods[$invDet["iid"]]["nombre"]=$invDet["pname"];
                        $prods[$invDet["iid"]]["qty"]=$result["qty"];
                        if(empty($prods[$invDet["iid"]]["lote"][$lote])) {
                          $prods[$invDet["iid"]]["lote"][$lote]=$qty;
                        } else {
                          $qty_lote=floatval($prods[$invDet["iid"]]["lote"][$lote])+floatval($qty);
                          $prods[$invDet["iid"]]["lote"][$lote]=$qty;
                        }
                      } else {
                        if(empty($prods[$invDet["iid"]]["lote"][$lote])) {
                          $prods[$invDet["iid"]]["lote"][$lote]=$qty;
                        } else {
                          $qty_lote=floatval($prods[$invDet["iid"]]["lote"][$lote])+floatval($qty);
                          $prods[$invDet["iid"]]["lote"][$lote]=$qty;
                        }
                      }
                    }
                  }
                  foreach ($prods as $prod) { ?>
                <tr class="sn_<?php echo $prod["serial"] ?> item" id="item_<?php echo $k; ?>">
                  <td style="vertical-align: middle;">
                    <?php echo $prod["nombre"] ?><br/><small><?php echo $prod["serial"] ?></small>
                  </td>
                  <td style="vertical-align: middle;">
                    <?php
                      $i=1;
                      foreach ($prod["lote"] as $index => $dato) {
                        echo "<span>(".$dato.") ".$index."</span><br/>";
                        $i++;
                      }
                    ?>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                    <span class="badge bg-primary number2 max" style="font-size: 3rem; line-height: 1rem; padding: 1rem 0.5rem;">
                      <?php echo $prod["qty"] ?>
                    </span>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                    <span class="badge bg-info number2 qty" style="font-size: 3rem; line-height: 1rem; padding: 1rem 0.5rem;">0</span>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                      <a href="javascript:void(0)" class="badge bg-danger" onclick="restar(<?php echo $k; $k++;?>)">-</a>
                  </td>
                </tr>
                  <?php 
                  }
                }?>
            </tbody>
          </table>
        </div>
      </div>
    <?php } else { ?>
      <div class="row">
        <div class="col-md-12 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>CONCEPTO O DESCRIPCIÓN</th>
                <th style="text-align: left">LOTE</th>
                <th style="text-align: right;">CANT.</th>
                <th style="text-align: right"></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $k=0;
                $results = $almacen_transito->getProds();
                foreach ($results as $result) {
              ?>
                <tr class="sn_<?php echo $result["serial"] ?> item" id="item_<?php echo $k; ?>">
                  <td style="vertical-align: middle;">
                    <?php echo $result["nombre"] ?><br/><small><?php echo $result["serial"] ?></small>
                  </td>
                  <td style="vertical-align: middle;">
                    <?php
                      $i=1;
                      foreach ($result["lote"] as $index => $dato) {
                        echo "<span>(".$dato.") ".$index."</span><br/>";
                        $i++;
                      }
                    ?>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                    <span class="badge bg-primary number2 max" style="font-size: 3rem; line-height: 1rem; padding: 1rem 0.5rem;">
                      <?php echo $result["qty"] ?>
                    </span>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                    <span class="badge bg-success number2 qty" style="font-size: 3rem; line-height: 1rem; padding: 1rem 0.5rem;"><?php echo $result["qty"] ?></span>
                  </td>
                </tr>
              <?php } ?>
              <?php
                $results = $almacen_transito->getProdsOfer();
                foreach ($results as $result) {
                  ?>
                  <tr style="background-color: #fffdcb">
                    <td style="vertical-align: middle;">
                      <strong><?php echo $result["ofername"] ?><br/></strong>
                    </td>
                    <td style="vertical-align: middle;">
                    </td>
                    <td style="vertical-align: middle; text-align: right">
                      
                    </td>
                    <td style="vertical-align: middle; text-align: right">                    
                    </td>
                  </tr>
                  <?php
                  $items = explode(';', $result["desc"]);
                  $prods=array();
                  foreach ($items as $item) {
                    if(strlen($item)>0) {
                      list($InvDetId, $qty, $fvenc, $lote) = explode ("|", $item);
                      $query = Doctrine_Query::create()
                      ->select('id.id as fdid, i.id as iid, p.id as pid, p.nombre as pname, p.serial as serial')
                      ->from('InventarioDet id')
                      ->leftJoin('id.Inventario i')
                      ->leftJoin('i.Producto p')
                      ->Where('id.id =?', $InvDetId)
                      ->orderBy('p.nombre ASC');
                      $invDet=$query->fetchOne();
                      if(empty($prods[$invDet["iid"]][$invDet["serial"]])) {
                        $prods[$invDet["iid"]]["id"]=$invDet["iid"];
                        $prods[$invDet["iid"]]["serial"]=$invDet["serial"];
                        $prods[$invDet["iid"]]["nombre"]=$invDet["pname"];
                        $prods[$invDet["iid"]]["qty"]=$result["qty"];
                        if(empty($prods[$invDet["iid"]]["lote"][$lote])) {
                          $prods[$invDet["iid"]]["lote"][$lote]=$qty;
                        } else {
                          $qty_lote=floatval($prods[$invDet["iid"]]["lote"][$lote])+floatval($qty);
                          $prods[$invDet["iid"]]["lote"][$lote]=$qty;
                        }
                      } else {
                        if(empty($prods[$invDet["iid"]]["lote"][$lote])) {
                          $prods[$invDet["iid"]]["lote"][$lote]=$qty;
                        } else {
                          $qty_lote=floatval($prods[$invDet["iid"]]["lote"][$lote])+floatval($qty);
                          $prods[$invDet["iid"]]["lote"][$lote]=$qty;
                        }
                      }
                    }
                  }
                  foreach ($prods as $prod) { ?>
                <tr class="sn_<?php echo $prod["serial"] ?> item" id="item_<?php echo $k; ?>">
                  <td style="vertical-align: middle;">
                    <?php echo $prod["nombre"] ?><br/><small><?php echo $prod["serial"] ?></small>
                  </td>
                  <td style="vertical-align: middle;">
                    <?php
                      $i=1;
                      foreach ($prod["lote"] as $index => $dato) {
                        echo "<span>(".$dato.") ".$index."</span><br/>";
                        $i++;
                      }
                    ?>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                    <span class="badge bg-primary number2 max" style="font-size: 3rem; line-height: 1rem; padding: 1rem 0.5rem;">
                      <?php echo $prod["qty"] ?>
                    </span>
                  </td>
                  <td style="vertical-align: middle; text-align: right">
                    <span class="badge bg-success number2 qty" style="font-size: 3rem; line-height: 1rem; padding: 1rem 0.5rem;"><?php echo $prod["qty"] ?></span>
                  </td>
                </tr>
                  <?php 
                  }
                }?>
            </tbody>
          </table>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<div class="row no-print">
  <div class="col-md-4">
    <?php if($almacen_transito->getEstatus()==1): ?>
      <div class="form-group">
        <div class="input-group margin">
          <input type="number" class="form-control number2" placeholder="PRECINTO DESDE" id="precinto">
        </div>
        <br/>
        <div class="input-group margin">
          <input type="number" class="form-control number2" placeholder="CANTIDAD DE CAJAS" id="caja">
          <span class="input-group-btn">
            <a href="javascript:void(0)" class="btn btn-primary btn-flat disabled" onclick="guardar()" id="btn_guardar">Guardar!</a>
          </span>
        </div>
      </div>
    <?php endif; ?>
    <?php if($almacen_transito->getEstatus()==2): ?>
      <div class="form-group">
        <div class="input-group margin">
          <input type="text" class="form-control" value="PRECINTO DESDE: <?php echo $almacen_transito->getPrecinto(); ?>" readonly>
        </div>
        <br/>
        <div class="input-group margin">
          <input type="text" class="form-control" value="CAJAS: <?php echo $almacen_transito->getBoxes(); ?>" readonly>
          <span class="input-group-btn">
            <a href="javascript:void(0)" class="btn btn-success btn-flat" onclick="despachar()" id="btn_guardar">Despachar!</a>
          </span>
        </div>
      </div>
    <?php endif; ?>
    <?php if($almacen_transito->getEstatus()==3): ?>
      <div class="form-group">
        <div class="input-group margin">
          <input type="text" class="form-control" value="PRECINTO DESDE: <?php echo $almacen_transito->getPrecinto(); ?>" readonly>
        </div>
        <br/>
        <div class="input-group margin">
          <input type="text" class="form-control" value="CAJAS: <?php echo $almacen_transito->getBoxes(); ?>" readonly>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <div class="col-md-8">
    <?php if($almacen_transito->getEstatus()==2 || $almacen_transito->getEstatus()==3): ?>
      <a href="<?php echo url_for("@almacen_transito")."/print?id=".$form->getObject()->get('id')?>" target="_blank" class="btn btn-success float-right" style="margin-right: 5px;">
        <i class="fas fa-print"></i> Imprimir
      </a>
    <?php endif; ?>
    <?php if($almacen_transito->getEstatus()!=4): ?>
      <button onclick="anular()" class="btn btn-danger float-right" style="margin-right: 5px;">
        <i class="fas fa-minus-circle"></i> Anular
      </button>
    <?php endif; ?>
  </div>
</div>
<br/><br/>
<div><div><div><div>
<style>
table {     
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;  
}
</style>
<script>
  $(function(){
    if (document.addEventListener) {
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        }, false);
    } else {
        document.attachEvent('oncontextmenu', function() {
            window.event.returnValue = false;
        });
    }
    $("#buscador_prod").focus();
  });
  function validar (serial) {
    var cont=0;
    $('.item').each(function(index,item){
      var max  = number_float($(item).find(".max").text());
      var cant = number_float($(item).find(".qty").text());

      if(max==cant) {
        $(item).find(".qty").removeClass("bg-warning");
        $(item).find(".qty").removeClass("bg-info");
        $(item).find(".qty").removeClass("bg-danger");
        $(item).find(".qty").addClass("bg-success");
      } else if(cant>max) {
        $(item).find(".qty").removeClass("bg-warning");
        $(item).find(".qty").removeClass("bg-info");
        $(item).find(".qty").removeClass("bg-success");
        $(item).find(".qty").addClass("bg-danger");
        cont++;
      } else if(cant>0) {
        $(item).find(".qty").removeClass("bg-info");
        $(item).find(".qty").removeClass("bg-danger");
        $(item).find(".qty").removeClass("bg-success");
        $(item).find(".qty").addClass("bg-warning");
        cont++;
      } 
      else {
        $(item).find(".qty").removeClass("bg-warning");
        $(item).find(".qty").removeClass("bg-danger");
        $(item).find(".qty").removeClass("bg-success");
        $(item).find(".qty").addClass("bg-info");
        cont++;
      }
    });
    if(cont==0) {
      $("#btn_guardar").removeClass("disabled");
    } else {
      $("#btn_guardar").addClass("disabled");
    }
  }
  function restar (id) {
    console.log(id);
    var cant=number_float($("#item_"+id).find(".qty").text())
    if(cant>0) {
      cant-=1;
      $("#item_"+id).find(".qty").text(cant);
    }
    validar();
  }
  $(document).on('keypress', 'input[type="text"]', function(e) {
    if(e.which == 13) {
      var serial=$("#buscador_prod").val();
      var j=0, i=0;
      $('.sn_'+serial).each(function(index,item){
        j++;
      });
      $('.sn_'+serial).each(function(index,item){
        i++;
        var max  = number_float($(item).find(".max").text());
        var cant = number_float($(item).find(".qty").text());
        var cant_new = cant+1;

        if(cant<max) {
          $(item).find(".qty").text(cant_new);
          validar();
          return false;
        }
        if(j==i) {
          $(item).find(".qty").text(cant_new);
          validar();
          return false;
        }
      });
      $("#buscador_prod").val("");
      e.preventDefault();
      return false;
    }
  });
  function guardar() {
    var caja  = number_float($("#caja").val());
    var precinto  = number_float($("#precinto").val());
    if(caja<1) {
      $("#caja").addClass("is-invalid");
      $("#caja").parent().find(".error").remove();
      $("#caja").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Cantidad de cajas es requerido.</li></ul></div>" );
    } else {
      $("#caja").removeClass("is-invalid");
      $("#caja").parent().parent().find(".error").remove();
      if(precinto<1) {
        $("#precinto").addClass("is-invalid");
        $("#precinto").parent().find(".error").remove();
        $("#precinto").parent().parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Precinto es requerido.</li></ul></div>" );
      } else {
        $("#caja").parent().parent().find(".error").remove();
        $("#caja").removeClass("is-invalid");
        var retVal = confirm("¿Estas seguro de guardar?");
        if( retVal == true ){
            location.href = "<?php echo url_for("almacen_transito")."/embalado?id=".$form->getObject()->get('id')?>&box="+caja+"&precinto="+precinto;
        }else{
          return false;
        }
      }
    }
  }
  function despachar() {
    var retVal = confirm("¿Estas seguro de guardar?");
    if( retVal == true ){
      location.href = "<?php echo url_for("almacen_transito")."/despachar?id=".$form->getObject()->get('id')?>";
    }else{
      return false;
    }    
  }

  function anular() {
    var retVal = confirm("¿Estas seguro de anular?");
    if( retVal == true ){
      location.href = "<?php echo url_for("almacen_transito")."/anular?id=".$form->getObject()->get('id')?>";
    }else{
      return false;
    }    
  }
  
</script>