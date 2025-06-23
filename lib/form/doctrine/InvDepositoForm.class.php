<?php

/**
 * InvDeposito form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InvDepositoForm extends BaseInvDepositoForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by']
    );

    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array('0' => 'DEPOSITO', '1' => 'PISO VENTA', '2' => 'VENCIDOS'))));
    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tipo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['acronimo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->addOption('order_by',array('nombre','asc'));

    $this->setValidators(array(
       'id' => new sfValidatorInteger(array('required' => true)),
       'nombre'   => new sfValidatorString(array('max_length' => 400, 'min_length' => 1, 'required'=> true), array(
         'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
       'empresa_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
       'tipo'   => new sfValidatorPass(),
       'acronimo'   => new sfValidatorString(array('max_length' => 6, 'min_length' => 2, 'required'=> true), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
     )),
       'descripcion'   => new sfValidatorString(array('max_length' => 2000, 'min_length' => 2, 'required'=> false), array(
          'required'   => 'Requerido',
          'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
          'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
          'invalid'=> 'Campo invalido.'
       )),
      ));

      $this->validatorSchema->setPostValidator(
        new sfValidatorAnd(array(
          new sfValidatorDoctrineUnique(array
          ('model' => 'InvDeposito', 'column' => array('id')), array(
            'invalid'=> 'Codigo ya existente')),
          new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
        ))
      );
    }
    public function validaciones($validator, $values) {
  /*    if($this->isNew()) {
        $results = Doctrine_Query::create()
          ->select('COUNT(id) as cont')
          ->from('InvDeposito d')
          ->where('d.empresa_id = ?', $values['empresa_id'])
          ->andWhere('d.tipo =?', $values['tipo'])
          ->execute();
        $cont=0;
        foreach ($results as $result) {
          $cont=$result["cont"];
        }
        if($cont>0) {
          $error = new sfValidatorError($validator, 'Tipo de deposito ya existe en esta empresa');
          throw new sfValidatorErrorSchema($validator, array('tipo' => $error));
        }
      }*/
      if(!empty($values['acronimo'])) {
        $values['acronimo'] = trim(strtoupper($values['acronimo']));
      }
      if(!empty($values['nombre'])) {
        $values['nombre'] = trim(strtoupper($values['nombre']));
      }
      if(!empty($values['descripcion'])) {
        $values['descripcion'] = trim(strtoupper($values['descripcion']));
      }
      return $values;
    }
  }
