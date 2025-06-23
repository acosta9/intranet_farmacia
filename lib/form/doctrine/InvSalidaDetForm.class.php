<?php

/**
 * InvSalidaDet form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InvSalidaDetForm extends BaseInvSalidaDetForm
{
  public function configure()
  {
    unset(
      $this['inv_salida_id']
    );
    $this->widgetSchema->setLabels(array(
      'lote' => 'Codigo de Lote',
      'cantidad' => 'Cantidad',
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'qty'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'     => new sfValidatorString(array('max_length' => 20)),
      'price_tot'      => new sfValidatorString(array('max_length' => 20)),
      'inventario_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'))),
      'devolucion'           => new sfValidatorString(array('max_length' => 200, 'required' => false)),
    ));
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
    );
  }
  public function validaciones($validator, $values) {
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
