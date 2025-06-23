<?php

/**
 * comparar_depositos actions.
 *
 * @package    ired.localhost
 * @subpackage comparar_depositos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class traslado_autActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request){
    $this->redirect('traslado');
  }
  public function executeReporte(sfWebRequest $request){
  }
  public function executePdetalles(sfWebRequest $request) {
  }
  public function executePrefijo(sfWebRequest $request){
    $search=$request->getParameter('search');
    $arr=explode("|",$search);
    $exit="";
    foreach ($arr as $det) {
      if(strlen($det)>1) {
        list($iid, $qty)=explode(";",$det);
        $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $iid);
        $valor=$inventario->getCantidad();
        $valor-=$qty;
        if($valor<0) {
          $exit=$exit.$iid.";".$valor."|";
        }
      }
    }
    
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($exit));
  }
  public function executeProcesar(sfWebRequest $request){
   $userid = $this->getUser()->getGuardUser()->getId();
   $empresa_desde = substr($request->getParameter('depositoa'), 0,2);
   $deposito_desde = $request->getParameter('depositoa');
   $empresa_hasta = substr($request->getParameter('depositob'), 0,2);
   $deposito_hasta = $request->getParameter('depositob');
   $tasa_cambio = $request->getParameter('traslado_aut_tasa_cambio');
   $montoa = $request->getParameter('traslado_monto');
   $monto = str_replace(",", ".", $montoa);
  

    $tras = Doctrine_Core::getTable('Traslado')
         ->createQuery('a')
         ->select('id as contador')
         ->Where('substr(id, 1,2) =?', $empresa_desde)
         ->orderby('id DESC')
         ->limit(1)
         ->fetchOne();
         $count = 0;$counttras="";
         $count=$tras["contador"];
         if($count>0) {
         $count=substr($count, 2,6)."<br/>";
         $count=$count+1;
         $counttras = $empresa_desde.$count;
         } else {
         $counttras=$empresa_desde."1"; }

    $traslado = new Traslado();

    
    $traslado->id = $counttras;
    $traslado->empresa_desde = $empresa_desde;
    $traslado->empresa_hasta = $empresa_hasta;
    $traslado->deposito_desde = $deposito_desde;
    $traslado->deposito_hasta = $deposito_hasta;
    $traslado->estatus = 1;
    $traslado->tasa_cambio = $tasa_cambio;
    $traslado->monto = $monto;
    $traslado->save();

    $i=1; // ojo  exento=

    
    while (!empty($request->getParameter('iidd_'.$i.''))) {
       if(intval($request->getParameter('qty_'.$i.''))>0) {
         $traslado_det = new TrasladoDet();
       
         $iidd=$request->getParameter('iidd_'.$i.'');
         $qty=intval($request->getParameter('qty_'.$i.''));
         $pid=$request->getParameter('pid_'.$i.'');
         $price_unita = $request->getParameter('price_unit_'.$i.'');
         $price_unit = str_replace(",", ".", $price_unita);
         $price_tota = $request->getParameter('price_tot_'.$i.'');
         $price_tot = str_replace(",", ".", $price_tota);
         ////// Descuento del inventario origen /////////
         $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $iidd);
         $desc=$inventario->restarInventario($qty);

         
         $traslado_det->traslado_id = $counttras; 
         $traslado_det->producto_id = $request->getParameter('pid_'.$i.'');
         $traslado_det->inventario_id = $request->getParameter('iidd_'.$i.'');
         $traslado_det->qty = $qty;   //$request->getParameter('existenciaa_'.$i.'');
        // $traslado_det->inv_destino_id = $request->getParameter('iidh_'.$i.'');
        // $traslado_det->qty_dest = $qty;
         $traslado_det->price_unit = $price_unit;
         $traslado_det->price_tot = $price_tot;
         $traslado_det->descripcion=$desc;
         $traslado_det->exento="EXENTO";
         $traslado_det->save();
         
         } 
       $i++;
     } // while 
     
     $this->getUser()->setFlash('notice', 'El traslado se ha realizado correctamente');
    // $this->redirect('@traslado');
     $this->redirect('/index.php/traslado/'.$counttras.'/show');

   
  } 
}
