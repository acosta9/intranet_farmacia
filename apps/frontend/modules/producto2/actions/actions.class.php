<?php

require_once dirname(__FILE__).'/../lib/productoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/productoGeneratorHelper.class.php';

/**
 * producto actions.
 *
 * @package    maguey
 * @subpackage producto
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productoActions extends autoProductoActions
{
  public function executeFavorito(sfWebRequest $request) {
    if($this->getUser()->isAuthenticated()) {
      if($request->getParameter('change')) {
        $result=Doctrine_Core::getTable('Producto')->findOneBy('id',$request->getParameter('id'));
        $num=$result->getFavorito();
        $num = $num - 1;
        $solic = new Producto();
        $solic->assignIdentifier($request->getParameter('id'));
        $solic->favorito = $num;
        $solic->save();

        $results = Doctrine_Query::create()
        ->select('pf.*')
        ->from('ProductosFavoritos pf')
        ->where('pf.sf_guard_user_id = ?', $this->getUser()->getGuardUser()->getId())
        ->andwhere('pf.producto_id = ?', $request->getParameter('id'))
        ->andwhere('pf.tipo = ?', '1')
        ->limit(1)
        ->execute();
        foreach ($results as $result) {
          $result->delete();
        }
      } else {
        $result=Doctrine_Core::getTable('Producto')->findOneBy('id',$request->getParameter('id'));
        $num=$result->getFavorito();
        $num = $num + 1;
        $solic = new Producto();
        $solic->assignIdentifier($request->getParameter('id'));
        $solic->favorito = $num;
        $solic->save();

        $pf = new ProductosFavoritos();
        $pf->sf_guard_user_id = $this->getUser()->getGuardUser()->getId();
        $pf->producto_id = $result->getId();
        $pf->url_imagen = $result->getUrlImagen();
        $pf->nombre = $result->getNombre();
        $pf->tipo = "1";
        $pf->save();
      }
    }

    $this->redirect('producto/show?id='.$request->getParameter('id'));
  }

	public function executeIndex(sfWebRequest $request) {
		$this->setSearch("");
		if ($request->hasParameter('busqueda')) {
      $this->setSearch("");
      $filters=array(
          'busqueda' => $request->getParameter('busqueda'),
      );
      $this->setFilters($filters);
    }

		if($request->getParameter('cat')){
        $this->setSearch("");
        $filters=array(
            'producto_cat_id' => $request->getParameter('cat'),
        );
        $this->setFilters($filters);
    }

		if($request->getParameter('tag')){
        $this->setFilters($this->configuration->getFilterDefaults());
        $this->setSearch(strtolower($request->getParameter('tag')));
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
