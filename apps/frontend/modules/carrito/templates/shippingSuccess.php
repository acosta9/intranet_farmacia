<div class="container p-t-105 p-b-30" id="irarriba">
  <nav>
		<ol class="cd-multi-steps text-center">
			<li class="current">
        <a class="activo" href="<?php echo url_for("carrito");?>">
          <i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i>Carrito
        </a>
      </li>
			<li class="current">
        <a href="#">
          <i class="fa fa-rocket" aria-hidden="true" style="margin-right: 5px;"></i>Shipping
        </a>
      </li>
			<li class="">
        <em><i class="fa fa-credit-card" aria-hidden="true" style="margin-right: 5px;"></i>Método de pago</em>
      </li>
			<li>
        <em><i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>Review</em>
      </li>
		</ol>
	</nav>
</div>

<div class="container form-shipping">
  <div class="alert alert-danger m-t-20 m-b-40" style="display: none" id="eerror">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Error! revise la información proporcionada
  </div>
	<form role="form" class="form-horizontal" id="shipping-information" action="<?php echo url_for("carrito") ?>/guardarshipping" method="get">
		<fieldset>
			<legend>Información de envío</legend>
			<div class="row" style="border-bottom: 1px solid #e9e9e9;">
				<div class="col-lg-3">
					<h3 class="title" style="margin-top:10px;">INFORMACIÓN PERSONAL</h3>
				</div>
				<div class="col-lg-8 col-lg-offset-1 m-t-10">
					<div class="form-group">
						<label for="billingFirstName" class="col-md-2 control-label">Nombre Completo<small class="text-default">*</small></label>
						<div class="col-md-10">
							<input class="form-control" id="envio_nombre" name="envio_nombre"  placeholder="Escribe tu nombre aquí" type="text" value="<?php if($shipping) {echo $shipping->getNombreCompleto();}?>">
						</div>
					</div>

					<div class="form-group">
						<label for="shippingTel" class="col-md-2 control-label">Teléfono de contacto<small class="text-default">*</small></label>
						<div class="col-md-10">
							<input class="form-control" id="envio_telf_contacto" name="envio_telf_contacto"  placeholder="Teléfono de contacto" type="text" value="<?php if($shipping) {echo $shipping->getTelfContacto();}?>">
						</div>
					</div>
					<div class="form-group  m-b-30">
						<label for="shippingTel" class="col-md-2 control-label">Empresa</label>
						<div class="col-md-10">
							<input class="form-control" id="envio_empresa" name="envio_empresa" placeholder="Empresa" type="text" value="<?php if($shipping){echo $shipping->getEmpresa();}?>">
						</div>
					</div>
				</div>
			</div>
			<div class="space"></div>
			<div class="row m-t-30">
				<div class="col-lg-3">
					<h3 class="title"  style="margin-top:10px;">DIRECCIÓN</h3>
				</div>

				<div class="col-lg-8 col-lg-offset-1 m-t-10">
					<div class="form-group">
						<label for="shippingAddress1" class="col-md-2 control-label">Dirección<small class="text-default">*</small></label>
						<div class="col-md-10">
							<input class="form-control" id="envio_direccion" name="envio_direccion"   placeholder="Dirección" type="text" value="<?php if($shipping){echo $shipping->getDireccion();}?>">
						</div>
					</div>
          <div class="form-group">
						<label for="shippingAddress2" class="col-md-2 control-label">Número exterior<small class="text-default">*</small></label>
						<div class="col-md-10">
							<input class="form-control" id="envio_num_exterior" name="envio_num_exterior"   placeholder="Número exterior" type="text" value="<?php if($shipping){echo $shipping->getNumExterior();}?>">
						</div>
					</div>
					<div class="form-group">
						<label for="shippingAddress2" class="col-md-2 control-label">Número interior<small class="text-default">*</small></label>
						<div class="col-md-10">
							<input class="form-control" id="envio_num_interior" name="envio_num_interior"   placeholder="Número interior" type="text" value="<?php if($shipping){echo $shipping->getNumInterior();}?>">
						</div>
					</div>
					<div class="form-group">
						<label for="shippingCity" class="col-md-2 control-label">Estado<small class="text-default">*</small></label>
						<div class="col-md-10">
							<select class="form-control" id="envio_estado" name="envio_estado">
								<option value="0">Selecciona Uno...</option>
                <?php if($shipping){echo '<option selected value="'.$shipping->getEstado().'">'.$shipping->getEstado().'</option>';} ?>
                <?php
                  foreach ($estados as $estado) {
                ?>
                  <option value="<?php echo $estado->getId();?>"><?php echo $estado->getNombre();?></option>
                <?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="shippingCity" class="col-md-2 control-label">Ciudad<small class="text-default">*</small></label>
						<div class="col-md-10">
							<select class="form-control" id="envio_ciudad" name="envio_ciudad">
								<option value="0"></option>
                <?php if($shipping){echo '<option selected value="'.$shipping->getCiudad().'">'.$shipping->getCiudad().'</option>';} ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="shippingPostalCode" class="col-md-2 control-label">Delegación / Municipio<small class="text-default">*</small></label>
						<div class="col-md-10">
              <select class="form-control" id="envio_delegacion" name="envio_delegacion">
								<option value="0"></option>
                <?php if($shipping){echo '<option selected value="'.$shipping->getDelegacion().'">'.$shipping->getDelegacion().'</option>';} ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="shippingPostalCode" class="col-md-2 control-label">Colonia<small class="text-default">*</small></label>
						<div class="col-md-10">
              <select class="form-control" id="envio_colonia" name="envio_colonia">
								<option value="0"></option>
                <?php if($shipping){echo '<option selected value="'.$shipping->getColonia().'">'.$shipping->getColonia().'</option>';} ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="shippingPostalCode" class="col-md-2 control-label">Código postal<small class="text-default">*</small></label>
						<div class="col-md-10">
							<input class="form-control" id="envio_cod_postal" name="envio_cod_postal"  placeholder="Código postal" type="text" value="<?php if($shipping){echo $shipping->getCodPostal();}?>">
						</div>
					</div>
				</div>
			</div>
		</fieldset>

		<fieldset>
	    <legend>Información de facturación</legend>
	      <div id="billing-information" class="space-bottom" style="display:none;">
					<div class="row">
						<div class="col-lg-3">
							<h3 class="title">Información personal</h3>
						</div>
						<div class="col-lg-8 col-lg-offset-1">
							<div class="form-group">
								<label for="billingFirstName" class="col-md-2 control-label">Nombre Completo<small class="text-default">*</small></label>
								<div class="col-md-10">
									<input class="form-control" id="pago_nombre" name="pago_nombre"  placeholder="Escribe tu nombre aquí" type="text" value="<?php if($billing){echo $billing->getNombreCompleto();}?>">
								</div>
							</div>

							<div class="form-group">
								<label for="shippingTel" class="col-md-2 control-label">Teléfono de contacto<small class="text-default">*</small></label>
								<div class="col-md-10">
									<input class="form-control" id="pago_telf_contacto" name="pago_telf_contacto"  placeholder="Teléfono de contacto" type="text" value="<?php if($billing){echo $billing->getTelfContacto();}?>">
								</div>
							</div>
							<div class="form-group">
								<label for="shippingTel" class="col-md-2 control-label">Empresa</label>
								<div class="col-md-10">
									<input class="form-control" id="pago_empresa" name="pago_empresa" placeholder="Empresa" type="text" value="<?php if($billing){echo $billing->getEmpresa();}?>">
								</div>
							</div>
						</div>
					</div>
					<div class="space"></div>
					<div class="row">
						<div class="col-lg-3">
							<h3 class="title">Dirección</h3>
						</div>

						<div class="col-lg-8 col-lg-offset-1">
							<div class="form-group">
								<label for="shippingAddress1" class="col-md-2 control-label">Dirección<small class="text-default">*</small></label>
								<div class="col-md-10">
									<input class="form-control" id="pago_direccion" name="pago_direccion"   placeholder="Dirección" type="text" value="<?php if($billing){echo $billing->getDireccion();}?>">
								</div>
							</div>
							<div class="form-group">
								<label for="shippingAddress2" class="col-md-2 control-label">Número interior<small class="text-default">*</small></label>
								<div class="col-md-10">
									<input class="form-control" id="pago_num_interior" name="pago_num_interior"   placeholder="Número interior" type="text" value="<?php if($billing){echo $billing->getNumInterior();}?>">
								</div>
							</div>
							<div class="form-group">
								<label for="shippingAddress2" class="col-md-2 control-label">Número exterior<small class="text-default">*</small></label>
								<div class="col-md-10">
									<input class="form-control" id="pago_num_exterior" name="pago_num_exterior"   placeholder="Número exterior" type="text" value="<?php if($billing){echo $billing->getNumExterior();}?>">
								</div>
							</div>
							<div class="form-group">
								<label for="shippingCity" class="col-md-2 control-label">Estado<small class="text-default">*</small></label>
								<div class="col-md-10">
                  <select class="form-control" id="pago_estado" name="pago_estado">
    								<option value="0">Selecciona Uno...</option>
                    <?php if($billing){echo '<option selected value="'.$billing->getEstado().'">'.$billing->getEstado().'</option>';} ?>
                    <?php
                      foreach ($estados as $estado) {
                    ?>
                      <option value="<?php echo $estado->getId();?>"><?php echo $estado->getNombre();?></option>
                    <?php } ?>
    							</select>
								</div>
							</div>
							<div class="form-group">
								<label for="shippingCity" class="col-md-2 control-label">Ciudad<small class="text-default">*</small></label>
								<div class="col-md-10">
                  <select class="form-control" id="pago_ciudad" name="pago_ciudad">
    								<option value="0"></option>
                    <?php if($billing){echo '<option selected value="'.$billing->getCiudad().'">'.$billing->getCiudad().'</option>';} ?>
    							</select>
								</div>
							</div>
							<div class="form-group">
								<label for="shippingPostalCode" class="col-md-2 control-label">Delegación / Municipio<small class="text-default">*</small></label>
								<div class="col-md-10">
                  <select class="form-control" id="pago_delegacion" name="pago_delegacion">
    								<option value="0"></option>
                    <?php if($billing){echo '<option selected value="'.$billing->getDelegacion().'">'.$billing->getDelegacion().'</option>';} ?>
    							</select>
								</div>
							</div>
							<div class="form-group">
								<label for="shippingPostalCode" class="col-md-2 control-label">Colonia<small class="text-default">*</small></label>
								<div class="col-md-10">
                  <select class="form-control" id="pago_colonia" name="pago_colonia">
    								<option value="0"></option>
                    <?php if($billing){echo '<option selected value="'.$billing->getColonia().'">'.$billing->getColonia().'</option>';} ?>
    							</select>
								</div>
							</div>
							<div class="form-group">
								<label for="shippingPostalCode" class="col-md-2 control-label">Código postal<small class="text-default">*</small></label>
								<div class="col-md-10">
									<input class="form-control" id="pago_cod_postal" name="pago_cod_postal"  placeholder="Código postal" type="text" value="<?php if($billing){echo $billing->getCodPostal();}?>">
								</div>
							</div>
						</div>
					</div>
	      </div>
	      <div class="checkbox padding-top-clear">
	        <label>
	          <input id="billing-info-check" name="billing-info-check" checked="" type="checkbox"> Mi dirección de facturación es la misma información de envío.
					</label>
	      </div>
	  </fieldset>

	  <div class="text-right">
	    <a href="<?php echo url_for("carrito") ?>" class="btn btn-group btn-susc"><i class="icon-left-open-big"></i> Regresar</a>
			<input type="submit" class="btn btn-group btn-susc" value="Siguiente">
	  </div>
	</form>
</div>

<script language="javascript">
$(document).ready(function(){
   $("#envio_estado").change(function () {
     $("#envio_estado option:selected").each(function () {
       elegido=$(this).val();
       $.post("<?php echo url_for("carrito")?>/buscarciudad", { d: elegido }, function(data){
         $("#envio_ciudad").html(data);
         $('#envio_delegacion').find('option').remove();
         $('#envio_colonia').find('option').remove();
       });
     });
   });

   $("#envio_ciudad").change(function () {
     $("#envio_ciudad option:selected").each(function () {
       elegido=$(this).val();
       $.post("<?php echo url_for("carrito")?>/buscarmunicipio", { d: elegido }, function(data){
         $("#envio_delegacion").html(data);
         $('#envio_colonia').find('option').remove();
       });
     });
   });

   $("#envio_delegacion").change(function () {
     $("#envio_delegacion option:selected").each(function () {
       elegido=$(this).val();
       $.post("<?php echo url_for("carrito")?>/buscarcolonia", { d: elegido }, function(data){
         $("#envio_colonia").html(data);
       });
     });
   });

   $("#pago_estado").change(function () {
     $("#pago_estado option:selected").each(function () {
       elegido=$(this).val();
       $.post("<?php echo url_for("carrito")?>/buscarciudad", { d: elegido }, function(data){
         $("#pago_ciudad").html(data);
         $('#pago_delegacion').find('option').remove();
         $('#pago_colonia').find('option').remove();
       });
     });
   });

   $("#pago_ciudad").change(function () {
     $("#pago_ciudad option:selected").each(function () {
       elegido=$(this).val();
       $.post("<?php echo url_for("carrito")?>/buscarmunicipio", { d: elegido }, function(data){
         $("#pago_delegacion").html(data);
         $('#pago_colonia').find('option').remove();
       });
     });
   });

   $("#pago_delegacion").change(function () {
     $("#pago_delegacion option:selected").each(function () {
       elegido=$(this).val();
       $.post("<?php echo url_for("carrito")?>/buscarcolonia", { d: elegido }, function(data){
         $("#pago_colonia").html(data);
       });
     });
   });

});
</script>

<script>
  $('#shipping-information').submit(function(e) {
    var cont = 0;
    $( ".error_list" ).remove();
    if($('#envio_nombre').val().length <= 2 ) {
      $('#envio_nombre').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }
    if($('#envio_telf_contacto').val().length <= 2 ) {
      $('#envio_telf_contacto').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }
    if($('#envio_direccion').val().length <= 2 ) {
      $('#envio_direccion').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }
    if($('#envio_num_interior').val().length <= 2 ) {
      $('#envio_num_interior').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }
    if($('#envio_num_exterior').val().length <= 2 ) {
      $('#envio_num_exterior').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }
    if($("#envio_estado option:selected").val() == "0" ) {
      $('#envio_estado').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }
    if($("#envio_ciudad option:selected").val() == "0" ) {
      $('#envio_ciudad').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }
    if($("#envio_delegacion option:selected").val() == "0" ) {
      $('#envio_delegacion').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }
    if($("#envio_colonia option:selected").val() == "0" ) {
      $('#envio_colonia').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }
    if($('#envio_cod_postal').val().length <= 2 ) {
      $('#envio_cod_postal').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
      cont++;
    }

    if($('#billing-info-check').is(':checked')===false) {
      if($('#pago_nombre').val().length <= 2 ) {
        $('#pago_nombre').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
      if($('#pago_telf_contacto').val().length <= 2 ) {
        $('#pago_telf_contacto').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
      if($('#pago_direccion').val().length <= 2 ) {
        $('#pago_direccion').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
      if($('#pago_num_interior').val().length <= 2 ) {
        $('#pago_num_interior').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
      if($('#pago_num_exterior').val().length <= 2 ) {
        $('#pago_num_exterior').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
      if($("#pago_estado option:selected").val() == "0" ) {
        $('#pago_estado').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
      if($("#pago_ciudad option:selected").val() == "0" ) {
        $('#pago_ciudad').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
      if($("#pago_delegacion option:selected").val() == "0" ) {
        $('#pago_delegacion').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
      if($("#pago_colonia option:selected").val() == "0" ) {
        $('#pago_colonia').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
      if($('#pago_cod_postal').val().length <= 2 ) {
        $('#pago_cod_postal').parent().append("<ul class='error_list'><li>Requerido.</li></ul>");
        cont++;
      }
    }

    if(cont>=1) {
      e.preventDefault();
      $("#eerror").show("slow");
      $('html, body').animate({scrollTop: $("#irarriba").offset().top}, 2000);
    }
  });
</script>
