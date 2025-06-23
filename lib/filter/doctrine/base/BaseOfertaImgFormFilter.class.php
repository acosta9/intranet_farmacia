<?php

/**
 * OfertaImg filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseOfertaImgFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'oferta_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'add_empty' => true)),
      'url_imagen'  => new sfWidgetFormFilterInput(),
      'descripcion' => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'oferta_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Oferta'), 'column' => 'id')),
      'url_imagen'  => new sfValidatorPass(array('required' => false)),
      'descripcion' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('oferta_img_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'OfertaImg';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'oferta_id'   => 'ForeignKey',
      'url_imagen'  => 'Text',
      'descripcion' => 'Text',
    );
  }
}
