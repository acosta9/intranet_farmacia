<?php $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$form->getObject()->get('cliente_id'));?>
<?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
<style>
   .website-wrapper {
      background-color: #f3f3f3 !important;
   }
</style>
<div class="main-page-wrapper" style='background-color: #f3f3f3; font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"; font-size: 0.9rem; font-weight: 400; line-height: 1.5; color: #212529; text-align: left;'>
   <div class="page-title page-title-default title-size-default title-design-centered color-scheme-light" style="#background-color: #4c2d95">
		<div class="container">
			<header class="entry-header">
				<h1 class="entry-title">RECIBOS DE PAGO</h1>
				<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
					<a href="<?php echo url_for("@inicio"); ?>" rel="v:url" property="v:title">Inicio</a> » 
               <a href="<?php echo url_for("@recibo_pago"); ?>" rel="v:url" property="v:title">Recibos de pago</a> » 
               <span class="current">N° de control <?php echo $recibo_pago->getNcontrol(); ?></span>
				</div>
			</header>
		</div>
	</div>
   <div class="container">
      <div class="invoice p-3 mb-3" id="invoice" <?php if($form->getObject()->get('anulado')==1) { echo 'style="background: #f1daa759 !important; padding: 1rem"'; } else { echo 'style="background: #fff !important; padding: 1rem"'; }?>>
      <div class="row">
         <div class="col-md-6">
         <h4>
            <img src='/images/<?php echo $empresa->getId()?>.png' height="60"/>
         </h4>
         </div>
         <div class="col-md-6">
         <?php if($form->getObject()->get('anulado')==1) { ?>
            <img src='/images/anulado.png' style="float:right"/>
         <?php } ?>
         </div>
      </div>
      <div class="row invoice-info">
         <div class="col-sm-4 invoice-col">
         <address>
            <strong><?php echo $empresa->getNombre()?> | <?php echo $empresa->getRif()?></strong><br/>
            <span class="tcaps"><?php echo mb_strtolower($empresa->getDireccion())?></span><br/>
            <b>Telf:</b> <?php echo $empresa->getTelefono()?><br/>
            <b>Email:</b> <?php echo $empresa->getEmail()?>
         </address>
         </div>
         <div class="col-sm-4 invoice-col">
         <address>
            <strong><?php echo $cliente->getFullName(); ?> | <?php echo $cliente->getDocId(); ?></strong><br>
            <span class="tcaps"><?php echo mb_strtolower($cliente->getDireccion())?></span><br/>
            <b>Telf:</b> <?php echo $cliente->getTelf(); ?><br>
         </address>
         </div>
         <div class="col-sm-4 invoice-col">
         <small class="float-right">FECHA: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('fecha')))); ?></small><br/>
         <b class="float-right">RECIBO DE PAGO</b><br/>
         <b class="float-right">#<?php echo ($form->getObject()->get('ncontrol')); ?><br/></b><br>
         </div>
      </div>
      <div class="row" style="margin-top: 2rem">
         <div class="col-md-12" style="margin-bottom: 0.7rem;">
         <b>RECIBI DE: </b><span style="text-decoration: underline;"><?php echo $form->getObject()->get('quien_paga'); ?></span>
         </div>
         <div class="col-md-6" style="margin-bottom: 0.7rem;">
         <b>BAJO LA FORMA DE PAGO: </b><span style="text-decoration: underline;"><?php echo $recibo_pago->getFormaPago()." (".$recibo_pago->getCoin().")"; ?></span>
         </div>
         <?php if($recibo_pago->getMoneda()==1) { ?>
         <div class="col-md-3" style="margin-bottom: 0.7rem;">
            <b>CANTIDAD EN BS: </b><span style="text-decoration: underline;" class="number"><?php echo number_format(number_float($recibo_pago->getMonto())*number_float($recibo_pago->getTasaCambio()), 2, '.', ' '); ?></span>
         </div>
         <?php } ?>
         <div class="col-md-3" style="margin-bottom: 0.7rem;">
         <b>CANTIDAD EN USD: </b><span style="text-decoration: underline;" class="number"><?php echo number_float($recibo_pago->getMonto()); ?></span>
         </div>
         <div class="col-md-12" style="margin-bottom: 2rem;">
         <b>POR CONCEPTO DE:</b>
         <?php echo htmlspecialchars_decode(stripslashes($form->getObject()->get('descripcion'))) ?>
         </div>
         <div class="col-md-6" style="margin-bottom: 0.7rem;">
         <b>RECIBIDO POR: </b> <span style="text-decoration: underline;"><?php echo $recibo_pago->getCreator() ?></span>
         </div>
         <div class="col-md-6" style="margin-bottom: 0.7rem;">
         <b>FIRMA DEL USUARIO: </b> _____________________
         </div>
         <div class="col-md-6" style="margin-bottom: 0.7rem;">
            <b>FIRMA: </b> _____________________
         </div>
      </div>
   </div>
   <div class="row no-print">
      <div class="col-12" style="margin-top: 5px">
         <a href="#" target="_blank" class="button ver_detalles" onclick="printDiv('invoice')">
            <span><i class="fas fa-print"></i> Imprimir</span>
         </a>
      </div>
   </div>
   <br/><br/>
   <div class="card card-primary" id="sf_fieldset_otros">
      <div class="card-header">
         <h3 class="card-title">Detalles</h3>
      </div>
      <div class="card-body">
         <div class="row">
         <div class="col-12 table-responsive">
            <table class="table table-striped">
               <thead>
               <tr>
                  <th>RECIBO DE PAGO</th>
                  <th>DOCUMENTO</th>
                  <th>FECHA DOC.</th>
                  <th>ESTATUS DOC.</th>
               </tr>
               </thead>
               <tbody>
               <?php
                  $results = Doctrine_Query::create()
                     ->select('rp.id as rpdid, rp.ncontrol as rpncontrol, rp.monto as rpmonto, rp.anulado as rpanulado, rp.created_at,
                     cc.id as ccid, cc.factura_id as ccfid, cc.nota_entrega_id as ccneid, cc.estatus as ccestatus,
                     f.id as fid, f.num_factura as numfact, f.fecha as ffecha,
                     ne.id as neid, ne.ncontrol as necontrol, ne.fecha as neecha,')
                     ->from('ReciboPago rp')
                     ->leftJoin('rp.CuentasCobrar cc')
                     ->leftJoin('cc.Factura f')
                     ->leftJoin('cc.NotaEntrega ne')
                     ->where('rp.cuentas_cobrar_id = ?', $recibo_pago->getCuentasCobrarId())
                     ->orderBy('rp.id DESC')
                     ->execute();
                  $total=0;
                     foreach ($results as $result):
               ?>
               <tr>
                  <td><a href="<?php echo url_for("@recibo_pago")."/".$result["rpdid"]; ?>" class="button ver_detalles"><?php echo $result["rpncontrol"]; ?></a></td>
                  <?php
                     if($result["ccfid"]) {
                     echo "<td style='vertical-align: middle'>FACTURA: <a target='_blank' href='".url_for("factura")."/show?id=".$result["ccfid"]."'>".$result["numfact"]."</a></td>";
                     echo "<td style='vertical-align: middle'>".mb_strtoupper(format_datetime($result["ffecha"], 'D', 'es_ES'))."</a></td>";
                     } else {
                     echo "<td style='vertical-align: middle'>NOTA EN: <a target='_blank' href='".url_for("nota_entrega")."/show?id=".$result["ccneid"]."'>".$result["necontrol"]."</a></td>";
                     echo "<td style='vertical-align: middle'>".mb_strtoupper(format_datetime($result["neecha"], 'D', 'es_ES'))."</a></td>";
                     }
                  ?>
                  <td>
                     <?php
                     if($result["ccestatus"]==1) {
                     echo "<span class='badge bg-info'>PENDIENTE</span>";
                     } else if($result["ccestatus"]==2) {
                     echo "<span class='badge bg-warning'>ABONADO</span>";
                     } else if($result["ccestatus"]==3) {
                     echo "<span class='badge bg-success'>CANCELADO</span>";
                     } else if($result["ccestatus"]==4) {
                     echo "<span class='badge bg-danger'>ANULADO</span>";
                     }
                     ?>
                  </td>

               </tr>
               <?php endforeach; ?>
               </tbody>
            </table>
         </div>
         </div>
      </div>
   </div>
   </div>
</div>


<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
</script>


<?php
function number_float($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return $number;
}
?>
<style>
  .float-right {
     float: right;
  }
</style>
