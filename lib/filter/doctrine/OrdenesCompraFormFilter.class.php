<?php

/**
 * OrdenesCompra filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OrdenesCompraFormFilter extends BaseOrdenesCompraFormFilter
{
  public function configure()
  {
    $choices_user = array();
    $results = Doctrine_Query::create()
      ->select('u.full_name, u.username')
      ->from('SfGuardUser u')
      ->orderBy('u.full_name ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_user[$result->getId()]=$result["full_name"]." (".$result["username"].")";
    }

    $choices_emp = array();
    $results = Doctrine_Query::create()
      ->select('e.nombre')
      ->from('Empresa e')
      ->orderBy('e.nombre ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_emp[$result->getId()]=$result["nombre"];
    }

    $choices_empty = array();

    $this->setWidget('creado_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('updated_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('empresa_id', new sfWidgetFormSelect(array('choices' =>  $choices_emp, 'multiple' => 'multiple')));
    $this->setWidget('proveedor', new sfWidgetFormSelect(array('choices' =>  $choices_empty)));
    $this->setWidget('cotizacion_id', new sfWidgetFormSelect(array('choices' =>  $choices_empty, 'multiple' => 'multiple')));
    
    $this->setWidget('estatus', new sfWidgetFormChoice(array('multiple' => 'multiple', 'choices' => array(1 => 'COTIZACION', 2 => 'OC INGRESADA', 3 => 'OC PENDIENTE', 4 => 'OC CERRADA', 5 => 'ANULADO'))));
    $this->setWidget('ncontrol', new sfWidgetFormFilterInput(array('with_empty' => false)));

    $this->widgetSchema['estatus']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['proveedor_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['cotizacion_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['ncontrol']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['created_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['updated_by']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['estatus'] = new sfValidatorPass();
    $this->validatorSchema ['creado_por'] = new sfValidatorPass();
    $this->validatorSchema ['updated_por'] = new sfValidatorPass();
    $this->validatorSchema ['empresa_id'] = new sfValidatorPass();
    $this->validatorSchema ['proveedor'] = new sfValidatorPass();
    $this->validatorSchema ['cotizacion_id'] = new sfValidatorPass();
  }
  public function getFields() {
    $fields = parent::getFields();
    $fields['estatus'] = 'Text';
    $fields['creado_por'] = 'Text';
    $fields['updated_por'] = 'Text';
    $fields['empresa_id'] = 'Text';
    $fields['proveedor'] = 'Text';
    $fields['cotizacion_id'] = 'Text';
    return $fields;
  }
  public function addProveedorColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if(strlen($value)>1) {
      return $query->andwhere($rootAlias.'.proveedor_id = ?', $value);
    }
  }
  public function addCotizacionIdColumnQuery($query, $field, $value) {
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn("cc.id", $value);
  }
  public function addEstatusColumnQuery($query, $field, $value) {
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn("estatus", $value);
  }
  public function addCreadoPorColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.created_by', $value);
  }
  public function addUpdatedPorColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.updated_by', $value);
  }
  public function addEmpresaIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.empresa_id', $value);
  }
}
