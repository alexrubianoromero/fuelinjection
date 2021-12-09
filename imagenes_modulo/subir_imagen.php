<?php
session_start();
include('../valotablapc.php');
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
echo '<br>';
*/
/*
echo '<pre>';
print_r($_FILES);
echo '</pre>';
*/
/*
echo '<br>';
echo 'archivo<br>'.$_FILES['foto']['name'];
echo 'archivo<br>'.$_FILES['foto']['size'];
*/
//exit();
///////$mi_usuario=$usuario;
/////////$mi_password=$clave ;
$dir_destino = 'imagenes/';
$imagen_subida = $dir_destino.basename($_FILES['foto']['name']);
//Variables del metodo POST
$codigo=$_POST['codigo'];
$descripcion=$_POST['descripcion'];
if(!is_writable($dir_destino)){
	echo "no tiene permisos";
}else{
	if(is_uploaded_file($_FILES['foto']['tmp_name'])){
		/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
		echo "Mostrar contenido\n";
		echo $imagen_subida;*/
		if (move_uploaded_file($_FILES['foto']['tmp_name'], $imagen_subida)) {
			
			////////////$link = mysql_connect('localhost', $mi_usuario, $mi_password)
			///////	or die('Uyy!!!: ' . mysql_error());
			////////mysql_select_db($nombrebase) or die('No pudo selecionar la BD');
			//Creamos nuestra consulta sql
			$query="insert into $tablaima (idorden, descripcion, ruta_imagen,tamano,id_empresa) 
			value (
			'".$codigo."'
			, '".$descripcion."'
			, '".$imagen_subida."'
			, '".$_FILES['foto']['size']."'
			,'".$_SESSION['id_empresa']."'
			
			)";
			
			//echo '<br>la consulta<br>'.$query;

			//Ejecutamos la consutla
			$consulta_guardar_ruta  =	mysql_query($query,$conexion);

			echo "El archivo es fue cargado exitosamente.\n";
			echo '<br>Codigo: '.$codigo;
			echo '<br>Descripcion: '.$descripcion;
			echo "<br><img src='imagenes/". basename($imagen_subida) ."' width ='200' height = '200' />";
		} else {
			echo "Posible ataque de carga de archivos!\n";
		}
	}else{
		echo "Posible ataque del archivo subido: ";
		echo "nombre del archivo '". $_FILES['archivo_usuario']['tmp_name'] . "'.";
	}
}

echo  '<br>';
echo '<br>';

echo '<a href ="../menu_principal.php"> MENU PRINCIPAL <a/>';
?>