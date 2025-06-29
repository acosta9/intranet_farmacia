<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Retenciones', 'doctrine');

/**
 * BaseRetenciones
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $empresa_id
 * @property integer $cliente_id
 * @property integer $cuentas_cobrar_id
 * @property date $fecha
 * @property string $comprobante
 * @property string $base_imponible
 * @property string $iva_impuesto
 * @property string $monto
 * @property string $monto_usd
 * @property string $url_imagen
 * @property integer $tipo
 * @property string $descripcion
 * @property boolean $anulado
 * @property CuentasCobrar $CuentasCobrar
 * @property Empresa $Empresa
 * @property Cliente $Cliente
 * 
 * @method integer       getId()                Returns the current record's "id" value
 * @method integer       getEmpresaId()         Returns the current record's "empresa_id" value
 * @method integer       getClienteId()         Returns the current record's "cliente_id" value
 * @method integer       getCuentasCobrarId()   Returns the current record's "cuentas_cobrar_id" value
 * @method date          getFecha()             Returns the current record's "fecha" value
 * @method string        getComprobante()       Returns the current record's "comprobante" value
 * @method string        getBaseImponible()     Returns the current record's "base_imponible" value
 * @method string        getIvaImpuesto()       Returns the current record's "iva_impuesto" value
 * @method string        getMonto()             Returns the current record's "monto" value
 * @method string        getMontoUsd()          Returns the current record's "monto_usd" value
 * @method string        getUrlImagen()         Returns the current record's "url_imagen" value
 * @method integer       getTipo()              Returns the current record's "tipo" value
 * @method string        getDescripcion()       Returns the current record's "descripcion" value
 * @method boolean       getAnulado()           Returns the current record's "anulado" value
 * @method CuentasCobrar getCuentasCobrar()     Returns the current record's "CuentasCobrar" value
 * @method Empresa       getEmpresa()           Returns the current record's "Empresa" value
 * @method Cliente       getCliente()           Returns the current record's "Cliente" value
 * @method Retenciones   setId()                Sets the current record's "id" value
 * @method Retenciones   setEmpresaId()         Sets the current record's "empresa_id" value
 * @method Retenciones   setClienteId()         Sets the current record's "cliente_id" value
 * @method Retenciones   setCuentasCobrarId()   Sets the current record's "cuentas_cobrar_id" value
 * @method Retenciones   setFecha()             Sets the current record's "fecha" value
 * @method Retenciones   setComprobante()       Sets the current record's "comprobante" value
 * @method Retenciones   setBaseImponible()     Sets the current record's "base_imponible" value
 * @method Retenciones   setIvaImpuesto()       Sets the current record's "iva_impuesto" value
 * @method Retenciones   setMonto()             Sets the current record's "monto" value
 * @method Retenciones   setMontoUsd()          Sets the current record's "monto_usd" value
 * @method Retenciones   setUrlImagen()         Sets the current record's "url_imagen" value
 * @method Retenciones   setTipo()              Sets the current record's "tipo" value
 * @method Retenciones   setDescripcion()       Sets the current record's "descripcion" value
 * @method Retenciones   setAnulado()           Sets the current record's "anulado" value
 * @method Retenciones   setCuentasCobrar()     Sets the current record's "CuentasCobrar" value
 * @method Retenciones   setEmpresa()           Sets the current record's "Empresa" value
 * @method Retenciones   setCliente()           Sets the current record's "Cliente" value
 * 
 * @package    ired.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRetenciones extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('retenciones');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('empresa_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('cliente_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('cuentas_cobrar_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('fecha', 'date', 25, array(
             'type' => 'date',
             'notnull' => true,
             'length' => 25,
             ));
        $this->hasColumn('comprobante', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('base_imponible', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('iva_impuesto', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('monto', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('monto_usd', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('url_imagen', 'string', 200, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 200,
             ));
        $this->hasColumn('tipo', 'integer', 1, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('descripcion', 'string', null, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '',
             ));
        $this->hasColumn('anulado', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('CuentasCobrar', array(
             'local' => 'cuentas_cobrar_id',
             'foreign' => 'id'));

        $this->hasOne('Empresa', array(
             'local' => 'empresa_id',
             'foreign' => 'id'));

        $this->hasOne('Cliente', array(
             'local' => 'cliente_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $signable0 = new Doctrine_Template_Signable();
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}