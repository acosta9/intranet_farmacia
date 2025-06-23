<?php
  if(strpos(mb_strtolower($kardex["tabla"]), "factura_compra")!== false) {

    $str=explode("#",$kardex["concepto"]);
    echo $str[0]."<a href='".url_for("factura_compra")."/".$kardex["tabla_id"]."'>"." #".$str[1]."</a>";

  } else if(strpos(mb_strtolower($kardex["tabla"]), "factura")!== false) {

    $str=explode("#",$kardex["concepto"]);
    echo $str[0]."<a href='".url_for("factura")."/".$kardex["tabla_id"]."'>"." #".$str[1]."</a>";

  } else if(strpos(mb_strtolower($kardex["tabla"]), "traslado")!== false) {

    $str=explode("#",$kardex["concepto"]);
    echo $str[0]."<a href='".url_for("traslado")."/".$kardex["tabla_id"]."'>"." #".$str[1]."</a>";

  } else if(strpos(mb_strtolower($kardex["tabla"]), "inv_entrada")!== false) {

    $str=explode("#",$kardex["concepto"]);
    echo $str[0]."<a href='".url_for("inv_entrada")."/".$kardex["tabla_id"]."'>"." #".$str[1]."</a>";

  } else if(strpos(mb_strtolower($kardex["tabla"]), "inv_salida")!== false) {

    $str=explode("#",$kardex["concepto"]);
    echo $str[0]."<a href='".url_for("inv_salida")."/".$kardex["tabla_id"]."'>"." #".$str[1]."</a>";

  } else if(strpos(mb_strtolower($kardex["tabla"]), "inv_ajuste")!== false) {

    $str=explode("#",$kardex["concepto"]);
    echo $str[0]."<a href='".url_for("inv_ajuste")."/".$kardex["tabla_id"]."'>"." #".$str[1]."</a>";
    
  } else {
    echo $kardex["concepto"];
  }
?>