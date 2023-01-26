<?php
$tabla1 = "datos";
//$tabla2 = "cxp";
$tabla3 ="cliente0";
$tabla4 ="carros";
//$tabla5 ="parametros";
$tabla10 = "empresa"; 
$tabla11 = "facturas";
$tabla12 = "productos";
$tabla13 = "item_factura";
$tabla14 = "ordenes";
$tabla15 = "item_orden";
$tabla16 = "usuarios";
$tabla17 = "iva";
$tabla18 = "item_temporal";
$tabla19 = "movimientos_inventario";
$tabla20 = "retefuente";
$tabla21 = "tecnicos";
$tabla22 = "salin_salfin_caja";
$tabla23 = "recibos_de_caja";
$tabla50 = "recibos_de_caja_traz";
$tablaima= "imagenes_ordenes";
$tabla24 ="nombres_items_carros";
$tabla25 = "relacion_orden_inventario";
$cotizaciones = "cotizaciones";
$tipo_codigo_inventario = "tipo_codigo_inventario";
$item_orden_cotizaciones = "item_orden_cotizaciones";
$estados_cotizaciones = "estados_cotizaciones";
$cxp = "cxp";
$tipo_operario = "tipo_operario";
$proveedores = "proveedores";

/*valores para pc*/

$servidor = "localhost";
$usuario = "root";
$clave  = "peluche2016";
$nombrebase = "base_fuelinjection";



$servidor = "localhost";
$usuario = "ctwtvsxj_admin";
$clave  = "ElMejorProgramador***";
$nombrebase = "ctwtvsxj_base_fuelinjection";


$conexion =mysql_connect($servidor,$usuario,$clave);
$la_base =mysql_select_db($nombrebase,$conexion);




?>
