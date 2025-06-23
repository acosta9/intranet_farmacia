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

  public function executeGetClientes(sfWebRequest $request){
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
        $recibo_pago = $form->save();
        $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('id', $recibo_pago->getCuentasCobrarId());
        $desc=$cuentas_cobrar->putPagar($recibo_pago->getMonto());
        $recibo_pago->descripcion=$desc;
        $recibo_pago->save();
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
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $recibo_pago)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@recibo_pago_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'recibo_pago_show', 'sf_subject' => $recibo_pago));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeAnular(sfWebRequest $request){
    $recibo_pago = Doctrine_Core::getTable('ReciboPago')->findOneBy('id',$request->getParameter('id'));
    if($recibo_pago->getAnulado()==1) {
      $this->getUser()->setFlash('error','Recibo de pago, ya se encuentra anulado');
      $this->redirect(array('sf_route' => 'recibo_pago_show', 'sf_subject' => $recibo_pago));
    }

    $fechaC=strtotime($recibo_pago->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>24) {
      $this->getUser()->setFlash('error','No puede anular un recibo de pago con mas de 24horas de haberlo creado');
      $this->redirect(array('sf_route' => 'recibo_pago_show', 'sf_subject' => $recibo_pago));
    }

    $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('id', $recibo_pago->getCuentasCobrarId());
    $cuentas_cobrar->putAnular($recibo_pago->getMonto());
    $recibo_pago->anulado=1;
    $recibo_pago->save();

    $this->getUser()->setFlash('notice','Recibo de pago anulado correctamente');
    $this->redirect(array('sf_route' => 'recibo_pago_show', 'sf_subject' => $recibo_pago));
  }
}
