<?php

/**
 * InvAjuste form.
 *
 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InvAjusteForm extends BaseInvAjusteForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'], 
      $this['created_by'],
      $this['updated_by']
    );

    $this->setWidget('empresa_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)));
    $this->setWidget('deposito_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => true)));
    $this->widgetSchema['empresa_id']->addOption('order_by',array('nombre','asc'));
    $this->widgetSchema['deposito_id']->addOption('order_by',array('nombre','asc'));

    $this->widgetSchema['total']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['deposito_id']->setAttributes(array('class' => 'form-control', 'required' => 'required'));

    // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getInvAjusteDet();
    if (!$detgals){
      $detgal = new getInvAjusteDet();
      $detgal->setInvAjuste($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new InvAjusteDetForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('inv_ajuste_det', $detgals_forms);

    $this->setValidators(array(
       'id' => new sfValidatorInteger(array('required' => true)),
       'empresa_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
       'deposito_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
       'ncontrol'   => new sfValidatorPass(),
       'tasa_cambio'   => new sfValidatorPass(),
       'total'   => new sfValidatorPass(),
       'descripcion'   => new sfValidatorString(array('max_length' => 2000, 'min_length' => 1, 'required'=> false), array(
        'required'   => 'Requerido',
        'min_length' => 'Campo invalido, "%value%" es muy corto debe ser de %min_length% caracteres minimo',
        'max_length' => 'Campo invalido, "%value%" es muy largo debe ser de %max_length% caracteres maximo',
        'invalid'=> 'Campo invalido.'
        )),
      ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'InvAjuste', 'column' => array('id')), array(
          'invalid'=> 'Codigo ya existente')),
        new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
      ))
    );
  }

  public function validaciones($validator, $values) {
    if($this->isNew()) {
      $eid=$values['deposito_id'];
      $count_ccs = Doctrine_Core::getTable('InvAjuste')
        ->createQuery('a')
        ->select('COUNT(id) as contador')
        ->Where("id LIKE '$eid%'")
        ->limit(1)
        ->execute();
      $count = 0;
      foreach ($count_ccs as $count_cc) {
        $count=$count_cc["contador"];
        break;
      }
      $count = $count+1;
      $values['id']=$eid.$count;
    }
    return $values;
  }

  public function addDetalles($num){
    $detgal = new InvAjusteDet();
    $detgal->setInvAjuste($this->getObject());
    $detgal_form = new InvAjusteDetForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['inv_ajuste_det']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('inv_ajuste_det', $this->embeddedForms['inv_ajuste_det']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['inv_ajuste_det']) {
      foreach($taintedValues['inv_ajuste_det'] as $key=>$newTodo) {
        if (!isset($this['inv_ajuste_det'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }
}
