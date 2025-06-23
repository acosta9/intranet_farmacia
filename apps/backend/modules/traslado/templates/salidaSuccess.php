<?php $traslado=Doctrine_Core::getTable('Traslado')->findOneBy('id',$sf_params->get('id'));?>
<?php $empresa_origen=Doctrine_Core::getTable('Empresa')->findOneBy('id',$traslado->getEmpresaDesde());?>
<?php $empresa_destino=Doctrine_Core::getTable('Empresa')->findOneBy('id',$traslado->getEmpresaHasta());?>
<?php $inv_origen=Doctrine_Core::getTable('InvDeposito')->findOneBy('id',$traslado->getDepositoDesde());?>
<?php $inv_destino=Doctrine_Core::getTable('InvDeposito')->findOneBy('id',$traslado->getDepositoHasta());?>
</div></div></div>
  <div class="invoice p-3 mb-3" id="invoice" <?php if($traslado->getEstatus()==3) { echo 'style="background: #f1daa759 !important;"'; }?>>
    <div class="row">
      <div class="col-6">
        <h4>
          <img src='/images/<?php echo $empresa_origen->getId()?>.png' height="60"/>
        </h4>
      </div>
      <div class="col-md-6">
        <?php if($traslado->getEstatus()==3) { ?>
          <img src='/images/anulado.png' style="float:right"/>
        <?php } ?>
      </div>
    </div>
    <div class="row invoice-info">
      <div class="col-md-6 invoice-col">
        <address>
          <strong><?php echo $empresa_origen->getNombre()?> | <?php echo $empresa_origen->getRif()?></strong><br/>
          <span class="tcaps"><?php echo mb_strtolower($empresa_origen->getDireccion())?></span><br/>
          <b>Telf:</b> <?php echo $empresa_origen->getTelefono()?><br/>
          <b>Email:</b> <?php echo $empresa_origen->getEmail()?>
        </address>
      </div>
      <div class="col-md-6 invoice-col">
        <span class="float-right" style="font-weight: bold">TRASLADO ENTRE ALMACENES N°<?php echo ($traslado->getNcontrol()); ?></b></span><br>
        <span class="float-right">Emitido por: <?php echo $traslado->getCreator(); ?></span><br/>
        <span class="float-right">Fecha de Emisión: <?php echo(date("d/m/Y", strtotime($traslado->getCreatedAt()))); ?></span><br/>
      </div>
    </div>
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <tbody>
            <tr>
              <td style="text-align: center;"><b>DESDE:</b> <?php echo $empresa_origen->getNombre()."<br/>".$inv_origen->getNombre(); ?></td>
              <td  style="text-align: center;"><b>HASTA:</b> <?php echo $empresa_destino->getNombre()."<br/>".$inv_destino->getNombre(); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>CANT.</th>
              <th>SERIAL</th>
              <th>CONCEPTO O DESCRIPCIÓN</th>
              <th style="text-align: right">P. UNITARIO</th>
              <th style="text-align: right">TOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $results = Doctrine_Query::create()
              ->select('td.exento as exento, td.qty as qty, td.price_unit as punit, td.price_tot as ptot, i.id as iid, p.nombre as nombre, p.serial as serial')
              ->from('TrasladoDet td, td.Inventario i, i.Producto p')
              ->where('td.traslado_id = ?', $traslado->getId())
              ->orderBy('td.id ASC')
              ->execute();
            $total=0; $j=0;
              foreach ($results as $result) {
                $j++;
                $total+=number_float($result["ptot"]);
                $exento="G";
                if(str_replace(" ", "_", $result["exento"])=="EXENTO") {
                  $exento="E";
                }
            ?>
            <tr>
              <td style="vertical-align: middle" class="number2"><?php echo $result["qty"] ?></td>
              <td style="vertical-align: middle"><?php echo $result["serial"] ?></td>
              <td style="vertical-align: middle"><?php echo $result["nombre"].$result["ofname"]." (".$exento.")" ?></td>
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
                <td style="text-align: right"><b>CANTIDAD DE LINEAS</b></td>
                <td></td>
                <td></td>
                <td style="text-align: right">
                  <?php echo number_format($subtotal=number_float($j), 0, '.', ' ');?>
                </td>
              </tr>
              <tr>
                <td style="text-align: right"><b>MONTO TOTAL</b></td>
                <td></td>
                <td></td>
                <td style="text-align: right"><?php echo "USD ".number_format(number_float($traslado->getMonto()), 2, '.', ' ');?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row no-print">
    <div class="col-12">
      <a href="#" target="_blank" class="btn btn-default" onclick="printDiv('invoice')">
        <i class="fas fa-print"></i> Imprimir
      </a>
      <a href="<?php echo url_for("@traslado")."/print?id=".$traslado->getId()?>" target="_blank" class="btn btn-info" >
        <i class="fas fa-stamp"></i> Forma Libre
      </a>
      <?php
        $results = Doctrine_Query::create()
          ->select('sc.id as scid, e.id as eid')
          ->from('ServerConf sc, sc.Empresa e')
          ->where('sc.empresa_id=?', $traslado->getEmpresaHasta())
          ->orderBy('sc.id ASC')
          ->execute();
        $i=0;
        foreach ($results as $result) {
          $i++;
        }
        if($i>0) {
          if($traslado->getEstatus()==2) { ?>
            <a href="<?php echo url_for("@traslado")."/".$traslado->getId()."/procesar"; ?>" class="btn btn-success" style="margin-right: 5px;">
              <i class="fas fa-dolly-flatbed"></i> Ver detalles
            </a>
          <?php } else {
          ?>
            <a href="<?php echo url_for("@traslado")."/".$traslado->getId()."/edit"; ?>" class="btn btn-success" style="margin-right: 5px;">
              <i class="fas fa-dolly-flatbed"></i> Procesar
            </a>
        <?php
          }
        }
      ?>
      <button onclick="anular()" class="btn btn-danger float-right" style="margin-right: 5px;">
        <i class="fas fa-minus-circle"></i> Anular
      </button>
    </div>
  </div>
<br/><br/>
<div class="card card-primary" id="sf_fieldset_otros">
  <div class="card-header">
    <h3 class="card-title">Historial del traslado</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <main>
          <div class="main-timeline4">
              <div class="timeline">
                  <span class="timeline-icon"></span>
                  <span class="year"><?php echo(date("d/m/Y H:m", strtotime($traslado->getCreatedAt()))); ?></span>
                  <div class="timeline-content">
                      <h3 class="title">Registro de traslado (EGRESO)</h3>
                      <p class="description">
                        El registro de egreso de inventario se inicia en <br/><b style="font-size: 15px;">(1) <?php echo $empresa_origen->getNombre();?></b><br/>
                        procedente de <b style="font-size: 15px; text-decoration: underline;"><?php echo $inv_origen->getNombre(); ?></b><br/>
                        ha <b style="font-size: 15px;">(2) <?php echo $empresa_destino->getNombre(); ?><br/>
                          <span style="text-decoration: underline;"><?php echo $inv_destino->getNombre(); ?></b>
                      </p>
                  </div>
              </div>
              <div class="timeline">
                  <span class="timeline-icon"></span>
                  <span class="year"><?php echo(date("d/m/Y H:m", strtotime($traslado->getCreatedAt()))); ?></span>
                  <div class="timeline-content">
                      <h3 class="title">Egreso del inventario</h3>
                      <p class="description">
                        Se realiza el egreso del inventario de los items previamente nombrados de la empresa<br/><b style="font-size: 15px;"><?php echo $empresa_origen->getNombre();?></b><br/>
                        procedente de <b style="font-size: 15px;"><?php echo $inv_origen->getNombre(); ?></b><br/>
                      </p>
                  </div>
              </div>
              <?php if($traslado->getEstatus()==1): ?>
                <div class="timeline">
                    <span class="timeline-icon"></span>
                    <span class="year" style="background: #88948e;"><?php echo(date("d/m/Y H:m", strtotime($traslado->getUpdatedAt()))); ?></span>
                    <div class="timeline-content">
                        <h3 class="title">Registro de traslado (PENDIENTE)</h3>
                        <p class="description">
                          El registro de traslado esta pendiente para darle ingreso a los productos en el almacen destino
                        </p>
                    </div>
                </div>
              <?php endif; ?>
              <?php if($traslado->getEstatus()==2): ?>
                <div class="timeline">
                    <span class="timeline-icon"></span>
                    <span class="year"><?php echo(date("d/m/Y H:m", strtotime($traslado->getUpdatedAt()))); ?></span>
                    <div class="timeline-content">
                        <h3 class="title">Registro de traslado (INGRESO)</h3>
                        <p class="description">
                          Se da ingreso de los productos al<br/>
                          <b style="font-size: 15px; text-decoration: underline;"><?php echo $inv_destino->getNombre(); ?></b><br/>
                          de la empresa <b style="font-size: 15px;"><?php echo $empresa_destino->getNombre();?></b>
                        </p>
                    </div>
                </div>
              <?php endif; ?>
              <?php if($traslado->getEstatus()==3): ?>
                <div class="timeline">
                    <span class="timeline-icon"></span>
                    <span class="year" style="background: #bd1424;"><?php echo(date("d/m/Y H:m", strtotime($traslado->getUpdatedAt()))); ?></span>
                    <div class="timeline-content">
                        <h3 class="title">Registro de traslado (ANULADO)</h3>
                        <p class="description">
                          Se anulo el proceso de traslado de inventario y se regreso a existencia al almacen correspondiente los productos señalados en este traslado
                        </p>
                    </div>
                </div>
              <?php endif; ?>
          </div>
        </main>
      </div>
    </div>
  </div>
</div>
<div><div><div>
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
  function anular() {
    var retVal = confirm("¿Estas seguro de anular el traslado?");
    if( retVal == true ){
      location.href = "<?php echo url_for("traslado")."/anular?id=".$traslado->getId()?>";
    }else {
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
      border-color: #f39c12
  }

  .main-timeline4 .timeline:nth-child(2n) .year:before {
      border-top-color: #f39c12ad
  }

  <?php if($traslado->getEstatus()==1){ ?>
    .main-timeline4 .timeline:nth-child(3n) .year:before {
      border-top-color: #88948eba !important;
    }
    .main-timeline4 .timeline:nth-child(3n) .timeline-icon {
        border-color: #88948e;
    }
  <?php } else if($traslado->getEstatus()==3){ ?>
    .main-timeline4 .timeline:nth-child(3n) .year:before {
      border-top-color: #da1225ba !important;
    }
    .main-timeline4 .timeline:nth-child(3n) .timeline-icon {
        border-color: #bd1424;
    }
  <?php } else { ?>
    .main-timeline4 .timeline:nth-child(3n) .year:before {
      border-top-color: #008d4cba;
    }
    .main-timeline4 .timeline:nth-child(3n) .timeline-icon {
        border-color: #008d4c;
    }
  <?php } ?>


  .main-timeline4 .timeline:nth-child(3n) .year {
      background: #008d4c
  }

  .main-timeline4 .timeline:nth-child(4n) .timeline-icon {
      border-color: #f98d9c
  }

  .main-timeline4 .timeline:nth-child(4n) .year {
      background: #f98d9c
  }

  .main-timeline4 .timeline:nth-child(4n) .year:before {
      border-top-color: #f2aab3
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
