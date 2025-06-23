<div class="col-md-3">
  <div class="form-group">
    <label>CODIGO</label>
    <input type="text" value="<?php echo $form->getObject()->get('id') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>NOMBRE</label>
    <input type="text" value="<?php echo $form->getObject()->get('nombre') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>ACRONIMO</label>
    <input type="text" value="<?php echo $form->getObject()->get('acronimo') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>TIPO</label>
    <input type="text" value="<?php echo $form->getObject()->get('TipoEmpresa') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-3">
  <div class="form-group">
    <label>RIF</label>
    <input type="text" value="<?php echo $form->getObject()->get('rif') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label>EMAIL</label>
    <input type="text" value="<?php echo $form->getObject()->get('email') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-2">
  <div class="form-group">
    <label>TELEFONO</label>
    <input type="text" value="<?php echo $form->getObject()->get('telefono') ?>" class="form-control" readonly="">
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>DIRECCION</label>
    <textarea class="form-control" readonly=""><?php echo $form->getObject()->get('direccion') ?></textarea>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label>DESCRIPCION</label>
    <textarea class="form-control" readonly=""><?php echo $form->getObject()->get('descripcion') ?></textarea>
  </div>
</div>
</div></div></div></div>
<?php use_helper('Date') ?>
<div class="card card-primary" id="sf_fieldset_detalles">
  <div class="card-header">
    <h3 class="card-title">Fecha de Vencimiento de permisos</h3>
  </div>
  <div class="card-body">
    <div class="row">
    <div class="col-md-3">
        <div class="form-group">
          <label>TIPO TASA DE CAMBIO</label>
          <input type="text" value="<?php echo $empresa->getTipoTasa() ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>IVA (%)</label>
          <input type="text" value="<?php echo $form->getObject()->get('iva') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-6"></div>
      <div class="col-md-3">
        <div class="form-group">
          <label>COD COORPOTULIPA</label>
          <input type="text" value="<?php echo $form->getObject()->get('cod_coorpotulipa') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° CONTROL</label>
          <input type="text" value="<?php echo $form->getObject()->get('ncontrol') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° FACTURA</label>
          <input type="text" value="<?php echo $form->getObject()->get('nfactura') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3"></div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° DE NOTA DESPACHO (%)</label>
          <input type="text" value="<?php echo $form->getObject()->get('ndespacho') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° DE NOTA ENTREGA</label>
          <input type="text" value="<?php echo $form->getObject()->get('nentrega') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° DE RECIBO PAGO</label>
          <input type="text" value="<?php echo $form->getObject()->get('npago') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° NOTA DE CREDITO</label>
          <input type="text" value="<?php echo $form->getObject()->get('ncredito') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° TRASLADO</label>
          <input type="text" value="<?php echo $form->getObject()->get('ntraslado') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° ORDEN DE VENTA</label>
          <input type="text" value="<?php echo $form->getObject()->get('ncompra') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° FACTURA DE COMPRA</label>
          <input type="text" value="<?php echo $form->getObject()->get('factcompra') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° FACTURA DE GASTO</label>
          <input type="text" value="<?php echo $form->getObject()->get('factgasto') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° ORDEN DE COMPRA</label>
          <input type="text" value="<?php echo $form->getObject()->get('ordencompra') ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>N° COTIZACION DE COMPRA</label>
          <input type="text" value="<?php echo $form->getObject()->get('coticompra') ?>" class="form-control" readonly="">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card card-primary" id="sf_fieldset_detalles">
  <div class="card-header">
    <h3 class="card-title">Fecha de Vencimiento de permisos</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label>REGISTRO DE COMERCIO</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('venc_registro_comercio'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>RIF</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('venc_rif'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>BOMBEROS</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('venc_bomberos'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>LICENCIA DE FUNCIONAMIENTO</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('venc_lic_funcionamiento'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>USO CONFORME</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('venc_uso_conforme'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>PERMISO SANITARIO</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('venc_permiso_sanitario'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>PERMISO INSTALACION Y FUNCIONAMIENTO</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('venc_permiso_instalacion'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>DESTINADO Y AFINES</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('venc_destinado_afines'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>DESTINADOS Y ABASTOS</label>
          <input type="text" value="<?php echo strtoupper(format_datetime($form->getObject()->get('venc_destinado_abastos'), 'D', 'es_ES')) ?>" class="form-control" readonly="">
        </div>
      </div>
    </div>
  </div>
</div>
<div><div><div><div>
