<?php
  $value = array();
  $i=0;
  foreach ($facturas as $factura):
    $value[$i]=$factura["id"];
    $i++;
  endforeach;
?>
<div style="font-size: 12px; max-width: 21cm;">
  <table style="border-spacing: 0px; width: 100%;">
    <thead>
      <tr>
        <td colspan="5" style="text-align: center; text-decoration: underline;">
          <p style="margin-top: 0px !important">
            <b>REPORTE DE PRODUCTOS MAS VENDIDOS</b>
            <b><?php echo date('d/m/Y H:i:s'); //." - ".ini_get('date.timezone') ?></b>
          </p>
        </td>
      </tr>
      <tr style="font-size: 10px !important">
        <td class="bbottom" style="width: 1cm;"></td>
        <td class="bbottom tleft" style="width: 3cm;"><b>SERIAL</b></td>
        <td class="bbottom tleft" style="width: 1.6cm;"><b>LAB</b></td>
        <td class="bbottom tleft" style="width: 2.5cm;"><b>PRESENTACION</b></td>
        <td class="bbottom tleft"><b>NOMBRE</b></td>
        <td class="bbottom tright" style="min-width: 1.5cm;"><b>MONTO</b></td>
        <td class="bbottom tright" style="width: 1.5cm;"><b>QTY</b></td>
      </tr>
    </thead>
    <tbody>
    <?php
      $i=1;
      if (count($value)>0):
        $results = Doctrine_Query::create()
          ->select('fd.id as fdid, fd.qty as qty, fd.price_tot as ptot, f.id as fid, i.id as iid, p.id as pid, 
          p.nombre as pname, p.serial as serial, pl.id as plid, pl.descripcion as lab, pu.id as puid, pu.nombre as pre')
          ->from('FacturaDet fd')
          ->leftJoin('fd.Factura f')
          ->leftJoin('fd.Inventario i')
          ->leftJoin('i.Producto p')
          ->leftJoin('p.ProdLaboratorio pl')
          ->leftJoin('p.ProdUnidad pu')
          ->where('f.estatus=3')
          ->andWhereIn('fd.inventario_id', $value)
          ->andWhere('fd.oferta_id IS NULL')
          ->orderBy('p.nombre ASC')
          ->execute();
        $prods=array();
        foreach ($results as $result) {
          if(empty($prods[$result["serial"]])) {
            $prods[$result["serial"]]["qty"]=$result["qty"];
            $prods[$result["serial"]]["serial"]=$result["serial"];
            $prods[$result["serial"]]["nombre"]=$result["pname"];
            $prods[$result["serial"]]["monto"]=$result["ptot"];
            $prods[$result["serial"]]["lab"]=$result["lab"];
            $prods[$result["serial"]]["pre"]=$result["pre"];
          } else {
            $qty_new=$prods[$result["serial"]]["qty"];
            $ptot_new=$prods[$result["serial"]]["monto"];
            $qty_new+=$result["qty"];
            $ptot_new+=$result["ptot"];

            $prods[$result["serial"]]["qty"]=$qty_new;
            $prods[$result["serial"]]["monto"]=$ptot_new;
          }
        }

        $results = Doctrine_Query::create()
          ->select('fd.id as fdid, fd.qty as qty, fd.price_tot as ptot, f.id as fid, 
          o.id as oid, o.qty as oqty, od.id as odid, i.id as iid, p.id as pid, p.nombre as pname, p.serial as serial')
          ->from('FacturaDet fd')
          ->leftJoin('fd.Factura f')
          ->leftJoin('fd.Oferta o')
          ->leftJoin('o.OfertaDet od')
          ->leftJoin('od.Inventario i')
          ->leftJoin('i.Producto p')
          ->leftJoin('p.ProdLaboratorio pl')
          ->leftJoin('p.ProdUnidad pu')
          ->where('f.estatus=3')
          ->andWhereIn('od.inventario_id', $value)
          ->andWhere('fd.inventario_id IS NULL')
          ->orderBy('p.nombre ASC')
          ->execute();
        foreach ($results as $result) {
          if(empty($prods[$result["serial"]])) {
            $prods[$result["serial"]]["qty"]=($result["qty"]*$result["oqty"]);
            $prods[$result["serial"]]["serial"]=$result["serial"];
            $prods[$result["serial"]]["nombre"]=$result["pname"];
            $prods[$result["serial"]]["monto"]=$result["ptot"];
            $prods[$result["serial"]]["lab"]=$result["lab"];
            $prods[$result["serial"]]["pre"]=$result["pre"];
          } else {
            $qty_new=$prods[$result["serial"]]["qty"];
            $ptot_new=$prods[$result["serial"]]["monto"];
            $qty_new+=($result["qty"]*$result["oqty"]);
            $ptot_new+=$result["ptot"];

            $prods[$result["serial"]]["qty"]=$qty_new;
            $prods[$result["serial"]]["monto"]=$ptot_new;
          }
        }

        function cmp($a, $b) {
          return $b["qty"] - $a["qty"];
        }
        usort($prods, "cmp");

        $i=0;
        foreach ($prods as $prod):
          $background="background-color: #fff";
          if ($i & 1) {
            $background="background-color: #dcdada";
          }
    ?>
          <tr style="font-size: 11px !important; <?php echo $background; $i++;?>">             
            <td class="bbottom tright clight" style="padding-right: 10px"><?php echo $i; ?></td>
            <td class="bbottom tleft tcaps"><?php echo $prod["serial"]; ?></td>
            <td class="bbottom tleft tcaps"><?php echo $prod["lab"]; ?></td>
            <td class="bbottom tleft tcaps"><?php echo $prod["pre"]; ?></td>
            <td class="bbottom tleft tcaps"><?php echo $prod["nombre"]; ?></td>
            <td class="bbottom tright"><?php echo number_format($prod["monto"],2,"."," "); ?> $</td>
            <td class="bbottom tright"><?php echo $prod["qty"]; ?></td>
          </tr>
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
