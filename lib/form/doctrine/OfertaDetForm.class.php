<?php

/**
 * OfertaDet form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OfertaDetForm extends BaseOfertaDetForm
{
  public function configure()
  {
    unset(
      $this['oferta_id']
    );

    $this->widgetSchema->setLabels(array(
      'fecha_venc' => 'Fecha de Vencimiento',
      'lote' => 'Codigo de Lote',
      'cantidad' => 'Cantidad',
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'inventario_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Inventario'), 'required' => true)),
    ));
  }
}
