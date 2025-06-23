<?php

require_once dirname(__FILE__).'/../lib/kardexGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/kardexGeneratorHelper.class.php';

/**
 * kardex actions.
 *
 * @package    ired.localhost
 * @subpackage kardex
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class kardexActions extends autoKardexActions
{
  public function executeIndex(sfWebRequest $request) {
    $producto="";
    if(!empty($this->getFilters()["producto"])) {
      $index=$this->getFilters()["producto"];
      $prod=Doctrine_Core::getTable('Producto')->findOneBy('id',$index);
      $producto= $prod->getId()."|".$prod->getNombre()." [".$prod->getSerial()."];";
    } else {
      $prod = Doctrine_Query::create()
        ->select('k.id as kid, p.id as pid, p.nombre as pname, p.serial as serial')
        ->from('Kardex k')
        ->leftJoin('k.Producto p')
        ->orderBy('RAND()')
        ->limit(1)
        ->fetchOne();
      $producto= $prod["pid"]."|".$prod["pname"]." [".$prod["serial"]."];";
    }
   
    if ($request->hasParameter('search')) {
      $this->setSearch($request->getParameter('search'));
      $request->setParameter('page', 1);
    }
  
    if ($request->getParameter('filters')) {
      $this->setFilters($request->getParameter('filters'));
    }
    
    if ($request->getParameter('sort')) {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    if ($request->getParameter('maxPerPage')) {
      $this->setMaxPerPage($request->getParameter('maxPerPage'));
      $this->setPage(1);
    }
	
	  if ($request->getParameter('page')) {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
    $this->prods = $producto;

    if ($request->isXmlHttpRequest()) {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));
      
      if ($request->hasParameter('search')) {
        $partialSearch = $this->getPartial('kardex/search', array('configuration' => $this->configuration));
      }
      
      if ($request->hasParameter('_reset'))  {
        $partialFilter = $this->getPartial('kardex/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      
      $partialList = $this->getPartial('kardex/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
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

  public function executeDepositoFilters(sfWebRequest $request){
  }
  
  public function executeDelete(sfWebRequest $request){
		$this->redirect('kardex');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->redirect('kardex');
	}

	public function executeNew(sfWebRequest $request) {
		$this->redirect('kardex');
	}
  public function executeBatchReporteFirst(sfWebRequest $request) {
    // filtering
    $this->setMaxPerPage("900");
    $this->setPage(1);
    $this->pager = $this->getPager();
    $this->kardexs=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }
}
