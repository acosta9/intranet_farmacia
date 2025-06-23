<?php

/**
 * gcaja actions.
 *
 * @package    ired.localhost
 * @subpackage gcaja
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gcajaActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
   
  }
   public function executeCierre(sfWebRequest $request)
  {
   
  }
  public function executeGestionar(sfWebRequest $request){
  }
  public function executeCaja(sfWebRequest $request){
  }
  public function executeValidarc(sfWebRequest $request){

     $userid = $this->getUser()->getGuardUser()->getId();
     $super = $request->getParameter('supervisor');
     $clave = $request->getParameter('clave');
     $hay=0;

     $userids=Doctrine_Core::getTable('SfGuardUser')->findOneBy('username',$super);
     if($userids->getClave()==$clave)
      $hay=1;
     
      $this->getResponse()->setContentType('application/json');
      return $this->renderText(json_encode($hay));
  }

  public function executeAbrirdet(sfWebRequest $request){
    $userid = $this->getUser()->getGuardUser()->getId();
    $caja_id = $request->getParameter('caja_id');
    $date = date("Y-m-d H:i_s");
    $caja = Doctrine_Core::getTable('Caja')->findOneBy('id',$caja_id);
    /// Valido el tipo de caja para chequear estatus de la fiscal  ///
      $tipo=  $caja->getTipo();
      if($tipo == true) {
        /// chequeo impresora ///
        include_once ("TfhkaPHP.php");
        $itObj = new Tfhka();
        $out= " ";
        $out =  $itObj->CheckFprinter();
        /// falta leer el estatus para dejarlo continuar o sacarlo con mensaje ///
        $leerst = file('/IntTFHKA/Status_Error.txt');
          $stimps = array($leerst);
          foreach ($stimps as $stimp) {
            $st=$stimp[0];
           } 
           if (substr($st,0,1) == "F") {
            $this->getUser()->setFlash('error', 'La impresora fiscal no responde, chequee el puerto'); 
            $this->redirect('/');
          }
      } // validacion si es impresora fiscal
      

    /// Valido que la caja que se está abriendo en esa estación de trabajo sea la correcta  ///

    $leerca = file('/IntTFHKA/Caja.txt');
          $stcajas = array($leerca);
          foreach ($stcajas as $stcaja) {
            $estacion=$stcaja[0];
           } 
         
       if($estacion>0) { //echo "estacion      ".abs($estacion)."caja".abs($caja_id); 
       if(abs($estacion) != abs($caja_id)) {//echo "entra"; die();
        $this->getUser()->setFlash('error', 'La caja seleccionada no corresponde a la estación de trabajo'); 
        $this->redirect('/');
        }
      }

    /// validación estación de trabajo vs caja ///


    $user_det = Doctrine_Query::create()
      ->select('cd.*')
      ->from('CajaDet cd')
      ->Where('cd.sf_guard_user_id = ?', $userid)
      ->orderBy('cd.id DESC')
      ->limit(1)
      ->fetchOne(); 
      if($user_det) {
       if($user_det->getStatus()==true) {
        $this->getUser()->setFlash('error', 'Ya usted abrió operaciones en otra caja'); 
        $this->redirect('/');
        }
      }
    
     $caja->status = 1;
     $caja->save(); 

     $caja_det = new CajaDet();
    
      $caja_det->caja_id = $caja_id;
      $caja_det->sf_guard_user_id = $userid;
      $caja_det->status = 1;
      $caja_det->fecha = $date;
      $caja_det->fondo = $request->getParameter('fondo_det');
      $caja_det->descripcion = $request->getParameter('desc_det');
      $caja_det->save();

      $this->getUser()->setFlash('notice', 'La caja se aperturó correctamente, puede comenzar a facturar'); 
      $this->redirect('pventa');
  }
 
  public function executeHeader(sfWebRequest $request){
  }
  public function executeHeaderc(sfWebRequest $request){
  }
  public function executeVerheader(sfWebRequest $request){
  }
  public function executeDia(sfWebRequest $request){
  }
  public function executeDiac(sfWebRequest $request){
  }
  public function executeReportes(sfWebRequest $request){
  }
  public function executeAefectivo(sfWebRequest $request) {
     $this->forward404unless($request->isXmlHttpRequest());
   
     return $this->renderPartial('gcaja/aefectivo',array('num' => $request->getParameter('num'),'cid' => $request->getParameter('cid')));
  }

 
  public function executeProcesar(sfWebRequest $request){
  $userid = $this->getUser()->getGuardUser()->getId();
  $caja_id = $request->getParameter('caja_id'); 
  $date = date("Y-m-d H:i:s");
  $caja = Doctrine_Core::getTable('Caja')->findOneBy('id',$caja_id);
  $datos ="";
  $dia = date("Y-m-d");    // $dia="2020-10-27";

  //////// Busco la ultima fecha en que se abrio la Caja para cerrar con esa fecha de apertura ///////

    $cadet = Doctrine_Query::create()
      ->select('cdet.id, cdet.fecha, cdet.status')
      ->from('CajaDet cdet')
      ->Where('cdet.caja_id =?', $caja_id)
      ->orderBy('cdet.id DESC')
      ->limit(1)
      ->fetchOne();
      if(substr($cadet->getFecha(), 0,10)==$dia)
        $dia=$dia;
      else
        $dia=substr($cadet->getFecha(), 0,10);


    /// Valido el tipo de caja para chequear estatus de la fiscal  ///
      $tipo=  $caja->getTipo();
       if($tipo == true) {  
        /// chequeo impresora ///
        include_once ("TfhkaPHP.php");
        $itObj = new Tfhka();
        $out= " ";
        $out =  $itObj->CheckFprinter();
        /// falta leer el estatus para dejarlo continuar o sacarlo con mensaje ///
        $leerst = file('/IntTFHKA/Status_Error.txt');
          $stimps = array($leerst);
          foreach ($stimps as $stimp) {
            $st=$stimp[0];
           } 
           if (substr($st,0,1) == "F") {
            $this->getUser()->setFlash('error', 'La impresora fiscal no responde, chequee el puerto'); 
            $this->redirect('/');
          
          }
      } // validacion si es impresora fiscal
 
 
   /// Valido que la caja que se está abriendo en esa estación de trabajo sea la correcta  ///

    $leerca = file('/IntTFHKA/Caja.txt');
          $stcajas = array($leerca);
          foreach ($stcajas as $stcaja) {
            $estacion=$stcaja[0];
           } 
         
       if($estacion) { // echo " que trae el array    ".$estacion; die();
       if(trim($estacion)!=$caja_id) {
        $this->getUser()->setFlash('error', 'La caja seleccionada no corresponde a la estación de trabajo'); 
        $this->redirect('gcaja');
        
        }
      }

    /// validación estación de trabajo vs caja ///
 
     
    $caja_det = new CajaDet();
    
    $caja_det->caja_id = $caja_id;
    $caja_det->sf_guard_user_id = $userid;
    $caja_det->status = 0;
    $caja_det->fecha = $date;
    $caja_det->fondo = $request->getParameter('mfondo2');
    $caja_det->descripcion = $request->getParameter('mdescripcion2');
    $caja_det->save();       

    // Ingreso de totales del día //

    $aa10001 = $request->getParameter('aa10001');
    if($aa10001 != "" || $aa10001 != 0 || $aa10001 != 0.0 || $aa10001 != 0.00){
       $caja_arqueo = new CajaArqueo();
       $caja_arqueo->caja_id = $caja_id;
       $caja_arqueo->sf_guard_user_id = $userid;
       $caja_arqueo->fecha = $dia;
       $caja_arqueo->moneda = 1;
       $caja_arqueo->forma_pago_id = 10001;
       $caja_arqueo->monto = $aa10001;
       $caja_arqueo->save();
    }
    $aa10002 = $request->getParameter('aa10002');
    if($aa10002 != "" || $aa10002 != 0 || $aa10002 != 0.0 || $aa10002 != 0.00){
       $caja_arqueo = new CajaArqueo();
       $caja_arqueo->caja_id = $caja_id;
       $caja_arqueo->sf_guard_user_id = $userid;
       $caja_arqueo->fecha = $dia;
       $caja_arqueo->moneda = 1;
       $caja_arqueo->forma_pago_id = 10002;
       $caja_arqueo->monto = $aa10002;
       $caja_arqueo->save();
    }
    $aa10003 = $request->getParameter('aa10003');
    if($aa10003 != "" || $aa10003 != 0 || $aa10003 != 0.0 || $aa10003 != 0.00){
       $caja_arqueo = new CajaArqueo();
       $caja_arqueo->caja_id = $caja_id;
       $caja_arqueo->sf_guard_user_id = $userid;
       $caja_arqueo->fecha = $dia;
       $caja_arqueo->moneda = 1;
       $caja_arqueo->forma_pago_id = 10003;
       $caja_arqueo->monto = $aa10003;
       $caja_arqueo->save();
    }
    $aa10004 = $request->getParameter('aa10004');
    if($aa10004 != "" || $aa10004 != 0 || $aa10004 != 0.0 || $aa10004 != 0.00){
       $caja_arqueo = new CajaArqueo();
       $caja_arqueo->caja_id = $caja_id;
       $caja_arqueo->sf_guard_user_id = $userid;
       $caja_arqueo->fecha = $dia;
       $caja_arqueo->moneda = 1;
       $caja_arqueo->forma_pago_id = 10004;
       $caja_arqueo->monto = $aa10004;
       $caja_arqueo->save();
    }
    $aa10005 = $request->getParameter('aa10005');
    if($aa10005 != "" || $aa10005 != 0 || $aa10005 != 0.0 || $aa10005 != 0.00){
       $caja_arqueo = new CajaArqueo();
       $caja_arqueo->caja_id = $caja_id;
       $caja_arqueo->sf_guard_user_id = $userid;
       $caja_arqueo->fecha = $dia;
       $caja_arqueo->moneda = 1;
       $caja_arqueo->forma_pago_id = 10005;
       $caja_arqueo->monto = $aa10005;
       $caja_arqueo->save();
    }
    $aa10006 = $request->getParameter('aa10006');
    if($aa10006 != "" || $aa10006 != 0 || $aa10006 != 0.0 || $aa10006 != 0.00){
       $caja_arqueo = new CajaArqueo();
       $caja_arqueo->caja_id = $caja_id;
       $caja_arqueo->sf_guard_user_id = $userid;
       $caja_arqueo->fecha = $dia;
       $caja_arqueo->moneda = 1;
       $caja_arqueo->forma_pago_id = 10006;
       $caja_arqueo->monto = $aa10006;
       $caja_arqueo->save();
    }
     $aa10011 = $request->getParameter('aa10011');
    if($aa10011 != "" || $aa10011 != 0 || $aa10011 != 0.0 || $aa10011 != 0.00){
       $caja_arqueo = new CajaArqueo();
       $caja_arqueo->caja_id = $caja_id;
       $caja_arqueo->sf_guard_user_id = $userid;
       $caja_arqueo->fecha = $dia;
       $caja_arqueo->moneda = 2;
       $caja_arqueo->forma_pago_id = 10011;
       $caja_arqueo->monto = $aa10011;
       $caja_arqueo->save();
    }
    $aa10012 = $request->getParameter('aa10012');
    if($aa10012 != "" || $aa10012 != 0 || $aa10012 != 0.0 || $aa10012 != 0.00){
       $caja_arqueo = new CajaArqueo();
       $caja_arqueo->caja_id = $caja_id;
       $caja_arqueo->sf_guard_user_id = $userid;
       $caja_arqueo->fecha = $dia;
       $caja_arqueo->moneda = 2;
       $caja_arqueo->forma_pago_id = 10012;
       $caja_arqueo->monto = $aa10012;
       $caja_arqueo->save();
    }
    $aa10013 = $request->getParameter('aa10013');
    if($aa10013 != "" || $aa10013 != 0 || $aa10013 != 0.0 || $aa10013 != 0.00){
       $caja_arqueo = new CajaArqueo();
       $caja_arqueo->caja_id = $caja_id;
       $caja_arqueo->sf_guard_user_id = $userid;
       $caja_arqueo->fecha = $dia;
       $caja_arqueo->moneda = 2;
       $caja_arqueo->forma_pago_id = 10013;
       $caja_arqueo->monto = $aa10013;
       $caja_arqueo->save();
    }

    /// Ingreso de efectivo ////
     
  // Cantidad de billetes 
    $nitems2 = $request->getParameter('num_items2');
  if($nitems2 >= 1)
  {  
    for($i=1; $i<=$nitems2; $i++)
    {  

        // Inserto la informacion enviada por el formulario
    
         $moneda =  $request->getParameter('moneda_'.$i.'');
         $billete =  $request->getParameter('billete_'.$i.'');
         $cantidad =  $request->getParameter('cantidad_'.$i.'');

         if($billete && $cantidad){
           $caja_efectivo = new CajaEfectivo();
           $caja_efectivo->caja_id = $caja_id; 
           $caja_efectivo->sf_guard_user_id = $userid;
           $caja_efectivo->fecha = $dia;
           $caja_efectivo->moneda = $moneda;
           $caja_efectivo->billete=$billete;
           $caja_efectivo->cantidad=$cantidad;
           $caja_efectivo->save();
         }
        }
      }
      /// fin caja_efectivo ////

      /// busco la fecha hora de inicio de la caja la primera vez del dia ////
      
      $detz = Doctrine_Query::create()
      ->select('cd.id, cd.fecha as fecha_in')
      ->from('CajaDet cd')
      ->where('cd.caja_id = ?', $caja_id)
      ->andWhere('DATE_FORMAT(cd.fecha, "%Y-%m-%d") = ?', $dia)
      ->andWhere('cd.status = ?', 1)
      ->orderBy('cd.id DESC')
      ->limit(1)
      ->fetchOne(); 
      if($detz)
      $fecha_in=$detz->getFechaIn();
         
      ////////////////////////////////////////////////////////////////////////

      // si es fiscal mando el comando para el corte z ///
       if($tipo == true || $tipo == 1) { 
        /// chequeo impresora ///
        include_once ("TfhkaPHP.php");
        $itObj = new Tfhka();
        $out= " ";
        $out =  $itObj->SendCmd("I0Z");
        $out =  $itObj->UploadReportCmd("U0Z" , "/IntTFHKA/ReportData.txt"); 
        /// falta leer el estatus para dejarlo continuar o sacarlo con mensaje ///
        $leercz = file('/IntTFHKA/Reporte.txt');
          $cortzs = array($leercz);
         foreach ($cortzs as $cortz) {

            $dataz=$cortz[0];   // ojo validar
            $ult_repz=substr($dataz, 0, 4);
            $fecha_repz=substr($dataz, 4, 6);
            $hora_repz=substr($dataz, 10, 4);
            $ult_fact=substr($dataz, 14, 8);
            $fecha_ult_fact=substr($dataz, 22, 6);
            $hora_ult_fact=substr($dataz, 28, 4);
            $ult_nc=substr($dataz, 40, 8);
            $exento_fact=substr($dataz, 56, 18);
            $base_impt1_fact=substr($dataz, 74, 18);
            $iva_t1_fact=substr($dataz, 92, 18);
            $exento_nc=substr($dataz, 308, 18);
            $base_impt1_nc=substr($dataz, 326, 18);
            $iva_t1_nc=substr($dataz, 344, 18);
           } 
           // busco el codigo de maq fiscal que no me lo muestra el reporte z
            $out =  $itObj->UploadStatusCmd("S1", "/IntTFHKA/StatusData.txt");
            $leers1 = file('/IntTFHKA/Status.txt');
            $stuffs = array($leers1);
            foreach ($stuffs as $stuff) {
              $stat=$stuff[0];
            }
            $cant_factf=substr($stat, 29, 5); 
            $cod_imp=substr($stat, 92, 10);
            $cant_nc=substr($stat, 96, 5); 
            ////////////////////// fin busqueda codigo fiscal ///////////////
           if (!$dataz) {
            $this->getUser()->setFlash('error', 'La impresora fiscal no responde, chequee el puerto'); 
            $this->redirect('/');
            
          }

          /////// inserto en caja_corte z///////////////

          $caja_corte = new CajaCorte();
        
          $caja_corte->caja_id = $caja_id;
          $caja_corte->sf_guard_user_id = $userid;
          $caja_corte->tipo = 1;
          $caja_corte->fecha_ini = $fecha_in;
          $caja_corte->fecha_fin = $date;
          ////// campos de la fiscal //////
          $caja_corte->ult_repz= $ult_repz;
          $caja_corte->fecha_repz=$fecha_repz;
          $caja_corte->hora_repz=$hora_repz;
          $caja_corte->ult_fact=$ult_fact;
          $caja_corte->fecha_ult_fact=$fecha_ult_fact;
          $caja_corte->hora_ult_fact=$hora_ult_fact;
          $caja_corte->ult_nc=$ult_nc;
          $caja_corte->exento_fact=$exento_fact;
          $caja_corte->base_impt1_fact=$base_impt1_fact;
          $caja_corte->iva_t1_fact=$iva_t1_fact;
          $caja_corte->exento_nc=$exento_nc;
          $caja_corte->base_impt1_nc=$base_impt1_nc;
          $caja_corte->iva_t1_nc=$iva_t1_nc;
          $caja_corte->codigof=$cod_imp;
          $caja_corte->cant_fact=$cant_factf;
          $caja_corte->cant_nc=$cant_nc;
          
          ////// fin campos fiscal ///////
          $caja_corte->save();

      } // es impresora fiscal y es z
      else  // no es fiscal
      { // busco la informacion en factura y la guardo para luego sacar un reporte z
        
        $sum_exento=0;$abi=0;$amiva=0;$f=0; 
        $facts = Doctrine_Query::create()
            ->select('f.id as fid, f.caja_id as cid, f.ndespacho as nfactura, f.iva as fiva, f.created_at as fcreacion')
            ->from('Factura f')
            ->where('f.caja_id = ?', $caja_id)
            ->andWhere('f.fecha = ?', $dia)
            ->orderBy('f.id ASC')
            ->execute(); 
           foreach ($facts as $fact) { 
            $f++;
           $nfactura=$fact["nfactura"];
           $fcreacion=$fact["fcreacion"];
           $fid=$fact["fid"];
           $fiva=$fact["fiva"]; 
           if($facts) {

            $dets = Doctrine_Query::create()
            ->select('fd.id as fdid, fd.factura_id as fdfid, fd.exento as exento, fd.qty, fd.price_unit, fd.price_tot, fd.tasa_cambio')
            ->from('FacturaDet fd')
            ->where('fd.factura_id = ?', $fid)
            ->orderBy('fd.id ASC')
            ->execute(); 
           foreach ($dets as $det) {  
              $bi=0;$miva=0;
              $exento="G"; 
              $tasac = str_replace(" ", "", $det["tasa_cambio"]);
              $tcambio = str_replace(" ", "", $tasac);
              $tacambio1 = str_replace(',', '', $tcambio); 
              $tasa =  floatval($tacambio1); 


              $pricet = str_replace(" ", "", $det["price_tot"]);
              
               if($det["exento"]=="EXENTO") {
                $exento="E";
                $sum_exento=round($sum_exento+($pricet*$tasa),4);
               
              } else {
                $bi=round(($pricet*$tasa),4);
                $abi=round(($abi+$bi),4);
                if($fiva>0) {
                $miva=round(($fiva*$bi)/100,4); 
                $amiva=round(($amiva+$miva),4); }
                // ojo debo redondear a 2 decimales?
              }
           } // foreach dets
         }
         } // foreach facts   

         // busco la informacion en devolver y la guargardo para luego sacar un reporte z
       
        $sum_exento_nc=0;$bi_nc=0;$miva_nc=0;$abi_nc=0;$amiva_nc=0;$nc=0;$ult_nc="";
        $devs = Doctrine_Query::create()
            ->select('d.id as did, d.factura_id as dfid, d.empresa_id as deid, d.created_at as dcreacion, f.id as fid, f.caja_id as cid, f.iva as diva')
            ->from('Factura f')
            ->leftJoin('f.Devolver d')
            ->where('f.caja_id = ?', $caja_id)
            ->andWhere('d.fecha = ?', $dia)
            ->orderBy('d.id ASC')
            ->execute(); 
           foreach ($devs as $dev) { 
           $nc++;
           $dcreacion=$dev["dcreacion"];
           $did=$dev["did"];
           $empresa_id=$dev["deid"];
           $diva=$dev["diva"]; 
           if($devs) {

            $det_devs = Doctrine_Query::create()
            ->select('dd.id as ddid, dd.devolver_id as ddfid, dd.exento as dexento, dd.qty, dd.price_unit, dd.price_tot, dd.tasa_cambio')
            ->from('DevolverDet dd')
            ->where('dd.devolver_id = ?', $did)
            ->orderBy('dd.id ASC')
            ->execute(); 
           foreach ($det_devs as $det_dev) { 
              $exento="G"; 
              //$tasa=$det_dev["tasa_cambio"];
              $tasadev = str_replace(" ", "", $det_dev["tasa_cambio"]);
              $tacambiod = str_replace(',', '', $tasadev); 
              $tasad =  floatval($tacambiod); 

               if($det_dev["exento"]=="EXENTO") {
                $exento="E";
                $sum_exento_nc=round(($sum_exento_nc+($det_dev["price_tot"]*$tasad)),4);
              } else {
                $bi_nc=round(($det_dev["price_tot"]*$tasad),4);
                $abi_nc=round(($abi_nc+$bi_nc),4);
                if($diva>0) {
                 $miva_nc=round(($diva*$bi_nc)/100, 4);
                 $amiva_nc=round(($amiva_nc+$miva_nc),4); }// ojo debo redondear a 2 decimales?
              }
           } // foreach dets
         }
         } // foreach facts 

         // Falta buscar la ultima nc de esta caja en este día
         $cxcs = Doctrine_Query::create()
            ->select('cc.id as ccid, cc.fecha as ccfecha, cc.factura_id as ccfid, f.caja_id as cid')
            ->from('Factura f, f.CuentasCobrar cc')
            ->where('f.caja_id = ?', $caja_id)
            ->andWhere('cc.fecha = ?', $dia)
            ->orderBy('cc.id ASC')
            ->execute(); 
           foreach ($cxcs as $cxc) { 
            $ccid=$cxc["ccid"]; 
           
            $ncs = Doctrine_Query::create()
            ->select('nc.id as ncid, nc.ncontrol as ncncontrol, dnc.id as dncid, dnc.cuentas_cobrar_id as dncccid')
            ->from('NotaCredito nc, nc.NotaCreditoDet dnc')
            ->where('dnc.cuentas_cobrar_id = ?', $ccid)
            ->orderBy('nc.id DESC')
            ->limit(1)
            ->fetchOne();
           $ult_nc1=$ncs["ncncontrol"];
           if($ult_nc1)
            $ult_nc=$ncs["ncncontrol"];
           }
           
      /////// inserto en caja_corte z///////////////
        $fech_ult_fact=substr($fcreacion, 0,10);
        $hor_ult_fact=substr($fcreacion, 11,5);
        $fecha_ult_fact = str_replace("-", "", $fech_ult_fact);
        $hora_ult_fact = str_replace(":", "", $hor_ult_fact); 
        $caja_corte = new CajaCorte();
        $caja_corte->caja_id = $caja_id;
        $caja_corte->sf_guard_user_id = $userid;
        $caja_corte->tipo = 1;
        $caja_corte->fecha_ini = $fecha_in;
        $caja_corte->fecha_fin = $date;
        $caja_corte->ult_fact=$nfactura;
        $caja_corte->fecha_ult_fact=$fecha_ult_fact;
        $caja_corte->hora_ult_fact=$hora_ult_fact;
        $caja_corte->exento_fact=$sum_exento;
        $caja_corte->base_impt1_fact=$abi;
        $caja_corte->iva_t1_fact=$amiva;
        if($devs) {
        $caja_corte->ult_nc=$ult_nc;
        $caja_corte->exento_nc=$sum_exento_nc;
        $caja_corte->base_impt1_nc=$abi_nc;
        $caja_corte->iva_t1_nc=$amiva_nc;
        }

        $caja_corte->cant_fact=$f;
        $caja_corte->cant_nc=$nc;
        $caja_corte->save();
    }
    
  
      // cambio estatus de la caja  //
      $caja->status = $status;
      $caja->save();

      if($tipo==0 || $tipo== false){ 
        // lo envio al reporte para la impresora termica; 
         $this->redirect('gcaja/printz?caja_id='.$caja_id); 
      } 
      else {
        $this->getUser()->setFlash('notice', 'La caja se cerró correctamente');
        $this->redirect('/');
      }

       
  }
 
  public function executeImprimir(sfWebRequest $request){
   $idz=$request->getParameter('idz');
   $datos=$idz;
  
    $this->redirect('gcaja/print?idz='.$idz); 
   
  }
 public function executeImprimirz(sfWebRequest $request){
   $id=$request->getParameter('id');
  
    $this->redirect('gcaja/arqueo?id='.$id); 
     
  }
 public function executeImprimirf(sfWebRequest $request){
    $id=$request->getParameter('cid').";".$request->getParameter('fecha');
  
    $this->redirect('gcaja/facturas?cid='.$id); 
     
  } 
 public function executePrint(sfWebRequest $request){
 }
 public function executePrintz(sfWebRequest $request){
 }
 public function executeArqueo(sfWebRequest $request){
 }
 public function executeMaestrov(sfWebRequest $request){
 }
 public function executeMaestro(sfWebRequest $request){

   
   $fechas=$request->getParameter('fini').$request->getParameter('ffin');
   //$ffin=$request->getParameter('ffin');
  
    $this->redirect('gcaja/maestrov?id='.$fechas); 
    
  }
 public function executeVentas(sfWebRequest $request){
 } 
 public function executeRecibo(sfWebRequest $request){
 }
 public function executeVfallas(sfWebRequest $request){

   
   $fechas=$request->getParameter('fini').$request->getParameter('ffin');
   //$ffin=$request->getParameter('ffin');
  
    $this->redirect('gcaja/fallas?id='.$fechas); 
    
  }
 public function executeFallas(sfWebRequest $request){
 }
 public function executeFacturas(sfWebRequest $request){
 } 
 public function executeCola(sfWebRequest $request){
    $ya=0; 
    
    $vcola = Doctrine_Core::getTable('CajaCola')
         ->createQuery('a')
         ->select('COUNT(caja_id) as cant, fecha_hr as fe')
         ->fetchOne();
         
         $vcola->delete(); 
         $ya=1; 
       

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($ya));
  }
}
