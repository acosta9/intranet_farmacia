<?php

/**
 * FormaPago filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FormaPagoFormFilter extends BaseFormaPagoFormFilter
{
  public function configure()
  {
    $this->setWidget('coin', new sfWidgetFormChoice(array('choices' => array('' => '', 1 => 'BOLIVARES', 2 => 'DOLARES'))));
    $this->setWidget('activo', new sfWidgetFormChoice(array('choices' => array('' => '', 0 => 'DES-HABILITADO', 1 => 'HABILITADO'))));
    $this->setWidget('descripcion', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->widgetSchema['coin']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['activo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));

    $this->validatorSchema ['coin'] = new sfValidatorPass();
  }
  public function getFields() {
    $fields = parent::getFields();
    $fields['coin'] = 'Text';
    return $fields;
  }
  public function addCoinColumnQuery($query, $field, $value) {
      $rootAlias = $query->getRootAlias();
      return $query->andwhere($rootAlias.'.moneda = ?', "$value");
  }
}
