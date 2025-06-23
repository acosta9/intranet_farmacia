<?php

require_once dirname(__FILE__).'/../lib/cajaGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/cajaGeneratorHelper.class.php';

/**
 * caja actions.
 *
 * @package    ired.localhost
 * @subpackage caja
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cajaActions extends autoCajaActions
{
  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');

    $caj = Doctrine_Core::getTable('Caja')
      ->createQuery('a')
      ->select('id as contador')
      ->Where('substr(id, 1,2) =?', $id)
      ->orderby('id DESC')
      ->fetchOne();
         $count = 0; $countcaj="";
         $count=$caj["contador"];
         if($count>0) {
         $count=substr($count, 2,2)."<br/>";
         $count=$count+1;
         $countcaj = $id.$count;
      } else {
        $countcaj=$id."1"; }

    
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($countcaj));
  }
  
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'EmpresaName':
        $sort[0] = 'ename';
        break;
      case 'TipoImp':
        $sort[0] = 'tipo';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }
  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Caja")->hasColumn($column) || $column == "TipoImp" || $column == "EmpresaName";
  }
}
