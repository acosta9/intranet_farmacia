<label>TASA</label>
<input type="text" class="form-control ntasa" readonly="" id="tasa" value="<?php echo $tasa; ?>">

<script>
$( document ).ready(function() {
  $('.ntasa').number(true, 4, '.', ' ' );
  InitPrice(number_float($('#producto_costo_usd_1').val()));
});
</script>
