<?php

/**
 * inicio actions.
 *
 * @package    ired.localhost
 * @subpackage inicio
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class inicioActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request){
  }

  public function executeDashFarmacia(sfWebRequest $request){
  }

  public function executeDashCompras(sfWebRequest $request){
  }

  public function executeDashIncidenciaInv(sfWebRequest $request){
  }

  public function executeDashGerencia(sfWebRequest $request){
  }  

  public function executeDashHome(sfWebRequest $request){
  }

  public function executeIncidencias(sfWebRequest $request){
  }
  
  public function executeFindClientes(sfWebRequest $request) {
    if(empty($request->getParameter('search_id'))) {
      $this->getUser()->setFlash('error','Debes seleccionar correctamente el usuario del listado');
      $this->redirect('@homepage');
    }
    $this->client=Doctrine_Core::getTable('Client')->findOneBy('id', $request->getParameter('search_id'));
    if(empty($this->client)) {
      $this->getUser()->setFlash('error','Debes seleccionar correctamente el usuario del listado');
      $this->redirect('@homepage');
    }
    $tipo_class="primary";
    $tipo=0;
    $contratos = Doctrine_Query::create()
      ->select('cd.id as cdid, c.convenio as convenio, p.nombre as pname')
      ->from('ContratoDet cd')
      ->innerJoin('cd.Contrato c')
      ->innerJoin('cd.Planes p')
      ->Where('c.client_id =?', $request->getParameter('search_id'))
      ->orderBy('p.ref ASC')
      ->execute();
      $cant_contrato=0;
    foreach ($contratos as $contrato) {
      $cant_contrato+=1;
      if($contrato["convenio"]==1){
        $tipo=1;
      } else {
        list($tipop, $mb)=explode("/",$contrato["pname"]);
        if(strcmp($tipop,"RESIDENCIAL")==0) {
          $tipo=2;
        } else if (strcmp($tipop,"EMPRESARIAL")==0) {
          $tipo=3;
        } else if (strcmp($tipop,"SIMETRICO")==0) {
          $tipo=4;
        }
      }
    }

    if($tipo==1) {
      $tipo_class="info";
    } else if($tipo==2) {
      $tipo_class="success";
    } else if($tipo==3) {
      $tipo_class="warning";
    } else if($tipo==4) {
      $tipo_class="danger";
    }

    $recs = Doctrine_Query::create()
      ->select('COUNT(id) as count')
      ->from('ReciboPago rp')
      ->Where('rp.client_id =?', $request->getParameter('search_id'))
      ->andWhere('rp.anulado=0')
      ->execute();
      $cant_recs=0;
    foreach ($recs as $rec) {
      $cant_recs+=$rec["count"];
    }

    $facts = Doctrine_Query::create()
      ->select('COUNT(id) as count')
      ->from('PreFactura pf')
      ->Where('pf.client_id =?', $request->getParameter('search_id'))
      ->andWhere('pf.anulado=0')
      ->execute();
      $cant_facts=0;
    foreach ($facts as $fact) {
      $cant_facts+=$fact["count"];
    }

    $this->class=$tipo_class;
    $this->cant_contrato=$cant_contrato;
    $this->cant_rec=$cant_recs;
    $this->cant_fact=$cant_facts;
  }
  public function executeGetClientes(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    // Parametro 'q', contiene lo que fue introducido en el campo por teclado
    $string = trim($request->getParameter('q'));
    // Consulta al modelo dado
    $words=explode("_",$string);
    $i=0; $sql="";
    foreach ($words as $word) {
      if($i==0){
        $sql="(full_name LIKE '%".$word."%' || doc_id LIKE '%".$word."%')";
      } else {
        $sql=$sql." && (full_name LIKE '%".$word."%' || doc_id LIKE '%".$word."%')";
      }
      $i++;
    }
    $query = Doctrine_Query::create()
    ->from('Client c')
    ->where($sql)
    ->orderBy('c.full_name ASC')
    ->execute();

    $clients = array();
    foreach ($query as $row) {
      $clients[] = array("id"=>$row->getId(),"name"=>$row->getFullName()." [".$row->getDocId()."]");
    }
    return $this->renderText(json_encode($clients));
  }
}
