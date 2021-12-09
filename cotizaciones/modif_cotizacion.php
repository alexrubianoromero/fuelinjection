<?php
include('../valotablapc.php');
/*
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';
*/
$sql_actualizar = "update $cotizaciones   set  
kilometraje = '".$_REQUEST['kilometraje']."'
,observaciones = '".$_REQUEST['observaciones']."'

where  id_cotizacion = '".$_REQUEST['id_cotizacion']."'

";
$con_actualizar = mysql_query($sql_actualizar,$conexion);

?>