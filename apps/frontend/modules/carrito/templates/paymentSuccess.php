<div class="container p-t-105 p-b-30">
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
        <a href="#">
          <i class="fa fa-credit-card" aria-hidden="true" style="margin-right: 5px;"></i>Método de pago
        </a>
      </li>
			<li>
        <em><i class="fa fa-eye" aria-hidden="true" style="margin-right: 5px;"></i>Review</em>
      </li>
		</ol>
	</nav>
</div>

<div class="container p-b-30 form-shipping">
	<div class="p-t-10">
		<form role="form" class="form-horizontal" id="payment-information" action="<?php echo url_for("carrito") ?>/review" method="get">
		<fieldset>
			<legend>Pago</legend>
        <div class="row">
          <div class="col-lg-12">
            <div class="radio">
              <label>
                <input name="radio"  value="Conekta" checked="" type="radio">
								<img src="/images/conekta.png" width="100"/><i class="fa fa-cc-visa pl-10"></i><i class="fa fa-cc-amex pl-10"></i><i class="fa fa-cc-mastercard pl-10"></i>
							</label>
              <p>Sólo un paso más y tu pago será procesado.</p>
            </div>
            <div class="space-bottom"></div>
          </div>
        </div>

        <div class="space"></div>

        <div class="row">
          <div class="col-lg-12">
            <div class="radio">
              <label style="font-weight: 700; font-size: 13px; color: #414758;">
                <input name="radio" value="Transferencia" type="radio">
								TRANSFERENCIA
              </label>
              <p>Se le enviará un correo con toda la información necesaria para este paso.</p>
            </div>
            <div class="space-bottom"></div>
          </div>
        </div>
    </fieldset>

    <div class="text-right">
      <a href="<?php echo url_for('@carrito') ?>/shipping" class="btn btn-group btn-susc"><i class="icon-left-open-big"></i> Regresar</a>
		 	<input type="submit" class="btn btn-group btn-susc" value="Siguiente"/>
    </div>
		</form>
  </div>
</div>
