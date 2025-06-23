<table style="border-spacing: 0px; width: 100%;">
  <thead>
    <tr>
      <td colspan="3">
        <img src="/images/logo_full.png">
      </td>
      <td colspan="4">
        <address style="text-align: right; font-size: 10px">
          <strong>BESSER SOLUTIONS C.A | RIF: J-40069750-6</strong><br>
          Cll San Miguel Edif. Asdrubal Jose, Piso PB, Ofic. Planta Baj,  Urb. Santa Irene, Punto Fijo, Falcón<br>
          Telf: (0269) 247.67.15 / (0412) 658.01.02<br>
          Email: administracion@bessersolutions.com
        </address>
      </td>
    </tr>
    <tr>
      <td colspan="7" style="text-align: center; text-decoration: underline;">
        <b>REPORTE DE INGRESOS</b> CORRESPONDIENTE AL
        <b><?php echo date('d/m/Y') ?></b><br/><br/>
      </td>
    </tr>
    <tr style="font-size: 11px !important;">
      <td class="bbottom tleft"></td>
      <td class="bbottom tleft"><b>FECHA</b></td>
      <td class="bbottom tleft"><b>CLIENTE</b></td>
      <td class="bbottom tleft"><b>RIF</b></td>
      <td class="bbottom tright"><b>BOLIVARES</b></td>
      <td class="bbottom tright"><b>DOLARES</b></td>
      <td class="bbottom tright"><b>N° VOUCHER</b></td>
      <td class="bbottom tright"><b>FORMA DE PAGO</b></td>
    </tr>
  </thead>
  <tbody>
    <?php
      $i=1;
      foreach ($recibo_pagos as $recibo):
        $anulado=""; $anulado_inner="<span class='anulado' style='display: none'>0</span>";
        if($recibo->getAnulado()==1) {
          $anulado="text-decoration: line-through;";
          $anulado_inner="<span class='anulado' style='display: none'>1</span>";
        }
    ?>
      <tr style="font-size: 11px !important; <?php echo $anulado; ?> ">
        <td class="bbottom tright clight" style="padding-right: 10px;"><?php echo $i; $i++?><?php echo $anulado_inner; ?></td>
        <td class="bbottom tleft"><?php echo date('d/m/Y',strtotime($recibo->getFecha())); ?></td>
        <td class="bbottom tcaps"><?php echo mb_strtolower($recibo["full_name"]); ?></td>
        <td class="bbottom tleft">
          <?php echo $recibo["doc_id"]; ?>
          <span class="moneda" style="display:none"><?php echo $recibo->getMoneda()?></span>
          <span class="all_monto" style="display: none"><?php echo number_format($recibo->getMonto2(), 2, '.', ',');?></span>
        </td>
        <?php if($recibo->getMoneda()==0) { ?>
          <td class="bbottom val_bs tright">
            <?php echo number_format($recibo->getMonto(), 2, '.', ',');?>
          </td>
          <td class="bbottom val_usd tright">0</td>
        <?php } else { ?>
          <td class="bbottom val_bs tright">0</td>
          <td class="bbottom val_usd tright">
            <?php echo number_format($recibo->getMonto2(), 2, '.', ',');?>
          </td>
        <?php } ?>
        <td class="bbottom tright tcaps"><?php echo mb_strtolower($recibo["num_recibo"]); ?></td>
        <td class="bbottom tright tcaps">
          <span class="forma_pago" style="display:none"><?php echo $recibo->getFormaPago();?></span>
          <?php echo mb_strtolower($recibo->getFormaDePago());?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<br/><br/>
<table style="border-spacing: 0px; width: 100%;">
  <tbody>
    <tr style="font-size: 11px !important;">
      <td colspan="2" class="bbottom"></td>
      <td colspan="4" class="btop bleft bbottom tcenter"><b>TRANSFERENCIA BS</b></td>
      <td colspan="4" class="btop bleft bbottom tcenter"><b>TRANSFERENCIA USD</b></td>
      <td colspan="4" class="btop bleft bbottom bright tcenter"><b>EFECTIVO</b></td>
    </tr>
    <tr style="font-size: 11px !important;">
      <td colspan="2" class="bbottom bleft tcenter vcenter"><b>TOTALES</b></td>
      <td class="bbottom bleft"><b>PAGO MOVIL</b></td>
      <td class="bbottom bleft"><b>PUNTO DE VENTA</b></td>
      <td class="bbottom bleft"><b>BANESCO</b></td>
      <td class="bbottom bleft"><b>BOD</b></td>
      <td class="bbottom bleft"><b>BOFA</b></td>
      <td class="bbottom bleft"><b>ZELLE</b></td>
      <td class="bbottom bleft"><b>BNC</b></td>
      <td class="bbottom bleft"><b>AIRTM</b></td>
      <td class="bbottom bleft"><b>BOLIVARES</b></td>
      <td class="bbottom bleft bright"><b>DOLARES</b></td>
    </tr>
    <tr style="font-size: 11px !important;">
      <td class="bbottom bleft">BS</td>
      <td class="bbottom bleft" id="total_bs"></td>
      <td class="bbottom bleft" id="forma8_bs"></td>
      <td class="bbottom bleft" id="forma9_bs"></td>
      <td class="bbottom bleft" id="forma2_bs"></td>
      <td class="bbottom bleft" id="forma7_bs"></td>
      <td class="bbottom bleft" id="forma3_bs"></td>
      <td class="bbottom bleft" id="forma5_bs"></td>
      <td class="bbottom bleft" id="forma4_bs"></td>
      <td class="bbottom bleft" id="forma6_bs"></td>
      <td class="bbottom bleft" id="forma0_bs"></td>
      <td class="bbottom bleft bright" id="forma1_bs"></td>
    </tr>
    <tr style="font-size: 11px !important;">
      <td class="bbottom bleft">USD</td>
      <td class="bbottom bleft" id="total_usd"></td>
      <td class="bbottom bleft" id="forma8_usd"></td>
      <td class="bbottom bleft" id="forma9_usd"></td>
      <td class="bbottom bleft" id="forma2_usd"></td>
      <td class="bbottom bleft" id="forma7_usd"></td>
      <td class="bbottom bleft" id="forma3_usd"></td>
      <td class="bbottom bleft" id="forma5_usd"></td>
      <td class="bbottom bleft" id="forma4_usd"></td>
      <td class="bbottom bleft" id="forma6_usd"></td>
      <td class="bbottom bleft" id="forma0_usd"></td>
      <td class="bbottom bleft bright" id="forma1_usd"></td>
    </tr>
    <tr style="font-size: 11px !important;">
      <td class="bbottom bleft"><b>TOT</b></td>
      <td class="bbottom bleft bright"><b id="total_all"></b></td>
      <td colspan="10"></td>
    </tr>
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
  $( document ).ready(function() {
    var val_bs=0, val_usd=0, val_all=0;
    $('.all_monto').each(function(){
      var anulado = parseFloat($(this).parent().parent().find(".anulado").html());
      if(anulado==0) {
        val_all+=parseFloat($(this).html().replace(/,/g, ""));
      } else {
        val_all+=0;
      }
    });
    $('.val_bs').each(function(){
      var anulado = parseFloat($(this).parent().find(".anulado").html());
      if(anulado==0) {
        val_bs+=parseFloat($(this).html().replace(/,/g, ""));
      } else {
        val_bs+=0;
      }
    });
    $('.val_usd').each(function(){
      var anulado = parseFloat($(this).parent().find(".anulado").html());
      if(anulado==0) {
        val_usd+=parseFloat($(this).html().replace(/,/g, ""));
      } else {
        val_usd+=0;
      }
    });
    $("#total_bs").text($.number(val_bs,2));
    $("#total_usd").text($.number(val_usd,2));
    $("#total_all").text($.number(val_all,2));

    var forma_pago=0, forma0_bs=0,forma0_usd=0,forma1_bs=0,forma1_usd=0,forma2_bs=0,forma2_usd=0;
    var forma3_bs=0,forma3_usd=0,forma4_bs=0,forma4_usd=0,forma5_bs=0, forma5_usd=0, forma6_bs=0;
    var forma6_usd=0, forma7_bs=0, forma7_usd=0, forma8_bs=0, forma8_usd=0, forma9_bs=0, forma9_usd=0;
    $('.forma_pago').each(function(){
      forma_pago=parseFloat($(this).html());
      var anulado = parseFloat($(this).parent().parent().find(".anulado").html());
      if(anulado==0) {
        var bs = parseFloat($(this).parent().parent().find(".val_bs").html().replace(/,/g, ""));
        var usd = parseFloat($(this).parent().parent().find(".val_usd").html().replace(/,/g, ""));
      } else {
        var bs = 0;
        var usd = 0;
      }
      if($(this).parent().parent().find(".moneda").html()==0) {
        switch(forma_pago) {
          case 0:
            forma0_bs+=bs;
            break;
          case 1:
            forma1_bs+=bs;
            break;
          case 2:
            forma2_bs+=bs;
            break;
          case 3:
            forma3_bs+=bs;
            break;
          case 4:
            forma4_bs+=bs;
            break;
          case 5:
            forma5_bs+=bs;
            break;
          case 6:
            forma6_bs+=bs;
            break;
          case 7:
            forma7_bs+=bs;
            break;
          case 8:
            forma8_bs+=bs;
            break;
          case 9:
            forma9_bs+=bs;
            break;
        }
      } else {
        switch(forma_pago) {
          case 0:
            forma0_usd+=usd;
            break;
          case 1:
            forma1_usd+=usd;
            break;
          case 2:
            forma2_usd+=usd;
            break;
          case 3:
            forma3_usd+=usd;
            break;
          case 4:
            forma4_usd+=usd;
            break;
          case 5:
            forma5_usd+=usd;
            break;
          case 6:
            forma6_usd+=usd;
            break;
          case 7:
            forma7_usd+=usd;
            break;
          case 8:
            forma8_usd+=usd;
            break;
          case 9:
            forma9_usd+=usd;
            break;
        }
      }
    });
    $("#forma0_bs").text($.number(forma0_bs,2));
    $("#forma1_bs").text($.number(forma1_bs,2));
    $("#forma2_bs").text($.number(forma2_bs,2));
    $("#forma3_bs").text($.number(forma3_bs,2));
    $("#forma4_bs").text($.number(forma4_bs,2));
    $("#forma5_bs").text($.number(forma5_bs,2));
    $("#forma6_bs").text($.number(forma6_bs,2));
    $("#forma7_bs").text($.number(forma7_bs,2));
    $("#forma8_bs").text($.number(forma8_bs,2));
    $("#forma9_bs").text($.number(forma9_bs,2));

    $("#forma0_usd").text($.number(forma0_usd,2));
    $("#forma1_usd").text($.number(forma1_usd,2));
    $("#forma2_usd").text($.number(forma2_usd,2));
    $("#forma3_usd").text($.number(forma3_usd,2));
    $("#forma4_usd").text($.number(forma4_usd,2));
    $("#forma5_usd").text($.number(forma5_usd,2));
    $("#forma6_usd").text($.number(forma6_usd,2));
    $("#forma7_usd").text($.number(forma7_usd,2));
    $("#forma8_usd").text($.number(forma8_usd,2));
    $("#forma9_usd").text($.number(forma9_usd,2));

    imprimir();
  });

  function imprimir() {
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

<script src="/js/jquery.number.min.js"></script>
