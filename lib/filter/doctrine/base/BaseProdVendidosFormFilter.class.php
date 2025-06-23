<?php

/**
 * ProdVendidos filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProdVendidosFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'empresa_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'deposito_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => true)),
      'producto_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'add_empty' => true)),
      'cliente_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => true)),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'price_unit'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_tot'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tabla'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tabla_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fecha'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'cantidad'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'oferta'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'anulado'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'empresa_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'deposito_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InvDeposito'), 'column' => 'id')),
      'producto_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Producto'), 'column' => 'id')),
      'cliente_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cliente'), 'column' => 'id')),
      'user_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'price_unit'  => new sfValidatorPass(array('required' => false)),
      'price_tot'   => new sfValidatorPass(array('required' => false)),
      'tabla'       => new sfValidatorPass(array('required' => false)),
      'tabla_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'fecha'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'cantidad'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'oferta'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'anulado'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('prod_vendidos_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProdVendidos';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Text',
      'empresa_id'  => 'ForeignKey',
      'deposito_id' => 'ForeignKey',
      'producto_id' => 'ForeignKey',
      'cliente_id'  => 'ForeignKey',
      'user_id'     => 'ForeignKey',
      'price_unit'  => 'Text',
      'price_tot'   => 'Text',
      'tabla'       => 'Text',
      'tabla_id'    => 'Number',
      'fecha'       => 'Date',
      'cantidad'    => 'Number',
      'oferta'      => 'Boolean',
      'anulado'     => 'Boolean',
    );
  }
}
