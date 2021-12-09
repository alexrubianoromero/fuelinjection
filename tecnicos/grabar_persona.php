<?php
session_start();
include('../valotablapc.php');

$sql_grabar_persona  = "insert into $tabla21 (identi,nombre,telefono,direccion,id_empresa,tipo_operario)   
values('".$_REQUEST['cedula']."','".$_REQUEST['nombre']."','".$_REQUEST['telefono']."','".$_REQUEST['direccion']."'
,'".$_SESSION['id_empresa']."'
,'".$_REQUEST['id_tipo']."'

)"; 
$consulta_grabar= mysql_query($sql_grabar_persona,$conexion);

echo 'TECNICO GRABADO';

include('../colocar_links2.php');

?>