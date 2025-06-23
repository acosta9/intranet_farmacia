<?php

/**
 * Oferta form base class.
 *
 * @method Oferta getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseOfertaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'nombre'          => new sfWidgetFormTextarea(),
      'fecha'           => new sfWidgetFormDate(),
      'fecha_venc'      => new sfWidgetFormDate(),
      'empresa_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'deposito_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => false)),
      'ncontrol'        => new sfWidgetFormInputText(),
      'tipo_oferta'     => new sfWidgetFormInputText(),
      'activo'          => new sfWidgetFormInputCheckbox(),
      'precio_usd'      => new sfWidgetFormInputText(),
      'qty'             => new sfWidgetFormInputText(),
      'exento'          => new sfWidgetFormInputCheckbox(),
      'tasa'            => new sfWidgetFormInputText(),
      'url_imagen'      => new sfWidgetFormInputText(),
      'url_imagen_desc' => new sfWidgetFormTextarea(),
      'descripcion'     => new sfWidgetFormTextarea(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'created_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'nombre'          => new sfValidatorString(),
      'fecha'           => new sfValidatorDate(),
      'fecha_venc'      => new sfValidatorDate(),
      'empresa_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
      'ncontrol'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'tipo_oferta'     => new sfValidatorInteger(array('required' => false)),
      'activo'          => new sfValidatorBoolean(array('required' => false)),
      'precio_usd'      => new sfValidatorString(array('max_length' => 20)),
      'qty'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'exento'          => new sfValidatorBoolean(array('required' => false)),
      'tasa'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'url_imagen'      => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'url_imagen_desc' => new sfValidatorString(array('required' => false)),
      'descripcion'     => new sfValidatorString(array('required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'created_by'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('oferta[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Oferta';
  }

}
