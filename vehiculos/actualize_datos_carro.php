<?php
include('../valotablapc.php');
include('../funciones.php');
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/

if ($_POST['cambiopropietario']== 'undefined'){$_POST['cambiopropietario'] = 0;}

$sql_act_carro = "update $tabla4   set  
marca = '".$_POST['marca']."',     
tipo = '".$_POST['tipo']."',
modelo = '".$_POST['modelo']."',
color = '".$_POST['color']."',
vencisoat = '".$_POST['vencisoat']."',
revision = '".$_POST['revision']."'
";
if($_POST['cambiopropietario'] ==1) 
		{
			  $sql_act_carro .=  ", propietario = '".$_POST['nuevopropietario']."'  ";
		}
 
$sql_act_carro  .=   " where idcarro = '".$_POST['idcarro']."'   ";  
//echo '<br>'.$sql_act_carro;
$consulta = mysql_query($sql_act_carro,$conexion);
include('../colocar_links2.php');

?>
