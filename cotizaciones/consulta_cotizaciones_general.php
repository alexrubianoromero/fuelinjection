<?php
session_start();
if($_SESSION['id_empresa']=='')
{
         include('../sesion_caducada.php');
}	
else
{	

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
#div_botones12{
	font-size: 15px;
   background-color: #c0c0c0;
   padding: 20px;
}
</style>
</head>
<body>
<? include("../empresa.php"); ?>
<Div id="container">

<div align="center">
	<br>
<a href="../menu_principal"  class="btn btn-success">IR AL MENU PRINCIPAL</a>
<a href="../orden/muestre_orden.php"  class="btn btn-success">CONSULTAR ORDENES</a>
<br><br>
</div>
 <div id="div_botones12" align="center">  

    PLACA <input type="text"  id="placa_buscar" class="fila_llenar"> IDENTIFICACION <input type="text"  id="identificacion_buscar" class="fila_llenar">
    <button id="btn_buscar"  class="btn btn-success" >BUSCAR</button>
    	<button id="btn_nueva_cot" class="btn btn-info" >NUEVA COTIZACION</button>
</div>

<div id="div_mostrar_motos">
	<?php
     include('../cotizaciones/mostrar_cotizaciones.php');

     ?>

</div>
</div>
<?php
} //fin de else
?>	
</body>

</html>
<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../js/jquery-2.1.1.js"></script>   

<script language="JavaScript" type="text/JavaScript">
            
			$(document).ready(function(){

						$("#btn_buscar").click(function(){
							var data =  'placa_buscar=' + $("#placa_buscar").val();
								data += '&identificacion_buscar=' + $("#identificacion_buscar").val();
							$.post('../vehiculos/mostrar_cotizaciones.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#div_mostrar_motos").html(a);
								//alert(data);
							});	
						 });
					////////////////////////
					$("#btn_nueva_cot").click(function(){
							var data =  'placa_buscar=' + $("#placa_buscar").val();
								//data += '&identificacion_buscar=' + $("#identificacion_buscar").val();
							$.post('../cotizaciones/captura_cotizacion.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#div_mostrar_motos").html(a);
								//alert(data);
							});	
						 });


          //////////////////			
		 });	//fin de la funcion principal 		
          	
</script>