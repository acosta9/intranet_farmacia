<?php
  $prods = array(); $invs = array ();
  $i=0;
  $todo=0;
  foreach ($prod_vendidos as $prod_vendido):
    $todo+=str_replace(",",".",str_replace(".","",$prod_vendido["total"]));
    if(empty($prods[$prod_vendido["pid"]]["qty"])) {
      $cat=explode("/",$prod_vendido["pcname"]);
      $rubro=$cat[0];
      $categoria=$cat[0];
      if(!empty($cat[1])) {
        $categoria=$cat[1];
      }
      $prods[$prod_vendido["pid"]]["pid"]=$prod_vendido["pid"];
      $prods[$prod_vendido["pid"]]["producto"]=ucwords(mb_strtolower($prod_vendido["pname"]));
      $prods[$prod_vendido["pid"]]["serial"]=$prod_vendido["sname"];
      $prods[$prod_vendido["pid"]]["cat"]=ucwords(mb_strtolower($categoria));
      $prods[$prod_vendido["pid"]]["rubro"]=ucwords(mb_strtolower($rubro));
      $prods[$prod_vendido["pid"]]["lab"]=ucwords(mb_strtolower($prod_vendido["labnombre"]));
      $prods[$prod_vendido["pid"]]["unit"]=ucwords(mb_strtolower($prod_vendido["unit"]));
      $prods[$prod_vendido["pid"]]["qty"]=$prod_vendido["qty"];
      $prods[$prod_vendido["pid"]]["total"]=str_replace(",",".",str_replace(".","",$prod_vendido["total"]));
    } else {
      $qty_old=$prods[$prod_vendido["pid"]]["qty"];
      $total_old=$prods[$prod_vendido["pid"]]["total"];
      $total_new=str_replace(",",".",str_replace(".","",$prod_vendido["total"]));
      $prods[$prod_vendido["pid"]]["qty"]=$prod_vendido["qty"]+$qty_old;
      $prods[$prod_vendido["pid"]]["total"]=$total_new+$total_old;
    }
    $i++;
  endforeach;
?>

<div style="margin-bottom: 10px" id="botones">
  <a href="#" onclick="toPdf()" class="btn btn-success">IMPRIMIR PDF</a>
  <a href="#" onclick="toExcel()" class="btn btn-primary">IMPRIMIR EXCEL</a>
</div>
<?php
  $cat=$sf_params->get('c');
  $tipo="--";
  if($sf_params->get('t')=="1") {
    $tipo="IMPORTADO";
  } else if ($sf_params->get('t')=="0") {
    $tipo="NACIONAL";
  }
  $emp="";
  if(!empty($empid=$sf_params->get('e'))) {
    $value = explode(',', $sf_params->get('e'));
    $results = Doctrine_Query::create()
      ->select('e.acronimo as ename')
      ->from('Empresa e')
      ->WhereIn('e.id', $value)
      ->execute();
    foreach ($results as $result) {
      $emp=$emp.$result["ename"]." / ";
    }
  }
  $dep="--";
  if(!empty($did=$sf_params->get("dep"))) {
    $results = Doctrine_Query::create()
      ->select('id.id as idid, id.nombre as idname, e.id as eid, e.acronimo as ename')
      ->from('InvDeposito id')
      ->leftJoin('id.Empresa e')
      ->Where('id.id = ?', $sf_params->get("dep"))
      ->execute();
    foreach ($results as $result) {
      $dep="[".$result["ename"]."] ".$result["idname"];
    }
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $rec_pendings = $q->execute("SELECT p.id as prodid, SUM(i.cantidad) as qty 
      FROM inventario as i
      LEFT JOIN producto as p
      ON i.producto_id=p.id
      WHERE i.deposito_id=$did
      GROUP BY i.producto_id");
    foreach ($rec_pendings as $result) {
      $invs[$result["prodid"]]=$result["qty"];
    }
  } else {
    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $rec_pendings = $q->execute("SELECT p.id as prodid, SUM(i.cantidad) as qty 
      FROM inventario as i
      LEFT JOIN producto as p
      ON i.producto_id=p.id
      WHERE i.empresa_id IN ($empid)
      GROUP BY i.producto_id");
    foreach ($rec_pendings as $result) {
      $invs[$result["prodid"]]=$result["qty"];
    }
  }
  $lab="--";
  if(!empty($sf_params->get("lab"))) {
    $labT=Doctrine::getTable('ProdLaboratorio')->findOneBy('id',$sf_params->get("lab"));
    $lab=$labT->getNombre();
  }
  $unit="--";
  if(!empty($sf_params->get("unit"))) {
    $unitT=Doctrine::getTable('ProdUnidad')->findOneBy('id',$sf_params->get("unit"));
    $unit=$unitT->getNombre();
  }
?>
<div>
  <table style="border-spacing: 0px; width: 100%; font-size: 12px" id="tabla_export">
    <thead>
      <tr>
        <td colspan="14" class="ball">
          <p style="text-align:center">ANALISIS ABC: <b>DESDE: <?php echo $sf_params->get('d');?> / HASTA: <?php echo $sf_params->get('h');?> </b></p>
        </td>
      </tr>
      <tr>
        <td colspan="9" class="bleft"><b>EMPRESA(S):</b> <?php echo $emp; ?></td>
        <td colspan="5" class="bleft bright"><b>DEPOSITO:</b> <?php echo $dep; ?></td>
      </tr>
      <tr>
        <td colspan="3" class="ball"><b>CATEGORIA:</b> <?php echo $cat; ?></td>
        <td colspan="3" class="btop bright bbottom"><b>LABORATORIO:</b> <?php echo $lab; ?></td>
        <td colspan="5" class="btop bright bbottom"><b>PRESENTACION:</b> <?php echo $unit; ?></td>
        <td colspan="3" class="btop bright bbottom"><b>TIPO:</b> <?php echo $tipo; ?></td>
      </tr>
      <tr>
        <td colspan="14"><br/><br/></td>
      </tr>
      <tr style="background-color: #b3afafab;">
        <td class="bleft"></td>
        <td class="bleft"><b>NOMBRE</b></td>
        <td class="bleft"><b>SERIAL</b></td>
        <td class="bleft"><b>RUBRO</b></td>
        <td class="bleft"><b>CATEGORIA</b></td>
        <td class="bleft"><b>LABORATORIO</b></td>
        <td class="bleft"><b>PRESENTACION</b></td>
        <td class="bleft tright"><b>CANT.</b></td>
        <td class="bleft tright"><b>PRECIO<br/>PROMEDIO</b></td>
        <td class="bleft tright"><b>TOTAL</b></td>
        <td class="bleft tright"><b>PART</b></td>
        <td class="bleft tright"><b>ACUM</b></td>
        <td class="bleft tright"><b>CLASE</b></td>
        <td class="bleft bright tright"><b>EXIS<br/>TENCIA</b></td>
      </tr>
    </thead>
    <tbody>
    <?php
      if (count($prods)>0):
        foreach ($prods as $prod) {
          $prom=$prod["total"]/$prod["qty"];
          $prods[$prod["pid"]]["prom"]=$prom;
          $participacion=($prod["total"]*100)/$todo;
          $prods[$prod["pid"]]["participacion"]=$participacion;
        }
        function cmp($a, $b) {
          return $b["total"] - $a["total"];
        }
        usort($prods, "cmp");
        
        $i=1; $acum=0;
        foreach ($prods as $prod):
    ?>
          <tr>
            <td class="bleft btop"><?php echo $i; $i++; ?></td>
            <td class="bleft btop"><?php echo $prod["producto"]; ?></td>
            <td class="bleft btop"><?php echo trim($prod["serial"]); ?></td>
            <td class="bleft btop"><?php echo $prod["rubro"]; ?></td>
            <td class="bleft btop"><?php echo $prod["cat"]; ?></td>
            <td class="bleft btop"><?php echo $prod["lab"]; ?></td>
            <td class="bleft btop"><?php echo $prod["unit"]; ?></td>
            <td class="bleft btop tright"><?php echo $prod["qty"]; ?></td>
            <td class="bleft btop tright"><?php echo "$".number_format($prod["prom"],4,",","."); ?></td>
            <td class="bleft btop tright"><?php echo "$".number_format($prod["total"],4,",","."); ?></td>
            <td class="bleft btop tright">
              <?php $acum+=$prod["participacion"]; ?>
              <?php echo number_format($prod["participacion"],2,",","")."%"; ?>
            </td>
            <td class="bleft btop tright"><?php echo number_format($acum,2,",","")."%"; ?></td>
            <td class="bleft btop tcenter">
              <?php 
                if($acum>0 && $acum<=80) {
                  echo "A";
                } else if($acum>80 && $acum<=95) {
                  echo "B";
                } else {
                  echo "C";
                }
              ?>
            </td>
            <td class="bleft bright btop tright"><?php echo $invs[$prod["pid"]]; ?></td>
          </tr>
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
    border: 1px solid #4441418c !important;
  }

  .bright {
    border-right: 1px solid #4441418c !important;
  }

  .bleft {
    border-left: 1px solid #4441418c !important;
  }

  .bbottom {
    border-bottom: 1px solid #4441418c !important;
  }

  .btop {
    border-top: 1px solid #4441418c !important;
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

    document.title='analisis_abc_'+fecha+'.pdf';
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
      filename: 'analisis_abc_'+fecha+'.xls',
      preserveColors: true 
    });
  }
</script>
