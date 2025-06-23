<?php

/**
 * safety_stock actions.
 *
 * @package    ired.localhost
 * @subpackage safety_stock
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class safety_stock_farmacia_configActions extends sfActions
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
  
  public function executeGetCorreos(sfWebRequest $request){
    $search=$request->getParameter('search');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(sfgu.email_address LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(sfgu.email_address LIKE '%".$word."%' || sfgu.full_name LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (sfgu.email_address LIKE '%".$word."%' || sfgu.full_name LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT sfgu.email_address as email, sfgu.full_name as name
    FROM sf_guard_user sfgu where $sql
    ORDER BY name ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["email"]]=$result["name"]." [".$result["email"]."]";
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }
}
