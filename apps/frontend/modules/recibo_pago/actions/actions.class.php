<?php

require_once dirname(__FILE__).'/../lib/recibo_pagoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/recibo_pagoGeneratorHelper.class.php';

/**
 * recibo_pago actions.
 *
 * @package    ired.localhost
 * @subpackage recibo_pago
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class recibo_pagoActions extends autoRecibo_pagoActions
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
				$partialSearch = $this->getPartial('recibo_pago/search', array('configuration' => $this->configuration));
			}

			if ($request->hasParameter('_reset')) {
				$partialFilter = $this->getPartial('recibo_pago/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
			}

			$partialList = $this->getPartial('recibo_pago/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));

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
		$this->redirect('recibo_pago');
	}

	public function executeEdit(sfWebRequest $request) {
		$this->redirect('recibo_pago');
	}

	public function executeNew(sfWebRequest $request) {
		$this->redirect('recibo_pago');
	}
}
