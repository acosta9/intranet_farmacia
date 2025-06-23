<?php

/**
 * CuentasCobrar filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CuentasCobrarFormFilter extends BaseCuentasCobrarFormFilter
{
  public function configure()
  {
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
    $this->setWidget('estatus', new sfWidgetFormChoice(array('multiple' => 'multiple', 'choices' => array(1 => 'PENDIENTE', 2 => 'ABONADO', 3 => 'CANCELADO', 4 => 'ANULADO'))));
    $this->setWidget('cliente', new sfWidgetFormFilterInput(array('with_empty' => false)));

    $this->widgetSchema['cliente']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['estatus']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['estatus'] = new sfValidatorPass();
    $this->validatorSchema ['empresa_id'] = new sfValidatorPass();
    $this->validatorSchema ['cliente'] = new sfValidatorPass();
  }
  public function getFields() {
    $fields = parent::getFields();
    $fields['estatus'] = 'Text';
    $fields['empresa_id'] = 'Text';
    $fields['cliente'] = 'Text';
    return $fields;
  }
  public function addClienteColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>1) {
      return $query->andwhere("c.full_name LIKE '%$valor%'");
    }
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
