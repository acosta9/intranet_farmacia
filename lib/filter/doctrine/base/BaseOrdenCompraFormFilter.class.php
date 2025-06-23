<?php

/**
 * OrdenCompra filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseOrdenCompraFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ncontrol'                => new sfWidgetFormFilterInput(),
      'tasa_cambio'             => new sfWidgetFormFilterInput(),
      'empresa_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)),
      'deposito_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => true)),
      'cliente_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => true)),
      'orden_compra_estatus_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrdenCompraEstatus'), 'add_empty' => true)),
      'titulo'                  => new sfWidgetFormFilterInput(),
      'total'                   => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'ncontrol'                => new sfValidatorPass(array('required' => false)),
      'tasa_cambio'             => new sfValidatorPass(array('required' => false)),
      'empresa_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Empresa'), 'column' => 'id')),
      'deposito_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('InvDeposito'), 'column' => 'id')),
      'cliente_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Cliente'), 'column' => 'id')),
      'orden_compra_estatus_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('OrdenCompraEstatus'), 'column' => 'id')),
      'titulo'                  => new sfValidatorPass(array('required' => false)),
      'total'                   => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('orden_compra_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCompra';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'ncontrol'                => 'Text',
      'tasa_cambio'             => 'Text',
      'empresa_id'              => 'ForeignKey',
      'deposito_id'             => 'ForeignKey',
      'cliente_id'              => 'ForeignKey',
      'orden_compra_estatus_id' => 'ForeignKey',
      'titulo'                  => 'Text',
      'total'                   => 'Text',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
      'created_by'              => 'ForeignKey',
      'updated_by'              => 'ForeignKey',
    );
  }
}
