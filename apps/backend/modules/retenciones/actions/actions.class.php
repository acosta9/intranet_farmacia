<?php

require_once dirname(__FILE__).'/../lib/retencionesGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/retencionesGeneratorHelper.class.php';

/**
 * retenciones actions.
 *
 * @package    ired.localhost
 * @subpackage retenciones
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class retencionesActions extends autoRetencionesActions
{
  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }

    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }

    switch ($sort[0]) {
      case 'company':
        $sort[0] = 'e.acronimo';
        break;
      case 'clienteName':
        $sort[0] = 'c.full_name';
        break;
      case 'tipoTxt':
        $sort[0] = 'tipo';
        break;
      case 'factura':
        $sort[0] = 'f.num_factura';
        break;
      case 'fechaTxt':
        $sort[0] = 'fecha';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Retenciones")->hasColumn($column) || $column == "company" || $column == "ClienteName" || $column == "tipoTxt" || $column == "factura" || $column == "fechaTxt";
  }

  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');
    $codigo=$id;
    $dets = Doctrine_Core::getTable('Retenciones')
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

  public function executeHeader(sfWebRequest $request){
  }

  public function executeFooter(sfWebRequest $request){
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $retenciones = $form->save();
        $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('id', $retenciones->getCuentasCobrarId());
        $desc=$cuentas_cobrar->putPagar($retenciones->getMontoUsd());
        $retenciones->descripcion=$desc;
        $retenciones->save();
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
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $retenciones)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@retenciones_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'retenciones_show', 'sf_subject' => $retenciones));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeAnular(sfWebRequest $request){
    $retenciones = Doctrine_Core::getTable('Retenciones')->findOneBy('id',$request->getParameter('id'));
    if($retenciones->getAnulado()==1) {
      $this->getUser()->setFlash('error','Comprobante de retencion, ya se encuentra anulado');
      $this->redirect(array('sf_route' => 'recibo_pago_show', 'sf_subject' => $retenciones));
    }

    $fechaC=strtotime($retenciones->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>24) {
      $this->getUser()->setFlash('error','No puede anular una retencion con mas de 24horas de haberla creado');
      $this->redirect(array('sf_route' => 'retenciones_show', 'sf_subject' => $retenciones));
    }

    $cuentas_cobrar = Doctrine_Core::getTable('CuentasCobrar')->findOneBy('id', $retenciones->getCuentasCobrarId());
    $cuentas_cobrar->putAnular($retenciones->getMontoUsd());
    $retenciones->anulado=1;
    $retenciones->save();

    $this->getUser()->setFlash('notice','Comprobante de retencion anulado correctamente');
    $this->redirect(array('sf_route' => 'retenciones_show', 'sf_subject' => $retenciones));
  }
}
