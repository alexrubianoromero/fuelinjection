<?php
session_start();
include('../valotablapc.php');
include('../funciones.php');

$sql_clientes = "select nombre,telefono,email,direccion,observaci,idcliente 
from $tabla3 as cli  where  cli.id_empresa = '".$_SESSION['id_empresa']."'   ";



//inner join $tabla4 car  on (car.propietario = cli.idcliente)
//,placa,marca,color,modelo

echo '<BR>CONSULTA GENERAL DE CLIENTES<BR>';

echo '<table border = "1" width = "95%" >';
echo '<tr><td>NOMBRE</td><td>TELEFONO</td><td>EMAIL</td><td>DIRECCION</td><td>OBSERVACIONES</td><td>PLACA</td><td>MARCA</td><td>COLOR</td><td>MODELO</td></tr>';
$consulta_clientes = mysql_query($sql_clientes,$conexion);
while($clientes = mysql_fetch_array($consulta_clientes))
	{
			echo '<tr>';	
			echo '<td>'.$clientes[0].'</td>';
			echo '<td>'.$clientes[1].'</td>';
			echo '<td>'.$clientes[2].'</td>';
			echo '<td>'.$clientes[3].'</td>';
			echo '<td>'.$clientes[4].'</td>';
			$sql_carros = "select placa,marca,color,modelo from $tabla4   where propietario = '".$clientes[5]."'";	
			$consulta_carros = mysql_query($sql_carros,$conexion);
			$filas = mysql_num_rows($consulta_carros);
			if ($filas >0)
					{
						$carros = mysql_fetch_assoc($consulta_carros); 
						echo '<td>'.$carros['placa'].'</td>';
						echo '<td>'.$carros['marca'].'</td>';
						echo '<td>'.$carros['modelo'].'</td>';
						echo '<td>'.$carros['color'].'</td>';
					}
					else
					{
						echo '<td>NO TIENE</td>';
						echo '<td>NO TIENE</td>';
						echo '<td>NO TIENE</td>';
						echo '<td>NO TIENE</td>';
					}

			echo '</tr>';
	}
echo '</table>';



?>