<?php

/**
 * FacturaCompraDet form base class.
 *
 * @method FacturaCompraDet getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseFacturaCompraDetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'factura_compra_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaCompra'), 'add_empty' => false)),
      'qty'               => new sfWidgetFormInputText(),
      'qtyr'              => new sfWidgetFormInputText(),
      'price_unit'        => new sfWidgetFormInputText(),
      'price_unit_bs'     => new sfWidgetFormInputText(),
      'price_calculado'   => new sfWidgetFormInputText(),
      'price_unit_old'    => new sfWidgetFormInputText(),
      'util_old'          => new sfWidgetFormInputText(),
      'util_new'          => new sfWidgetFormInputText(),
      'price_tot'         => new sfWidgetFormInputText(),
      'inventario_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
      'descripcion'       => new sfWidgetFormTextarea(),
      'exento'            => new sfWidgetFormInputText(),
      'fecha_venc'        => new sfWidgetFormDate(),
      'lote'              => new sfWidgetFormInputText(),
      'tipo_precio'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'factura_compra_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('FacturaCompra'))),
      'qty'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'qtyr'              => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'        => new sfValidatorString(array('max_length' => 20)),
      'price_unit_bs'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_calculado'   => new sfValidatorString(array('max_length' => 20)),
      'price_unit_old'    => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_old'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'util_new'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_tot'         => new sfValidatorString(array('max_length' => 20)),
      'inventario_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'required' => false)),
      'descripcion'       => new sfValidatorString(array('required' => false)),
      'exento'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'fecha_venc'        => new sfValidatorDate(),
      'lote'              => new sfValidatorString(array('max_length' => 200)),
      'tipo_precio'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('factura_compra_det[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'FacturaCompraDet';
  }

}
