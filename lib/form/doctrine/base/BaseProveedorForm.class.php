<?php

/**
 * Proveedor form base class.
 *
 * @method Proveedor getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProveedorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'full_name'   => new sfWidgetFormInputText(),
      'doc_id'      => new sfWidgetFormInputText(),
      'direccion'   => new sfWidgetFormTextarea(),
      'telf'        => new sfWidgetFormInputText(),
      'celular'     => new sfWidgetFormInputText(),
      'email'       => new sfWidgetFormInputText(),
      'tipo'        => new sfWidgetFormInputText(),
      'activo'      => new sfWidgetFormInputCheckbox(),
      'descripcion' => new sfWidgetFormTextarea(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'created_by'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'full_name'   => new sfValidatorString(array('max_length' => 200)),
      'doc_id'      => new sfValidatorString(array('max_length' => 20)),
      'direccion'   => new sfValidatorString(),
      'telf'        => new sfValidatorString(array('max_length' => 20)),
      'celular'     => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'email'       => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'tipo'        => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'activo'      => new sfValidatorBoolean(array('required' => false)),
      'descripcion' => new sfValidatorString(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
      'created_by'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Proveedor', 'column' => array('doc_id')))
    );

    $this->widgetSchema->setNameFormat('proveedor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Proveedor';
  }

}
