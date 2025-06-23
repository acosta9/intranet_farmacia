<?php

require_once dirname(__FILE__).'/../lib/nota_debitoGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/nota_debitoGeneratorHelper.class.php';

/**
 * nota_debito actions.
 *
 * @package    ired.localhost
 * @subpackage nota_debito
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class nota_debitoActions extends autoNota_debitoActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('nota_debito');
    }

    $this->form = $this->configuration->getForm();
    $this->nota_debito = $this->form->getObject();
  }

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
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("NotaDebito")->hasColumn($column) || $column == "company" || $column == "ClienteName" || $column == "forPagoCoin" || $column == "fechaTxt";
  }

  public function executeHeader(sfWebRequest $request){
  }

  public function executeContador(sfWebRequest $request){
    $id = $request->getParameter('id');
    $codigo=$id;
    $dets = Doctrine_Core::getTable('NotaDebito')
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

  protected function processForm(sfWebRequest $request, sfForm $form) {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $nota_debito = $form->save();
        $nota_debito->monto_faltante=$nota_debito->getMonto();
        $nota_debito->save();
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
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $nota_debito)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@nota_debito_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'nota_debito_show', 'sf_subject' => $nota_debito));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeAnular(sfWebRequest $request){
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('nota_debito');
    }

    $nota_debito = Doctrine_Core::getTable('NotaDebito')->findOneBy('id',$request->getParameter('id'));
    if($nota_debito->getEstatus()==3) {
      $this->getUser()->setFlash('error','Nota de debito, ya se encuentra anulada');
      $this->redirect(array('sf_route' => 'nota_debito_show', 'sf_subject' => $nota_debito));
    }

    $fechaC=strtotime($nota_debito->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>72) {
      $this->getUser()->setFlash('error','No puede anular una Nota de debito con mas de 72horas de haberla creada');
      $this->redirect(array('sf_route' => 'nota_debito_show', 'sf_subject' => $nota_debito));
    }

    $results = Doctrine_Query::create()
      ->select('ncd.id, ncd.anulado')
      ->from('NotaDebitoDet ncd')
      ->where('ncd.nota_debito_id = ?', $nota_debito->getId())
      ->orderBy('ncd.id DESC')
      ->execute();
    foreach ($results as $result) {
      if($result->getAnulado()==0) {
        $this->getUser()->setFlash('error','Debe anular previamente los items asociados a esta nota de debito');
        $this->redirect(array('sf_route' => 'nota_debito_show', 'sf_subject' => $nota_debito));
        break;
      }
    }

    $nota_debito->estatus=3;
    $nota_debito->save();

    $this->getUser()->setFlash('notice','Nota de debito anulada correctamente');
    $this->redirect(array('sf_route' => 'nota_debito_show', 'sf_subject' => $nota_debito));
  }

  public function executeProcesar(sfWebRequest $request){
    $nota_debito = Doctrine_Core::getTable('NotaDebito')->findOneBy('id',$request->getParameter('ndid'));
    $val=$nota_debito->putProcesar($request->getParameter('cpid'));

    $this->getUser()->setFlash('notice','Nota de debito ha sido procesada correctamente');
    $this->redirect(array('sf_route' => 'nota_debito_show', 'sf_subject' => $nota_debito));
  }

  public function executeAnularItem(sfWebRequest $request){
    $nota_debito = Doctrine_Core::getTable('NotaDebito')->findOneBy('id',$request->getParameter('ndid'));

    $nota_debito_det = Doctrine_Core::getTable('NotaDebitoDet')->findOneBy('id',$request->getParameter('id'));
    if($nota_debito_det->getAnulado()==1) {
      $this->getUser()->setFlash('error','El item de la Nota de debito ya se encuentra anulado');
      $this->redirect(array('sf_route' => 'nota_debito_show', 'sf_subject' => $nota_debito));
    }

    $nota_debito->putAnular($request->getParameter('id'));

    $this->getUser()->setFlash('notice','El item de la Nota de debito ha sido anulada correctamente');
    $this->redirect(array('sf_route' => 'nota_debito_show', 'sf_subject' => $nota_debito));
  }
}
