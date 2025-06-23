<?php

/**
 * FacturaCompraDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseFacturaCompraDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'factura_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaCompra'), 'add_empty' => true)),
      'qty'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'qtyr'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit_bs'     => new sfWidgetFormFilterInput(),
      'price_calculado'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'price_unit_old'    => new sfWidgetFormFilterInput(),
      'util_old'          => new sfWidgetFormFilterInput(),
      'util_new'          => new sfWidgetFormFilterInput(),
      'price_tot'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'inventario_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'descripcion'       => new sfWidgetFormFilterInput(),
      'exento'            => new sfWidgetFormFilterInput(),
      'fecha_venc'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'lote'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tipo_precio'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'factura_compra_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('FacturaCompra'), 'column' => 'id')),
      'qty'               => new sfValidatorPass(array('required' => false)),
      'qtyr'              => new sfValidatorPass(array('required' => false)),
      'price_unit'        => new sfValidatorPass(array('required' => false)),
      'price_unit_bs'     => new sfValidatorPass(array('required' => false)),
      'price_calculado'   => new sfValidatorPass(array('required' => false)),
      'price_unit_old'    => new sfValidatorPass(array('required' => false)),
      'util_old'          => new sfValidatorPass(array('required' => false)),
      'util_new'          => new sfValidatorPass(array('required' => false)),
      'price_tot'         => new sfValidatorPass(array('required' => false)),
      'inventario_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario'), 'column' => 'id')),
      'descripcion'       => new sfValidatorPass(array('required' => false)),
      'exento'            => new sfValidatorPass(array('required' => false)),
      'fecha_venc'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'lote'              => new sfValidatorPass(array('required' => false)),
      'tipo_precio'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('factura_compra_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FacturaCompraDet';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'factura_compra_id' => 'ForeignKey',
      'qty'               => 'Text',
      'qtyr'              => 'Text',
      'price_unit'        => 'Text',
      'price_unit_bs'     => 'Text',
      'price_calculado'   => 'Text',
      'price_unit_old'    => 'Text',
      'util_old'          => 'Text',
      'util_new'          => 'Text',
      'price_tot'         => 'Text',
      'inventario_id'     => 'ForeignKey',
      'descripcion'       => 'Text',
      'exento'            => 'Text',
      'fecha_venc'        => 'Date',
      'lote'              => 'Text',
      'tipo_precio'       => 'Number',
    );
  }
}
