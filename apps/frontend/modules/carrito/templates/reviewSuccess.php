<div class="container p-t-105 p-b-30">
  <?php if ($sf_user->hasFlash('error')): ?>
    <div class="alert alert-danger m-t-50 m-b-20">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <?php echo $sf_user->getFlash('error') ?>
    </div>
  <?php endif; ?>
  <nav>
		<ol class="cd-multi-steps text-center">
			<li class="current">
        <a class="activo" href="<?php echo url_for("carrito");?>">
          <i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i>Carrito
        </a>
      </li>
			<li class="current">
        <a class="activo" href="<?php echo url_for("carrito");?>/shipping">
          <i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i>Shipping
        </a>
      </li>
			<li class="current">
        <a class="activo" href="<?php echo url_for("carrito");?>/payment">
          <i class="fa fa-check" aria-hidden="true" style="margin-right: 5px;"></i>Método de pago
        </a>
      </li>
			<li class="current">
        <a class="" href="#"><i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>Review</a>
      </li>
		</ol>
	</nav>
</div>

<div class="container p-b-30 review">
  <div class="p-t-10 padding-30">
    <table class="table cart table-colored">
      <thead>
        <tr>
          <th>Imagen</th>
          <th>Producto</th>
          <th>Precio </th>
          <th>Cantidad</th>
          <th class="amount">Total </th>
        </tr>
      </thead>
      <tbody>
				<?php $conta = 0; $total=0;?>
				<?php foreach ($results as $carrito) { ?>
					<?php
						$conta++;
						if($carrito->getProductoId()) {
							$producto=Doctrine::getTable('Producto')->findOneBy('id',$carrito->getProductoId());
							$image = "/uploads/producto/".$producto->getUrlImagen();
							$enlace = url_for('producto/show?id='.$producto->getId());
						} else {
							$producto=Doctrine::getTable('Foodfit')->findOneBy('id',$carrito->getFoodfitId());
							$image = "/uploads/foodfit/".$producto->getUrlImagen();
							$enlace = url_for('foodfit/show?id='.$producto->getId());
						}
					?>

					<tr>
						<td><img class="img-car" src="<?php echo $image?>" alt="" class="img-responsive"></td>
						<td class="product"><a href="<?php echo $enlace; ?>"><?php echo $producto->getNombre(); ?></a> <small><?php echo substr($producto->getDescripcion(),0,155)."..."; ?></small></td>
						<td class="price"> <?php list ($mm, $pp) = explode(" ",$producto->getPrecNetoT()); echo $mm." ".number_format($pp, 2, ',', '.');?> </td>
						<td class="quantity">
							<div class="form-group">
								<input class="form-control" value="<?php echo $carrito->getCantidad(); ?>" type="text" readonly="readonly">
						 </div>
					 </td>
					 <td class="amount"><?php $total+=$carrito->getCantidad()*$pp; echo $mm." ".number_format($carrito->getCantidad()*$pp, 2, ',', '.'); ?></td>
					</tr>
				<?php } ?>

        <tr>
          <td style="text-align: left;" colspan="4">Total <?php echo $conta ?> Items</td>
    			<td style="text-align: right;">$ <?php echo number_format($total, 2, ',', '.'); ?></td>
        </tr>
        <tr>
          <td style="text-align: left;" colspan="4">Costo de Envio</td>
    			<td style="text-align: right;">$ <?php echo number_format($costo_envio->getCosto(), 2, ',', '.'); ?></td>
        </tr>
        <tr>
          <td class="total-quantity" colspan="4">Total a Pagar</td>
    			<td class="total-amount">$ <?php echo number_format($costo_envio->getCosto()+$total, 2, ',', '.'); ?></td>
        </tr>
      </tbody>
    </table>

    <table class="table facturacion">
      <thead>
        <tr>
          <th colspan="2">Información de facturación </th>
        </tr>
      </thead>
      <tbody>
				<tr>
          <td>Nombre completo</td>
          <td class="information"><?php echo $billing->getNombreCompleto() ?> </td>
        </tr>
				<?php if ($shipping->getEmpresa()) { ?>
        <tr>
          <td>Empresa</td>
          <td class="information"><?php echo $billing->getEmpresa() ?> </td>
        </tr>
				<?php } ?>
        <tr>
          <td>Telefóno de contacto</td>
          <td class="information"><?php echo $billing->getTelfContacto() ?></td>
        </tr>
        <tr>
          <td>Dirección</td>
          <td class="information"><?php echo $billing->getEstado().", ".$billing->getCiudad().", ".$billing->getDelegacion().", ".$billing->getColonia().", ".$billing->getCodPostal().", ".$billing->getDireccion() ?></td>
        </tr>
      </tbody>
    </table>

    <table class="table facturacion">
      <thead>
        <tr>
          <th colspan="2">Información de envío </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Nombre completo</td>
          <td class="information"><?php echo $shipping->getNombreCompleto() ?> </td>
        </tr>
				<?php if ($shipping->getEmpresa()) { ?>
        <tr>
          <td>Empresa</td>
          <td class="information"><?php echo $shipping->getEmpresa() ?> </td>
        </tr>
				<?php } ?>
        <tr>
          <td>Telefóno de contacto</td>
          <td class="information"><?php echo $shipping->getTelfContacto() ?></td>
        </tr>
        <tr>
          <td>Dirección</td>
          <td class="information"><?php echo $shipping->getEstado().", ".$shipping->getCiudad().", ".$shipping->getDelegacion().", ".$shipping->getColonia().", ".$shipping->getCodPostal().", ".$shipping->getDireccion() ?></td>
        </tr>
      </tbody>
    </table>

    <table class="table facturacion">
      <thead>
        <tr>
          <th colspan="2">Pago </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo $tipo ?></td>
        </tr>
      </tbody>
    </table>

		<form action="<?php echo url_for("carrito")?>/procesar" method="POST" id="card-form">
			<input type="hidden" readonly="readonly" value="<?php echo $tipo ?>" name="tipo" id="tipoo"/>

      <button id="conekkta" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display:none">Open Modal</button>

      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Tarjeta de Débito/Crédito</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label">Nombre del Tarjetahabiente<small class="text-default">*</small></label>
                    <input class="form-control" type="text" data-conekta="card[name]" required/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label">Número de tarjeta de crédito<small class="text-default">*</small></label>
                    <input class="form-control" type="text" data-conekta="card[number]" required/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="control-label">CVC<small class="text-default">*</small></label>
                    <input class="form-control" type="text" data-conekta="card[cvc]" required/>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group expiracion">
                    <label class="control-label">Fecha de expiración (MM/AAAA)<small class="text-default">*</small></label>
                    <div class="row">
                      <div class="col-md-2">
                        <input class="form-control" type="text" data-conekta="card[exp_month]" required/>
                      </div>
                      <div class="col-md-2">
                        <input class="form-control col-md-2" type="text" data-conekta="card[exp_year]" required/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-group btn-susc" style="padding: 0rem 0rem !important; width: 10rem;" id="pconekta">Pagar con Conekta</button>
              <button class="btn btn-default" data-dismiss="modal" style="margin-top: -0.8rem !important;">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

	    <div class="text-right">
	      <a href="<?php echo url_for("carrito") ?>/payment" class="btn btn-group btn-susc"><i class="icon-left-open-big"></i> Regresar</a>
	      <a href="#" class="btn btn-group btn-susc" id="comprarr">Comprar</a>
	    </div>
		</form>

    <script>
      var formm = document.getElementById("card-form");
      document.getElementById("comprarr").addEventListener("click", function () {
        if ($('#tipoo').val()==="Transferencia") {
      		formm.submit();
      	} else {
          $("#conekkta").trigger('click');
        }
      });
    </script>

    <script type="text/javascript" src="https://conektaapi.s3.amazonaws.com/v0.3.0/js/conekta.js"></script>

  	<script type="text/javascript">
  	 Conekta.setPublishableKey('key_W6EH2J49cqXuKmJRthmu3Pg');
  	</script>

    <script type="text/javascript">
      jQuery(function($) {
        var conektaSuccessResponseHandler;
        conektaSuccessResponseHandler = function(token) {
          var $form;
          $form = $("#card-form");
          $form.append($("<input type=\"hidden\" name=\"conektaTokenId\" />").val(token.id));
          $form.get(0).submit();
        };

        conektaErrorResponseHandler = function(token) {
          console.log(token);
        };

        $("#card-form").submit(function(event) {
          event.preventDefault();
          var $form;
          $form = $(this);
          $form.find("button").prop("disabled", true);
          Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
          return false;
        });
      });
    </script>

  </div>
</div>
