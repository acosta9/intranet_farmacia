<?php

/**
 * FacturaCompraDet form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FacturaCompraDetForm extends BaseFacturaCompraDetForm
{
  public function configure()
  {
    unset(
      $this['factura_compra_id']
    );

    $this->setWidget('tipo_precio', new sfWidgetFormChoice(array('choices' => array('1' => 'P. ACTUAL', '2' => 'P. PROMEDIO', '3' => 'FACTURA COMPRA'))));

    $this->setWidget('fecha_venc', new sfWidgetFormInputText());
    $this->widgetSchema['fecha_venc']->setAttributes(array('class' => 'form-control'));

    $this->widgetSchema->setLabels(array(
      'fecha_venc' => 'Fecha de Vencimiento',
      'lote' => 'Codigo de Lote'
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
    if(!empty($values['qtyr'])) {
      $money=str_replace(".","",$values['qtyr']);
      $money=str_replace(",",".",$money);
      $values['qtyr'] = floatval($money);
    } else {
      $values['qtyr']=0;
    }    
    if(!empty($values['price_unit'])) {
      $money=str_replace(".","",$values['price_unit']);
      $money=str_replace(",",".",$money);
      $values['price_unit'] = floatval($money);
    } else {
      $values['price_unit']=0;
    }
    if(!empty($values['price_unit_bs'])) {
      $money=str_replace(".","",$values['price_unit_bs']);
      $money=str_replace(",",".",$money);
      $values['price_unit_bs'] = floatval($money);
    } else {
      $values['price_unit_bs']=0;
    }    
    if(!empty($values['price_calculado'])) {
      $money=str_replace(".","",$values['price_calculado']);
      $money=str_replace(",",".",$money);
      $values['price_calculado'] = floatval($money);
    } else {
      $values['price_calculado']=0;
    }
    if(!empty($values['price_tot'])) {
      $money=str_replace(".","",$values['price_tot']);
      $money=str_replace(",",".",$money);
      $values['price_tot'] = floatval($money);
    } else {
      $values['price_tot']=0;
    }
    $values['util_old']=0;
    $values['util_new']=0;
    return $values;
  }
}