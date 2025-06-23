<?php

require_once dirname(__FILE__).'/../lib/nota_creditoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/nota_creditoGeneratorHelper.class.php';

/**
 * nota_credito actions.
 *
 * @package    ired.localhost
 * @subpackage nota_credito
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class nota_creditoActions extends autoNota_creditoActions
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
      case 'forPagoCoin':
        $sort[0] = 'fp.acronimo';
        break;
      case 'fechaTxt':
        $sort[0] = 'fecha';
        break;
        case 'montoCoin':
          $sort[0] = 'monto';
          break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("NotaCredito")->hasColumn($column) || $column == "company" || $column == "ClienteName" || $column == "forPagoCoin" || $column == "fechaTxt";
  }

  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');
    $codigo=$id;
    $dets = Doctrine_Core::getTable('NotaCredito')
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

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $nota_credito = $form->save();
        $nota_credito->monto_faltante=$nota_credito->getMonto();
        $nota_credito->save();
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
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $nota_credito)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@nota_credito_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'nota_credito_show', 'sf_subject' => $nota_credito));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeAnular(sfWebRequest $request){
    $nota_credito = Doctrine_Core::getTable('NotaCredito')->findOneBy('id',$request->getParameter('id'));
    if($nota_credito->getEstatus()==3) {
      $this->getUser()->setFlash('error','Nota de credito, ya se encuentra anulada');
      $this->redirect(array('sf_route' => 'nota_credito_show', 'sf_subject' => $nota_credito));
    }

    $fechaC=strtotime($nota_credito->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>24) {
      $this->getUser()->setFlash('error','No puede anular una Nota de credito con mas de 24horas de haberla creada');
      $this->redirect(array('sf_route' => 'nota_credito_show', 'sf_subject' => $nota_credito));
    }

    $results = Doctrine_Query::create()
      ->select('ncd.id, ncd.anulado')
      ->from('NotaCreditoDet ncd')
      ->where('ncd.nota_credito_id = ?', $nota_credito->getId())
      ->orderBy('ncd.id DESC')
      ->execute();
    foreach ($results as $result) {
      if($result->getAnulado()==0) {
        $this->getUser()->setFlash('error','Debe anular previamente los items asociados a esta nota de credito');
        $this->redirect(array('sf_route' => 'nota_credito_show', 'sf_subject' => $nota_credito));
        break;
      }
    }

    $nota_credito->estatus=3;
    $nota_credito->save();

    $this->getUser()->setFlash('notice','Nota de credito anulada correctamente');
    $this->redirect(array('sf_route' => 'nota_credito_show', 'sf_subject' => $nota_credito));
  }

  public function executeProcesar(sfWebRequest $request){
    $nota_credito = Doctrine_Core::getTable('NotaCredito')->findOneBy('id',$request->getParameter('ncid'));
    $val=$nota_credito->putProcesar($request->getParameter('ccid'));

    $this->getUser()->setFlash('notice','Nota de credito ha sido procesada correctamente');
    $this->redirect(array('sf_route' => 'nota_credito_show', 'sf_subject' => $nota_credito));
  }

  public function executeAnularItem(sfWebRequest $request){
    $nota_credito = Doctrine_Core::getTable('NotaCredito')->findOneBy('id',$request->getParameter('ncid'));

    $nota_credito_det = Doctrine_Core::getTable('NotaCreditoDet')->findOneBy('id',$request->getParameter('id'));
    if($nota_credito_det->getAnulado()==1) {
      $this->getUser()->setFlash('error','El item de la Nota de credito ya se encuentra anulado');
      $this->redirect(array('sf_route' => 'nota_credito_show', 'sf_subject' => $nota_credito));
    }

    $nota_credito->putAnular($request->getParameter('id'));

    $this->getUser()->setFlash('notice','El item de la Nota de credito ha sido anulada correctamente');
    $this->redirect(array('sf_route' => 'nota_credito_show', 'sf_subject' => $nota_credito));
  }
}
