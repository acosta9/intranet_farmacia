window.onload = function() {
  var path = $(location).attr('pathname').split("/");
  var module = path[2];
  switch(module) {
    case 'empresa':
      ModuleActive('administracion', 'empresas');
      break;
    case 'otros':
      ModuleActive('administracion', 'tasas');
      break;
    case 'oferta':
      ModuleActive('administracion', 'ofertas');
      break;
    case 'forma_pago':
      ModuleActive('administracion', 'formasdepago');
      break;
    case 'kardex':
      ModuleActive('estadisticas', 'kardex');
      break;
    case 'ranking':
      ModuleActive('estadisticas', 'rankingclientes');
      break;
    case 'prod_vendidos':
      ModuleActive('estadisticas', 'prodsmasvendidos');
      break;
    case 'prod_novendidos':
      ModuleActive('estadisticas', 'prodsnovendidos');
      break;
    case 'comparar_depositos':
      ModuleActive('estadisticas', 'comparardepositos');
      break;
    case 'turnover':
      ModuleActive('estadisticas', 'turnover');
      break;
    case 'cliente':
      ModuleActive('facturacion', 'clientes');
      break;
    case 'factura':
      ModuleActive('facturacion', 'facturas');
      break;
    case 'nota_entrega':
      ModuleActive('facturacion', 'notasdeentrega');
      break;
    case 'recibo_pago':
      ModuleActive('facturacion', 'recibosdepago');
      break;
    case 'nota_credito':
      ModuleActive('facturacion', 'notasdecredito');
      break;
    case 'orden_compra':
      ModuleActive('facturacion', 'ordenesdeventa');
      break;
    case 'cuentas_cobrar':
      ModuleActive('facturacion', 'cuentasporcobrar');
      break;
    case 'retenciones':
      ModuleActive('facturacion', 'retenciones');
      break;
    case 'proveedor':
      ModuleActive('compras', 'proveedores');
      break;
    case 'factura_compra':
      ModuleActive('compras', 'facturasdecompra');
      break;
    case 'factura_gastos':
      ModuleActive('compras', 'facturasdegastos');
      break;
    case 'gastos_tipo':
      ModuleActive('compras', 'tiposdegastos');
      break;
    case 'cuentas_pagar':
      ModuleActive('compras', 'cuentasporpagar');
      break;
    case 'recibo_pago_compra':
      ModuleActive('compras', 'registrarpagos');
      break;
    case 'nota_debito':
      ModuleActive('compras', 'notasdecreditos');
      break;
    case 'ordenes_compra':
      ModuleActive('compras', 'ordenesdecompra');
      break;
    case 'cotizacion_compra':
      ModuleActive('compras', 'cotizaciones');
      break;
    case 'inv_deposito':
      ModuleActive('gestioninventario', 'almacenes');
      break;
    case 'prod_categoria':
      ModuleActive('gestionproductos', 'categorias');
      break;
    case 'compuesto':
      ModuleActive('gestionproductos', 'compuestos');
      break;
    case 'prod_laboratorio':
      ModuleActive('gestionproductos', 'laboratorios');
      break;
    case 'prod_unidad':
      ModuleActive('gestionproductos', 'presentaciones');
      break;
    case 'producto':
      ModuleActive('gestionproductos', 'productos');
      break;
    case 'inventario':
      ModuleActive('gestioninventario', 'inventario');
      break;
    case 'inv_entrada':
      ModuleActive('gestioninventario', 'entradadeinv');
      break;
    case 'inv_salida':
      ModuleActive('gestioninventario', 'salidadeinv');
      break;
    case 'inv_ajuste':
      ModuleActive('gestioninventario', 'ajustedeinv');
      break;
    case 'traslado':
      ModuleActive('gestioninventario', 'trasladoinv');
      break;
    case 'caja':
      ModuleActive('puntodeventa', 'confcaja');
      break;
    case 'gcaja':
      ModuleActive('puntodeventa', 'gestindecaja');
      break;
    case 'almacen_transito':
      ModuleActive('gestionmercancia', 'despacho');
      break;
    case 'banners':
      ModuleActive('gestionwebsite', 'banners');
      break;
    case 'galeria':
      ModuleActive('gestionwebsite', 'slider');
      break;
    case 'contactenos':
      ModuleActive('gestionwebsite', 'contactenos');
      break;
    case 'usuarios':
      ModuleActive('usuarios', 'usuarios');
      break;
    case 'permisos':
      ModuleActive('usuarios', 'permisos');
      break;
    case 'grupos':
      ModuleActive('usuarios', 'grupos');
      break;
    default:
      ModuleActive('s', '_dashboard');
      break;
  }
};

function ModuleActive(activar, modulo) {
  $('#father'+activar).addClass('menu-open');
  $('#ref'+activar).addClass('active');
  $('#child'+modulo).addClass('active');
}

function setAndFormat(str) {
  var numero=number_float(SetMoney(str));
  return numero;
}
function number_float(str) {
  if(str.length>1) {
    str=str.replace(/\s|\./g,'');
    str=str.replace(",",'.');
    var number = parseFloat(str);
    return number;
  } else {
    if(parseFloat(str)>0) {
      return parseFloat(str);
    } else {
      return 0;
    }
  }
};
function SetMoney(numero){
  var txt="";
  if(numero<0) {
    txt='-';
  }
  var formatter = new StringMask('#.##0,0000', { reverse: true });
  var valor_nuevo = formatter.apply(number_float(numero.toFixed(4)));  
  return txt+valor_nuevo;
};

function Get(yourUrl){
  var Httpreq = new XMLHttpRequest(); // a new request
  Httpreq.open("GET",yourUrl,false);
  Httpreq.send(null);
  return Httpreq.responseText;
}

$( document ).ready(function() {
  $(".moneyStr").each(function() {
    var str=$(this).text();
    var res = str.replace(/\s/g,'');
    var numero = parseFloat(res);
    var res2=SetMoney(numero);
    $(this).text( res2 !== '' ? res2 : '' );
  });
  $(".money").each(function() {
    var str=$(this).val();
    var res = str.replace(/\s/g,'');
    var numero = parseFloat(res);
    var res2=numero.toFixed(4);
    $(this).val( res2 !== '' ? res2 : '' );
  });
  $(".money2").each(function() {
    var str=$(this).val();
    var res = str.replace(/\s/g,'');
    var number = parseFloat(res);
    var res2=number.toFixed(4);
    $(this).val( res2 !== '' ? res2 : '' );
  });
  $('.money2').mask('#.###,0000', {
    reverse: true,
    clearIfNotMatch: true,
    placeholder: "#,####",
    translation: {
      '#': {
        pattern: /-|\d/,
        recursive: true
      }
    },
    onChange: function(value, e) {      
      e.target.value = value.replace(/(?!^)-/g, '').replace(/^,/, '').replace(/^-,/, '-');
    }
  });
  $('.money').mask("#.##0,0000", {
    clearIfNotMatch: true,
    placeholder: "#,####",
    reverse: true
  });

  $('.iva').mask("00", {reverse: true});
  $('.diascredito').mask("999", {reverse: false});
  $('.onlyqty').mask("###1", {reverse: true});
  $('.onlyinteger').mask("#.##0", {reverse: true});
  $('.integer_nomask').mask("###0", {reverse: true});
  $('.celphone').mask('(0000) 000-0000', {clearIfNotMatch: true, placeholder: "(####) ###-####"});
  $('.rifcompany').mask('S-00000000-0', {
    clearIfNotMatch: true, 
    placeholder: "J-########-#",
    translation: {
      'S': {
        pattern: /[J|j]/, optional: false
      }
    }
  });
  $('.docid').mask('S-00000000D9', {
    clearIfNotMatch: true, 
    placeholder: "V-########-#",
    translation: {
      'S': {
        pattern: /[J|j|V|v|E|e|G|g]/, optional: false
      },
      'D': {
        pattern: /[-]/, optional: true
      }
    }
  });

  $(".dateonly").each(function() {
    var str=$(this).val();
    var res = str.replace(" 00:00:00", "");
    var res = res.replace(" 23:59:59", "");
    $(this).val( res !== '' ? res : '' );
  });
  $(".dateonly").datepicker({
    language: 'es',
    format: "yyyy-mm-dd"
  });
  $('.error_list').each(function() {
    $(this).before($("<i class='far fa-times-circle'></i>"));
    $(this).parent().find('.form-control').addClass('is-invalid');
  });
});