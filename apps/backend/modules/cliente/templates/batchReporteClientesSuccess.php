<table style="border-spacing: 0px; width: 100%;">
  <thead>
    <tr>
      <td colspan="9" style="text-align: center; text-decoration: underline;">
        <p style="margin-top: 0px !important">
          <b>REPORTE DE CLIENTES</b>
          <b><?php echo date('d/m/Y') ?></b>
        </p>
      </td>
    </tr>
    <tr style="font-size: 11px !important">
      <td class="bbottom"></td>
      <td class="bbottom tleft"><b>EMPRESA</b></td>
      <td colspan="2" class="bbottom tleft"><b>NOMBRE COMPLETO</b></td>
      <td class="bbottom tleft"><b>DOC. DE IDENTIDAD</b></td>
      <td class="bbottom tleft"><b>TELF. PRIMARIO</b></td>
      <td class="bbottom tleft"><b>TELF. CELULAR</b></td>
      <td colspan="2" class="bbottom tleft"><b>CORREO ELECTRONICO</b></td>
      <td class="bbottom tleft"><b>TIPO PRECIO</b></td>
      <td class="bbottom tright"><b>DIAS<br/>CREDITO</b></td>
    </tr>
  </thead>
  <tbody>
    <?php $i=1;
    foreach ($clients as $client) { ?>
      <tr style="font-size: 11px !important" >
        <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
        <td class="bbottom tleft tcaps" ><?php echo mb_strtolower($client["company"]);?></td>
        <td colspan="2" class="bbottom tleft tcaps" ><?php echo mb_strtolower($client->getFullName());?></td>
        <td class="bbottom tleft"><?php echo $client->getDocId(); ?></td>
        <td class="bbottom tleft"><?php echo mb_strtolower($client->getTelf()); ?></td>
        <td class="bbottom tleft"><?php echo mb_strtolower($client->getCelular()); ?></td>
        <td colspan="2" class="bbottom tleft"><?php echo mb_strtolower($client->getEmail());?></td>
        <td class="bbottom tleft tcaps" ><?php echo mb_strtolower($client->getTipoDePrecio());?></td>
        <td class="bbottom tright tcaps" ><?php echo $client->getDiasCredito();?></td>
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
