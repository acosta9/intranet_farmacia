<script type="text/javascript">
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
    <?php if(!$form->getObject()->isNew()): ?>
      $("#prod_categoria_codigo").prop('readonly', 'readonly');
    //  $("#prod_categoria_nombre").prop('readonly', 'readonly');
    <?php endif; ?>
    $( "form" ).submit(function( event ) {
      $('#loading').fadeIn( "slow", function() {});
    });
  });
</script>
