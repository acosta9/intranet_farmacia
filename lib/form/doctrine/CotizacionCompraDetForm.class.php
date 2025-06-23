<?php

/**
 * CotizacionCompraDet form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CotizacionCompraDetForm extends BaseCotizacionCompraDetForm
{
  public function configure()
  {
    unset(
      $this['cotizacion_compra_id']
    );

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
