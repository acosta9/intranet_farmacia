<?php

/**
 * turnover actions.
 *
 * @package    ired.localhost
 * @subpackage turnover
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class turnoverActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request){    
  }

  public function executeResult(sfWebRequest $request){    
  }

  public function executeDetalles(sfWebRequest $request){    
  }

  public function executeMinimo(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());

    $id=$request->getParameter('id');
    $min=$request->getParameter('min');

    $inventario = Doctrine_Core::getTable('Inventario')->findOneBy('id', $id);
    $inventario->limite_stock=$min;
    $inventario->save();
    
    return $this->renderText("success");
  }

  public function executeProveedor(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());

    $pid=$request->getParameter('pid');
    $provId=$request->getParameter('provId');
    $uid=$this->getUser()->getGuardUser()->getId();

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $error = $q->execute("REPLACE INTO turnover (producto_id, proveedor_id, created_at, updated_at, created_by, updated_by) 
      VALUES ($pid, $provId, now(), now(), $uid, $uid); ");
    
    return $this->renderText("success");
  }

  public function executeGetProductos(sfWebRequest $request){
    $search=$request->getParameter('search');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.nombre LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.nombre LIKE '%".$word."%' || p.serial LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial 
    FROM producto p where $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"]." [".$result["serial"]."]";
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executeGetProveedor(sfWebRequest $request){
    $search=$request->getParameter('search');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.doc_id LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.full_name LIKE '%".$word."%' || p.doc_id LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.full_name LIKE '%".$word."%' || p.doc_id LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, lower(p.full_name) as pname, p.doc_id as serial 
    FROM proveedor p where $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=ucwords($result["pname"]);
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executeDeposito(sfWebRequest $request){
  }

  public function executeReporte(sfWebRequest $request){
  }
}
