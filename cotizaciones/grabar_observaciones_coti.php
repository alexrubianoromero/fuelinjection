<?php
session_start();
/*
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

echo 'rrrrrrrrrrrrrrrrrrrrrrrrrrrrr';
*/
include('../valotablapc.php');

$sql_obse="update $cotizaciones set observaciones = '".$_REQUEST['observaciones']."' 
where id_cotizacion = '".$_REQUEST['id_cotizacion']."'";
$con_obse = mysql_query($sql_obse,$conexion);



?>