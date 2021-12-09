<?php
session_start();
include('../valotablapc.php');
 function  consulta_assoc($tabla,$campo,$parametro,$conexion)
  {
       $sql="select * from $tabla  where ".$campo." = '".$parametro."' ";
       //echo '<br>'.$sql;
       $con = mysql_query($sql,$conexion);
       $arr_con = mysql_fetch_assoc($con);
       return $arr_con;
  }
$datos_factura = consulta_assoc($tabla11,'id_factura',$_REQUEST['id_factura'],$conexion); 

$sql_borrar_factura = "delete from facturas where id_factura = '".$_REQUEST['id_factura']."'  and tipo_factura = '8' ";
$con_borrar = mysql_query($sql_borrar_factura,$conexion);

$sql_cambiar_estado_orden = "update $tabla14 set estado = '0'   where id = '".$datos_factura['id_orden']."'  ";
$con_actu = mysql_query($sql_cambiar_estado_orden);
echo '<div id="div_borrar" align="center">';
echo '<br><br><br>';
echo '<h1>LA FACTURA SE BORRO  Y LA ORDEN SE DEJO NUEVAMENTE EN ESTADO NO FACTURADA </h1>';
echo '<br><br>';
echo '<h2><a href = "../menu_principal.php">MENU PRINCIPAL</a></h2>';
echo '</div>';
?>

