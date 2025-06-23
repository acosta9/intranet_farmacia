<?php
  $dida=$sf_params->get('dida');
  $didb=$sf_params->get('didb');
  
  $q = Doctrine_Manager::getInstance()->getCurrentConnection();
  
  $didaData = $q->execute("SELECT id.nombre as idname, e.acronimo as ename
    FROM inv_deposito as id
    LEFT JOIN empresa as e ON id.empresa_id=e.id
    WHERE id.id=$dida");
  $dida_name="";
  foreach ($didaData as $didaD) {
    $dida_name="[".$didaD["ename"]."] ".$didaD["idname"];
  }

  $didbData = $q->execute("SELECT id.nombre as idname, e.acronimo as ename
    FROM inv_deposito as id
    LEFT JOIN empresa as e ON id.empresa_id=e.id
    WHERE id.id=$didb");
  $didb_name="";
  foreach ($didbData as $didbD) {
    $didb_name="[".$didbD["ename"]."] ".$didbD["idname"];
  }

  $tipo="--"; $tipoQuery="";
  if($sf_params->get('tipo')=="1") {
    $tipo="IMPORTADO";
    $tipoQuery=" && p.tipo='1' ";
  } else if ($sf_params->get('tipo')=="0") {
    $tipo="NACIONAL";
    $tipoQuery=" && p.tipo='0' ";
  }

  $unit="--"; $unitQuery="";
  if(!empty($unitId=$sf_params->get("unit"))) {
    $unitQuery=" && p.unidad_id ='$unitId' ";
    $unitT=Doctrine::getTable('ProdUnidad')->findOneBy('id',$sf_params->get("unit"));
    $unit=$unitT->getNombre();
  }
  $cat="--"; $catQuery="";
  if(!empty($sf_params->get("cid"))) {
    $cat=$sf_params->get("cid");
    $cat=str_replace("_", " ", $cat);
    $catQuery=" && pc.nombre LIKE '$cat%' ";
  }

  $inv1 = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial, FORMAT(REPLACE(p.costo_usd_1, ' ', ''), 4, 'de_DE') as costo_usd_1, i.cantidad as cantInv, i.id as iid
    FROM inventario as i
    LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
    LEFT JOIN producto as p ON i.producto_id=p.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    WHERE i.deposito_id=$dida $tipoQuery $catQuery $unitQuery
    GROUP BY i.producto_id
    ORDER BY p.nombre ASC");
  $prods1=array();
  foreach($inv1 as $data) {
    $prods1[$data["pid"]]["id"]=$data["pid"];
    $prods1[$data["pid"]]["iid"]=$data["iid"]; // ojo
    $prods1[$data["pid"]]["nombre"]=$data["pname"];
    $prods1[$data["pid"]]["serial"]=$data["serial"];
    $prods1[$data["pid"]]["existencia"]=$data["cantInv"];
    $prods1[$data["pid"]]["costo_usd_1"]=$data["costo_usd_1"];
  }

  $inv2 = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial, 
    p.costo_usd_1 as costo_usd_1, i.cantidad as cantInv, i.id as invid
    FROM inventario as i
    LEFT JOIN inv_deposito as id ON i.deposito_id=id.id
    LEFT JOIN producto as p ON i.producto_id=p.id
    LEFT JOIN prod_categoria as pc ON p.categoria_id=pc.id
    WHERE i.deposito_id=$didb $tipoQuery $catQuery $unitQuery
    GROUP BY i.producto_id
    ORDER BY p.nombre ASC");
  $prods2=array();
  foreach($inv2 as $data) {
    $prods2[$data["pid"]]["id"]=$data["pid"];
    $prods2[$data["pid"]]["invid"]=$data["invid"]; // ojo
    $prods2[$data["pid"]]["nombre"]=$data["pname"];
    $prods2[$data["pid"]]["serial"]=$data["serial"];
    $prods2[$data["pid"]]["existencia"]=$data["cantInv"];
    $prods1[$data["pid"]]["costo_usd_1"]=$data["costo_usd_1"];
  }
  
?>

    <?php $num=0;
      foreach ($prods1 as $prod):
      if($prod["existencia"]>0 && !empty($prods2[$prod["id"]]["nombre"])){
        $num++;
      $prod["costo_usd_1"] = number_format($prod["costo_usd_1"], 4, '.', '');

       ?>
 
     <tr class="row items" id="row_<?php echo $num ?>">
     <td width="450px" style="padding: 2px;">
      <input class="form-control nombre" type="text" name="nombre_<?php echo $num?>" value="<?php echo $prod["nombre"]; ?>" id="nombre_<?php echo $num?>" />
      <input class="form-control hide" type="text" name="pid_<?php echo $num?>" value="<?php echo $prod["id"]; ?>" id="pid_<?php echo $num?>" />
      <input class="form-control iidd hide" type="text" name="iidd_<?php echo $num?>" value="<?php echo $prod["iid"]; ?>" id="iidd_<?php echo $num?>" />
      <input class="form-control hide" type="text" name="iidh_<?php echo $num?>" value="<?php echo $prods2[$prod["id"]]["invid"]; ?>" id="iidh_<?php echo $num?>" />
      </td>
   
      <td width="150px" style="padding: 2px;">
         <input class="form-control serial" type="text" name="serial_<?php echo $num?>" value="<?php echo $prod["serial"]; ?>" readonly id="serial_<?php echo $num?>" />
      </td>

      <td width="90px" style="padding: 2px;">
 
          <input class="form-control " type="text" name="existenciaa_<?php echo $num?>" value="<?php echo $prod["existencia"]; ?>"  readonly id="existenciaa_<?php echo $num?>"/>
        
      </td>
      
      <td width="90px" style="padding: 2px;">
          <input class="form-control existenciab " type="text" name="existenciab_<?php echo $num?>" value="<?php echo $prods2[$prod["id"]]["existencia"];?>"  readonly id="existenciab_<?php echo $num?>"/>
      </td>
 
      <td width="90px" style="padding: 2px;">
 
          <input class="form-control qty onlyqty" type="text" name="qty_<?php echo $num?>" value="0" id="qty_<?php echo $num?>" />
        
      </td>


      <td width="120px" style="padding: 2px;">
         <input class="form-control price_unit money_intern" type="text" name="price_unit_<?php echo $num?>" value="<?php echo $prod["costo_usd_1"]; ?>" readonly id="price_unit_<?php echo $num?>"/>
         <input class="form-control price_unit_bs  hide" type="text" name="price_unit_bs_<?php echo $num?>" value="" readonly id="price_unit_bs_<?php echo $num?>"/>
        
      </td>

      <td width="120px" style="padding: 2px;">
        
          <input class="form-control price_tot money_intern" type="text" name="price_tot_<?php echo $num?>" value="" readonly id="price_tot_<?php echo $num?>"/>
         
      </td>

      <td width="135px" style="padding: 2px;">
        
          <input class="form-control price_tot_bs money_intern" type="text" name="price_tot_bs_<?php echo $num?>" value="" readonly id="price_tot_bs_<?php echo $num?>"/>
         
      </td>
      
    </tr> <!-- row <span style="padding: 2px; size: 14px;"></span>-->

 <?php  } endforeach; ?>

<script type="text/javascript">
  $(document).ready(function() {

     $('.onlyqty').mask("###0", {reverse: true});

    $('.money_intern').mask("#.##0,0000", {
      clearIfNotMatch: true,
      placeholder: "#,####",
      reverse: true
    });
  });

  $(function () {

    $('.qty').keyup(function(){
      sumar();
    });
 
  });

  
</script>