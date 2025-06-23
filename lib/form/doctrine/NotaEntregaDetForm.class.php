<?php

/**
 * NotaEntregaDet form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NotaEntregaDetForm extends BaseNotaEntregaDetForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by'],
      $this['nota_entrega_id']
    );

    $this->widgetSchema->setLabels(array(
      'qty' => 'Cant.',
      'price_unit' => 'P. Unitario',
      'price_tot' => 'Total',
      'descripcion' => 'Concepto',
      'exento' => 'Exento',
    ));

    $this->setWidget('inventario_id', new sfWidgetFormInputText());
    $this->setWidget('oferta_id', new sfWidgetFormInputText());
    $this->setWidget('descripcion', new sfWidgetFormInputText());

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'qty'             => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'      => new sfValidatorString(array('max_length' => 20)),
      'price_tot'       => new sfValidatorString(array('max_length' => 20)),
      'exento'       => new sfValidatorString(array('max_length' => 20)),
      'inventario_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'required' => false)),
      'oferta_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Oferta'), 'required' => false)),
    ));

    $this->widgetSchema['qty']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['price_unit']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['price_tot']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['exento']->setAttributes(array('class' => 'form-control'));

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  
  public function validaciones($validator, $values) {
    if(!empty($values['descripcion'])) {
      $values['descripcion'] = trim(strtoupper($values['descripcion']));
    }
    if(!empty($values['qty'])) {
      $money=str_replace(".","",$values['qty']);
      $money=str_replace(",",".",$money);
      $values['qty'] = floatval($money);
    } else {
      $values['qty']=0;
    }
    if(!empty($values['price_unit'])) {
      $money=str_replace(".","",$values['price_unit']);
      $money=str_replace(",",".",$money);
      $values['price_unit'] = floatval($money);
    } else {
      $values['price_unit']=0;
    }
    if(!empty($values['price_tot'])) {
      $money=str_replace(".","",$values['price_tot']);
      $money=str_replace(",",".",$money);
      $values['price_tot'] = floatval($money);
    } else {
      $values['price_tot']=0;
    }
    return $values;
  }
}