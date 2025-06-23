<?php

require_once dirname(__FILE__).'/../lib/cuentas_cobrarGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/cuentas_cobrarGeneratorHelper.class.php';

/**
 * cuentas_cobrar actions.
 *
 * @package    ired.localhost
 * @subpackage cuentas_cobrar
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cuentas_cobrarActions extends autoCuentas_cobrarActions
{
  public function executeIndex(sfWebRequest $request) {
		$this->setSearch('');
		$filters=array(
			'cliente_id' => $this->getUser()->getGuardUser()->getClienteId(),
		);

		$this->setFilters($filters);

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

		if ($request->isXmlHttpRequest()) {
			$partialFilter = null;
			sfConfig::set('sf_web_debug', false);
			$this->setLayout(false);
			sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));

			if ($request->hasParameter('search')) {
				$partialSearch = $this->getPartial('cuentas_cobrar/search', array('configuration' => $this->configuration));
			}

			if ($request->hasParameter('_reset')) {
				$partialFilter = $this->getPartial('cuentas_cobrar/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
			}

			$partialList = $this->getPartial('cuentas_cobrar/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));

			if (isset($partialSearch)) {
				$partialList .= '#__filter__#'.$partialSearch;
			}

			if (isset($partialFilter)) {
				$partialList .= '#__filter__#'.$partialFilter;
			}
			return $this->renderText($partialList);
		}
	}

	public function executeDelete(sfWebRequest $request){
		$this->redirect('cuentas_cobrar');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->redirect('cuentas_cobrar');
	}

	public function executeNew(sfWebRequest $request) {
		$this->redirect('cuentas_cobrar');
	}
}
