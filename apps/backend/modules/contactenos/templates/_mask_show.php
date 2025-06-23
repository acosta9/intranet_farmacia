</div></div></div></div>
<div><div><div><div>
<div class="row no-print">
<?php 
if($form->getObject()->get('estatus')) {
  $class="btn-danger";
  $estatus="No leido";
  $icon="fa-minus-circle";
} else {  
  $class="btn-success";
  $estatus="Leido";
  $icon="fa-check";
}
?>
  <div class="col-12">
    <button onclick="estatus()" class="btn <?php echo $class; ?> float-right" style="margin-right: 5px;">
      <i class="fas <?php echo $icon; ?>"></i> <?php echo " ".$estatus; ?>
    </button>
  </div>
</div>
  <br/><br/>
<script>
  function estatus() {
    var retVal = confirm("¿Estas seguro de cambiar el estatus del registro de contactenos?");
    if( retVal == true ){
        location.href = "<?php echo url_for("contactenos")."/estatus?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
  }
</script>