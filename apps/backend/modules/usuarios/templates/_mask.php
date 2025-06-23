
<script type="text/javascript">
  $( document ).ready(function() {
    $("#sf_guard_user_cliente_id").select2({ width: '100%'});
    $('#loading').fadeOut( "slow", function() {});
    $( "form" ).submit(function( event ) {
      $('#loading').fadeIn( "slow", function() {});
    });
  });
</script>
