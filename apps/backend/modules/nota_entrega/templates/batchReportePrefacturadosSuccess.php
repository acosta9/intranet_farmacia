<table style="border-spacing: 0px; width: 100%;">
  <thead>
    <tr>
      <td colspan="10" style="text-align: center; text-decoration: underline;">
        REPORTE DE <b>FACTURAS REALIZADAS</b>
        <b><?php echo date('d/m/Y') ?></b>
      </td>
    </tr>
    <tr style="font-size: 11px !important">
      <td class="bbottom"></td>
      <td class="bbottom tleft"><b>FECHA DE<br/>CREACION</b></td>
      <td class="bbottom tleft"><b>FECHA DE<br/>EMISIÓN</b></td>
      <td class="bbottom tleft"><b>EMPRESA</b></td>
      <td colspan="2" class="bbottom tleft"><b>CLIENTE</b></td>
      <td class="bbottom tleft"><b>RIF</b></td>
      <td class="bbottom tleft"><b>N° CONTROL</b></td>
      <td class="bbottom tleft"><b>N° FACTURA</b></td>
      <td class="bbottom tright"><b>MONTO<br/>TOTAL. USD</b></td>
    </tr>
  </thead>
  <tbody>
    <?php $i=1; $total=0; foreach ($facturas as $factura): ?>
      <?php
      $anulado=""; $anulado_inner="<span class='anulado' style='display: none'>0</span>";
      if($factura->getAnulado()==1) {
        $anulado="text-decoration: line-through;";
        $anulado_inner="<span class='anulado' style='display: none'>1</span>";
      }
      ?>
      <tr style="font-size: 11px !important; <?php echo $anulado; ?> ">
        <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++?><?php echo $anulado_inner; ?></td>
        <td class="bbottom tleft"><?php echo date('d/m/Y',strtotime($factura->getCreatedAt())); ?></td>
        <td class="bbottom tleft"><?php echo date('d/m/Y',strtotime($factura->getFecha())); ?></td>
        <td class="bbottom tleft tcaps"><?php echo mb_strtolower($factura["ename"]); ?></td>
        <td class="bbottom tleft tcaps" colspan="2"><?php echo mb_strtolower($factura->getRazonSocial()); ?></td>
        <td class="bbottom tleft">
          <?php echo $factura->getDocId(); ?>
        </td>
        <td class="bbottom tleft">
          <?php echo $factura->getNcontrol(); ?>
        </td>
        <td class="bbottom tleft">
          <?php echo $factura->getNumFactura(); ?>
        </td>
        <td class="bbottom tright">
          <span class="apagar">
            <?php echo number_format($factura->getTotal(), 2, ',', '.')?>
            <?php $total+=$factura->getTotal(); ?>
          </span>
        </td>
      </tr>
    <?php endforeach; ?>
    <tr style="font-size: 11px !important;">
      <td colspan="9"></td>
      <td class="tright">
        <span class="apagar">
          <?php echo number_format($total, 2, ',', '.')?>
        </span>
      </td>
    </tr>
  </tbody>
</table>
<br/><br/>

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
    var val_pre=0, val_fact=0;
    $('.val_pre').each(function(){
      var anulado = parseFloat($(this).parent().parent().find(".anulado").html());
      if(anulado==0) {
        val_pre+=parseFloat($(this).parent().parent().find(".apagar").html().replace(/,/g, ""));
      } else {
        val_pre+=0;
      }
    });
    $('.val_fact').each(function(){
      var anulado = parseFloat($(this).parent().parent().find(".anulado").html());
      if(anulado==0) {
        console.log($(this).parent().find(".apagar").html());
        val_fact+=parseFloat($(this).parent().parent().find(".apagar").html().replace(/,/g, ""));
      } else {
        val_fact+=0;
      }
    });

    $("#total_pre").text($.number(val_pre,2));
    $("#total_fact").text($.number(val_fact,2));

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
