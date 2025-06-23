<?php

/**
 * CotizacionCompraDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCotizacionCompraDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cotizacion_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CotizacionCompra'), 'add_empty' => true)),
      'qty'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_tot'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'producto_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'cotizacion_compra_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CotizacionCompra'), 'column' => 'id')),
      'qty'                  => new sfValidatorPass(array('required' => false)),
      'price_unit'           => new sfValidatorPass(array('required' => false)),
      'price_tot'            => new sfValidatorPass(array('required' => false)),
      'producto_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Producto'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cotizacion_compra_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CotizacionCompraDet';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'cotizacion_compra_id' => 'ForeignKey',
      'qty'                  => 'Text',
      'price_unit'           => 'Text',
      'price_tot'            => 'Text',
      'producto_id'          => 'ForeignKey',
    );
  }
}
