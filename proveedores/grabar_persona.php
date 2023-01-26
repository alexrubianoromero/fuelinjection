<?php
session_start();
include('../valotablapc.php');
$sql = "select * from $proveedores   where identi ='".$_REQUEST['cedula'] ."'  "; 
$consulta_verificar= mysql_query($sql,$conexion);
$filas = mysql_num_rows($consulta_verificar); 
if ($filas<=0){
$sql_grabar_persona  = "insert into $proveedores (identi,nombre,telefono,direccion)   
values('".$_REQUEST['cedula']."','".$_REQUEST['nombre']."','".$_REQUEST['telefono']."','".$_REQUEST['direccion']."'
)"; 
$consulta_grabar= mysql_query($sql_grabar_persona,$conexion);

echo 'PROVEEDOR GRABADO';
}
else{
    echo 'EL NUMERO DE IDENTIDAD YA EXISTE EN BASE DE DATOS';
}

?>