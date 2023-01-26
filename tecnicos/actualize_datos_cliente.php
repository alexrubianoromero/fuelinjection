<?php
session_start();
include('../valotablapc.php');
include('../funciones.php');
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/
//exit();



$sql_act_cliente = "update $tabla21   set  
identi = '".$_REQUEST['identi']."',     
nombre = '".$_REQUEST['nombre']."',
direccion = '".$_REQUEST['direccion']."',
telefono = '".$_REQUEST['telefono']."',
email = '".$_REQUEST['email']."',
tipo_operario = '".$_REQUEST['id_tipo']."',
observaci = '".$_REQUEST['observaci']."'
 where idcliente = '".$_REQUEST['idcliente']."' and id_empresa =  '".$_SESSION['id_empresa']." '  ";  
//echo '<br>'.$sql_act_cliente;
$consulta = mysql_query($sql_act_cliente,$conexion);

$sql_cliente = "select t.nombre,t.telefono,t.email,t.direccion,b.descripcion as tipo 
from $tabla21 as t 
left join $tipo_operario b on b.id = t.tipo_operario  
where t.idcliente = '".$_REQUEST['idcliente']."'  "; 

$consulta_cliente = mysql_query($sql_cliente,$conexion );
$datos = get_table_assoc($consulta_cliente);
echo '<br>';
echo 'LOS DATOS DEL CLIENTE QUEDARON DE LA SIGUIENTE MANERA';
draw_table($datos);
echo '<br>';
include('../colocar_links2.php');


?>
