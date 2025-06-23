<div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="padding: .345rem .75rem; margin-top: 0.05rem;">+ OPCIONES</button>
  <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, -2px, 0px);">
    <?php if ($sf_user->hasCredential(array(  0 =>   array(    0 => 'farmacia',    1 => 'suppventa',  ),))): ?>
      <a target="_blank" class="dropdown-item" href="<?php echo url_for("prod_vendidos")."/batchReporteMasVendidos"?>">REPORTE MAS VENDIDOS</a>
    <?php endif; ?>
    <?php if ($sf_user->hasCredential(array(  0 => 'compra2',))): ?>
      <a class="dropdown-item" href="#" onclick="reporte_abc()">REPORTE ABC</a>
    <?php endif; ?>
  </div>
</div>

<script> 
  var labs=$("#lab_hidden").text();
  labs=labs.trim();
  if(labs.length>2) {
    var res = labs.split(";");
    for (index = 0; index < res.length; index++) {
      if(res[index].length>1) {
        var res2 = res[index].split("|");
        $("#prod_vendidos_filters_laboratorio_id").append("<option value='"+res2[0]+"' selected>"+res2[1]+"</option>");
      }
    }
  }
  var fecha_desde = $("#prod_vendidos_filters_fecha_from").val();
  var fecha_hasta = $("#prod_vendidos_filters_fecha_to").val();

  var emp = $("#prod_vendidos_filters_empresa_id").val();
  var dep = $("#prod_vendidos_filters_deposito_id").val();
  var cat = $("#prod_vendidos_filters_categoria_id").val();
  var tipo = $("#prod_vendidos_filters_tipo").val();

  var lab = "";
  if ($("#prod_vendidos_filters_laboratorio_id").val()) {
    lab = $("#prod_vendidos_filters_laboratorio_id").val();
  }

  var unit = "";
  if ($("#prod_vendidos_filters_laboratorio_id").val()) {
    unit = $("#prod_vendidos_filters_unidad_id").val();
  }

  if(!fecha_desde) {
    desde="∞";
  } else {
    var d = new Date(fecha_desde);
    const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
    const mo = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(d);
    const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
    var desde=`${da}-${mo}-${ye}`;
  }
  if(!fecha_hasta) {
    hasta="∞"
  } else {
    var d = new Date(fecha_hasta);
    const ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
    const mo = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(d);
    const da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
    var hasta=`${da}-${mo}-${ye}`;
  }
  function reporte_abc() {
    if($("#sin_resultados").text()) {
      alert("no hay resultados en la busqueda");
    } else {
      window.open("<?php echo url_for("prod_vendidos")."/batchReporteAbc"?>?d="+desde+"&h="+hasta+"&c="+cat+"&t="+tipo+"&e="+emp+"&dep="+dep+"&lab="+lab+"&unit="+unit, '_blank');
    }
  }
  
</script>