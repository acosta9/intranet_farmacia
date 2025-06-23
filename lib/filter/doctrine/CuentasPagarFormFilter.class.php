<?php

/**
 * CuentasPagar filter form.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CuentasPagarFormFilter extends BaseCuentasPagarFormFilter
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

    $choices_gast = array();
    $results = Doctrine_Query::create()
      ->select('g.nombre')
      ->from('GastosTipo g')
      ->orderBy('g.nombre ASC')
      ->execute();
    foreach ($results as $result) {
        $choices_gast[$result->getId()]=$result["nombre"];
    }

    $this->setWidget('tipo_proveedor', new sfWidgetFormChoice(array('choices' => array('' => '', 'factura_compra' => 'FACTURA DE COMPRAS', 'factura_gasto' => 'FACTURA DE GASTOS', 'ambos' => 'F. COMPRAS Y F. GASTOS'))));
    $this->setWidget('empresa_id', new sfWidgetFormSelect(array('choices' =>  $choices_emp, 'multiple' => 'multiple')));
    $this->setWidget('tipo_gastos', new sfWidgetFormSelect(array('choices' =>  $choices_gast, 'multiple' => 'multiple')));
    $this->setWidget('estatus', new sfWidgetFormChoice(array('multiple' => 'multiple', 'choices' => array(1 => 'PENDIENTE', 2 => 'ABONADO', 3 => 'CANCELADO', 4 => 'ANULADO'))));
    $this->setWidget('estatus', new sfWidgetFormChoice(array('multiple' => 'multiple', 'choices' => array(1 => 'PENDIENTE', 2 => 'ABONADO', 3 => 'CANCELADO', 4 => 'ANULADO'))));
    $this->setWidget('proveedor', new sfWidgetFormFilterInput(array('with_empty' => false)));

    $this->widgetSchema['proveedor']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['estatus']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['empresa_id']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tipo_gastos']->setAttributes(array('class' => 'form-control'));
    $this->widgetSchema['tipo_proveedor']->setAttributes(array('class' => 'form-control'));

    $this->setWidget('created_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('updated_at', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('fecha', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));
    $this->setWidget('fecha_recepcion', new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'to_date' => new sfWidgetFormDateJQueryUI(array('change_month' => true, 'change_year'=> true, 'culture' => 'es', 'show_button_panel' => 'true', 'yearRange' => '1930:2040')), 'with_empty' => false)));

    $this->validatorSchema ['estatus'] = new sfValidatorPass();
    $this->validatorSchema ['empresa_id'] = new sfValidatorPass();
    $this->validatorSchema ['proveedor'] = new sfValidatorPass();
    $this->validatorSchema ['tipo_gastos'] = new sfValidatorPass();
    $this->validatorSchema ['tipo_proveedor'] = new sfValidatorPass();
  }
  public function getFields() {
    $fields = parent::getFields();
    $fields['estatus'] = 'Text';
    $fields['empresa_id'] = 'Text';
    $fields['proveedor'] = 'Text';
    $fields['tipo_gastos'] = 'Text';
    $fields['tipo_proveedor'] = 'Text';
    return $fields;
  }
  public function addTipoProveedorColumnQuery($query, $field, $value) {
    //$valor=implode($value);
    if(strlen($value)>1) {
      return $query->andwhere("p.tipo LIKE '%$value%'");
    }
  }
  public function addProveedorColumnQuery($query, $field, $value) {
    $valor=implode($value);
    if(strlen($valor)>1) {
      return $query->andwhere("p.full_name LIKE '%$valor%'");
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
  public function addTipoGastosColumnQuery($query, $field, $value) {
    $rootAlias = $query->getRootAlias();
    if (!is_array($value)) {
      $value = array($value);
    }
    if (!count($value)) {
      return;
    }
    return $query->andWhereIn('fg.gastos_tipo_id', $value);
  }
}
