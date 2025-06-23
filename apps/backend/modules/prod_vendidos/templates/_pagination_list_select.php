<?php
$show = __(' Mostrar ');
$perPage = __(' por pagina');
$nbRecords = array('10', '20', '30', '50', '100', '500');
$currentMaxPerPage = $sf_user->getAttribute('prod_vendidos.max_per_page', $pager->getMaxPerPage(),'admin_module');
?>
<select id="select_max_per_page" name="select_max_per_page" class="custom-select custom-select-sm form-control form-control-sm" style="height: 2.4rem;">
<?php  foreach(sfConfig::get('app_mp_reality_max_per_page', $nbRecords) as $maxPerPage): ?>
<option value="<?php echo $maxPerPage ?>" <?php echo ($currentMaxPerPage == $maxPerPage) ? 'selected=selected' :'' ?>><?php echo $maxPerPage ?></option>
<?php endforeach ?>
</select>

<script type="text/javascript">
/* <![CDATA[ */
$('#select_max_per_page').change(function() {
  var singleValues = $("#select_max_per_page").val();
  //alert('Handler for .change() called. '+singleValues);
  changePageSize(singleValues);
});
function changePageSize(val){
        var newLocation = "<?php echo url_for('@prod_vendidos') ?>?maxPerPage="+val;
        window.location=newLocation;
    };
/* ]]> */
</script>
