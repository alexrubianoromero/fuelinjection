<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<? include("../empresa.php"); ?>
<Div id="contenidos">
		<header>
			<h1><? echo $empresa; ?></h1>
			<h2><? echo $slogan; ?><h2>
		</header>
		<nav>
		<ul class="menu">
	    <li><a href="pregunte_placa.php" class="menu">CREAR FACTURA </a></li>
		  <li><a href="muestre_factura.php" class="menu">CONSULTAR FACTURAS </a></li>
		  <li><a href="pregunte_placa_anular.php" class="menu">ANULAR FACTURAS </a></li>
		  
		   <li><a href="pregunte_factura_ajuste_retefuente.php" class="menu">AJUSTAR RETEFUENTE FACTURA </a></li>
	
		   <li><a href="../menu_principal.php" class="menu"> MENU PRINCIPAL </a></li>

		

		</ul>
	</nav>
</Div>
	
</body>
</html>
<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../js/jquery-2.1.1.js"></script>   
