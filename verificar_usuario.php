<?php
session_start();
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/

include('valotablapc.php');
$sql_usuarios ="select * from $tabla16 where login = '".$_POST['usuario']."' ";
//echo '<br>consulta'.$sql_usuarios;
$consulta_usuario = mysql_query($sql_usuarios,$conexion);
$datos_base = mysql_fetch_assoc($consulta_usuario);


$filas = mysql_num_rows($consulta_usuario);
//echo 'idempresa = '.$datos_base['idempresa'];
//echo 'la clave de la base '.$datos_base['clave'];
//exit();

//echo '<br>numero de filas'.$filas ;

if($filas == 0 )
		{
		  echo "<BR>USUARIO NO EXISTE<BR>";
		  session_destroy();
       //echo "Has cerrado la sesion";
		  include('index.php');
		}  
		else
		{
		   
		   if($_POST['clave'] ==  $datos_base['clave'] )
		     		{
					  //echo "<br>CLAVE CORRRECTA";
					  $_SESSION['usuario']=$_REQUEST['usuario'];
					  $_SESSION['id_empresa']=$datos_base['idempresa'];
					   echo '<input type="hidden" id="id_empresa"   value = "'.$_SESSION['id_empresa'].'">';
					   ?>
					    <script type="text/javascript">
					   //sessionStorage.usuario = document.getElementById("usuario").value;
					   sessionStorage.id_empresa = document.getElementById("id_empresa").value;
					   //sessionStorage.id_usuario = document.getElementById("id_usuario").value;
					   //sessionStorage.id_perfil = document.getElementById("id_perfil").value;
					   //sessionStorage.nombre_usuario = document.getElementById("nombre_usuario").value;
					   //sessionStorage.nombre_perfil = document.getElementById("nombre_perfil").value;
					   //sessionStorage.nivel_perfil = document.getElementById("nivel_perfil").value;		
					   </script>	
					   <?php



					  include('menu_principal.php');
					}
					
			else {
			        echo "<br>CLAVE INCORRRECTA";
				 	include('index.php');
					session_destroy();
       				//echo "Has cerrado la sesion";
				}		
		   
		}

?>
