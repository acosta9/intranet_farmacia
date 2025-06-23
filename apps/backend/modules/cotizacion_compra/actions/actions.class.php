<?php

require_once dirname(__FILE__).'/../lib/cotizacion_compraGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/cotizacion_compraGeneratorHelper.class.php';

/**
 * cotizacion_compra actions.
 *
 * @package    ired.localhost
 * @subpackage cotizacion_compra
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cotizacion_compraActions extends autoCotizacion_compraActions
{
  public function executeNew(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso a esta area');
      $this->redirect('cotizacion_compra');
    }

    $this->form = $this->configuration->getForm();
    $this->cotizacion_compra = $this->form->getObject();
  }

  protected function addSortQuery($query) {
    if (array(null, null) == ($sort = $this->getSort())) {
      return;
    }
    if (!in_array(strtolower($sort[1]), array('asc', 'desc'))) {
      $sort[1] = 'asc';
    }
    switch ($sort[0]) {
      case 'ncontrol':
        $sort[0] = 'ninteger';
        break;
    }
    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function isValidSortColumn($column) {
    return Doctrine_Core::getTable("Factura")->hasColumn($column) || $column == "ncontrol";
  }

  public function executeGetProveedor(sfWebRequest $request){
    $search=$request->getParameter('search');
    $eid=$request->getParameter('eid');

    $words=explode(" ",$search);
    $i=0; $sql="";
    if($search=="**") {
      $sql="(p.full_name LIKE '%')";
    } else {
      foreach ($words as $word) {
        if($i==0){
          $sql=$sql."(p.full_name LIKE '%".$word."%' || p.doc_id LIKE '%".$word."%')";
        } else {
          $sql=$sql." && (p.full_name LIKE '%".$word."%' || p.doc_id LIKE '%".$word."%')";
        }
        $i++;
      }
    }

    $q = Doctrine_Manager::getInstance()->getCurrentConnection();
    $results = $q->execute("SELECT p.id as pid, p.full_name as pname, p.doc_id as docid 
    FROM proveedor p WHERE $sql AND p.empresa_id IN ($eid)
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $arreglo[$result["pid"]]=$result["pname"]." [".$result["docid"]."]";
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }
  
  public function executeGetProductos2(sfWebRequest $request){
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
    $results = $q->execute("SELECT p.id as pid, p.nombre as pname, p.serial as serial, FORMAT(REPLACE(p.costo_usd_1, ' ', ''), 4, 'de_DE') as p01 
    FROM producto p where $sql
    ORDER BY pname ASC LIMIT 40");

    $arreglo=array();
    foreach ($results as $result) {
      $precio="0.0000";
      if($result["p01"]!="0,0000") {
        $precio=$result["p01"];
      }
      $arreglo[$result["pid"]]=$result["pname"]." [".$result["serial"]."]|".$precio;
    }

    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($arreglo));
  }

  public function executeGetProveedores(sfWebRequest $request){
  }

  public function executeHeader(sfWebRequest $request){
  }
  
  public function executeDetalles(sfWebRequest $request) {
  }

  public function executeAddDetallesForm(sfWebRequest $request) {
    $this->forward404unless($request->isXmlHttpRequest());
    $number = $request->getParameter('num');

    if($card = Doctrine_Core::getTable('CotizacionCompra')->find($request->getParameter('id'))){
      $form = new CotizacionCompraForm($card);
    }else{
      $form = new CotizacionCompraForm(null);
    }

    $form->addDetalles($number);
    return $this->renderPartial('cotizacion_compra/detalles',array('form' => $form, 'num' => $number));
  }

  public function executeDelete(sfWebRequest $request) {
    $cotizacion_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $request->getParameter('id'));
    
    $this->getUser()->setFlash('error','No puedes eliminar la cotizacion de compra');
    $this->redirect(array('sf_route' => 'cotizacion_compra_show', 'sf_subject' => $cotizacion_compra));
  }

  public function executeEdit(sfWebRequest $request) {
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
      $this->redirect('cotizacion_compra');
    }

    $cotizacion_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $request->getParameter('id'));
    
    $this->getUser()->setFlash('error','No puedes editar la cotizacion de compra');
    $this->redirect(array('sf_route' => 'cotizacion_compra_show', 'sf_subject' => $cotizacion_compra));
  }

  protected function processForm(sfWebRequest $request, sfForm $form) {
   $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()) {
      $notice = $form->getObject()->isNew() ? 'datos guardados correctamente.' : 'datos guardados correctamente.';
      try {
        $cotizacion_compra = $form->save();
        $eid=$cotizacion_compra->getEmpresaId();
        $empresa=Doctrine_Core::getTable('Empresa')->findOneBy('id',$eid);
        $ncontrol=$empresa->getCoticompra()+1;
        $empresa->coticompra=$ncontrol;
        $empresa->save();
        $cotizacion_compra->ncontrol=$ncontrol;
        $cotizacion_compra->save();

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

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $cotizacion_compra)));
      if ($request->hasParameter('_save_and_add')) {
        $this->getUser()->setFlash('notice', $notice.' Puedes agregar otro registro abajo.');
        $this->redirect('@cotizacion_compra_new');
      } else {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'cotizacion_compra_show', 'sf_subject' => $cotizacion_compra));
      }
    } else {
      $this->getUser()->setFlash('error', 'Error, revisa los datos introducidos.', false);
    }
  }

  public function executeAnular(sfWebRequest $request){
    $ename=Doctrine_Core::getTable('ServerName')->findOneBy('valor', "nombre_server");
    if($ename["tipo"]<>2) {
      $this->getUser()->setFlash('error', $notice.' Este servidor no tiene acceso ha esta area');
      $this->redirect('cotizacion_compra');
    }
    
    $cotizacion_compra = Doctrine_Core::getTable('CotizacionCompra')->findOneBy('id', $request->getParameter('id'));

    if($cotizacion_compra->getEstatus()==2 || $cotizacion_compra->getEstatus()==3 || $cotizacion_compra->getEstatus()==4){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la cotizacion tiene asociada una orden de compra');
      $this->redirect(array('sf_route' => 'cotizacion_compra_show', 'sf_subject' => $cotizacion_compra));
    }

    if($cotizacion_compra->getEstatus()==5){
      $this->getUser()->setFlash('error','No puedes anular el registro, porque la cotizacion ya esta anulada');
      $this->redirect(array('sf_route' => 'cotizacion_compra_show', 'sf_subject' => $cotizacion_compra));
    }

    /*$fechaC=strtotime($cotizacion_compra->getCreatedAt());
    $fecha_actual = strtotime(date("d-m-Y H:i"));
    $diffHours = round(($fecha_actual - $fechaC) / 3600);
    if($diffHours>48) {
      $this->getUser()->setFlash('error','No puede anular este documento con mas de 48horas de haberla creado');
      $this->redirect(array('sf_route' => 'cotizacion_compra_show', 'sf_subject' => $cotizacion_compra));
    }*/

    $cotizacion_compra->estatus=5;
    $cotizacion_compra->save();

    $this->getUser()->setFlash('notice','La cotizacion de compra ha sido anulada correctamente');
    $this->redirect(array('sf_route' => 'cotizacion_compra_show', 'sf_subject' => $cotizacion_compra));
  }
}
