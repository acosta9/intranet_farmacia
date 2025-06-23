<?php

/**
 * Proveedor form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProveedorForm extends BaseProveedorForm
{
  public function configure() {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->widgetSchema->setLabels(array(
      'full_name' => 'Nombre',
      'doc_id' => 'RIF/CI',
      'telf' => 'Telefono (1)',
      'celular' => 'Telefono (2)',
      'email' => 'Correo Electronico'
    ));

    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array('factura_compra' => 'FACTURA DE COMPRAS', 'factura_gasto' => 'FACTURA DE GASTOS', 'ambos' => 'F. COMPRAS Y F. GASTOS'))));

    $this->widgetSchema['full_name']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['doc_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['email']->setAttributes(array('class' => 'form-control', 'type' => 'email'));
    $this->widgetSchema['telf']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['celular']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['direccion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tipo']->setAttributes(array('class' => 'form-control'));

    $this->setValidators(array(
      'id' => new sfValidatorInteger(array('required' => true)),
      'full_name'       => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'tipo'          => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'doc_id'          => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'telf'            => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'celular'         => new sfValidatorString(array('max_length' => 20, 'min_length' => 2, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'email'           => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'direccion'       => new sfValidatorString(array('max_length' => 200, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'descripcion'     => new sfValidatorString(array('max_length' => 2000, 'min_length' => 2, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muyfalse corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if(!empty($values['doc_id']) && $this->isNew()) {
      $results = Doctrine_Core::getTable('Proveedor')
        ->createQuery('a')
        ->select('COUNT(id) as contador')
        ->where("doc_id =?", $values['doc_id'])
        ->limit(1)
        ->execute();
      $count = 0;
      foreach ($results as $result) {
        $count=$result["contador"];
        break;
      }
      if($count>0) {
        $error = new sfValidatorError($validator, 'Ya esta ingresado este RIF o CI ');
        throw new sfValidatorErrorSchema($validator, array('doc_id' => $error));
      }
    } else if(!empty($values['doc_id']) && !$this->isNew()) {
      $results = Doctrine_Core::getTable('Proveedor')
        ->createQuery('a')
        ->select('id')
        ->where("doc_id =?", $values['doc_id'])
        ->execute();
      $cont=0; $id_search="";
      foreach ($results as $result) {
        $id_search=$result["id"];
        if($result["id"]!=$values['id']) {
          $cont++;
        }
      }
      if($cont>0) {
        $error = new sfValidatorError($validator, 'Ya esta ingresado este RIF o CI ');
        throw new sfValidatorErrorSchema($validator, array('doc_id' => $error));
      }
    }

    if(empty($values['celular'])) {
      $values['celular'] = NULL;
    }
    if(empty($values['email'])) {
      $values['email'] = NULL;
    } else {
      $values['email'] = trim(strtolower($values['email']));
    }
    if(empty($values['descripcion'])) {
      $values['descripcion'] = NULL;
    } else {
      $values['descripcion'] = trim(strtoupper($values['descripcion']));
    }

    $values['full_name'] = trim(strtoupper($values['full_name']));
    $values['direccion'] = trim(strtoupper($values['direccion']));
    $values['doc_id'] = trim(strtoupper($values['doc_id']));
    
    if($this->isNew()) {
       $count_ccs = Doctrine_Core::getTable('Proveedor')
        ->createQuery('a')
        ->select('COUNT(id) as contador')
        ->limit(1)
        ->execute();
      $count = 0;
      foreach ($count_ccs as $count_cc) {
        $count=$count_cc["contador"];
        break;
      }
      // se agrego  la sumatoria de 1214 por Duplicacion de id
      $count =$count + 1214;
      $conta = $count+1;
      $values['id']=$conta;

    }

    return $values;
  }
}
