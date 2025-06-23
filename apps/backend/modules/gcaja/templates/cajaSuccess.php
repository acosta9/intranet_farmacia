<?php $empre=$sf_params->get('eid');?>
 <label class=" control-label">Caja</label>
 <select name="caja_id" class="form-control caja_id" id="caja_id">
      <?php   
        $results = Doctrine_Query::create()
              ->select('c.nombre, c.id')
              ->from('Caja c')
              ->Where('c.empresa_id = ?', $empre)
              ->orderBy('c.nombre ASC')
              ->execute(); 
              if($results) { ?>
                  <option value="NULL"></option>
                  <?php foreach ($results as $result) { 
                    echo "<option value='".$result->getId()."'>".$result->getNombre()."</option>";
                    } 
                 } else
                     echo "<option value=''></option>";
                  ?>
  </select>
<script type="text/javascript">
  $("#caja_id").on('change', function(event){
    var eid = $("#empresa_id").val(); 
    var cid = $("#caja_id").val();
    $('#caja_header').hide();$('#caja_reportes').hide();
    $('#caja_header').load('<?php echo url_for('gcaja/verheader')?>?eid='+eid+'&cid='+cid).fadeIn("slow");
    $('#caja_reportes').load('<?php echo url_for('gcaja/reportes') ?>?eid='+eid+'&cid='+cid).fadeIn("slow");
  });
</script>