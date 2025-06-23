<?php

/**
 * OfertaDet filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseOfertaDetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'oferta_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'add_empty' => true)),
      'inventario_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'oferta_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Oferta'), 'column' => 'id')),
      'inventario_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Inventario'), 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('oferta_det_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OfertaDet';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'oferta_id'     => 'ForeignKey',
      'inventario_id' => 'ForeignKey',
    );
  }
}
