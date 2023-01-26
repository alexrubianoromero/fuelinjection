<?php
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/
//exit();

/*
'".$_POST['orden_numero']."',
'".$_POST['placa']."',
'".$_POST['clave']."',
'".$_POST['fecha']."',
'".$_POST['descripcion']."',
'".$_POST['radio']."',
'".$_POST['antena']."',
'".$_POST['repuesto']."',
'".$_POST['herramienta']."',
'".$_POST['otros']."'
*/
include('../valotablapc.php');
if ($_POST['radio']== 'undefined'){$_POST['radio'] = 0;}
if ($_POST['antena']== 'undefined'){$_POST['antena'] = 0;}
if ($_POST['repuesto']== 'undefined'){$_POST['repuesto'] = 0;}
if ($_POST['herramienta']== 'undefined'){$_POST['herramienta'] = 0;}
$mecanico = $_POST['mecanico'];
if($_POST['nuevo_mecanico']!= '')
{
  $mecanico =  $_POST['nuevo_mecanico'];   
}	
//$sql_actualizar_orden = "update  $tabla14  set (factura,placa,sigla,fecha,observaciones,radio,antena,repuesto,herramienta,otros) 
$sql_actualizar_orden = "update  $tabla14  set 
observaciones = '".$_POST['descripcion']."',
radio = '".$_POST['radio']."',
antena= '".$_POST['antena']."',
repuesto = '".$_POST['repuesto']."',
herramienta = '".$_POST['herramienta']."',
otros = '".$_POST['otros']."',
iva = '".$_POST['iva']."',
kilometraje = '".$_POST['kilometraje']."',
mecanico = '".$mecanico."'

where id = '".$_POST['orden_numero']."'
";

//echo '<br>'.$sql_actualizar_orden;
//exit();

$consulta_grabar = mysql_query($sql_actualizar_orden,$conexion); 
echo "<br><br><br>ORDEN ACTUALIZADA";
echo "<br><a href='../index.php' >Pagina Principal</a>";
echo "<br><a href='index.php' >Menu Ordenes</a>";
//<a href="#">#</a>
?>