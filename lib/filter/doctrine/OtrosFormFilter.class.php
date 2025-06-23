<?php

/**
 * Otros filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class OtrosFormFilter extends BaseOtrosFormFilter
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
    $this->setWidget('empresa_id', new sfWidgetFormSelect(array('choices' =>  $choices_emp, 'multiple' => 'multiple')));
    $this->setWidget('creado_por', new sfWidgetFormSelect(array('choices' =>  $choices_user, 'multiple' => 'multiple')));

    $this->setWidget('nombre', new sfWidgetFormChoice(array('choices' => array('' => '', 'T01' => 'TASA DE MEDICAMENTOS', 'T02' => 'TASA DE MISCELANEOS', 'T03' => 'TASA DEL DIA'))));

    $this->widgetSchema['nombre']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['valor']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['created_by']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['updated_by']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['creado_por'] = new sfValidatorPass();
    $this->validatorSchema ['empresa_id'] = new sfValidatorPass();
    $this->validatorSchema ['nombre'] = new sfValidatorPass();
  }
  public function getFields() {
    $fields = parent::getFields();
    $fields['creado_por'] = 'Text';
    $fields['empresa_id'] = 'Text';
    $fields['nombre'] = 'Text';
    return $fields;
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
  public function addNombreColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    return $query->andwhere($rootAlias.".nombre =?", $value);
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
  /*public function addCategoriaIdColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    $second="IS NOT NULL";
    foreach ($value as $val) {
      if($val=="NULL") {
          $second="IS NULL";
      }
    }
    return $query->andWhereIn($rootAlias.'.categoria_id', $value)->orWhere($rootAlias.".categoria_id $second");
  } */
}
