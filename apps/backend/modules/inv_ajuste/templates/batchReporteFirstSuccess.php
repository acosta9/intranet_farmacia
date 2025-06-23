<?php
  $value = array();
  $i=0;
  foreach ($inv_ajustes as $inv_ajuste):
    $value[$i]=$inv_ajuste["id"];
    $i++;
  endforeach;
?>
<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>
<div style="font-size: 12px;">
  <table style="border-spacing: 0px; width: 100%;" id="tabla_export">
    <thead>
      <tr>
        <td colspan="12" style="text-align: center; text-decoration: underline;">
          <p style="margin-top: 0px !important">
            <b>REPORTE DE AJUSTE DE INVENTARIO</b>
            <b><?php echo date('d/m/Y H:i:s'); //." - ".ini_get('date.timezone') ?></b>
          </p>
        </td>
      </tr>
      <tr style="">
        <td class="bbottom" style="width: 0.5cm;"></td>
        <td class="bbottom tleft"><b>N° CONTROL</b></td>
        <td class="bbottom tleft"><b>EMP.</b></td>
        <td class="bbottom tleft"><b>DEPOSITO</b></td>
        <td class="bbottom tleft"><b>SERIAL</b></td>
        <td class="bbottom tleft"><b>NOMBRE</b></td>
        <td class="bbottom tleft"><b>PRESENTACION</b></td>
        <td class="bbottom tleft"><b>FECHA</b></td>
        <td class="bbottom tcenter"><b>LOTE</b></td>
        <td class="bbottom tleft"><b>VENC.</b></td>
        <td class="bbottom tright"><b>QTY</b></td>
        <td class="bbottom tright"><b>ESTATUS</b></td>
      </tr>
    </thead>
    <tbody>
      <?php
        if (count($value)>0):
          $valor=implode(",",$value);
          $q = Doctrine_Manager::getInstance()->getCurrentConnection();
          $results = $q->execute("SELECT e.acronimo as emin, 
          id.nombre as idname,
          ied.qty as qty, ied.devolucion as devolucion, ied.tipo as tipo,
          ie.id as ieid, ie.created_at as fsalida, ie.anulado as anulado,
          p.nombre as pname, p.serial as pserial, 
          pu.nombre as puname
          FROM inv_ajuste_det ied
          LEFT JOIN inventario i ON ied.inventario_id=i.id
          LEFT JOIN producto p ON i.producto_id=p.id
          LEFT JOIN prod_unidad pu ON p.unidad_id=pu.id
          LEFT JOIN inv_ajuste ie ON ied.inv_ajuste_id=ie.id
          LEFT JOIN empresa e ON ie.empresa_id=e.id
          LEFT JOIN inv_deposito id ON ie.deposito_id=id.id
          WHERE ied.inv_ajuste_id IN ($valor)
          ORDER BY ie.id DESC, ied.id ASC");
            $i=0;
          foreach ($results as $result):
            if($result["tipo"]==1){
              $tipo="+";
            } else {
              $tipo="-";
            }
            $items = explode(';', $result["devolucion"]);
            foreach ($items as $item) {
              if(strlen($item)>0) {
                $background="background-color: #fff";
                if ($i & 1) {
                  $background="background-color: #dcdada";
                }
                list($qty, $fvenc, $lote)=explode("|",$result["devolucion"]);
                ?>
                <tr style="<?php echo $background;?>">
                  <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; $i++;?></td>
                  <td class="bbottom tleft"><?php echo $result["ieid"];?></td>
                  <td class="bbottom tleft tcaps"><?php echo $result["emin"];?></td>
                  <td class="bbottom tleft tcaps"><?php echo mb_strtolower($result["idname"]);?></td>
                  <td class="bbottom tleft"><?php echo $result["pserial"]; ?></td>
                  <td class="bbottom tleft tcaps"><?php echo mb_strtolower($result["pname"]); ?></td>
                  <td class="bbottom tleft tcaps"><?php echo mb_strtolower($result["puname"]); ?></td>
                  <td class="bbottom tleft"><?php echo date("d/m/Y H:i:s", strtotime($result["fsalida"])); ?></td>
                  <td class="bbottom tcenter"><?php echo $lote; ?></td>
                  <td class="bbottom tleft"><?php echo date("d/m/Y", strtotime($fvenc)); ?></td>
                  <td class="bbottom tright"><span style=""><?php echo $tipo; ?></span><?php echo $result["qty"]; ?></td>
                  <td class="bbottom tright">
                    <?php
                      if($result["anulado"]==1):
                        echo "ANULADO";
                      else:
                        echo "PROCESADO";
                      endif;
                    ?>
                  </td>
                </tr>
                <?php
              }
            }
      ?>
      <?php
          endforeach;
        endif;
      ?>
    </tbody>
  </table>
</div>

<style>
  .btn {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
    text-decoration: none;
  }
  .btn-primary {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    box-shadow: 0 1px 1px rgba(0,0,0,.075);
  }
  .btn-success {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
    box-shadow: 0 1px 1px rgba(0,0,0,.075);
  }
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

<script src="/js/jquery.table2excel.min.js"></script>
<script>
  function toPdf() {
    $("#botones").hide();
    <?php $dt = new DateTime(); ?>
    var fecha = "<?php echo $dt->format('Y-m-d_H:i:s'); ?>";
    var css = '@page { size: 297mm 210mm; margin: 2mm 2mm 2mm 2mm; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

    document.title='salida_de_inventario_'+fecha+'.pdf';
    style.type = 'text/css';
    style.media = 'print';

    if (style.styleSheet){
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);

    window.print();
    $("#botones").show();
  }
  function toExcel() {
    <?php $dt = new DateTime(); ?>
    var fecha = "<?php echo $dt->format('Y-m-d_H:i:s'); ?>";
    $("#tabla_export").table2excel({
      filename: 'salida_de_inventario_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>
