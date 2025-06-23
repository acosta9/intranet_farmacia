<?php

/**
 * InvEntradaDet form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InvEntradaDetForm extends BaseInvEntradaDetForm
{
  public function configure()
  {
    unset(
      $this['inv_entrada_id']
    );

    $this->setWidget('fecha_venc', new sfWidgetFormInputText());
    $this->widgetSchema['fecha_venc']->setAttributes(array('class' => 'form-control'));

    $this->widgetSchema->setLabels(array(
      'fecha_venc' => 'Fecha de Vencimiento',
      'lote' => 'Codigo de Lote',
      'cantidad' => 'Cantidad',
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'qty'            => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'price_unit'     => new sfValidatorString(array('max_length' => 20)),
      'price_tot'      => new sfValidatorString(array('max_length' => 20)),
      'inventario_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'))),
      'fecha_venc'     => new sfValidatorDate(),
      'lote'           => new sfValidatorString(array('max_length' => 200)),
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
