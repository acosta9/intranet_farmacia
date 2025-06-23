<?php $cliente=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$form->getObject()->get('proveedor_id'));?>
<?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
</div></div></div>
  <div class="invoice p-3 mb-3" id="invoice" <?php if($form->getObject()->get('estatus')==5) { echo 'style="background: #f1daa759 !important;"'; }?>>
    <div class="row">
      <div class="col-6">
        <h4>
          <img src='/images/<?php echo $empresa->getId()?>.png' height="60"/>
        </h4>
      </div>
      <div class="col-md-6">
        <?php if($form->getObject()->get('estatus')==5) { ?>
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
          <strong><?php echo $form->getObject()->get('razon_social'); ?> | <?php echo $form->getObject()->get('doc_id'); ?></strong><br>
          <span class="tcaps"><?php echo mb_strtolower($form->getObject()->get('direccion'))?></span><br/>
          <b>Telf:</b> <?php echo $form->getObject()->get('telf'); ?><br>
        </address>
      </div>
      <div class="col-sm-4 invoice-col">
        <b class="float-right">COTIZACION DE COMPRA: #<?php echo ($form->getObject()->get('ncontrol')); ?></b><br>
        <small class="float-right">Emision: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('created_at')))); ?></small><br/>
        <small class="float-right">Dias de Credito: <?php echo $cotizacion_compra->getDiasCredito(); ?></small><br/>
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
              ->select("ccd.id as ccdid, FORMAT(REPLACE(ccd.qty, ' ', ''), 0, 'de_DE') as qty, FORMAT(REPLACE(ccd.price_unit, ' ', ''), 4, 'de_DE') as punit,
              FORMAT(REPLACE(ccd.price_tot, ' ', ''), 4, 'de_DE') as ptot,
              p.nombre as nombre, p.serial as serial")
              ->from('CotizacionCompraDet ccd')
              ->leftJoin('ccd.Producto p')
              ->where('ccd.cotizacion_compra_id = ?', $form->getObject()->get('id'))
              ->orderBy('ccd.id ASC')
              ->execute();
            $total=0;
            foreach ($results as $result) {
            ?>
            <tr>
              <td style="vertical-align: middle"><?php echo $result["qty"] ?></td>
              <td style="vertical-align: middle">
                <?php echo $result["nombre"] ?><br/>
                <small><b>s/n: <?php echo $result["serial"]; ?></b></small>
              </td>
              <td style="vertical-align: middle; text-align: right"><?php echo "$".$result["punit"];?></span></td>
              <td style="vertical-align: middle; text-align: right"><?php echo "$".$result["ptot"];?></span></td>
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
                <td style="text-align: right">
                  <?php echo "$<span class='moneyStr'>".$subtotal=$form->getObject()->get('subtotal')."</span>";?>
                </td>
              </tr>
              <tr>
                <?php 
                  $desc=$form->getObject()->get('descuento');
                  $descPorcentaje=(($desc*$subtotal)/100);
                  $classStr="moneyStr";
                  if($desc<=0) {
                    $desc="0.0000";
                    $descPorcentaje="0.0000";
                    $classStr="";
                  }
                ?>
                <td style="text-align: right"><b>DESCUENTO</b></td>
                <td style="text-align: right">
                  <?php echo "%<span class='".$classStr."'>".$desc."</span>";?>
                </td>
                <td style="text-align: right">
                  <?php echo "$<span class='".$classStr."'>".$descPorcentaje."</span>";?>
                </td>
              </tr>
              <tr>
                <td style="text-align: right"><b>TOTAL</b></td>
                <td></td>
                <td style="text-align: right"><?php echo "$<span class='moneyStr'>".$form->getObject()->get('total')."</span>";?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row no-print">
    <div class="col-12">
      <a href="#" class="btn btn-default" onclick="printDiv('invoice')">
        <i class="fas fa-print"></i> Imprimir
      </a>
      <?php if($form->getObject()->get('estatus')!=5): ?>
        <?php if($form->getObject()->get('estatus')==1): ?>
          <a href="<?php echo url_for("@ordenes_compra")."/new?cc=1&id=".$form->getObject()->get('id')?>" class="btn btn-warning" >
            <i class="fas fa-file-invoice"></i> Convertir a OC
          </a>
        <?php endif; ?>
        <button onclick="anular()" class="btn btn-danger float-right" style="margin-right: 5px;">
          <i class="fas fa-minus-circle"></i> Anular
        </button>
      <?php endif; ?>
    </div>
  </div>
  <br/><br/>

<div><div><div>

<script src="/plugins/printThis/printThis.js"></script>

<script>
  function printDiv(divName) {
    document.title='cotizacion_compra_<?php echo $form->getObject()->get('ncontrol'); ?>.pdf';
    $("#"+divName).printThis({
      pageTitle: 'cotizacion_compra_<?php echo $form->getObject()->get('ncontrol'); ?>.pdf',
    });
  }
  function anular() {
    var retVal = confirm("¿Estas seguro de anular la cotizacion de compra?");
    if( retVal == true ){
        location.href = "<?php echo url_for("cotizacion_compra")."/anular?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
  }
</script>

<style>
  .timeline:before {
    content: none !important;
  }

  .main-timeline4 {
      overflow: hidden;
      position: relative
  }

  .main-timeline4:after,
  .main-timeline4:before {
      content: "";
      display: block;
      width: 100%;
      clear: both
  }

  .main-timeline4:before {
      content: "";
      width: 3px;
      height: 100%;
      background: #d6d5d5;
      position: absolute;
      top: 30px;
      left: 50%
  }

  .main-timeline4 .timeline {
      width: 50%;
      float: left;
      padding-right: 30px;
      position: relative
  }

  .main-timeline4 .timeline-icon {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: #fff;
      border: 3px solid #00acd6;
      position: absolute;
      top: 5.5%;
      right: -17.5px
  }

  .main-timeline4 .year {
      display: block;
      padding: 10px;
      margin: 0;
      font-size: 30px;
      color: #fff;
      border-radius: 0 50px 50px 0;
      background: #00acd6;
      text-align: center;
      position: relative
  }

  .main-timeline4 .year:before {
      content: "";
      border-top: 35px solid #00acd6ad;
      border-left: 35px solid transparent;
      position: absolute;
      bottom: -35px;
      left: 0
  }

  .main-timeline4 .timeline-content {
      padding: 30px 20px;
      margin: 0 45px 0 35px;
      background: #f2f2f2
  }

  .main-timeline4 .title {
      font-size: 19px;
      font-weight: 700;
      color: #504f54;
      margin: 0 0 10px
  }

  .main-timeline4 .description {
      font-size: 14px;
      color: #7d7b7b;
      margin: 0
  }

  .main-timeline4 .timeline:nth-child(2n) {
      padding: 0 0 0 30px
  }

  .main-timeline4 .timeline:nth-child(2n) .timeline-icon {
      right: auto;
      left: -14.5px
  }

  .main-timeline4 .timeline:nth-child(2n) .year {
      border-radius: 50px 0 0 50px;
      background: #f39c12
  }

  .main-timeline4 .timeline:nth-child(2n) .year:before {
      border-left: none;
      border-right: 35px solid transparent;
      left: auto;
      right: 0
  }

  .main-timeline4 .timeline:nth-child(2n) .timeline-content {
      text-align: right;
      margin: 0 35px 0 45px
  }

  .main-timeline4 .timeline:nth-child(2) {
      margin-top: 170px
  }

  .main-timeline4 .timeline:nth-child(odd) {
      margin: -175px 0 0
  }

  .main-timeline4 .timeline:nth-child(even) {
      margin-bottom: 80px
  }

  .main-timeline4 .timeline:first-child,
  .main-timeline4 .timeline:last-child:nth-child(even) {
      margin: 0
  }

  .main-timeline4 .timeline:nth-child(2n) .timeline-icon {
      border-color: #88948e;
  }

  .main-timeline4 .timeline:nth-child(2n) .year:before {
      border-top-color: #88948ead;
  }

  .main-timeline4 .timeline:nth-child(3n) .timeline-icon {
      border-color: #f39c12;
  }

  .main-timeline4 .timeline:nth-child(3n) .year:before {
      border-top-color: #f39c12ad;
  }

  @media only screen and (max-width:767px) {
      .main-timeline4 {
          overflow: visible
      }
      .main-timeline4:before {
          top: 0;
          left: 0
      }
      .main-timeline4 .timeline:nth-child(2),
      .main-timeline4 .timeline:nth-child(even),
      .main-timeline4 .timeline:nth-child(odd) {
          margin: 0
      }
      .main-timeline4 .timeline {
          width: 100%;
          float: none;
          padding: 0 0 0 30px;
          margin-bottom: 20px!important
      }
      .main-timeline4 .timeline:last-child {
          margin: 0!important
      }
      .main-timeline4 .timeline-icon {
          right: auto;
          left: -14.5px
      }
      .main-timeline4 .year {
          border-radius: 50px 0 0 50px
      }
      .main-timeline4 .year:before {
          border-left: none;
          border-right: 35px solid transparent;
          left: auto;
          right: 0
      }
      .main-timeline4 .timeline-content {
          margin: 0 35px 0 45px
      }
  }
</style>
