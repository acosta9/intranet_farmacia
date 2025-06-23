<?php 
  foreach ($kardexs as $kardex) {
    $unico=$kardex;
    break;
  }
  if(empty($unico)) {
    echo "no hay resultados";
    die();
  }
  $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id', $unico["eid"]);
  $producto=Doctrine_Core::getTable('Producto')->findOneBy('id', $unico["pid"]);
  $cat=Doctrine_Core::getTable('ProdCategoria')->findOneBy('id', $producto->getCategoriaId());
  if(empty($producto->getLaboratorioId())) {
    $lab="";
  } else {
    $lab2=Doctrine_Core::getTable('ProdLaboratorio')->findOneBy('id', $producto->getLaboratorioId());
    $lab=$lab2["nombre"];
  }
  if(empty($producto->getUnidadId())) {
    $unit="";
  } else {
    $unit2=Doctrine_Core::getTable('ProdUnidad')->findOneBy('id', $producto->getUnidadId());
    $unit=$unit2["nombre"];
  }
  $uni=Doctrine_Core::getTable('Producto')->findOneBy('id', $unico["pid"]);

  $entradas_prev=0;
  $salidas_prev=0;
  #1 entrada, 2 salida
  $did=$sf_params->get('did');
  $result_entradas = Doctrine_Query::create()
    ->select('SUM(cantidad) as qty')
    ->from('Kardex k')
    ->where("k.producto_id =?", $unico["pid"])
    ->andWhere("k.fecha <?", $unico["fecha"])
    ->andWhere("k.deposito_id = ?", $did)
    ->andWhere("k.tipo =?",1)
    ->execute();
  foreach ($result_entradas as $result_entrada) {
    $entradas_prev=$result_entrada["qty"];
  }

  $result_salidas = Doctrine_Query::create()
    ->select('SUM(cantidad) as qty')
    ->from('Kardex k')
    ->where("k.producto_id =?", $unico["pid"])
    ->andWhere("k.fecha <?", $unico["fecha"])
    ->andWhere("k.deposito_id = ?", $did)
    ->andWhere("k.tipo =?",2)
    ->execute();
  foreach ($result_salidas as $result_salida) {
    $salidas_prev=$result_salida["qty"];
  }
  
  $init=0;
  $exis_previa=$entradas_prev-$salidas_prev;
?>
<div style="font-size: 12px; max-width: 21cm;">
  <p>
    <b><?php echo $empresa->getNombre()." | ".$empresa->getRif(); ?></b><br/>
    <span style="text-transform: capitalize"><?php echo mb_strtolower($empresa->getDireccion()); ?></span><br/>
    Telf: <?php echo mb_strtolower($empresa->getTelefono()); ?><br/>
  </p>
  <p style="border-bottom: 2px solid #000">
    <span>KARDEX DE UN PRODUCTO: <b><?php echo $unico["pname"]; ?></b></span>
    <span style="float: right">EXISTENCIA PREV. <b>[<?php echo number_format($exis_previa,2,".","") ?>]</b></span>
  </p>
  <table style="border-spacing: 0px; width: 100%;">
    <tr>
      <td style="border: 1px solid #000"><b>SN:</b> <?php echo $unico["sname"]; ?></td>
      <td style="border: 1px solid #000"><b>CAT:</b> <?php echo $cat->getNombre(); ?></td>
      <td style="border: 1px solid #000"><b>LAB:</b> <?php echo $lab; ?></td>
      <td style="border: 1px solid #000"><b>UNIT:</b> <?php echo $unit; ?></td>
    </tr>
    <tr>
      <td colspan="2" style="border: 1px solid #000"><b>EMPRESA:</b> <span id="emp"></span></td>
      <td colspan="2" style="border: 1px solid #000"><b>DEPOSITO:</b> <span id="dep"></span></td>
    </tr>
  </table>
  <br/>
  <table style="border-spacing: 0px; width: 100%;">
    <thead>
      <tr>
        <td colspan="8" style="text-align: center; text-decoration: underline;">
          <p style="margin-top: 0px !important">
            <b>DESDE: <?php echo $sf_params->get('desde');?> / HASTA: <?php echo $sf_params->get('hasta');?> </b></b>
          </p>
        </td>
      </tr>
      <tr style="font-size: 10px !important">
        <td class="bbottom" style="width: 1cm;"></td>
        <td class="bbottom tleft"><b>FECHA.</b></td>
        <td class="bbottom tleft"><b>CONCEPTO</b></td>
        <td class="bbottom tright"><b>ENTRADA</b></td>
        <td class="bbottom tright"><b>SALIDA</b></td>
        <td class="bbottom tright"><b>EXISTENCIA</b></td>
      </tr>
    </thead>
    <tbody>
    <?php 
      $i=0; 
      $entrada_number=0;
      $salida_number=0;
      foreach($kardexs as $kardex): ?>
      <?php 
      if($kardex["tipo"]==1) {
        $entrada_number+=$kardex["qty"];
        $entrada=number_format($kardex["qty"],2,".","");
        $salida=number_format(0,2,",",".");
        $init+=$entrada;
      } else {
        $salida_number+=$kardex["qty"];
        $entrada=number_format(0,2,",",".");
        $salida=number_format($kardex["qty"],2,".","");
        $init-=$salida;
      }
      $background="background-color: #fff";
        if ($i & 1) {
          $background="background-color: #dcdada";
        }
      ?>
      <tr style="font-size: 12px !important; <?php echo $background; $i++;?>">
        <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; ?></td>
        <td class="bbottom tleft tcaps"><?php echo $kardex["fecha"]; ?></td>
        <td class="bbottom tleft tcaps"><?php echo $kardex["concepto"]; ?></td>
        <td class="bbottom tright tcaps"><?php echo $entrada; ?></td>
        <td class="bbottom tright tcaps"><?php echo $salida; ?></td>
        <td class="bbottom tright tcaps"><?php echo number_format($init,2,".",""); ?></td>
        <?php $dep=$kardex["idname"]; $emp=$kardex["emin"]; ?>
      </tr>
    <?php endforeach; ?>
      <tr style="font-size: 14px !important;">
        <td colspan="2" style="border-top: 2px solid #000;">TOTAL LINEAS: <?php echo $i; ?></td>
        <td class="tright" style="border-top: 2px solid #000;"><b>RESUMEN DE EXISTENCIA</b></td>
        <td class="tright" style="border-top: 2px solid #000;"><?php echo number_format($entrada_number,2,".",""); ?></td>
        <td class="tright" style="border-top: 2px solid #000;"><?php echo number_format($salida_number,2,".",""); ?></td>
        <td class="tright" style="border-top: 2px solid #000;"><?php echo number_format($init,2,".",""); ?></td>
        <td style="border-top: 2px solid #000;"></td>
      </tr>
      <tr style="font-size: 14px !important;">
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" class="tright">Existencia Prev:</td>
        <td class="tright"><?php echo number_format($exis_previa,2,".",""); ?></td>
      </tr>
      <tr style="font-size: 14px !important;">
        <td></td>
        <td></td>
        <td></td>
        <td colspan="2" class="tright" style="border-top: 2px dotted #000">Existencia Final:</td>
        <td class="tright" style="border-top: 2px dotted #000"><?php echo number_format($init+$exis_previa,2,".",""); ?></td>
      </tr>
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
  $("#emp").text('<?php echo $emp; ?>');
  $("#dep").text('<?php echo $dep; ?>');
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

