<?php
session_start();
include('../valotablapc.php');
/*
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';
*/

///revisar que esta factura no este creada 

$ql_traer_factura = "select * from $tabla11 where numero_factura = '".$_REQUEST['no_factura']."'  and  tipo_factura ='8' ";
//echo '<br>'.$ql_traer_factura;
$con_esta = mysql_query($ql_traer_factura,$conexion);
$filas_esta = mysql_num_rows($con_esta);

if($filas_esta <1)
{	

$sql_crear_factura = "insert into $tabla11 (numero_factura,fecha,id_empresa,id_orden,
	placa,tipo_factura,anulado,forma_pago) 
values (
'".$_REQUEST['no_factura']."'
,'".$_REQUEST['fecha']."'
,'11'
,'".$_REQUEST['id_orden']."'
,'".$_REQUEST['placa']."'
,'8'
,'0'
,'".$_REQUEST['forma_pago']."'
)";

$con_crear_fact = mysql_query($sql_crear_factura,$conexion);

//echo '<br>'.$sql_crear_factura;

$sql_cambiar_estado_orden = "update $tabla14 set estado = '1' where id = '".$_REQUEST['id_orden']."' ";
$con_act =mysql_query($sql_cambiar_estado_orden,$conexion);

$sql_id_fact = "select max(id_factura) as maxima from $tabla11 ";
$con_id = mysql_query($sql_id_fact,$conexion);
$arr_maxima = mysql_fetch_assoc($con_id);
}
else

{
	echo 'Esta factura ya esta creada ';
}

echo '<br>';
echo '<br>';
echo '<a  target="_blank"  href="../facturas/factura_imprimir_nueva.php?id_factura='.$arr_maxima['maxima'].'">IMPRIMIR_FACTURA_NUEVO </a>';

echo '<br>';
echo '<br>';
echo '<a href="../menu_principal.php">MENU PRINCIPAL  </a>';
echo '<br>';
echo '<br>';
echo '<a href="../orden/muestre_orden.php">ORDENES </a>';
?>