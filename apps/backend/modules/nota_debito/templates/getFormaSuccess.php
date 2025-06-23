<script>
$( document ).ready(function() {
  if($("#nota_debito_moneda").val()==1) {
    $('#nota_debito_monto').prop('readonly', true);
    $('#monto_bs').prop('readonly', false);
  } else {
    $('#nota_debito_monto').prop('readonly', false);
    $('#monto_bs').prop('readonly', true);
  }
});
</script>
