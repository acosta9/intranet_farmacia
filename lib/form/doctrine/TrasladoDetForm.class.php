<?php

/**
 * TrasladoDet form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class TrasladoDetForm extends BaseTrasladoDetForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by'],
      $this['traslado_id']
    );

    $this->widgetSchema->setLabels(array(
      'qty' => 'Cant.',
      'price_unit' => 'P. Unitario',
      'price_tot' => 'Total',
      'descripcion' => 'Concepto',
    ));

    $this->setWidget('inventario_id', new sfWidgetFormInputText());
    $this->setWidget('inv_destino_id', new sfWidgetFormInputText());
    $this->setWidget('producto_id', new sfWidgetFormInputText());
    $this->setWidget('descripcion', new sfWidgetFormInputText());

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'producto_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'))),
      'inventario_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'))),
      'qty'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'inv_destino_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario2'), 'required' => false)),
      'qty_dest'          => new sfValidatorInteger(array('required' => false)),
      'prod_destino_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Producto2'))),
      'price_unit'        => new sfValidatorString(array('max_length' => 20)),
      'price_tot'         => new sfValidatorString(array('max_length' => 20)),
      'descripcion'       => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema['qty']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['price_unit']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['price_tot']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['descripcion']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['producto_id']->setAttributes(array('class' => 'form-control'));

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
    if($this->isNew()) {
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
    }
    return $values;
  }
}
