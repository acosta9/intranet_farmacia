</div></div></div>
<div class="invoice p-3 mb-3" id="invoice" >
  <div class="row invoice-info">
    <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
      <div id="produtoImg" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <?php $i=0; ?>
          <?php if($producto->getUrlImagen()): ?>
            <li data-target="#produtoImg" data-slide-to="<?php echo $i; $i++;?>" class="active"></li>
          <?php endif;
            $results = Doctrine_Query::create()
              ->select('i.url_imagen as img, i.descripcion as desc')
              ->from('ProductoImg i')
              ->where('i.producto_id = ?', $form->getObject()->get('id'))
              ->execute();
            foreach ($results as $result) {
              $class="";
              if($i==0) {
                $class="active";
              }
          ?>
            <li data-target="#produtoImg" data-slide-to="<?php echo $i; $i++;?>" class="<?php echo $class; ?>"></li>
          <?php }
          if($i==0) {
            echo "<li data-target='#produtoImg' data-slide-to='0' class='active'></li>";
          }
          ?>
        </ol>
        <div class="carousel-inner">
          <?php $i=0; ?>
            <?php if($producto->getUrlImagen()): ?>
              <div class="carousel-item active">
                <img class="d-block" src="/uploads/producto/<?php echo $producto->getUrlImagen(); $i++; ?>" alt="<?php echo $producto->getUrlImagenDesc()?>" style="max-width: 350px; height:350px; margin-left: auto; margin-right: auto;">
              </div>
          <?php endif;
            foreach ($results as $result) {
              $class="";
              if($i==0) {
                $class="active";
              }
              $i++;
          ?>
          <div class="carousel-item <?php echo $class; ?>">
            <img class="d-block" src="/uploads/producto_img/<?php echo $result["img"]?>" alt="<?php echo $result["desc"]?>" style="max-width: 350px; height:350px; margin-left: auto; margin-right: auto;">
          </div>
          <?php }
          if($i==0) { ?>
            <div class="carousel-item active">
              <img class="d-block" src="/images/no-product.png" alt="no image" style="width:auto; max-width: 400px; height:400px; margin-left: auto; margin-right: auto;">
            </div>
          <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#produtoImg" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Ant</span>
        </a>
        <a class="carousel-control-next" href="#produtoImg" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Sig</span>
        </a>
      </div>
    </div>
    <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12 smt-40 xmt-40">
      <div class="row">
        <div class="col-md-8">
          <div class="form-group">
            <label>NOMBRE</label>
            <input type="text" value="<?php echo $form->getObject()->get('nombre') ?>" class="form-control" readonly="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>SERIAL</label>
            <input type="text" value="<?php echo $form->getObject()->get('serial') ?>" class="form-control" readonly="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>CATEGORIA</label>
            <input type="text" value="<?php echo $form->getObject()->get('ProdCategoria') ?>" class="form-control" readonly="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>LABORATORIO</label>
            <input type="text" value="<?php echo $form->getObject()->get('ProdLaboratorio') ?>" class="form-control" readonly="">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>TIPO</label>
            <input type="text" value="<?php echo $form->getObject()->get('ProdTipo') ?>" class="form-control" readonly="">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>PRESENTACION</label>
            <input type="text" value="<?php echo $form->getObject()->get('ProdUnidad') ?>" class="form-control" readonly="">
          </div>
        </div>
        
        <div class="col-md-2">
          <div class="form-group">
            <label>EXENTO</label>
            <input type="text" value="<?php if($form->getObject()->get('exento')) { echo "SI"; } else {echo "NO";} ?>" class="form-control" readonly="">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>DESTACADO</label>
            <input type="text" value="<?php if($form->getObject()->get('destacado')) { echo "SI"; } else {echo "NO";} ?>" class="form-control" readonly="">
          </div>
        </div>       
        <div class="col-md-8">
          <div class="form-group">
            <label>COMPUESTOS</label>
            <input type="text" value="<?php echo $form->getObject()->get('ProdCompuestos') ?>" class="form-control" readonly="">
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <label>TAGS</label>
            <input type="text" value="<?php echo str_replace(";", "; ",$form->getObject()->get('tags')) ?>" class="form-control" readonly="">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php if($form->getObject()->get('subproducto_id')): ?>
  <div class="card card-primary" id="sf_fieldset_precio">
    <div class="card-header">
      <h3 class="card-title">Sub-Producto</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-8 col-sm-12">
          <div class="form-group">
          <label>PRODUCTO</label>
          <div class="input-group margin">
            <?php $subp = Doctrine_Core::getTable('Producto')->findOneBy('id', $producto->getSubproductoId()); ?>
            <input type="text" class="form-control" value="<?php echo $subp->getNombre()." [".$subp->getSerial()."] [".$subp->getCodigo()."]"?>" readonly="">
            <span class="input-group-btn">
              <a href="<?php echo url_for("producto")."/show?id=".$producto->getSubproductoId(); ?>" class="btn btn-info btn-flat">Ver Producto!</a>
            </span>
          </div>
        </div>
        </div>
        <div class="col-md-4 col-sm-12">
          <div class="form-group">
            <label class="col-sm-12 control-label">CANTIDAD</label>
            <div class="col-sm-12">
              <input type="text" value="<?php echo $form->getObject()->get('qty_desglozado'); ?>" class="form-control money2" readonly/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
<div style="<?php if(!$sf_user->hasCredential("drogueria")) { echo "display: none"; } ?>" class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Detalles bulto</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>SERIAL BULTO (1)</label>
          <input type="text" value="<?php echo $form->getObject()->get('serial_bulto1'); ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>CANTIDAD</label>
          <input type="text" value="<?php echo $form->getObject()->get('cantidad_bulto1'); ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>SERIAL BULTO (2)</label>
          <input type="text" value="<?php echo $form->getObject()->get('serial_bulto2'); ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label>CANTIDAD</label>
          <input type="text" value="<?php echo $form->getObject()->get('cantidad_bulto2'); ?>" class="form-control" readonly="">
        </div>
      </div>
    </div>
  </div>
</div>

  <div class="card card-primary" id="sf_fieldset_precio">
    <div class="card-header">
      <h3 class="card-title">Precios</h3>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-5">
          <div class="form-group">
            <label>EMPRESA</label>
            <select name="producto[empresa_id]" class="form-control" id="producto_empresa_id">
              <?php
                $results = Doctrine_Query::create()
                  ->select('e.id, e.nombre, eu.user_id')
                  ->from('Empresa e')
                  ->leftJoin('e.EmpresaUser eu')
                  ->where('eu.user_id = ?', $sf_user->getGuardUser()->getId())
                  ->orderBy('e.nombre ASC')
                  ->execute();
                foreach ($results as $result) {
                  echo "<option value='".$result->getId()."'>".$result->getNombre()."</option>";
                }
              ?>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>COSTO USD</label>
            <input id="producto_costo_usd_1" type="text" value="<?php echo $form->getObject()->get('costo_usd_1') ?>" class="form-control money" readonly="">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label>TIPO TASA</label>
            <select name="producto[tasa]" class="form-control" id="producto_tasa" readonly>
              <?php if ($form->getObject()->get('tasa')=="T01"){ ?>
                <option value="T01">TASA MEDICAMENTOS</option>
              <?php }else if ($form->getObject()->get('tasa')=="T02"){ ?>
                <option value="T02">TASA MISCELANEOS</option>
              <?php }else if ($form->getObject()->get('tasa')=="T03"){ ?>
                <option value="T03" selected="selected">TASA DEL DIA</option>
              <?php }else{ ?>
                <option value=""></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>TASA BS</label>
            <input type="text" class="form-control" readonly="" id="tasa">
          </div>
        </div>
        <div style="<?php if(!$sf_user->hasCredential("drogueria")) { echo "display: none"; } ?>" class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>UTILIDAD % (1)</label>
              <input type="text" value="<?php echo $form->getObject()->get('util_usd_1') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO USD (1)</label>
              <input id="producto_precio_usd_1" type="text" value="<?php echo $form->getObject()->get('precio_usd_1') ?>" class="form-control money" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO BS (1)</label>
              <input id="producto_precio_bs_1" type="text" value="" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>UTILIDAD % (2)</label>
              <input type="text" value="<?php echo $form->getObject()->get('util_usd_2') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO USD (2)</label>
              <input id="producto_precio_usd_2" type="text" value="<?php echo $form->getObject()->get('precio_usd_2') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO BS (2)</label>
              <input id="producto_precio_bs_2" type="text" value="" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>UTILIDAD % (3)</label>
              <input type="text" value="<?php echo $form->getObject()->get('util_usd_3') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO USD (3)</label>
              <input id="producto_precio_usd_3" type="text" value="<?php echo $form->getObject()->get('precio_usd_3') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO BS (3)</label>
              <input id="producto_precio_bs_3" type="text" value="" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>UTILIDAD % (4)</label>
              <input type="text" value="<?php echo $form->getObject()->get('util_usd_4') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO USD (4)</label>
              <input id="producto_precio_usd_4" type="text" value="<?php echo $form->getObject()->get('precio_usd_4') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO BS (4)</label>
              <input id="producto_precio_bs_4" type="text" value="" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>UTILIDAD % (5)</label>
              <input type="text" value="<?php echo $form->getObject()->get('util_usd_5') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO USD (5)</label>
              <input id="producto_precio_usd_5" type="text" value="<?php echo $form->getObject()->get('precio_usd_5') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO BS (5)</label>
              <input id="producto_precio_bs_5" type="text" value="" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>UTILIDAD % (6)</label>
              <input type="text" value="<?php echo $form->getObject()->get('util_usd_6') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO USD (6)</label>
              <input id="producto_precio_usd_6" type="text" value="<?php echo $form->getObject()->get('precio_usd_6') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO BS (6)</label>
              <input id="producto_precio_bs_6" type="text" value="" class="form-control money" readonly="" id="producto_precio_bs_7">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>UTILIDAD % (7)</label>
              <input type="text" value="<?php echo $form->getObject()->get('util_usd_7') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO USD (7)</label>
              <input id="producto_precio_usd_7" type="text" value="<?php echo $form->getObject()->get('precio_usd_7') ?>" class="form-control money" readonly="">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>PRECIO BS (7)</label>
              <input id="producto_precio_bs_7" type="text" value="" class="form-control money" readonly="">
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>UTILIDAD % (8)</label>
            <input type="text" value="<?php echo $form->getObject()->get('util_usd_8') ?>" class="form-control money2" readonly="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>PRECIO USD (8)</label>
            <input id="producto_precio_usd_8" type="text" value="<?php echo $form->getObject()->get('precio_usd_8') ?>" class="form-control money" readonly="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>PRECIO BS (8)</label>
            <input id="producto_precio_bs_8" type="text" value="" class="form-control" readonly="">
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr/>
  <div class="row no-print">
    <div class="col-12">
      <a href="#" target="_blank" class="btn btn-default" onclick="printDiv('invoice')" >
        <i class="fas fa-print"></i> Imprimir
      </a>
    </div>
  </div>
</div>

<br/><br/>

<div><div><div>

<script>
$( document ).ready(function() {
  GetTasa2();
});

$("#producto_empresa_id").on('change', function(event){
  GetTasa2();
});

function InitPrice() {
  var tasa_txt = $("#tasa").val();
  var tasa=0;
  if(number_float(tasa_txt)>0) {
    tasa=number_float(tasa_txt);
  }

  $("#producto_precio_bs_1").val(SetMoney(number_float($("#producto_precio_usd_1").val())*tasa));
  $("#producto_precio_bs_2").val(SetMoney(number_float($("#producto_precio_usd_2").val())*tasa));
  $("#producto_precio_bs_3").val(SetMoney(number_float($("#producto_precio_usd_3").val())*tasa));
  $("#producto_precio_bs_4").val(SetMoney(number_float($("#producto_precio_usd_4").val())*tasa));
  $("#producto_precio_bs_5").val(SetMoney(number_float($("#producto_precio_usd_5").val())*tasa));
  $("#producto_precio_bs_6").val(SetMoney(number_float($("#producto_precio_usd_6").val())*tasa));
  $("#producto_precio_bs_7").val(SetMoney(number_float($("#producto_precio_usd_7").val())*tasa));
  $("#producto_precio_bs_8").val(SetMoney(number_float($("#producto_precio_usd_8").val())*tasa));
}

function GetTasa() {
  var empresa_id = $("#producto_empresa_id" ).val();
  var categoria_id = <?php echo $form->getObject()->get('categoria_id') ?>;
  var json_obj = JSON.parse(Get("<?php echo url_for("producto");?>/tasa?id="+empresa_id+'&cat='+categoria_id));
  $('#tasa').val(json_obj);
  InitPrice();
}

function GetTasa2() {
  if($("#producto_tasa").val().length>2) {
    var empresa_id = $("#producto_empresa_id" ).val();
    var categoria_id = $("#producto_tasa").val();
    var json_obj = JSON.parse(Get("<?php echo url_for("producto");?>/tasa2?id="+empresa_id+'&cat='+categoria_id));
    $('#tasa').val(json_obj);
    InitPrice();
  } else {
    GetTasa();
  }
}

function printDiv(divName) {
  var printContents = document.getElementById(divName).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
</script>
<?php
function number_float2($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return floatval($number);
}
?>
