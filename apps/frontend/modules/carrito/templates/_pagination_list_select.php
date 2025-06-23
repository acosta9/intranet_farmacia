<?php
$show = __(' Mostrar ');
$perPage = __(' por pagina');
$nbRecords = array('3','5','10', '20', '50', '100', '∞');
$currentMaxPerPage = $sf_user->getAttribute('carrito.max_per_page', $pager->getMaxPerPage(),'admin_module');
?>

| <?php echo $show ?>
<select id="select_max_per_page" name="select_max_per_page" class="select_max_per_page" >
<?php  foreach(sfConfig::get('app_mp_reality_max_per_page', $nbRecords) as $maxPerPage): ?>
<option value="<?php echo $maxPerPage ?>" <?php echo ($currentMaxPerPage == $maxPerPage) ? 'selected=selected' :'' ?>><?php echo $maxPerPage ?></option>
<?php endforeach ?>
</select>
<?php echo $perPage ?>
<script type="text/javascript">
/* <![CDATA[ */
$('.select_max_per_page').change(function() {
  var singleValues = $("#select_max_per_page").val();
  //alert('Handler for .change() called. '+singleValues);
  changePageSize(singleValues);
});
function changePageSize(val){   
        var newLocation = "<?php echo url_for('@carrito') ?>?maxPerPage="+val;
        window.location=newLocation;
    };
/* ]]> */
</script>
