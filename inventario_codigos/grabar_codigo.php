<?php
session_start();
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/




include('../valotablapc.php');  
$sql_grabar_codigo ="insert into $tabla12 (codigo_producto,descripcion,valor_unit,cantidad,id_empresa,valorventa,iva)   
values (
'".$_POST['codigo']."',
'".$_POST['descripcion']."',
'".$_POST['valorunit']."',
'".$_POST['cantidad']."',
'".$_SESSION['id_empresa']."',
'".$_POST['valorventa']."',
'".$_POST['iva']."'

)  ";
$consulta_grabar_codigo = mysql_query($sql_grabar_codigo,$conexion);

/////////////////////
//debo obtener el id del producto 
$sql_traer_id_producto = "select id_codigo from $tabla12 where codigo_producto = '".$_POST['codigo']."'    and id_empresa = '".$_SESSION['id_empresa']."'      "; 
$consulta_id_producto  =  mysql_query($sql_traer_id_producto,$conexion);
$id_producto = mysql_fetch_assoc($consulta_id_producto);
/*
echo '<pre>';
print_r($id_producto);
echo '</pre>';
*/
$id_codigo_producto = $id_producto['id_codigo'];

/////////////////////////////
//ahora debe grabar el moviento en la tabla de movimientos 
$sql_grabar_movimiento = "insert into $tabla19 (fecha_movimiento,cantidad,tipo_movimiento,id_codigo_producto,id_empresa,observaciones) 
values ('".$_POST['fecha']."','".$_POST['cantidad']."','1',
'".$id_codigo_producto = $id_producto['id_codigo']."','".$_SESSION['id_empresa']."','Saldo Inicial'
)";

$grabar_movimiento = mysql_query($sql_grabar_movimiento,$conexion); 
////////////////

echo '<br><h3>CODIGO GRABADO</h3>';
include('../colocar_links2.php');
/*
echo '<br><a href="index.php">Menu Codigos</a>';
echo '<br><a href="../menu_principal.php">Menu Principal</a>';
*/
?>



