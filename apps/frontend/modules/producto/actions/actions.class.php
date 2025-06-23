<?php

require_once dirname(__FILE__).'/../lib/productoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/productoGeneratorHelper.class.php';

/**
 * producto actions.
 *
 * @package    ired.localhost
 * @subpackage producto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoActions extends autoProductoActions
{
  public function executeIndex(sfWebRequest $request) {
    if ($request->hasParameter('tag')) {
      $this->setSearch("");
      $filters=array(
          'tag' => $request->getParameter('tag'),
      );
      $this->setFilters($filters);
    }
    if($request->getParameter('busqueda')){
      $this->setSearch("");
      $filters=array(
        'busqueda' => $request->getParameter('busqueda'),
      );
      $this->setFilters($filters);
    }

		if($request->getParameter('cat')){
      $this->setSearch("");
      $filters=array(
        'categoria_id' => $request->getParameter('cat'),
      );
      $this->setFilters($filters);
    }

    if($request->getParameter('catname')){
      $dets = Doctrine_Core::getTable('ProdCategoria')
        ->createQuery('a')
        ->select('id')
        ->Where("nombre LIKE '%".$request->getParameter('catname')."%' ")
        ->limit(1)
        ->execute();
      $catid = 0;
      foreach ($dets as $det) {
        $catid=$det["id"];
        break;
      }
      $this->setSearch("");
      $filters=array(
        'catname' => $request->getParameter('catname'),
        'categoria_id' => $catid,
      );
      $this->setFilters($filters);
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

    if ($request->isXmlHttpRequest())
    {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));

      if ($request->hasParameter('search'))
      {
        $partialSearch = $this->getPartial('producto/search', array('configuration' => $this->configuration));
      }

      if ($request->hasParameter('_reset'))
      {
        $partialFilter = $this->getPartial('producto/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }

      $partialList = $this->getPartial('producto/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));

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
}
