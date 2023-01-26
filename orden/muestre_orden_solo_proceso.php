<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>Muestre Ordenes</title>
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<? 
include("../empresa.php"); 
include('../valotablapc.php');
include('../funciones.php');
$sql_muestre_ordenes = "select id as No_Orden,
fecha,
placa,
id,
orden,
estado
 from $tabla14  where id_empresa = '".$_SESSION['id_empresa']."' and tipo_orden < '2' and anulado = '0'  
and estado = 0
 order by id desc";

$consulta_ordenes = mysql_query($sql_muestre_ordenes,$conexion);

function traer_marca_modelo($placa,$conexion,$tabla4){
    $sql = "select marca,modelo from $tabla4  where placa = '".$placa."' ";
    $consulta_marca_modelo= mysql_query($sql,$conexion);
    $resultado = mysql_fetch_assoc($consulta_marca_modelo);
    return $resultado;
    /*
    echo '<pre>';
    print_r($resultado);
    echo '</pre>';
    */
    
}//fin de marca modelo
  
?>
<Div id="contenidos">
		<header>
			<h2>CONSULTA ORDENES </h2>
		</header>
	
<?php
include('../colocar_links2.php');
echo '<table border= "1">';
	echo '<td><h3>No Orden<h3></td><td><h3>Marca/Modelo</h3></td><td><h3>Fecha Ingreso</h3></td><td><h3>Placa</h3></td>';
echo '<td><H3>MOD</H3></td>';
	echo '<td><h3>Resumen</h3></td>
<td><h3>Modificar</h3></td><td><h3>Ficha Tecnica </h3></td><td><h3>Detalle</h3></td><td><h3>Croquis</h3></td>  <td><h3>Estado</h3></td><td><h3>Doc Soporte</h3></td>'; 
echo '<td><h3>NUEVO</h3></td>';
		while($ordenes = mysql_fetch_array($consulta_ordenes))
			{
				
				$marca_modelo = traer_marca_modelo($ordenes['2'],$conexion,$tabla4);

				echo '<tr>';
				echo '<td><h3>'.$ordenes['4'].'</h3></td>';
					echo  '<td><h3>';
					echo $marca_modelo['marca'].' '.$marca_modelo['modelo'];
				/*echo '<a href="../imagenes_modulo/muestre_imagenes_orden.php?idorden='.$ordenes['0'].'">Imagenes</a>'; */

				echo '</h3></td>';
				echo '<td><h3>'.$ordenes['1'].'</h3></td><td><h3>'.$ordenes['2'].'</h3></td>';
				
				echo '<td><h3>';
				echo '<a href="../cxp/index.php?idorden='.$ordenes['0'].'">MOD</a>';
				echo '</h3></td>';
				
				echo  '<td><h3>';
				echo '<a href="orden_detallado.php?idorden='.$ordenes['0'].'">Detalle</a>';
				echo '</h3></td>'; 
				echo  '<td><h3>';
				echo '<a href="orden_modificar.php?idorden='.$ordenes['0'].'">Modificar</a>';
				echo '</h3></td>';
				 
				echo  '<td><h3>';
				echo '<a href="orden_detallado_ficha.php?idorden='.$ordenes['0'].'"  target = "_blank">Ficha_Detalle</a>';
				echo '</h3></td>'; 
				echo  '<td><h3>';
				echo '<a href="orden_imprimir.php?idorden='.$ordenes['0'].'"  target = "_blank">Imprimir_Orden</a>';
				echo '</h3></td>';
					echo  '<td><h3>';
				echo '<a href="orden_imprimir2.php?idorden='.$ordenes['0'].'" target = "_blank">Impresion2</a>';
				echo '</h3></td>';
				$letrero_estado = 'En Proceso';
				if($ordenes['5'] > 0){$letrero_estado = 'Terminado';}
				echo  '<td><h3>';
				echo $letrero_estado;
				echo '</h3></td>'; 
				 
				
				
				echo  '<td><h3>';
					if($ordenes['5'] < 1)
					{echo '<a href="../facturas/muestre_listado_ordenes_pendientes_por_facturar.php?placa123='.$ordenes[2].'">Crear</a>';}
					if($ordenes['5'] >0)
					{echo 'Facturada';}
				echo '</h3></td>'; 
					echo  '<td><h3>';
					if($ordenes['5'] < 1)
					{echo '<a href="../facturas/facturar_nuevo.php?id_orden='.$ordenes[0].'">Crear Doc Soporte</a>';}
					if($ordenes['5'] >0)
					{
						$sql_traer_id_factura = "select id_factura from $tabla11   where id_orden = '".$ordenes[0]."'    ";
						$con_id_factura = mysql_query($sql_traer_id_factura,$conexion);
						$arr_id_factura = mysql_fetch_assoc($con_id_factura);
						echo '<a target="_blank"  href="../facturas/factura_imprimir_nueva.php?id_factura='.$arr_id_factura['id_factura'].'">Ver_Factu</a>';

					}
				echo '</h3></td>'; 
				
				
				echo '<tr>';
			}
echo '<table border= "1">';

?>
	</Div>
</body>
</html>
<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../js/jquery-2.1.1.js"></script>   
