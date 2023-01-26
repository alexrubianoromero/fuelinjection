<?php
session_start();
include('../valotablapc.php');
include('../funciones_summers.php');

$sql = "delete from $tabla21 where idcliente = '".$_REQUEST['idcliente']."' ";
// echo $sql;
$consulta_eliminar = mysql_query($sql,$conexion);
echo '<h1>Tecnico eliminado</h1> ';


?>