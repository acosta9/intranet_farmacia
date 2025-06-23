<?php

/**
 * Empresa filter form base class.
 *
 * @package    ired.localhost
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseEmpresaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'nombre'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'acronimo'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ncontrol'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nfactura'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ndespacho'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nentrega'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'npago'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ncredito'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ntraslado'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ncompra'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'factcompra'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'factgasto'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ordencompra'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'coticompra'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'rif'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'cod_coorpotulipa'         => new sfWidgetFormFilterInput(),
      'direccion'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'telefono'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tipo'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'iva'                      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tasa'                     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'venc_registro_comercio'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'venc_rif'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'venc_bomberos'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'venc_lic_funcionamiento'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'venc_uso_conforme'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'venc_permiso_sanitario'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'venc_permiso_instalacion' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'venc_destinado_afines'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'venc_destinado_abastos'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'descripcion'              => new sfWidgetFormFilterInput(),
      'created_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'created_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Creator'), 'add_empty' => true)),
      'updated_by'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Updator'), 'add_empty' => true)),
      'user_list'                => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'nombre'                   => new sfValidatorPass(array('required' => false)),
      'acronimo'                 => new sfValidatorPass(array('required' => false)),
      'ncontrol'                 => new sfValidatorPass(array('required' => false)),
      'nfactura'                 => new sfValidatorPass(array('required' => false)),
      'ndespacho'                => new sfValidatorPass(array('required' => false)),
      'nentrega'                 => new sfValidatorPass(array('required' => false)),
      'npago'                    => new sfValidatorPass(array('required' => false)),
      'ncredito'                 => new sfValidatorPass(array('required' => false)),
      'ntraslado'                => new sfValidatorPass(array('required' => false)),
      'ncompra'                  => new sfValidatorPass(array('required' => false)),
      'factcompra'               => new sfValidatorPass(array('required' => false)),
      'factgasto'                => new sfValidatorPass(array('required' => false)),
      'ordencompra'              => new sfValidatorPass(array('required' => false)),
      'coticompra'               => new sfValidatorPass(array('required' => false)),
      'rif'                      => new sfValidatorPass(array('required' => false)),
      'cod_coorpotulipa'         => new sfValidatorPass(array('required' => false)),
      'direccion'                => new sfValidatorPass(array('required' => false)),
      'telefono'                 => new sfValidatorPass(array('required' => false)),
      'email'                    => new sfValidatorPass(array('required' => false)),
      'tipo'                     => new sfValidatorPass(array('required' => false)),
      'iva'                      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tasa'                     => new sfValidatorPass(array('required' => false)),
      'venc_registro_comercio'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'venc_rif'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'venc_bomberos'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'venc_lic_funcionamiento'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'venc_uso_conforme'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'venc_permiso_sanitario'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'venc_permiso_instalacion' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'venc_destinado_afines'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'venc_destinado_abastos'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'descripcion'              => new sfValidatorPass(array('required' => false)),
      'created_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Creator'), 'column' => 'id')),
      'updated_by'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Updator'), 'column' => 'id')),
      'user_list'                => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('empresa_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addUserListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.EmpresaUser EmpresaUser')
      ->andWhereIn('EmpresaUser.user_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Empresa';
  }

  public function getFields()
  {
    return array(
      'id'                       => 'Number',
      'nombre'                   => 'Text',
      'acronimo'                 => 'Text',
      'ncontrol'                 => 'Text',
      'nfactura'                 => 'Text',
      'ndespacho'                => 'Text',
      'nentrega'                 => 'Text',
      'npago'                    => 'Text',
      'ncredito'                 => 'Text',
      'ntraslado'                => 'Text',
      'ncompra'                  => 'Text',
      'factcompra'               => 'Text',
      'factgasto'                => 'Text',
      'ordencompra'              => 'Text',
      'coticompra'               => 'Text',
      'rif'                      => 'Text',
      'cod_coorpotulipa'         => 'Text',
      'direccion'                => 'Text',
      'telefono'                 => 'Text',
      'email'                    => 'Text',
      'tipo'                     => 'Text',
      'iva'                      => 'Number',
      'tasa'                     => 'Text',
      'venc_registro_comercio'   => 'Date',
      'venc_rif'                 => 'Date',
      'venc_bomberos'            => 'Date',
      'venc_lic_funcionamiento'  => 'Date',
      'venc_uso_conforme'        => 'Date',
      'venc_permiso_sanitario'   => 'Date',
      'venc_permiso_instalacion' => 'Date',
      'venc_destinado_afines'    => 'Date',
      'venc_destinado_abastos'   => 'Date',
      'descripcion'              => 'Text',
      'created_at'               => 'Date',
      'updated_at'               => 'Date',
      'created_by'               => 'ForeignKey',
      'updated_by'               => 'ForeignKey',
      'user_list'                => 'ManyKey',
    );
  }
}
