<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('NotaDebito', 'doctrine');

/**
 * BaseNotaDebito
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $empresa_id
 * @property integer $proveedor_id
 * @property string $ncontrol
 * @property tinyint $moneda
 * @property integer $forma_pago_id
 * @property string $num_recibo
 * @property date $fecha
 * @property string $monto
 * @property string $monto_faltante
 * @property string $quien_paga
 * @property string $url_imagen
 * @property string $tasa_cambio
 * @property string $descripcion
 * @property integer $estatus
 * @property integer $libro_compras
 * @property FormaPago $FormaPago
 * @property Empresa $Empresa
 * @property Proveedor $Proveedor
 * @property Doctrine_Collection $NotaDebitoDet
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method integer             getEmpresaId()      Returns the current record's "empresa_id" value
 * @method integer             getProveedorId()    Returns the current record's "proveedor_id" value
 * @method string              getNcontrol()       Returns the current record's "ncontrol" value
 * @method tinyint             getMoneda()         Returns the current record's "moneda" value
 * @method integer             getFormaPagoId()    Returns the current record's "forma_pago_id" value
 * @method string              getNumRecibo()      Returns the current record's "num_recibo" value
 * @method date                getFecha()          Returns the current record's "fecha" value
 * @method string              getMonto()          Returns the current record's "monto" value
 * @method string              getMontoFaltante()  Returns the current record's "monto_faltante" value
 * @method string              getQuienPaga()      Returns the current record's "quien_paga" value
 * @method string              getUrlImagen()      Returns the current record's "url_imagen" value
 * @method string              getTasaCambio()     Returns the current record's "tasa_cambio" value
 * @method string              getDescripcion()    Returns the current record's "descripcion" value
 * @method integer             getEstatus()        Returns the current record's "estatus" value
 * @method integer             getLibroCompras()   Returns the current record's "libro_compras" value
 * @method FormaPago           getFormaPago()      Returns the current record's "FormaPago" value
 * @method Empresa             getEmpresa()        Returns the current record's "Empresa" value
 * @method Proveedor           getProveedor()      Returns the current record's "Proveedor" value
 * @method Doctrine_Collection getNotaDebitoDet()  Returns the current record's "NotaDebitoDet" collection
 * @method NotaDebito          setId()             Sets the current record's "id" value
 * @method NotaDebito          setEmpresaId()      Sets the current record's "empresa_id" value
 * @method NotaDebito          setProveedorId()    Sets the current record's "proveedor_id" value
 * @method NotaDebito          setNcontrol()       Sets the current record's "ncontrol" value
 * @method NotaDebito          setMoneda()         Sets the current record's "moneda" value
 * @method NotaDebito          setFormaPagoId()    Sets the current record's "forma_pago_id" value
 * @method NotaDebito          setNumRecibo()      Sets the current record's "num_recibo" value
 * @method NotaDebito          setFecha()          Sets the current record's "fecha" value
 * @method NotaDebito          setMonto()          Sets the current record's "monto" value
 * @method NotaDebito          setMontoFaltante()  Sets the current record's "monto_faltante" value
 * @method NotaDebito          setQuienPaga()      Sets the current record's "quien_paga" value
 * @method NotaDebito          setUrlImagen()      Sets the current record's "url_imagen" value
 * @method NotaDebito          setTasaCambio()     Sets the current record's "tasa_cambio" value
 * @method NotaDebito          setDescripcion()    Sets the current record's "descripcion" value
 * @method NotaDebito          setEstatus()        Sets the current record's "estatus" value
 * @method NotaDebito          setLibroCompras()   Sets the current record's "libro_compras" value
 * @method NotaDebito          setFormaPago()      Sets the current record's "FormaPago" value
 * @method NotaDebito          setEmpresa()        Sets the current record's "Empresa" value
 * @method NotaDebito          setProveedor()      Sets the current record's "Proveedor" value
 * @method NotaDebito          setNotaDebitoDet()  Sets the current record's "NotaDebitoDet" collection
 * 
 * @package    ired.localhost
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNotaDebito extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('nota_debito');
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
        $this->hasColumn('proveedor_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('ncontrol', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'unique' => false,
             'length' => 20,
             ));
        $this->hasColumn('moneda', 'tinyint', null, array(
             'type' => 'tinyint',
             'unsigned' => true,
             'notnull' => true,
             ));
        $this->hasColumn('forma_pago_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => false,
             'length' => 4,
             ));
        $this->hasColumn('num_recibo', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('fecha', 'date', 25, array(
             'type' => 'date',
             'notnull' => true,
             'length' => 25,
             ));
        $this->hasColumn('monto', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('monto_faltante', 'string', 20, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 20,
             ));
        $this->hasColumn('quien_paga', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
        $this->hasColumn('url_imagen', 'string', 200, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 200,
             ));
        $this->hasColumn('tasa_cambio', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('descripcion', 'string', null, array(
             'type' => 'string',
             'notnull' => false,
             'length' => '',
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
        $this->hasOne('FormaPago', array(
             'local' => 'forma_pago_id',
             'foreign' => 'id'));

        $this->hasOne('Empresa', array(
             'local' => 'empresa_id',
             'foreign' => 'id'));

        $this->hasOne('Proveedor', array(
             'local' => 'proveedor_id',
             'foreign' => 'id'));

        $this->hasMany('NotaDebitoDet', array(
             'local' => 'id',
             'foreign' => 'nota_debito_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $signable0 = new Doctrine_Template_Signable();
        $this->actAs($timestampable0);
        $this->actAs($signable0);
    }
}