<?php
session_start();
include('../valotablapc.php');


 function  consulta_assoc_coti($tabla,$campo,$parametro,$conexion)
  {
       $sql="select * from $tabla  where ".$campo." = '".$parametro."' ";
       //echo '<br>'.$sql;
       $con = mysql_query($sql,$conexion);
       $arr_con = mysql_fetch_assoc($con);
       return $arr_con;
  }

function sumar_items($tabla,$campo,$parametro,$conexion){
	$sql =" select sum(total_item)  as suma from $tabla where no_factura = '".$parametro."'  ";
	 $con = mysql_query($sql,$conexion);
       $arr_con = mysql_fetch_assoc($con);
       return $arr_con['suma'];
}
		/*
		$sql_consutla_carros = "select car.idcarro,car.placa,car.tipo,car.marca,car.color,car.propietario  
					from $tabla4  as car 
					inner join $tabla3 cli on (car.propietario = cli.idcliente)
					where   car.id_empresa = '".$_SESSION['id_empresa']."' ";

		if($_REQUEST['placa_buscar'] != '')
		{
			$sql_consutla_carros .=  " and car.placa = '".$_REQUEST['placa_buscar']."'  ";
		}

		if($_REQUEST['identificacion_buscar'] != '')
		{
			$sql_consutla_carros .=  " and cli.identi = '".$_REQUEST['identificacion_buscar']."'  ";
		}


			$sql_consutla_carros .=	"	order by car.idcarro desc";


       //echo '<br>'.$sql_consutla_carros;
					
		$consulta_carros = mysql_query($sql_consutla_carros,$conexion);
		*/

////////////////////////////////////
$sql_cotizaciones = "select * from $cotizaciones where anulado = '0' order by id_cotizacion desc ";
$con_cotizaciones = mysql_query($sql_cotizaciones,$conexion);
//echo '<br>'.$sql_cotizaciones;
	
?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">
	<meta name='viewport' content='width=device-width initial-scale=1'>
<meta name='mobile-web-app-capable' content='yes'>
<link rel='stylesheet' href='../css/bootstrap.min.css'>
<script src='../js/bootstrap.min.js'></script>
<style>

#formato_tabla thead{
	background-color: #E8E1E0;
	text-align: center;

}
.fila_aprobada
    {background-color:#91EBE5; }     
</style>
</head>
<body>


	<table  border="1"  class="table  table-hover" id="formato_tabla">
	<thead>	
  <tr>
  	    <td><div align="center">NO_COTIZACION</div></td>
    <td><div align="center">PLACA</div></td>

    <td><div align="center">KILOMETRAJE</div></td>
    <td><div align="center">VALOR</div></td>
    <td><div align="center">ESTADO</div></td>
    <td><div align="center">MODIFICAR</div></td>
    <td><div align="center">IMPRIMIR</div></td>

  </tr>
</thead>
<tbody>
<?php

while($row = mysql_fetch_assoc($con_cotizaciones))
	{
		$datos_carro = consulta_assoc_coti($tabla4,'idcarro',$row['idcarro'],$conexion);
		$estados_coti = consulta_assoc_coti($estados_cotizaciones,'valor_estado',$row['estado'],$conexion);
		$suma_items = sumar_items($item_orden_cotizaciones,'no_factura',$row['id_cotizacion'],$conexion);
        // #91EBE5
        if($row['estado'] == 1){ echo '<tr class="fila_aprobada">'; }
        else
        {	
		echo '<tr>';
	   }
		echo '<td>'.$row['no_cotizacion'].'</td>';
		echo '<td>'.$datos_carro['placa'].'</td>';
		
		echo '<td>'.$row['kilometraje'].'</td>';	
		echo '<td align="right">'.number_format($suma_items, 0, ',', '.').'</td>';		
		echo '<td>'.$estados_coti['descripcion_estado'].'</td>';	
		if($row['estado']==1)
		{
			echo '<td>'.$estados_coti['descripcion_estado'].'</td>';
		}
		else
		{
		echo '<td><a  href ="../cotizaciones/modificar_cotizacion.php?id_cotizacion='.$row['id_cotizacion'].'">MODIFICAR</a></td>';		
		}
		echo '<td><a target="_blank" href ="../cotizaciones/imprimir_cotizacion.php?id_cotizacion='.$row['id_cotizacion'].'">IMPRIMIR</a></td>';		
		
		echo '</tr>';
		
	}
	echo '</tbody>';
echo '</table>';


//////////////
?>

</body>
</html>	