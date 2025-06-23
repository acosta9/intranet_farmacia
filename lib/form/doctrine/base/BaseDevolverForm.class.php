<?php

/**
 * Devolver form base class.
 *
 * @method Devolver getObject() Returns the current form's model object
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDevolverForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'empresa_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => false)),
      'deposito_id'      => new sfWidgetFormInputText(),
      'factura_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Factura'), 'add_empty' => false)),
      'num_nota_credito' => new sfWidgetFormInputText(),
      'codigof'          => new sfWidgetFormInputText(),
      'cliente_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'), 'add_empty' => false)),
      'fecha'            => new sfWidgetFormDate(),
      'descripcion'      => new sfWidgetFormTextarea(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'created_by'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'empresa_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
      'deposito_id'      => new sfValidatorInteger(),
      'factura_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Factura'))),
      'num_nota_credito' => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'codigof'          => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'cliente_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Cliente'))),
      'fecha'            => new sfValidatorDate(),
      'descripcion'      => new sfValidatorString(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'created_by'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'required' => false)),
      'updated_by'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('devolver[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Devolver';
  }

}
