<?php
session_start();
/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';


echo '<pre>';
print_r($_POST);
echo '</pre>';
*/
include('../valotablapc.php');
$sql_traer_clave_actual = "select * from $tabla16  ";
$consulta_traer_informacion = mysql_query($sql_traer_clave_actual,$conexion);
$datos_usuario = mysql_fetch_assoc($consulta_traer_informacion);
/*
echo '<br>clave actual'.$datos_usuario['clave'];
echo '<br>clave nueva'.$_POST['nueva1'];
*/
if($datos_usuario['clave']==$_POST['anterior'])
	{
			//echo 'la clave si coincide';
			if($_POST['nueva1']==$_POST['nueva2'])
				{
					$actualizar_clave = "update $tabla16 set clave = '".$_POST['nueva1']."'  where  idempresa  = '".$_SESSION['id_empresa']."'";
					$consulta_cambio_clave = mysql_query($actualizar_clave,$conexion);
					//echo '<br>'.$actualizar_clave.'<br>';
					echo 'CLAVE ACTUALIZADA EXITOSAMENTE ';
				}
			else 
				{
				   echo 'LAS NUEVAS CLAVES NO COINCIDEN';
				}	
				
	}
else
	{
			echo 'LA CLAVE ANTERIOR NO COINCIDE';
	}
include('../colocar_links2.php');


?>