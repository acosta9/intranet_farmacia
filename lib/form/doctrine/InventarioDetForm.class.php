<?php

/**
 * InventarioDet form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InventarioDetForm extends BaseInventarioDetForm
{
  public function configure()
  {
    unset(
      $this['inventario_id'],
      $this['created_at'],
      $this['updated_at']
    );

    $this->setWidget('fecha_venc', new sfWidgetFormInputText());
    $this->widgetSchema['fecha_venc']->setAttributes(array('class' => 'form-control update_fecha', 'data-inputmask' => "'mask': '99/99/9999', 'placeholder': 'dd/mm/yyyy'", 'data-mask' => " "));

    $this->widgetSchema->setLabels(array(
      'fecha_venc' => 'Fecha de Vencimiento',
      'lote' => 'Codigo de Lote',
      'cantidad' => 'Cantidad',
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'lote'   => new sfValidatorString(array('max_length' => 40, 'min_length' => 1, 'required'=> true), array(
       'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
      )),
      'cantidad' => new sfValidatorPass(),
      'fecha_venc'   => new sfValidatorPass(),
    ));
  }
}
