<?php use_helper('Date') ?>
<style>
body {
  margin: 0px !important;
}
p {
  margin-top: 2px !important;
  margin-bottom: 2px !important;
}
</style>
<?php
  $despacho=Doctrine_Core::getTable('AlmacenTransito')->findOneBy('id',$sf_params->get('id'));
  $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$despacho->getEmpresaId());
  $cliente=Doctrine_Core::getTable('Cliente')->findOneBy('id',$despacho->getClienteId());
  $factura=Doctrine_Core::getTable('Factura')->findOneBy('id',$despacho->getFacturaId());
?>
<?php 
  $hinit="0.2";
  $boxes=$despacho->getBoxes();
  $precinto=$despacho->getPrecinto();
  for($i=1;$i<=$boxes;$i++){
?>
  <div style="max-width: 5cm; height: 3.1cm;" >
    <table style="position: absolute; left: 0.0cm; ?>; width: 5cm; height: 3cm; border-spacing: 0px; font-size: 10px !important;">
      <tr>
        <td><b><?php echo $cliente->getFullName(); ?></b></td>
      </tr>
      <tr>
        <td>Zona: <?php echo $cliente->getZona(); ?> </td>
      </tr>
      <tr>
        <td>N° Factura: <?php echo $factura->getNumFactura(); ?></td>
      </tr>
      <tr>
        <td># Bulto: <?php echo $i."/".$boxes; ?></td>
      </tr>
      <tr>
        <td>
          Fecha: <?php echo mb_strtoupper(format_datetime($despacho->getFechaEmbalaje(), 'd', 'es_ES')); ?>
          Precinto: <?php echo $precinto; $precinto+=1; ?>
        </td>
      </tr>
      <tr>
        <td style="text-align: center"><?php echo $empresa->getNombre(); ?></td>
      </tr>
      <tr>
        <td style="text-align: center"><?php echo $empresa->getRif(); ?></td>
      </tr>
    </table>
  </div>
  <?php } ?>
<script>
  $( document ).ready(function() {
    imprimir();
  });
  function imprimir() {
    var css = '@page { size: 56mm 31mm; margin: 0mm 0mm 0mm 0mm; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);

    window.print();
  }
</script>
<style>
  .tcaps {
    text-transform: capitalize;
  }
  .tpadd {
    padding: 0.1cm;
  }
  .clight {
    color: #adadad;
  }
  .ball {
    border: 1px solid #000 !important;
  }

  .bright {
    border-right: 1px solid #000 !important;
  }

  .bleft {
    border-left: 1px solid #000 !important;
  }

  .bbottom {
    border-bottom: 1px solid #000 !important;
  }

  .btop {
    border-top: 1px solid #000 !important;
  }

  .tleft {
    text-align: left !important;
  }

  .tright {
    text-align: right !important;
  }

  .tcenter {
    text-align: center !important;
  }

  .vcenter {
    vertical-align: middle !important;
  }
</style>

<?php
function number_float($str) {
  $stripped = str_replace(' ', '', $str);
  $number = str_replace(',', '', $stripped);
  return $number;
}
?>
