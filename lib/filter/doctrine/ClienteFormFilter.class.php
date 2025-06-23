<?php

/**
 * Cliente filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ClienteFormFilter extends BaseClienteFormFilter
{
  public function configure() {
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

    $choices_vendedor = array();
    $results = Doctrine_Query::create()
      ->select('u.*')
      ->from('sfGuardUser u')
      ->orderBy('u.full_name ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_vendedor[$result->getId()]=$result->getFullName()." (".$result->getUsername().")";
    }
    $this->setWidget('vendedor', new sfWidgetFormSelect(array('choices' =>  $choices_vendedor, 'multiple' => 'multiple')));
    $this->setWidget('creado_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('updated_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));
    $this->setWidget('empresa_id', new sfWidgetFormSelect(array('choices' =>  $choices_emp, 'multiple' => 'multiple')));

    $this->setWidget('tipo', new sfWidgetFormChoice(array('choices' => array(
       1 => 'PRECIO 01',
       2 => 'PRECIO 02',
       3 => 'PRECIO 03',
       4 => 'PRECIO 04',
       5 => 'PRECIO 05',
       6 => 'PRECIO 06',
       7 => 'PRECIO 07'
    ), 'multiple' => 'multiple')));
    $this->setWidget('telefono', new sfWidgetFormFilterInput(array('with_empty' => false)));

    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['full_name']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tipo']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['telefono']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['created_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['updated_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['doc_id']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['telefono'] = new sfValidatorPass();
    $this->validatorSchema ['tipo'] = new sfValidatorPass();
    $this->validatorSchema ['vendedor'] = new sfValidatorPass();
    $this->validatorSchema ['creado_por'] = new sfValidatorPass();
    $this->validatorSchema ['updated_por'] = new sfValidatorPass();
    $this->validatorSchema ['empresa_id'] = new sfValidatorPass();
  }
  public function getFields() {
    $fields = parent::getFields();
    $fields['telefono'] = 'Text';
    $fields['tipo'] = 'Text';
    $fields['vendedor'] = 'Text';
    $fields['creado_por'] = 'Text';
    $fields['updated_por'] = 'Text';
    $fields['empresa_id'] = 'Text';
    return $fields;
  }
  public function addTelefonoColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>1) {
      return $query->andwhere("telf = '$valor' OR celular = '$valor'");
    }
  }
  public function addTipoColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.tipo_precio', $value);
  }
/*  public function addVendedorColumnQuery($query, $field, $value) {
    return $query->andwhere("vendedor_01 = '$value' OR vendedor_02 = '$value'");
  } */
  public function addVendedorColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn($rootAlias.'.vendedor_01', $value)->orWhereIn($rootAlias.'.vendedor_02', $value);
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
