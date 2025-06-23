<?php

/**
 * FacturaGastosDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFacturaGastosDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'factura_gastos_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaGastos'), 'add_empty' => true)),
      'qty'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_tot'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'exento'            => new sfWidgetFormFilterInput(),
      'descripcion'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'factura_gastos_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FacturaGastos'), 'column' => 'id')),
      'qty'               => new sfValidatorPass(array('required' => false)),
      'price_unit'        => new sfValidatorPass(array('required' => false)),
      'price_tot'         => new sfValidatorPass(array('required' => false)),
      'exento'            => new sfValidatorPass(array('required' => false)),
      'descripcion'       => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('factura_gastos_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FacturaGastosDet';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'factura_gastos_id' => 'ForeignKey',
      'qty'               => 'Text',
      'price_unit'        => 'Text',
      'price_tot'         => 'Text',
      'exento'            => 'Text',
      'descripcion'       => 'Text',
    );
  }
}
