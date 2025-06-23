<?php if($form->getObject()->isNew()) { ?>
<?php } else { ?>
  <div id="prods" style="display: none">
    <?php
    $traslado=Doctrine_Core::getTable('Traslado')->findOneBy('id',$sf_params->get('id'));
    $results = Doctrine_Query::create()
      ->select('i.id as iid, p.id as pid, p.nombre as name, p.serial as serial')
      ->from('Inventario i')
      ->leftJoin('i.Producto p')
      ->Where('i.deposito_id =?', $traslado->getDepositoHasta())
      ->orderBy('p.nombre ASC')
      ->execute();
      foreach ($results as $result) {
        echo "<div id='".$result["pid"]."' class='item ".$result["pid"]."'>";
          echo "<div class='id'>".$result["iid"]."</div>";
          echo "<div class='pid'>".$result["pid"]."</div>";
          echo "<div class='name'>".$result["name"]."</div>";
          echo "<div class='serial'>".$result["serial"]."</div>";
        echo "</div>";
      }
    ?>
  </div>
  <?php echo $form['tasa_cambio']->render(array("type" => "hidden", "readonly" => "readonly")); ?>
  <?php if ($form['traslado_det']) : ?>
      <?php $numero=1 ?>
      <?php foreach ($form['traslado_det'] as $det){ ?>
        <div class="card card-primary items" id="sf_fieldset_det_<?php echo $numero?>">
          <div class="card-header">
            <h3 class="card-title">item [<?php echo $numero?>]</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label class="col-sm-12 control-label">Producto</label>
                  <div id="form_<?php echo $numero; ?>_name">
                    <input type="text" readonly="readonly" id="traslado_traslado_det_<?php echo $numero; ?>_producto_name" class="form-control det_producto"/>
                  </div>
                  <input type="hidden" readonly="readonly" id="existe_<?php echo $numero; ?>" class="form-control det_existe" value="0"/>
                  <?php echo $det['producto_id']->render(array("type" => "hidden", "readonly" => "readonly")); ?>
                  <?php echo $det['inventario_id']->render(array("type" => "hidden", "readonly" => "readonly")); ?>
                  <?php echo $det['exento']->render(array("type" => "hidden", "readonly" => "readonly")); ?>
                  <?php echo $det['price_unit']->render(array("type" => "hidden", "readonly" => "readonly")); ?>
                  <?php echo $det['price_tot']->render(array("type" => "hidden", "readonly" => "readonly")); ?>
                  <?php echo $det['descripcion']->render(array("type" => "hidden", "readonly" => "readonly")); ?>
                  <?php echo $det['inv_destino_id']->render(array("type" => "hidden", "readonly" => "readonly")); ?>
                  <?php echo $det['qty']->render(array("type" => "hidden", "readonly" => "readonly", 'class' => 'traslado_det_qty')); ?>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="col-sm-12 control-label">Qty</label>
                  <?php echo $det['qty_dest']->render(array("readonly" => "readonly", "class" => "form-control det_qty_dest numero")); ?>
                </div>
              </div>
              <div class="col-md-2" style="display: none" id="ingresar_num_<?php echo $numero; ?>">
                <label class="col-sm-12 control-label"><br/></label>
                <a target="_blank" class="btn btn-warning btn-block text-uppercase btn-align" href="<?php echo url_for("@inventario")."/new"; ?>">
                  <i class="fa fa-plus-square mr-2"></i>Ingresar prod a inventario
                </a>
              </div>
            </div>
          </div>
        </div>
        <script>
          $( document ).ready(function() {
            var producto_id = $("#traslado_traslado_det_<?php echo $numero; ?>_producto_id").val();

            var serial=$("#prods #"+producto_id+" .serial").text();
            var product_name=$("#prods #"+producto_id+" .name").text();
            var qty = $("#traslado_traslado_det_<?php echo $numero; ?>_qty").val();
            var inv_dest_id = $("#prods #"+producto_id+" .id").text();
            $("#traslado_traslado_det_<?php echo $numero; ?>_producto_name").val(product_name+" ["+serial+"]");
            $("#traslado_traslado_det_<?php echo $numero; ?>_qty_dest").val(qty);
            $("#traslado_traslado_det_<?php echo $numero; ?>_inv_destino_id").val(inv_dest_id);

            if(product_name.length<1) {
              $("#existe_<?php echo $numero; ?>").val("1");
              $("#sf_fieldset_det_<?php echo $numero; ?>").removeClass("card-primary");
              $("#sf_fieldset_det_<?php echo $numero; ?>").addClass("card-warning");
              $("#ingresar_num_<?php echo $numero; ?>").show();

              $("#form_<?php echo $numero; ?>_name").load('<?php echo url_for('traslado/name') ?>?id='+producto_id).fadeIn("slow");
            }
          });
        </script>
        <?php $numero=$numero+1; ?>
    <?php } ?>
  <?php endif; ?>
  <?php echo $form['monto']->render(array("readonly" => "readonly", "type" => "hidden")); ?>

  <script>
    $( document ).ready(function() {
      $('#traslado_empresa_desde').prop('disabled', true);
      $('#traslado_empresa_hasta').prop('disabled', true);
      $('#traslado_deposito_desde').prop('disabled', true);
      $('#traslado_deposito_hasta').prop('disabled', true);
    });
    $( "form" ).submit(function( event ) {
      var cont=0;
      $(".items").each(function() {
        if($(this).find(".det_existe").val()==1) {
          $(this).find(".det_producto").addClass("is-invalid");
          $(this).find(".det_producto").parent().find(".error").remove();
          $(this).find(".det_producto").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Producto no existe en el inventario destino</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".det_producto").parent().find(".error").remove();
          $(this).find(".det_producto").removeClass("is-invalid");
        }

        if($(this).find(".det_qty_dest").val() % 1 > 0) {
          $(this).find(".det_qty_dest").addClass("is-invalid");
          $(this).find(".det_qty_dest").parent().find(".error").remove();
          $(this).find(".det_qty_dest").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>Debe ser un numero entero</li></ul></div>" );
          cont++;
        }else {
          $(this).find(".det_qty_dest").parent().find(".error").remove();
          $(this).find(".det_qty_dest").removeClass("is-invalid");
        }

      });
      if(cont>0) {
        $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, REVISA LOS DATOS INTRODUCIDOS.</div>');
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, 1000);
      } else {
        $('#loading').fadeIn( "slow", function() {});
        $('#traslado_empresa_desde').prop('disabled', false);
        $('#traslado_empresa_hasta').prop('disabled', false);
        $('#traslado_deposito_desde').prop('disabled', false);
        $('#traslado_deposito_hasta').prop('disabled', false);
      }
    });
  </script>
<?php } ?>
