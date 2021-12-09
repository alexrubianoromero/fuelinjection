<?php
session_start();
//echo '<br>idempresa '.$_SESSION['id_empresa'].'<br>';
?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
<? include("empresa.php");
$sql_ruta_imagen = "select ruta_imagen,nombre,tipo_taller from $tabla10 where id_empresa = '".$_SESSION['id_empresa']."'  ";  
$consulta_empresa = mysql_query($sql_ruta_imagen,$conexion);
$datos_empresa = mysql_fetch_assoc($consulta_empresa);
$ruta_imagen = 'logos/'.$datos_empresa['ruta_imagen'];
//echo '<br>ruta'.$ruta_imagen;
if($datos_empresa['tipo_taller'] == '1') // OSEA SI ES TALLER DE VEHICULOS
      { $palabra = 'VEHICULOS' ; } 
else  { $palabra = 'MOTOS'  ;} 
 ?>
<Div id="contenidos">
		<header>
			<h1><? //echo $empresa; ?></h1>
			<h2><? //echo $slogan; ?><h2>
			<img src="<?php  echo $ruta_imagen    ?>" width="268" height="92">
		</header>
		<nav>
		<ul class="menu">
		   <li><a href="clientes/index.php" class="menu">CLIENTES</a></li>
		   <li><a href="tecnicos/index.php" class="menu">TECNICOS</a></li>
		  <li><a href="vehiculos/carros.php" class="menu"><?PHP  echo $palabra;    ?></a></li>
	    <li><a href="cotizaciones/consulta_cotizaciones_general.php" class="menu">COTIZACIONES</a></li>
	    <li><a href="orden/index.php" class="menu">ORDENES DE TRABAJO</a></li>
		  <li><a href="facturas/index.php" class="menu">FACTURAS</a></li>
		  <li><a href="inventario_codigos/index.php" class="menu">CODIGOS DE INVENTARIO</a></li>

		  <li><a href="proveedores/index.php" class="menu">PROVEEDORES CXP</a></li>

		   <li><a href="caja/index.php" class="menu">CAJA</a></li>

		   <li><a href="consultas/pregunte_fechas_mecanico_modif.php" class="menu"> NOMINA </a></li>
			<li><a href="consultas/index.php" class="menu">CONSULTAS</a></li>
			<li><a href="consultas/vencimientos.php" class="menu">VENCIMIENTOS</a></li>
			<li><a href="clave/index.php" class="menu">CAMBIO DE CLAVE</a></li>
		

		</ul>
	</nav>
</Div>
	
</body>
</html>
<script src="js/modernizr.js"></script>   
<script src="js/prefixfree.min.js"></script>
<script src="js/jquery-2.1.1.js"></script>   
