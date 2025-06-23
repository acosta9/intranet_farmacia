<table style="border-spacing: 0px; width: 100%;">
  <thead>
    <tr>
      <td colspan="16" style="text-align: center; text-decoration: underline;">
        <p style="margin-top: 0px !important">
          <b>REPORTE DE PRODUCTOS</b>
          <b><?php echo date('d/m/Y') ?></b>
        </p>
      </td>
    </tr>
    <tr style="font-size: 10px !important">
      <td class="bbottom"></td>
      <td class="bbottom tleft"><b>CATEGORIA</b></td>
      <td colspan="2" class="bbottom tleft"><b>NOMBRE</b></td>
      <td class="bbottom tleft"><b>SERIAL</b></td>
      <td class="bbottom tleft"><b>PRESENTACION</b></td>
      <td class="bbottom tleft"><b>LAB.</b></td>
      <td class="bbottom tright"><b>COSTO</b></td>
      <td class="bbottom tright"><b>P. (1)</b></td>
      <td class="bbottom tright"><b>P. (2)</b></td>
      <td class="bbottom tright"><b>P. (3)</b></td>
      <td class="bbottom tright"><b>P. (4)</b></td>
      <td class="bbottom tright"><b>P. (5)</b></td>
      <td class="bbottom tright"><b>P. (6)</b></td>
      <td class="bbottom tright"><b>P. (7)</b></td>
      <td class="bbottom tright"><b>P. (8)</b></td>
    </tr>
  </thead>
  <tbody>
    <?php $i=1;
    foreach ($productos as $producto) { ?>
      <tr style="font-size: 11px !important" >
        <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
        <td class="bbottom tleft tcaps" ><?php echo mb_strtolower($producto["pcname"]);?></td>
        <td colspan="2" class="bbottom tleft tcaps" ><?php echo mb_strtolower($producto->getNombre());?></td>
        <td class="bbottom tleft"><?php echo $producto->getSerial(); ?></td>
        <td class="bbottom tleft tcaps"><?php echo mb_strtolower($producto["puname"]); ?></td>
        <td class="bbottom tleft tcaps"><?php echo mb_strtolower($producto["plname"]); ?></td>
        <td class="bbottom tright tcaps" ><?php echo mb_strtolower($producto["costo_usd_1"]);?></td>
        <td class="bbottom tright" ><?php echo mb_strtolower($producto["precio_usd_1"]);?></td>
        <td class="bbottom tright" ><?php echo mb_strtolower($producto["precio_usd_2"]);?></td>
        <td class="bbottom tright" ><?php echo mb_strtolower($producto["precio_usd_3"]);?></td>
        <td class="bbottom tright" ><?php echo mb_strtolower($producto["precio_usd_4"]);?></td>
        <td class="bbottom tright" ><?php echo mb_strtolower($producto["precio_usd_5"]);?></td>
        <td class="bbottom tright" ><?php echo mb_strtolower($producto["precio_usd_6"]);?></td>
        <td class="bbottom tright" ><?php echo mb_strtolower($producto["precio_usd_7"]);?></td>
        <td class="bbottom tright" ><?php echo mb_strtolower($producto["precio_usd_8"]);?></td>
      </tr>
    <?php   } ?>
  </tbody>
</table>

<style>
  .tcaps {
    text-transform: capitalize;
  }
  .clight {
    color: #adadad;
  }
  .ball {
    border: 1px solid #b3b3b38a !important;
  }

  .bright {
    border-right: 1px solid #b3b3b38a !important;
  }

  .bleft {
    border-left: 1px solid #b3b3b38a !important;
  }

  .bbottom {
    border-bottom: 1px solid #b3b3b38a !important;
  }

  .btop {
    border-top: 1px solid #b3b3b38a !important;
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

 <script>
 window.onload = function () {
   var css = '@page { size: 279mm 216mm; margin: 5mm 5mm 5mm 5mm; }',
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
