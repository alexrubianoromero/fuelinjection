<?php
session_start();
include('../valotablapc.php');

$sql_actualizar_valor = "update $tabla15    set 
valor_mecanico = '".$_REQUEST['valor_mecanico']."'

where id_item = '".$_REQUEST['id_item']."'
";
$consulta_actualizar_valor = mysql_query($sql_actualizar_valor,$conexion);


?>