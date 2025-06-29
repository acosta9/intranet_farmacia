<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('FacturaGastos', 'doctrine');

/**
 * BaseFacturaGastos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $gastos_tipo_id
 * @property integer $tipo
 * @property date $fecha
 * @property date $fecha_recepcion
 * @property string $dias_credito
 * @property integer $empresa_id
 * @property integer $proveedor_id
 * @property string $razon_social
 * @property string $doc_id
 * @property string $telf
 * @property string $direccion
 * @property string $ncontrol
 * @property string $num_factura
 * @property string $tasa_cambio
 * @property string $descuento
 * @property string $iva
 * @property string $base_imponible
 * @property string $iva_monto
 * @property string $subtotal
 * @property string $subtotal_desc
 * @property string $total
 * @property string $total2
 * @property string $monto_faltante
 * @property string $monto_pagado
 * @property integer $estatus
 * @property integer $libro_compras
 * @property Proveedor $Proveedor
 * @property GastosTipo $GastosTipo
 * @property Empresa $Empresa
 * @property Doctrine_Collection $FacturaGastosDet
 * @property Doctrine_Collection $CuentasPagar
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method integer             getGastosTipoId()     Returns the current record's "gastos_tipo_id" value
 * @method integer             getTipo()             Returns the current record's "tipo" value
 * @method date                getFecha()            Returns the current record's "fecha" value
 * @method date                getFechaRecepcion()   Returns the current record's "fecha_recepcion" value
 * @method string              getDiasCredito()      Returns the current record's "dias_credito" value
 * @method integer             getEmpresaId()        Returns the current record's "empresa_id" value
 * @method integer             getProveedorId()      Returns the current record's "proveedor_id" value
 * @method string              getRazonSocial()      Returns the current record's "razon_social" value
 * @method string              getDocId()            Returns the current record's "doc_id" value
 * @method string              getTelf()             Returns the current record's "telf" value
 * @method string              getDireccion()        Returns the current record's "direccion" value
 * @method string              getNcontrol()         Returns the current record's "ncontrol" value
 * @method string              getNumFactura()       Returns the current record's "num_factura" value
 * @method string              getTasaCambio()       Returns the current record's "tasa_cambio" value
 * @method string              getDescuento()        Returns the current record's "descuento" value
 * @method string              getIva()              Returns the current record's "iva" value
 * @method string              getBaseImponible()    Returns the current record's "base_imponible" value
 * @method string              getIvaMonto()         Returns the current record's "iva_monto" value
 * @method string              getSubtotal()         Returns the current record's "subtotal" value
 * @method string              getSubtotalDesc()     Returns the current record's "subtotal_desc" value
 * @method string              getTotal()            Returns the current record's "total" value
 * @method string              getTotal2()           Returns the current record's "total2" value
 * @method string              getMontoFaltante()    Returns the current record's "monto_faltante" value
 * @method string              getMontoPagado()      Returns the current record's "monto_pagado" value
 * @method integer             getEstatus()          Returns the current record's "estatus" value
 * @method integer             getLibroCompras()     Returns the current record's "libro_compras" value
 * @method Proveedor           getProveedor()        Returns the current record's "Proveedor" value
 * @method GastosTipo          getGastosTipo()       Returns the current record's "GastosTipo" value
 * @method Empresa             getEmpresa()          Returns the current record's "Empresa" value
 * @method Doctrine_Collection getFacturaGastosDet() Returns the current record's "FacturaGastosDet" collection
 * @method Doctrine_Collection getCuentasPagar()     Returns the current record's "CuentasPagar" collection
 * @method FacturaGastos       setId()               Sets the current record's "id" value
 * @method FacturaGastos       setGastosTipoId()     Sets the current record's "gastos_tipo_id" value
 * @method FacturaGastos       setTipo()             Sets the current record's "tipo" value
 * @method FacturaGastos       setFecha()            Sets the current record's "fecha" value
 * @method FacturaGastos       setFechaRecepcion()   Sets the current record's "fecha_recepcion" value
 * @method FacturaGastos       setDiasCredito()      Sets the current record's "dias_credito" value
 * @method FacturaGastos       setEmpresaId()        Sets the current record's "empresa_id" value
 * @method FacturaGastos       setProveedorId()      Sets the current record's "proveedor_id" value
 * @method FacturaGastos       setRazonSocial()      Sets the current record's "razon_social" value
 * @method FacturaGastos       setDocId()            Sets the current record's "doc_id" value
 * @method FacturaGastos       setTelf()             Sets the current record's "telf" value
 * @method FacturaGastos       setDireccion()        Sets the current record's "direccion" value
 * @method FacturaGastos       setNcontrol()         Sets the current record's "ncontrol" value
 * @method FacturaGastos       setNumFactura()       Sets the current record's "num_factura" value
 * @method FacturaGastos       setTasaCambio()       Sets the current record's "tasa_cambio" value
 * @method FacturaGastos       setDescuento()        Sets the current record's "descuento" value
 * @method FacturaGastos       setIva()              Sets the current record's "iva" value
 * @method FacturaGastos       setBaseImponible()    Sets the current record's "base_imponible" value
 * @method FacturaGastos       setIvaMonto()         Sets the current record's "iva_monto" value
 * @method FacturaGastos       setSubtotal()         Sets the current record's "subtotal" value
 * @method FacturaGastos       setSubtotalDesc()     Sets the current record's "subtotal_desc" value
 * @method FacturaGastos       setTotal()            Sets the current record's "total" value
 * @method FacturaGastos       setTotal2()           Sets the current record's "total2" value
 * @method FacturaGastos       setMontoFaltante()    Sets the current record's "monto_faltante" value
 * @method FacturaGastos       setMontoPagado()      Sets the current record's "monto_pagado" value
 * @method FacturaGastos       setEstatus()          Sets the current record's "estatus" value
 * @method FacturaGastos       setLibroCompras()     Sets the current record's "libro_compras" value
 * @method FacturaGastos       setProveedor()        Sets the current record's "Proveedor" value
 * @method FacturaGastos       setGastosTipo()       Sets the current record's "GastosTipo" value
 * @method FacturaGastos       setEmpresa()          Sets the current record's "Empresa" value
 * @method FacturaGastos       setFacturaGastosDet() Sets the current record's "FacturaGastosDet" collection
 * @method FacturaGastos       setCuentasPagar()     Sets the current record's "CuentasPagar" collection
 * 
 * @package    ired.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFacturaGastos extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('factura_gastos');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'primary' => true,
             'length' => 4,
             ));
        $this->hasColumn('gastos_tipo_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('tipo', 'integer', 1, array(
             'type' => 'integer',
             'default' => 1,
             'unsigned' => true,
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('fecha', 'date', 25, array(
             'type' => 'date',
             'notnull' => true,
             'length' => 25,
             ));
        $this->hasColumn('fecha_recepcion', 'date', 25, array(
             'type' => 'date',
             'notnull' => true,
             'length' => 25,
             ));
        $this->hasColumn('dias_credito', 'string', 4, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('empresa_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('proveedor_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('razon_social', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
        $this->hasColumn('doc_id', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('telf', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('direccion', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '',
             ));
        $this->hasColumn('ncontrol', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('num_factura', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('tasa_cambio', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('descuento', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 0,
             'length' => 20,
             ));
        $this->hasColumn('iva', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('base_imponible', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('iva_monto', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('subtotal', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('subtotal_desc', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('total', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('total2', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('monto_faltante', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('monto_pagado', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('estatus', 'integer', 1, array(
             'type' => 'integer',
             'default' => 1,
             'unsigned' => true,
             'notnull' => true,
             'length' => 1,
             ));
        $this->hasColumn('libro_compras', 'integer', 1, array(
             'type' => 'integer',
             'default' => 1,
             'unsigned' => true,
             'notnull' => true,
             'length' => 1,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Proveedor', array(
             'local' => 'proveedor_id',
             'foreign' => 'id'));

        $this->hasOne('GastosTipo', array(
             'local' => 'gastos_tipo_id',
             'foreign' => 'id'));

        $this->hasOne('Empresa', array(
             'local' => 'empresa_id',
             'foreign' => 'id'));

        $this->hasMany('FacturaGastosDet', array(
             'local' => 'id',
             'foreign' => 'factura_gastos_id'));

        $this->hasMany('CuentasPagar', array(
             'local' => 'id',
             'foreign' => 'factura_gastos_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $signable0 = new Doctrine_Template_Signable();
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}