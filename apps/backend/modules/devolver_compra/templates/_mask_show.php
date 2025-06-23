<?php $proveedor=Doctrine_Core::getTable('Proveedor')->findOneBy('id',$form->getObject()->get('proveedor_id'));?>
<?php $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$form->getObject()->get('empresa_id'));?>
<?php $factura_compra=Doctrine_Core::getTable('FacturaCompra')->findOneBy('id',$form->getObject()->get('factura_compra_id'));?>
</div></div></div>
  <div class="invoice p-3 mb-3" id="invoice" >
    <div class="row">
      <div class="col-6">
        <h4>
          <img src='/images/<?php echo $empresa->getId()?>.png' height="60"/>
        </h4>
      </div>
      <div class="col-md-6"></div>
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
          <strong><?php echo $factura_compra->getRazonSocial(); ?> | <?php echo $factura_compra->getDocId(); ?></strong><br>
          <span class="tcaps"><?php echo mb_strtolower($factura_compra->getDireccion())?></span><br/>
          <b>Telf:</b> <?php echo $factura_compra->getTelf(); ?><br>
        </address> 
      </div>
      <div class="col-sm-4 invoice-col">
        <b class="float-right">Devolución de la Factura: <?php echo $factura_compra->getNumFactura(); ?></b><br>
        <b class="float-right">N° control: <?php echo $factura_compra->getNControl(); ?></b><br>
        <small class="float-right">Emision: <?php echo(date("d/m/Y", strtotime($form->getObject()->get('fecha')))); ?></small><br/>
        <small class="float-right">Tasa: <?php echo "Bs <span class='moneyStr'>".$factura_compra->getTasaCambio(); ?></span></small><br/>
        <small class="float-right">Iva: <?php echo $factura_compra->getIva(); ?>%</small><br/>
        <br/>
      </div>
    </div>
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <tbody>
            <tr>
              
             
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>NUM.</th>
              <th>CANTIDAD</th>
              <th>NOMBRE DEL PRODUCTO</th>
              <th>PRECIO UNITARIO</th>
              <th>PRECIO UNITARIO</th>
              <th>TOTAL</th>
              <th>TOTAL</th>
            
             </tr>
          </thead>
          <tbody>
            <?php $num=0;
            $results = Doctrine_Query::create()
              ->select("FORMAT(REPLACE(dcd.qty, ' ', ''), 0, 'de_DE') as qty, dcd.exento as exento,
              dcd.price_unit as punit, dcd.price_tot as ptot, dcd.price_tot as ptot, i.id as iid, p.nombre as nombre, p.serial as serial")
              ->from('DevolverCompraDet dcd, dcd.Inventario i, i.Producto p')
              ->where('dcd.devolver_compra_id = ?', $form->getObject()->get('id'))
              ->orderBy('dcd.id ASC')
              ->execute();
            $stotal=0; $bi=0;$ivam=0;$total=0;$stotalbs=0;$bibs=0;$ivambs=0;$descPorcentajebs=0;$descPorcentaje=0;
            foreach ($results as $result) {
              $exento="G"; $num++;
              if(str_replace(" ", "_", $result["exento"])=="EXENTO") {
                $exento="E";
              }
              $punitbs=$result["punit"]*$form->getObject()->get('tasa_cambio');
              $totbs=$punitbs*$result["qty"];
            ?>
            <tr>
              <td style="vertical-align: middle" class="number2"><?php echo $num ?></td>
              <td style="vertical-align: middle" class="number2"><?php echo $result["qty"] ?></td>
              <td style="vertical-align: middle">
                <?php echo $result["nombre"]." (".$exento.")" ?><br/>
                <small><b>s/n: <?php echo $result["serial"]; ?></b></small>
              </td>
             
              <td ><?php echo "USD <span class='moneyStr'>".$result["punit"];?></span></td>
              <td ><?php echo "BsS <span class='moneyStr'>".$punitbs;?></span></td>
              <td ><?php echo "USD <span class='moneyStr'>".$result["ptot"];?></span></td>
              <td ><?php echo "BsS <span class='moneyStr'>".$totbs;?></span></td>
          
            </tr>
            <?php 
              $stotal=$stotal+$result["ptot"];
              $stotalbs=$stotalbs+$totbs;
              $iva=$factura_compra->getIva();
              if($iva>0){
                if($exento=="G"){
                  $bi=$bi+$result["ptot"];
                  $bibs=$bibs+$totbs;
                }
              }
             } ?>
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
                  <?php echo "Bs <span class='moneyStr'>".$subtotal=$stotalbs."</span>";?>
                </td>
              </tr>
              <?php 
                $desc=$factura_compra->getDescuento();
                $descPorcentaje=($stotal*$desc)/100;
                $descPorcentajebs=($stotalbs*$desc)/100;
                //$descPorcentaje=$form->getObject()->get('subtotal_desc');
                $classStr="moneyStr";
                if($desc<=0) {
                  $desc="0,0000";
                  $descPorcentaje="0,0000";$descPorcentajebs="0,0000";
                  $classStr="";
                }
                
                $iva_monto=($bi*$iva)/100;$iva_montobs=($bibs*$iva)/100;
                $classStr2="moneyStr";
                if($iva_monto<=0) {
                  $classStr2="";
                  $iva_monto="0,0000";$iva_montobs="0,0000";
                }
                $totalbs=($stotalbs-$descPorcentajebs)+$iva_montobs;
                $total=($stotal-$descPorcentaje)+$iva_monto;
              ?>
              <tr>
                <td style="text-align: right"><b>DESCUENTO</b></td>
                <td style="text-align: right">
                  <?php echo "<span class='".$classStr."'>".$desc."</span>%";?>
                </td>
                <td style="text-align: right">
                  <?php echo "Bs <span class='".$classStr."'>".$descPorcentajebs."</span>";?>
                </td>
              </tr>
              <tr>
                <td style="text-align: right"><b>IVA</b></td>
                <td style="text-align: right">
                  <?php echo "<span class='moneyStr'>".$iva."</span>%";?>
                </td>
                <td style="text-align: right">
                  <?php echo "Bs <span class='".$classStr2."'>".$iva_montobs."</span>";?>
                </td>
              </tr>
              <tr>
                <td style="text-align: right"><b>TOTAL BS</b></td>
                <td></td>
                <td style="text-align: right"><?php echo "Bs <span class='moneyStr'>".$totalbs."</span>";?>
              </tr>
              <tr>
                <td style="text-align: right"><b>TOTAL USD</b></td>
                <td></td>
                <td style="text-align: right"><?php echo "$ <span class='moneyStr'>".$total."</span>";?>
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
   <!--   <button onclick="anular()" class="btn btn-danger float-right" style="margin-right: 5px;">
        <i class="fas fa-minus-circle"></i> Anular
      </button>-->
    </div>
  </div>
  <br/><br/>

 
<div><div><div>

<script src="/plugins/printThis/printThis.js"></script>
<script>
  function printDiv(divName) {
    document.title='devolucion_compra_<?php echo $factura_compra->getNumFactura(); ?>.pdf';
    $("#"+divName).printThis({
      pageTitle: 'devolucion_compra_<?php echo $factura_compra->getNumFactura(); ?>.pdf',
    });
  }
  function anular() {
    var retVal = confirm("¿Estas seguro de anular la factura de compra?");
    if( retVal == true ){
        location.href = "<?php echo url_for("factura_compra")."/anular?id=".$form->getObject()->get('id')?>";
    }else{
     return false;
    }
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
