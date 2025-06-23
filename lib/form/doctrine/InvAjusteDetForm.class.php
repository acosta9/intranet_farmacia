<?php

/**
 * InvAjusteDet form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InvAjusteDetForm extends BaseInvAjusteDetForm
{
  public function configure()
  {
    unset(
      $this['inv_ajuste_id']
    );

    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array(1 => 'SUMA', 2 => 'RESTA'))));
    $this->setWidget('fecha_venc', new sfWidgetFormInputText());
    $this->widgetSchema['fecha_venc']->setAttributes(array('class' => 'form-control update_fecha', 'data-inputmask' => "'mask': '99/99/9999', 'placeholder': 'dd/mm/yyyy'", 'data-mask' => " "));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'qty'               => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'        => new sfValidatorPass(),
      'price_tot'         => new sfValidatorPass(),
      'inventario_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'))),
      'inventario_det_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InventarioDet'))),
      'tipo'              => new sfValidatorPass(),
      'fecha_venc'        => new sfValidatorDate(),
      'lote'              => new sfValidatorString(array('max_length' => 200)),
      'devolucion'        => new sfValidatorString(array('max_length' => 200, 'required' => false)),
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
    return $values;
  }
}