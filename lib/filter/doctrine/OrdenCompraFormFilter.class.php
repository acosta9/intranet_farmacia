<?php

/**
 * OrdenCompra filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OrdenCompraFormFilter extends BaseOrdenCompraFormFilter
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

    $choices_est = array();
    $results = Doctrine_Query::create()
      ->select('e.nombre')
      ->from('OrdenCompraEstatus e')
      ->orderBy('e.nombre ASC')
      ->execute();
    foreach ($results as $result) {
      $choices_est[$result->getId()]=$result["nombre"];
    }

    
    $this->setWidget('cliente', new sfWidgetFormFilterInput(array('with_empty' => false)));
    $this->setWidget('creado_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('updated_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('empresa_id', new sfWidgetFormSelect(array('choices' =>  $choices_emp, 'multiple' => 'multiple')));
    $this->setWidget('estatus', new sfWidgetFormSelect(array('choices' =>  $choices_est, 'multiple' => 'multiple')));

    $this->widgetSchema['estatus']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['cliente']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['created_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['updated_by']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['estatus'] = new sfValidatorPass();
    $this->validatorSchema ['creado_por'] = new sfValidatorPass();
    $this->validatorSchema ['updated_por'] = new sfValidatorPass();
    $this->validatorSchema ['empresa_id'] = new sfValidatorPass();
    $this->validatorSchema ['cliente'] = new sfValidatorPass();
  }
  public function getFields() {
    $fields = parent::getFields();
    $fields['estatus'] = 'Text';
    $fields['creado_por'] = 'Text';
    $fields['updated_por'] = 'Text';
    $fields['empresa_id'] = 'Text';
    $fields['cliente'] = 'Text';
    return $fields;
  }
  public function addEstatusColumnQuery($query, $field, $value) {
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn("orden_compra_estatus_id", $value);
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
  public function addClienteColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>1) {
      return $query->andwhere("cl.full_name LIKE '%$valor%' OR cl.doc_id LIKE '%$valor%'");
    }
  }
}
