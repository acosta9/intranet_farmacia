<?php

require_once dirname(__FILE__).'/../lib/recibo_pago_compraGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/recibo_pago_compraGeneratorHelper.class.php';

/**
 * recibo_pago_compra actions.
 *
 * @package    ired.localhost
 * @subpackage recibo_pago_compra
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class recibo_pago_compraActions extends autoRecibo_pago_compraActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('recibo_pago_compra');
    }

    $this->form = $this->configuration->getForm();
    $this->recibo_pago_compra = $this->form->getObject();
  }

  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'empresaName':
        $sort[0] = 'e.nombre';
        break;
      case 'clienteName':
        $sort[0] = 'c.full_name';
        break;
      case 'forPagoCoin':
        $sort[0] = 'fp.acronimo';
        break;
      case 'fechaTxt':
        $sort[0] = 'fecha';
        break;
      case 'company':
        $sort[0] = 'e.acronimo';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("ReciboPago")->hasColumn($column) || $column == "EmpresaName" || $column == "ClienteName" || $column == "forPagoCoin" || $column == "fechaTxt" || $column == "company";
  }

  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');
    $codigo=$id;
    $dets = Doctrine_Core::getTable('ReciboPago')
      ->createQuery('a')
      ->select('id as contador')
      ->Where("id LIKE '$id%'")
      ->orderby('id DESC')
      ->limit(1)
      ->execute();
    $count = 0;
    foreach ($dets as $det) {
      $count=$det["contador"];
      break;
    }
    if($count>0) {
      $count=substr($count, 4)."<br/>";
      $count = $id.$count+1;
    } else {
      $count=$id."1";
    }
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($count));
  }

  public function executeGetProveedores(sfWebRequest $request){
  }

  public function executeGetForma(sfWebRequest $request){
  }

  public function executeFormaFilters(sfWebRequest $request){
  }

  public function executeHeader(sfWebRequest $request){
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $recibo_pago_compra = $form->save();
        $cuentas_pagar = Doctrine_Core::getTable('CuentasPagar')->findOneBy('id', $recibo_pago_compra->getCuentasPagarId());
        $desc=$cuentas_pagar->putPagar($recibo_pago_compra->getMonto(),$recibo_pago_compra->getMonto2(),$recibo_pago_compra->getMoneda());
        $recibo_pago_compra->descripcion=$desc;
        $recibo_pago_compra->save();
      } catch (Doctrine_Validator_Exception $e) {
        $errorStack = $form->getObject()->getErrorStack();
        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
          $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');
        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $recibo_pago_compra)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@recibo_pago_compra_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'recibo_pago_compra_show', 'sf_subject' => $recibo_pago_compra));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeAnular(sfWebRequest $request){
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('recibo_pago_compra');
    }

    $recibo_pago_compra = Doctrine_Core::getTable('ReciboPagoCompra')->findOneBy('id',$request->getParameter('id'));
    if($recibo_pago_compra->getAnulado()==1) {
      $this->getUser()->setFlash('error','Recibo de pago, ya se encuentra anulado');
      $this->redirect(array('sf_route' => 'recibo_pago_compra_show', 'sf_subject' => $recibo_pago_compra));
    }

    $fechaC=strtotime($recibo_pago_compra->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>72) {
      $this->getUser()->setFlash('error','No puede anular un recibo de pago con mas de 72horas de haberlo creado');
      $this->redirect(array('sf_route' => 'recibo_pago_compra_show', 'sf_subject' => $recibo_pago_compra));
    }

    $cuentas_pagar = Doctrine_Core::getTable('CuentasPagar')->findOneBy('id', $recibo_pago_compra->getCuentasPagarId());
    $cuentas_pagar->putAnular($recibo_pago_compra->getMonto());
    $recibo_pago_compra->anulado=1;
    $recibo_pago_compra->save();

    $this->getUser()->setFlash('notice','Recibo de pago anulado correctamente');
    $this->redirect(array('sf_route' => 'recibo_pago_compra_show', 'sf_subject' => $recibo_pago_compra));
  }

  public function executeBatchExportarBanco(sfWebRequest $request) {
    if ($request->hasParameter('search')) {
      $this->setSearch($request->getParameter('search'));
      $request->setParameter('page', 1);
    }

    // filtering
    if ($request->getParameter('filters'))  {
      $this->setFilters($request->getParameter('filters'));
    }

    // sorting
    if ($request->getParameter('sort')) {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }

    $this->setMaxPerPage("∞");
    $this->setPage(1);
    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    if ($request->isXmlHttpRequest()) {
      $partialFilter = null;
      sfConfig::set('sf_web_debug', false);
      $this->setLayout(false);
      sfProjectConfiguration::getActive()->loadHelpers(array('I18N', 'Date'));

      if ($request->hasParameter('search')){ 
        $partialSearch = $this->getPartial('recibo_pago_compra/search', array('configuration' => $this->configuration));
      }
      if ($request->hasParameter('_reset')) {
        $partialFilter = $this->getPartial('recibo_pago_compra/filters', array('form' => $this->filters, 'configuration' => $this->configuration));
      }
      $partialList = $this->getPartial('recibo_pago_compra/list', array('pager' => $this->pager, 'sort' => $this->sort, 'helper' => $this->helper));
      if (isset($partialSearch)) {
        $partialList .= '#__filter__#'.$partialSearch;
      }
      if (isset($partialFilter)) {
        $partialList .= '#__filter__#'.$partialFilter;
      }
      return $this->renderText($partialList);
    }
    $this->recibo_pago_compras=$this->pager->getResults();

    $this->setMaxPerPage("20");
    $this->setPage(1);
  }
}
