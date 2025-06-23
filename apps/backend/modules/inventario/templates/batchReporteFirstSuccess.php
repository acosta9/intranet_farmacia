<?php
  $value = array();
  $i=0;
  foreach ($inventarios as $inventario):
    $value[$i]=$inventario["id"];
    $i++;
  endforeach;
?>
<div style="font-size: 12px; max-width: 21cm;">
  <table style="border-spacing: 0px; width: 100%;">
    <thead>
      <tr>
        <td colspan="11" style="text-align: center; text-decoration: underline;">
          <p style="margin-top: 0px !important">
            <b>REPORTE DE INVENTARIO</b>
            <b><?php echo date('d/m/Y H:i:s'); //." - ".ini_get('date.timezone') ?></b>
          </p>
        </td>
      </tr>
      <tr style="font-size: 10px !important">
        <td class="bbottom" style="width: 1cm;"></td>
        <td class="bbottom tleft" style="width: 1cm;"><b>EMP.</b></td>
        <td class="bbottom tleft" style="width: 1.3cm;"><b>DEPOSITO</b></td>
        <td class="bbottom tleft" style="width: 2cm;"><b>SERIAL</b></td>
        <td class="bbottom tleft" style="width: 8cm;"><b>NOMBRE</b></td>
        <td class="bbottom tright" style="width: 2cm;"><b>LOTE</b></td>
        <td class="bbottom tright" style="width: 2cm;"><b>VENC.</b></td>
        <td class="bbottom tright" style="width: 1.5cm;"><b>QTY</b></td>
        <td class="bbottom tright" style="width: 1.5cm;"><b>ST.</b></td>
      </tr>
    </thead>
    <tbody>
      <?php
        $i=1;
        if (count($value)>0):
          $results = Doctrine_Query::create()
            ->select('idet.id as idetid, idet.fecha_venc as fvenc, idet.lote as lote, idet.cantidad as qtydet,
            i.id as iid, i.cantidad as qty, i.activo as act, p.id as pid, p.nombre as pname, p.serial as serial, e.id as eid, e.acronimo as ename,
            id.id as idid, id.acronimo as idname')
            ->from('InventarioDet idet')
            ->leftJoin('idet.Inventario i')
            ->leftJoin('i.Producto p')
            ->leftJoin('i.Empresa e')
            ->leftJoin('i.InvDeposito id')
            ->andWhereIn('idet.inventario_id', $value)
            ->orderBy('p.nombre ASC, idet.id DESC')
            ->execute();
          $codViejo="";
          foreach ($results as $result):
      ?>
          <?php if($codViejo!=$result["serial"]): $codViejo=$result["serial"];?>
            <tr style="font-size: 11px !important; background-color: #dcdada">
              <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
              <td class="bbottom tleft tcaps"><?php echo $result["ename"];?></td>
              <td class="bbottom tleft tcaps"><?php echo $result["idname"];?></td>
              <td class="bbottom tleft"><?php echo $result["serial"];?></td>
              <td class="bbottom tleft tcaps"><?php echo mb_strtolower($result["pname"]);?></td>
              <td class="bbottom tcenter"></td>
              <td class="bbottom tleft"></td>
              <td class="bbottom tright"><?php echo $result["qty"];?></td>
              <td class="bbottom tright">
                <?php
                  if($result["act"]==1):
                    echo "HAB.";
                  else:
                    echo "DES.";
                  endif;
                ?>
              </td>
            </tr>
            <tr style="font-size: 11px !important">
              <td class="bbottom tright clight" style="padding-right: 10px"></td>
              <td class="bbottom tleft tcaps"></td>
              <td class="bbottom tleft tcaps"></td>
              <td class="bbottom tleft"></td>
              <td class="bbottom tleft tcaps"></td>
              <td class="bbottom tright"><?php echo mb_strtolower($result["lote"]);?></td>
              <td class="bbottom tright"><?php echo mb_strtolower($result["fvenc"]);?></td>
              <td class="bbottom tright"><?php echo mb_strtolower($result["qtydet"]);?></td>
              <td class="bbottom tright">
              </td>
            </tr>
          <?php else: ?>
            <?php if($result["qtydet"]>0): ?>
              <tr style="font-size: 11px !important">
                <td class="bbottom tright clight" style="padding-right: 10px"></td>
                <td class="bbottom tleft tcaps"></td>
                <td class="bbottom tleft tcaps"></td>
                <td class="bbottom tleft"></td>
                <td class="bbottom tleft tcaps"></td>
                <td class="bbottom tright"><?php echo mb_strtolower($result["lote"]);?></td>
                <td class="bbottom tright"><?php echo mb_strtolower($result["fvenc"]);?></td>
                <td class="bbottom tright"><?php echo mb_strtolower($result["qtydet"]);?></td>
                <td class="bbottom tright">
                </td>
              </tr>
            <?php endif; ?>
          <?php endif; ?>
      <?php
          endforeach;
        endif;
      ?>
    </tbody>
  </table>
</div>

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
   var css = '@page { size: 216mm 279mm; margin: 5mm 5mm 5mm 5mm; }',
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
