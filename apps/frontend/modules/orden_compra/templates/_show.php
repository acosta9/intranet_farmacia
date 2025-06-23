<style>
   .website-wrapper {
      background-color: #f3f3f3 !important;
   }
</style>
<div class="main-page-wrapper" style='background-color: #f3f3f3; font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"; font-size: 0.9rem; font-weight: 400; line-height: 1.5; color: #212529; text-align: left;'>
   <div class="page-title page-title-default title-size-default title-design-centered color-scheme-light" style="#background-color: #4c2d95">
		<div class="container">
			<header class="entry-header">
				<h1 class="entry-title">ORDENES DE COMPRA</h1>
				<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
					<a href="<?php echo url_for("@inicio"); ?>" rel="v:url" property="v:title">Inicio</a> » 
               <a href="<?php echo url_for("@orden_compra"); ?>" rel="v:url" property="v:title">Ordenes de compra</a> » 
               <span class="current">Orden #<?php echo $orden_compra->getId(); ?></span>
				</div>
			</header>
		</div>
	</div>
   <div class="container" id="invoice">
      <?php $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$form->getObject()->get('cliente_id'));?>
      <?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
      <div class="invoice p-3 mb-3" id="invoice" <?php if($form->getObject()->get('orden_compra_estatus_id')==3) { echo 'style="background: #f1daa759 !important; padding: 1rem"'; } else { echo 'style="background: #fff !important; padding: 1rem"'; }?>>
         <div class="row">
            <div class="col-6">
               <h4>
               <img src='/images/<?php echo $empresa->getId()?>.png' style="height: 60px"/>
               </h4>
            </div>
            <div class="col-md-6">
               <?php if($form->getObject()->get('orden_compra_estatus_id')==3) { ?>
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
               <small class="float-right">Emision: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('created_at')))); ?></small><br/>
               <b class="float-right">N° Control: <?php echo ($form->getObject()->get('id')); ?></b><br>
            </div>
         </div>
         <div class="row">
            <div class="col-12 table-responsive">
               <table class="table table-striped">
               <thead>
                  <tr>
                     <th>CANT.</th>
                     <th>CONCEPTO O DESCRIPCIÓN</th>
                     <th style="text-align: right">P. UNITARIO</th>
                     <th style="text-align: right">TOTAL</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $results = Doctrine_Query::create()
                     ->select('ocd.qty as qty, ocd.price_unit as punit, ocd.price_tot as ptot, 
                     i.id as iid, p.nombre as nombre, p.serial as serial, ofer.id as oferid, ofer.nombre as ofname, ofer.ncontrol as ofserial')
                     ->from('OrdenCompraDet ocd, ocd.Inventario i, i.Producto p, ocd.Oferta ofer')
                     ->where('ocd.orden_compra_id = ?', $form->getObject()->get('id'))
                     ->orderBy('ocd.id ASC')
                     ->execute();
                  $total=0;
                     foreach ($results as $result) {
                     $items = explode(';', $result["descripcion"]);
                     $total+=number_float($result["ptot"]);
                  ?>
                  <tr>
                     <td style="vertical-align: middle" class="number2"><?php echo $result["qty"] ?></td>
                     <td style="vertical-align: middle">
                     <?php echo $result["nombre"].$result["ofname"] ?><br/>
                     <small><b>s/n: <?php echo $result["serial"].$result["ofserial"]; ?></b></small>
                     </td>
                     <td style="vertical-align: middle; text-align: right"><?php echo "USD ".number_format(number_float($result["punit"]), 2, '.', ' ');?></td>
                     <td style="vertical-align: middle; text-align: right"><?php echo "USD ".number_format(number_float($result["ptot"]), 2, '.', ' ');?></td>
                  </tr>
                  <?php } ?>
               </tbody>
               </table>
            </div>
         </div>
         <div class="row">
            <div class="col-6"></div>
            <div class="col-6">
               <div class="table-responsive">
               <table class="table">
                  <tbody>
                     <tr>
                     <td style="text-align: right"><b>SUB-TOTAL</b></td>
                     <td></td>
                     <td></td>
                     <td style="text-align: right">
                        <?php echo "USD ".number_format(number_float($form->getObject()->get('total')), 2, '.', ' ');?>
                     </td>
                     </tr>
                  </tbody>
               </table>
               </div>
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
               <h3 class="card-title">Estatus</h3>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-12 table-responsive">
                  <table class="table table-striped">
                     <thead>
                        <tr>
                        <th>FACTURA</th>
                        <th>TOTAL</th>
                        <th>MONTO RESTANTE POR PAGAR</th>
                        <th>MONTO PAGADO</th>
                        <th>ESTATUS</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        if($fact=Doctrine_Core::getTable('Factura')->findOneBy('orden_compra_id', $form->getObject()->get('id'))):
                           $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('factura_id', $fact->getId());
                        ?>
                        <tr>
                           <td style="vertical-align: middle">
                              <?php
                              if($fact) {
                              echo "<a href='".url_for("factura")."/show?id=".$fact->getId()."' target='_blank'>".$fact->getNumFactura()."</a>";
                              } else {
                              echo "<i class='fas fa-minus-circle'></i>";
                              }?>
                           </td>
                           <td style="vertical-align: middle"><?php echo "USD ".$cuentas_cobrar->getTotal(); ?></td>
                           <td style="vertical-align: middle"><?php echo "USD ".$cuentas_cobrar->getMontoFaltante(); ?></td>
                           <td style="vertical-align: middle"><?php echo "USD ".$cuentas_cobrar->getMontoPagado(); ?></td>
                           <td>
                           <?php
                           if($cuentas_cobrar->getEstatus()==1) {
                              echo "<span class='badge bg-info'>PENDIENTE</span>";
                           } else if($cuentas_cobrar->getEstatus()==2) {
                              echo "<span class='badge bg-warning'>ABONADO</span>";
                           } else if($cuentas_cobrar->getEstatus()==3) {
                              echo "<span class='badge bg-success'>CANCELADO</span>";
                           } else if($cuentas_cobrar->getEstatus()==4) {
                              echo "<span class='badge bg-danger'>ANULADO</span>";
                           }
                           ?>
                           </td>
                        </tr>
                        <?php endif; ?>
                     </tbody>
                  </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
   function number_float($str) {
   $stripped = str_replace(' ', '', $str);
   $number = str_replace(',', '', $stripped);
   return floatval($number);
   }
?>
<script>
  function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  }
</script>
<style>
  .float-right {
     float: right;
  }
</style>