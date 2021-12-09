<?php
include("../empresa.php");
include("../valotablapc.php");
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/
$sql_atualizar_datos_codigos = "update $tabla12 set 
descripcion  = '".$_POST['descripcion']."',
valor_unit  = '".$_POST['valor_unit']."',    
cantidad  = '".$_POST['cantidad']."',  
valorventa  = '".$_POST['valorventa']."',  
iva  = '".$_POST['iva']."' 
where id_codigo = '".$_POST['id_codigo']."'  ";
//echo 'consulta<br>'.$sql_atualizar_datos_codigos;
$consulta_actualizar = mysql_query($sql_atualizar_datos_codigos,$conexion);
///registrar movimiento en movimientos de invetario este tipo de actualizacion se registra con 4


echo 'CODIGO ACTUALIZADO';
include('../colocar_links2.php');

?>