<?php

/**
 * OrdenCompraDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseOrdenCompraDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'orden_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('OrdenCompra'), 'add_empty' => true)),
      'qty'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_tot'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'inventario_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'oferta_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'add_empty' => true)),
      'descripcion'     => new sfWidgetFormFilterInput(),
      'exento'          => new sfWidgetFormFilterInput(),
      'tasa_cambio'     => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'orden_compra_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('OrdenCompra'), 'column' => 'id')),
      'qty'             => new sfValidatorPass(array('required' => false)),
      'price_unit'      => new sfValidatorPass(array('required' => false)),
      'price_tot'       => new sfValidatorPass(array('required' => false)),
      'inventario_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario'), 'column' => 'id')),
      'oferta_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Oferta'), 'column' => 'id')),
      'descripcion'     => new sfValidatorPass(array('required' => false)),
      'exento'          => new sfValidatorPass(array('required' => false)),
      'tasa_cambio'     => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('orden_compra_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OrdenCompraDet';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'orden_compra_id' => 'ForeignKey',
      'qty'             => 'Text',
      'price_unit'      => 'Text',
      'price_tot'       => 'Text',
      'inventario_id'   => 'ForeignKey',
      'oferta_id'       => 'ForeignKey',
      'descripcion'     => 'Text',
      'exento'          => 'Text',
      'tasa_cambio'     => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
