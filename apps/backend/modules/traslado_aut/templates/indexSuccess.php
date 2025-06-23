<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Traslado Directo  <small style="font-size: 60%;"> filtros </small></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo url_for("@homepage"); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo url_for("traslado_aut"); ?>">Traslado Directo </a></li>
          <li class="breadcrumb-item active"> filtros </li>
        </ol>
      </div>
    </div>
  </div>
</section>
<section class="content" id="filtros" style="">
  <div class="container-fluid">
    <form method="post" id="form_filter" action="<?php echo url_for('traslado_aut/procesar')?>">
    <div class="card card-default">
      <div class="card-body">
        
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="depositoa">Deposito (A)</label>
                <select class="form-control" name="depositoa" id="depositoa">
                  <?php //  OJO buscar la tasa de la empresa que se escoge //
                      //->Where('o.empresa_id =?', $empreo) ->andWhere('o.nombre =?', "T03")
                    $tasa3 = Doctrine_Query::create()
                                  ->select('o.valor, o.empresa_id, o.nombre')
                                  ->from('Otros o')
                                  ->Where('o.nombre =?', "T03")
                                  ->orderBy('o.created_at DESC')
                                  ->limit('1')
                                  ->fetchOne();
                                $tasa_03 = "0"; 
                                $tasa_03 = $tasa3->getValor();
                              
                                
                    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
                    $uid=$sf_user->getGuardUser()->getId();
                    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
                    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
                    $userid=$sf_user->getGuardUser()->getId();
                    $eid=$ename["srvid"];
                    $results = $q->execute("SELECT e.acronimo as acronimo, id.id as idid, id.nombre as dname
                      FROM empresa as e
                      LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
                      LEFT JOIN inv_deposito as id ON e.id=id.empresa_id
                      WHERE eu.user_id=$userid && e.id IN ($eid)
                      ORDER BY e.nombre ASC, id.nombre ASC");

                    foreach ($results as $result) {
                      echo "<option value='".$result["idid"]."'>"."[".$result["acronimo"]."] ".$result["dname"]."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="depositob">Deposito (B)</label>
                <select class="form-control" name="depositob" id="depositob">
                  <?php
                    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
                    $uid=$sf_user->getGuardUser()->getId();
                    $results = $q->execute("SELECT e.acronimo as acronimo, id.id as idid, id.nombre as dname
                    FROM server_conf as sc
                    LEFT JOIN empresa as e ON sc.empresa_id=e.id
                    LEFT JOIN empresa_user as eu ON e.id=eu.empresa_id
                    LEFT JOIN inv_deposito as id ON e.id=id.empresa_id
                    WHERE eu.user_id = '$uid'
                    GROUP BY id.nombre
                    ORDER BY e.nombre ASC, id.nombre ASC");

                    foreach ($results as $result) {
                      echo "<option value='".$result["idid"]."'>"."[".$result["acronimo"]."] ".$result["dname"]."</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="categoria_id">Categoria</label>
                <select class="form-control" name="categoria_id" id="categoria_id">
                <?php
                  $results = Doctrine_Query::create()
                    ->select('pc.nombre')
                    ->from('ProdCategoria pc')
                    ->orderBy('pc.nombre ASC')
                    ->execute();
                    echo "<option value=''></option>";
                  foreach ($results as $result) {
                    echo "<option value='".$result["nombre"]."'>".$result["nombre"]."</option>";
                  }
                ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="unidad_id">Presentacion</label>
                <select class="form-control" name="unidad_id" id="unidad_id">
                <?php
                  $results = Doctrine_Query::create()
                    ->select('pu.id as puid, pu.nombre')
                    ->from('ProdUnidad pu')
                    ->orderBy('pu.nombre ASC')
                    ->execute();
                    echo "<option value=''></option>";
                  foreach ($results as $result) {
                    echo "<option value='".$result["puid"]."'>".$result["nombre"]."</option>";
                  }
                ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="tipo_id">Tipo</label>
                <select class="form-control" name="tipo_id" id="tipo_id">
                  <option value="" selected="selected"></option>
                  <option value="0">NACIONAL</option>
                  <option value="1">IMPORTADO</option>
                </select>
              </div>
            </div>

            <div class="col-md-4 " name="tasa_cambio" id="tasa_cambio">
              <div class="form-group">
               <label for="traslado_aut_tasa_cambio">Tasa</label>
               <input class="form-control traslado_aut_tasa_cambio money" type="text" name="traslado_aut_tasa_cambio" id="traslado_aut_tasa_cambio" value="<?php echo $tasa_03;?>" readonly="readonly" >
                </div>
            </div> 

          </div>
          <div class="row float-md-right"> 
            <a class="btn btn-default" href="<?php echo url_for("traslado_aut"); ?>">LIMPIAR BUSQUEDA</a>
           <!-- <input class="btn btn-primary ml-3" type="submit" value="BUSCAR">     style="width: 77px; height: 80px;" -->
           <a class="btn btn-primary buscar"  href="javascript:void(0)">
            <span style="color: white; size: 18px;"><i class="fas fa-filter" style='font-size:18px'></i> BUSCAR</span>
            </a>
          </div>
        
      </div>
    </div>


    <div class="card card-primary detalle" id="oproducto">

       <div class="card-body">

        <div class="row">
          <div class="col-md-11">
            <table style="font-size: 14px; padding: 8px; " id="tabla_export">
              <thead>
               <tr style="background-color: #b3afafab;"> 
                <th width="450px" style="padding: 4px;">PRODUCTO</th>
                <th width="150px" style="padding: 4px;">SERIAL</th>
                <th width="90px" style="padding: 4px;">EXIST.(A)</th>
                <th width="90px" style="padding: 4px;">EXIST.(B)</th>
                <th width="90px" style="padding: 4px;">CANT.</th>
                <th width="120px" style="padding: 4px;">PRECIO UNIT.</th>
                <th width="120px" style="padding: 4px;">TOTAL</th>
                <th width="135px" style="padding: 4px;">TOTAL Bs</th>
               </tr>
              </thead>
            </table>  
          </div>
        </div>    

        <div class="row">
          <div class="col-md-11">
            <table style="border-spacing: 1px; font-size: 12px;">
              <div id="item"></div>
            </table>
          </div>
        </div>
        <br><br>
        <div class="row">
          <div class="col-md-3 offset-md-6">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">USD</span>
              </div>
              <input class="form-control money" type="text" name="traslado_monto" readonly="readonly" id="traslado_monto" value="0">
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">BSS</span>
              </div>
              <input class="form-control money" type="text" id="traslado_monto_bs" readonly="readonly" value="0">
            </div>
          </div>
        </div>
        <br><br>
        <input type="submit" name="submit" id="submit" class="btn btn-primary procesar" style="margin-bottom: 15px; padding: 10px 15px;" value="GUARDAR"  />

       </div>
    </div>

</form>

  </div>
</section>
            
<script type="text/javascript">
  $( document ).ready(function() {
    $("#oproducto").hide();
    $("#depositoa").select2({ width: '100%' });

    $("#depositob").select2({ width: '100%' });

    $("#categoria_id").select2({ width: '100%' });

    $("#unidad_id").select2({ width: '100%' });

   $('.buscar').click(function() {
       $("#oproducto").show(); 
       ver();
      });
  });
 
  function ver() {
      var dida = $("#depositoa").val();
      var didb = $("#depositob").val();
      var cid = "";
      if ($("#categoria_id").val()) {    
        caid = $("#categoria_id").val();
        //// REEMPLAZAR LOS ESPACIOS EN BLANCO CON _ Y LUEGO EN PDETALLES ELIMINAR LOS _ por ESPACIOS
        cid = caid.replace(' ', '_');
        console.log(cid);
      }
      var unit = "";
      if ($("#unidad_id").val()) {
        unit = $("#unidad_id").val();
      }
      var tipo = "";
      if ($("#tipo_id").val()) {
        tipo = $("#tipo_id").val();
      }
    $('#item').hide();
    $('#item').load('<?php echo url_for('traslado_aut/pdetalles')?>?dida='+dida+'&unit='+unit+'&tipo='+tipo+'&didb='+didb+'&cid='+cid).fadeIn("slow");
  }   
  function sumar() {

    $(".qty").each(function() {
      var tasa=number_float($("#traslado_aut_tasa_cambio").val());
      var qty=number_float(this.value);
      var punit=number_float($(this).parent().parent().find('.price_unit').val());
      var total=(qty*punit);
      var unit_bs = setAndFormat(punit*tasa);
      var total_bs = setAndFormat(unit_bs*qty);
      $(this).parent().parent().find('.price_tot').val(SetMoney(total));
      $(this).parent().parent().find('.price_unit_bs').val(SetMoney(unit_bs));
      $(this).parent().parent().find('.price_tot_bs').val(SetMoney(total_bs));
    });
    var sum=0;
    $(".price_tot").each(function() {
      sum += +number_float(this.value);
    });
    var tasa=number_float($("#traslado_aut_tasa_cambio").val());
    var sum_bs=setAndFormat(sum*tasa);
    $("#traslado_monto").val(SetMoney(sum));
    $("#traslado_monto_bs").val(SetMoney(sum_bs));
    
  }
  
  function showError(id, cant) {
      $(".items").each(function() {
        var idprod=$(this).find(".iidd").val();
        if(idprod==id){
          $(this).find(".qty").addClass("is-invalid");
          $(this).find(".qty").parent().find(".error").remove();
          $(this).find(".qty").parent().append( "<div class='error'><i class='far fa-times-circle'></i><ul class='error_list'><li>La nueva cantidad ("+cant+") no se puede guardar, actualize el listado para verificar</li></ul></div>" );
        }
      });
    }

    function removeError(id, cant) {
      $(".items").each(function() {
        $(this).find(".qty").parent().find(".error").remove();
        $(this).find(".qty").removeClass("is-invalid");
      });
    } 

  $("#form_filter").submit(function( event ) {
   console.log("Evento: " + event.type);
    var sum=0;
    var cont=0;
    $(".items").each(function() {
     
      var qty = number_float($(this).find(".qty").val());
      if(qty>0) 
        sum += 1;
      });

    if(sum==0) {
      
      $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, DEBE INTRODUCIR AL MENOS 1 ITEM</div>');
      event.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, 1000);
    }
    else {
        removeError();
        var divsitems  = $('.items');
        var allitems="";
        for(var i=0; i<divsitems.length; i++){
          var element = divsitems.eq(i);
          var idprod=$(element).find(".iidd").val();
          var qty=number_float($(element).find(".qty").val());
          allitems=allitems+idprod+";"+qty+"|";
        }
       
        var json_obj = JSON.parse(Get("<?php echo url_for('traslado_aut/prefijo');?>?search="+allitems));
        if(json_obj !== "") {
          var res = json_obj.split("|");
           
          for (index = 0; index < res.length; index++) {
            if(res[index].length>1) {
              var str = res[index].split(";");
              showError(str[0],str[1]); 
            }
          }
          cont++;
        }
        if(cont>0) {
          $('#flash-error').html('<div id="alert" class="alert alert-warning alert-dismissible" style="margin: 15px 15px 0px 15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h4>ERROR, REVISA LOS DATOS INTRODUCIDOS</div>');
          event.preventDefault();
          $("html, body").animate({ scrollTop: 0 }, 1000);
        } 
      } // else

  });
</script>

<script>
  $('#loading').fadeOut( "slow", function() {});
</script>