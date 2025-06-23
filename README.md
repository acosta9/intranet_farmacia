# README #

Este proyecto es una aplicación web interna (intranet) desarrollada para la gestión y operación de una farmacia y drogueria. Su objetivo principal es proporcionar un entorno seguro y controlado para el acceso a recursos y funcionalidades específicas del negocio, garantizando que solo el personal autorizado pueda acceder a información y herramientas sensibles.

Este sistema abarca módulos clave como facturación, gestión de inventario, cuentas por cobrar, contabilidad, punto de venta y requisiciones, además de una página web especializada para vendedores que permite la verificación de inventario, creación y seguimiento de órdenes de compra, y manejo del área contable.

El proyecto fue realizado para una farmacia la cual constaba con multiples sucursales y necesitaban integrar la informacion en un solo sitio, asi que el sistema fue construido para trabajar de una manera distribuida y que la informacion de precios e inventario fuera controlada desde un sitio central y se replicaba automaticamente la informacion al resto de las sucursales a traves de un APIREST y tareas programadas.

### Características y Funcionalidades Clave:
* Facturación y Contabilidad: Automatización de procesos de facturación, cuentas por cobrar y gestión contable, garantizando precisión y cumplimiento normativo.
* Gestión de Inventario: Control centralizado de inventarios, con actualizaciones en tiempo real y alertas para niveles bajos de stock.
* Punto de Venta (POS): Sistema de punto de venta integrado con maquinas fiscales.
* Requisiciones y Órdenes de Compra: Módulo para la creación, aprobación y seguimiento de requisiciones y órdenes de compra.
* Portal para Vendedores: Página web dedicada para vendedores, permitiendo la verificación de inventario y gestión de órdenes de compra desde cualquier ubicación.

### Arquitectura del Sistema y Consolidación de Datos:

* Entorno Distribuido: El sistema fue diseñado para operar en un entorno distribuido, permitiendo a distintas localizaciones trabajar de manera independiente pero consolidando toda la información en un sitio central.
* REST API: Implementé una REST API para facilitar la sincronización y consolidación de datos entre las diferentes localizaciones, asegurando coherencia y disponibilidad de la información en tiempo real.