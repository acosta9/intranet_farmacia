<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Inventario  <small style="font-size: 60%;"> incongruencias</small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage")?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for("@inventario")?>">Inventario</a></li>
          <li class="breadcrumb-item active">incongruencias</li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content">
  <div class="container-fluid">
    <div class="card card-default">
      <div class="card-header" style="padding: 0.75rem 1.25rem 0rem 1.25rem">
        <div class="row">
          <div class="col-md-2  col-sm-12">
            <a class="btn btn-default btn-block text-uppercase btn-align" href="<?php echo url_for("@inventario")?>"><i class="fa fa-bars mr-2"></i>Listado</a></div>
          <div class="col-md-2 col-sm-12">
            <div class="btn-group">
              <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="padding: .345rem .75rem; margin-top: 0.05rem;">+ OPCIONES</button>
              <div class="dropdown-menu" role="menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, -2px, 0px);">
                <a class="dropdown-item" href="#" onclick="toPdf()">Imprimir Pdf</a>
                <a class="dropdown-item" href="#" onclick="toExcel()">Imprimir Excel</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        $eid=$sf_params->get('eid');
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $invs = $q->execute("SELECT i.id as iid, i.deposito_id as did,
          p.id as pid, p.nombre as pname, p.serial as serial, 
          i.cantidad as qty_inv, SUM(id.cantidad) as qty_det, k.cant as qty_kardex,
          dep.acronimo as dname, e.acronimo as emin 
          FROM inventario i
          LEFT JOIN (SELECT SUM(case when tipo = '1' then cantidad else - cantidad end) as cant, deposito_id, producto_id FROM kardex WHERE empresa_id=$eid GROUP BY deposito_id, producto_id) as k ON (i.producto_id=k.producto_id && i.deposito_id=k.deposito_id)
          LEFT JOIN  producto p ON i.producto_id=p.id
          LEFT JOIN inventario_det id ON id.inventario_id=i.id
          LEFT JOIN inv_deposito dep ON i.deposito_id=dep.id
          LEFT JOIN empresa e ON i.empresa_id=e.id
          WHERE i.empresa_id=$eid && id.id IS NOT NULL
          GROUP BY i.id
          ORDER BY pname ASC");
        $i=1;
      ?>
      <div class="card-body">
        <table class="table table-hover table-striped table-list" id="tabla_export">
          <thead class="thead-dark">
            <tr>
              <th></th>
              <th scope="col">DEPOSITO</th>
              <th scope="col">PRODUCTO</th>
              <th scope="col">QTY INV</th>
              <th scope="col">QTY DET</th>
              <th scope="col">QTY KARDEX</th>
              <th scope="col">DIFF</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($invs as $inv): ?>
              <?php
                $qty_prev=$inv["qty_inv"];
                $qty_kardex=0;
                if(!empty($inv["qty_kardex"])) {
                  $qty_kardex=$inv["qty_kardex"];
                }

                $qty_interno=0;
                if(!empty($inv["qty_det"])){
                  $qty_interno=$inv["qty_det"];
                } 

                $qty_total=0; 
                if($qty_interno!=$qty_prev || $qty_prev!=$qty_kardex) {
                  $qty_total=1;
                }
              ?>
              <?php if($qty_total>0): ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $inv["emin"]." [".$inv["dname"]."]"; ?></td>
                  <td><?php echo $inv["pname"]." [".$inv["serial"]."]"; ?></td>
                  <td <?php if($inv["qty_inv"]<0){echo "style='background-color: red;'";}?>>
                    <?php echo $qty_prev; ?>
                  </td>
                  <td  <?php  if($qty_interno<0) { echo "style='background-color: red'"; }  ?>>
                    <?php echo $qty_interno; ?>
                  </td>
                  <td <?php  if($qty_kardex<0) { echo "style='background-color: red'"; } ?>>
                    <?php echo $qty_kardex; ?>
                  </td>
                  <td <?php if($qty_total<>0) { echo "style='background-color: yellow'"; }?>>
                    <?php echo $qty_total; ?>
                  </td>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script src="/js/jspdf.umd.min.js"></script>
<script src="/js/jspdf.plugin.autotable.min.js"></script>
<script src="/js/jquery.table2excel.min.js"></script>
<script>
  $('#loading').fadeOut( "slow", function() {});
  function toPdf() {
    var doc = new jspdf.jsPDF()
    doc.autoTable({ html: '#tabla_export' })
    doc.save('table.pdf')
  }
  function toExcel() {
    <?php $dt = new DateTime(); ?>
    var fecha = "<?php echo $dt->format('Y-m-d_H:i:s'); ?>";
    console.log(fecha);
    $("#tabla_export").table2excel({
      filename: 'incongruencias_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>