<?php

/**
 * Inventario form.
 *

 * @package    ired.localhost
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class InventarioForm extends BaseInventarioForm
{
  public function configure()
  {
    unset(
      $this['created_at'],
      $this['updated_at'],
      $this['created_by'],
      $this['updated_by'],
      $this['inventario_det']
    );

    $this->setWidget('empresa_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'), 'add_empty' => true)));
    $this->setWidget('deposito_id', new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'), 'add_empty' => true)));
    $this->setWidget('activo', new sfWidgetFormChoice(array('choices' => array(0 => 'DES-HABILITADO', 1 => 'HABILITADO'))));

    $this->widgetSchema['empresa_id']->addOption('order_by',array('nombre','asc'));
    $this->widgetSchema['deposito_id']->addOption('order_by',array('nombre','asc'));

    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['deposito_id']->setAttributes(array('class' => 'form-control', 'required' => 'required'));
    $this->widgetSchema['producto_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['activo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['cantidad']->setAttributes(array('class' => 'form-control', 'readonly' => 'readonly'));
    $this->widgetSchema['limite_stock']->setAttributes(array('class' => 'form-control', 'readonly' => 'readonly'));

    $this->setDefault("cantidad", "0");
    $this->setDefault("limite_stock", "0");

    // EMBEDIR DETALLES GALERIA
    //Empotramos al menos un formulario de detalles_factura
    $detgals = $this->getObject()->getInventarioDet();
    if (!$detgals){
      $detgal = new getInventarioDet();
      $detgal->setInventario($this->getObject());
      $detgals = array($detgal);
    }
    //Un formulario vacío hará de contenedor para todas los detalles
    $detgals_forms = new SfForm();
    $count = 1;
    foreach ($detgals as $detgal) {
      $detgals_form = new InventarioDetForm($detgal);
      //Empotramos cada formulario en el contenedor
      $detgals_forms->embedForm($count, $detgals_form);
      $count ++;
    }
    //Empotramos el contenedor en el formulario principal
    $this->embedForm('inventario_det', $detgals_forms);

    $this->setValidators(array(
       'id' => new sfValidatorInteger(array('required' => true)),
       'empresa_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Empresa'))),
       'deposito_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('InvDeposito'))),
       'producto_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Producto'))),
       'activo'   => new sfValidatorPass(),
       'inventario_det'   => new sfValidatorPass(),
       'cantidad' => new sfValidatorPass(),
       'limite_stock' => new sfValidatorInteger(array('required' => true)),
      ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Inventario', 'column' => array('id')), array(
          'invalid'=> 'Codigo ya existente')),
        new sfValidatorCallback(array('callback' => array($this, 'validaciones')))
      ))
    );
  }

  public function validaciones($validator, $values) {
    if(!empty($values['producto_id']) && !empty($values['deposito_id']) && $this->isNew()) {
      $results = Doctrine_Core::getTable('Inventario')
        ->createQuery('a')
        ->select('COUNT(id) as contador')
        ->Where("deposito_id =?", $values['deposito_id'])
        ->AndWhere("producto_id =?", $values['producto_id'])
        ->limit(1)
        ->execute();
      $count = 0;
      foreach ($results as $result) {
        $count=$result["contador"];
        break;
      }
      if($count>0) {
        $error = new sfValidatorError($validator, 'Ya esta ingresado el producto seleccionado al inventario');
        throw new sfValidatorErrorSchema($validator, array('producto_id' => $error));
      }
    }
    if($this->isNew()) {
      $eid=$values['deposito_id'];
      $count_ccs = Doctrine_Core::getTable('Inventario')
        ->createQuery('a')
        ->select('id as contador')
        ->Where("id LIKE '$eid%'")
        ->orderby('id DESC')
        ->limit(1)
        ->execute();
      $countt = 0;
      foreach ($count_ccs as $count_cc) {
        $countt=$count_cc["contador"];
        break;
      }
      $count=substr($countt, 3)."<br/>";
      $count=$count+1;
      $count=$eid.$count;
      $values['id']=$count;
    }

    return $values;
  }

  public function addDetalles($num){
    $detgal = new InventarioDet();
    $detgal->setInventario($this->getObject());
    $detgal_form = new InventarioDetForm($detgal);

    //Empotramos la nueva pícture en el contenedor
    $this->embeddedForms['inventario_det']->embedForm($num, $detgal_form);
    //Volvemos a empotrar el contenedor
    $this->embedForm('inventario_det', $this->embeddedForms['inventario_det']);
  }
  public function bind(array $taintedValues = null, array $taintedFiles = null)   {
    if(@$taintedValues['inventario_det']) {
      foreach($taintedValues['inventario_det'] as $key=>$newTodo) {
        if (!isset($this['inventario_det'][$key])) {
          $this->addDetalles($key);
        }
      }
    }
    parent::bind($taintedValues, $taintedFiles);
  }
}
