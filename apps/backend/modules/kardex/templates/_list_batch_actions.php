<div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="padding: .345rem .75rem; margin-top: 0.05rem;">+ OPCIONES</button>
  <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, -2px, 0px);">
    <?php if ($sf_user->hasCredential(array(  0 => 'farmacia', 1 => 'auditorinv'))): ?>
      <a class="dropdown-item" href="#" onclick="reporte_kardex()">REPORTE KARDEX</a>
    <?php endif; ?>
  </div>
</div>

<script> 
  var fecha_desde = $("#kardex_filters_fecha_from").val();
  var fecha_hasta = $("#kardex_filters_fecha_to").val();
  var did = $("#kardex_filters_deposito_id").val();
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
  function reporte_kardex() {
    if($("#sin_resultados").text()) {
      alert("no hay resultados en la busqueda");
    } else {
      window.open("<?php echo url_for("kardex")."/batchReporteFirst"?>?desde="+desde+"&hasta="+hasta+"&did="+did, '_blank');
    }
  }
  
</script>