<?php

require_once dirname(__FILE__).'/../lib/rankingGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/rankingGeneratorHelper.class.php';

/**
 * ranking actions.
 *
 * @package    ired.localhost
 * @subpackage ranking
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rankingActions extends autoRankingActions
{
  public function executeIndex(sfWebRequest $request) {
    $producto="";
    if(!empty($this->getFilters()["producto"])) {
      $arr=$this->getFilters()["producto"];
      foreach ($arr as $index) {
        $prod=Doctrine_Core::getTable('Producto')->findOneBy('id',$index);
        $producto= $producto.$prod->getId()."|".$prod->getNombre()." [".$prod->getSerial()."];";
      }
    }

    $laboratorio="";
    if(!empty($this->getFilters()["laboratorio_id"])) {
      $arr=$this->getFilters()["laboratorio_id"];
      $lab=Doctrine_Core::getTable('ProdLaboratorio')->findOneBy('id',$arr);
      $laboratorio= $laboratorio.$lab->getId()."|".$lab->getNombre().";";      
    }

    /*echo $producto; die();

    var_dump($this->getFilters()["producto"]); die();*/
   
    // searching
    if ($request->hasParameter('search'))
    {
      $this->setSearch($request->getParameter('search'));
      $request->setParameter('page', 1);
    }
  
    // filtering
    if ($request->getParameter('filters'))
    {
      $this->setFilters($request->getParameter('filters'));
    }
    
    // sorting
    if ($request->getParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

	  //maxPerPage
    if ($request->getParameter('maxPerPage'))
    {
      $this->setMaxPerPage($request->getParameter('maxPerPage'));
      $this->setPage(1);
    }
	
	
    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
    $this->prods = $producto;
    $this->labs = $laboratorio;

    if ($request->isXmlHttpRequest())
    {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));
      
      if ($request->hasParameter('search'))
      {
        $partialSearch = $this->getPartial('prod_vendidos_ranking/search', array('configuration' => $this->configuration));
      }
      
      if ($request->hasParameter('_reset')) 
      {
        $partialFilter = $this->getPartial('prod_vendidos_ranking/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      
      $partialList = $this->getPartial('prod_vendidos_ranking/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      
      if (isset($partialSearch)) 
      {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter))
      {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
  }

  public function executeDepositoFilters(sfWebRequest $request){
  }
  
  public function executeDelete(sfWebRequest $request){
		$this->redirect('prod_vendidos_ranking');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->redirect('prod_vendidos_ranking');
	}

	public function executeNew(sfWebRequest $request) {
		$this->redirect('prod_vendidos_ranking');
	}

  public function executeBatchReporteGeneral(sfWebRequest $request) {
    if ($request->getParameter('filters'))  {
      $this->setFilters($request->getParameter('filters'));
    }

    $this->setMaxPerPage("1000");
    $this->setPage(1);
    $this->pager = $this->getPager();
    $this->prod_vendidos=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
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
  
  public function executeGetCompuestos(sfWebRequest $request){
    $search=$request->getParameter('search');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.nombre LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.nombre LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.nombre LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname
    FROM compuesto p where $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"];
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executeGetLaboratorios(sfWebRequest $request){
    $search=$request->getParameter('search');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.nombre LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.nombre LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.nombre LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname
    FROM prod_laboratorio p where $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"];
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }
}
