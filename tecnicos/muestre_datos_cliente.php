<?php
session_start();
include('../valotablapc.php');
include('../funciones_summers.php');
				/*
				echo '<pre>';
				print_r($_GET);
				echo '</pre>';
				*/

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
<? 
include("../empresa.php");
include('../valotablapc.php');
include('../funciones.php');
include('../colocar_links2.php');

$sql_clientes = "select * from $tabla21 where idcliente = '".$_GET['idcliente']."'   and  id_empresa = '".$_SESSION['id_empresa']."'   ";
//echo '<br>'.$sql_clientes;

$consulta_clientes = mysql_query($sql_clientes,$conexion);

$filas = mysql_num_rows($consulta_clientes); 

//echo '<br>'.$filas;
if ($filas  > 0)
			{   
			 $datos = get_table_assoc($consulta_clientes);
			 	/*
				echo '<pre>';
				print_r($datos);
				echo '</pre>';
				*/
			 
			 ?>
			 <br> <br>
<div id="div_muestre_datos_tecnico">		 
			<table width="572" border="1">
  <tr>
    <td width="248">&nbsp;</td>
    <td width="308">&nbsp;</td>
  </tr>
  <tr>
    <td>IDENTIFICACION</td>
    <td><input name="identi" id  = "identi" type="text"  value = "<?php  echo $datos[0]['identi']?> " > </td>
  </tr>
  <tr>
    <td>NOMBRE</td>
    <td><input name="nombre" id  = "nombre" type="text"  value = "<?php  echo $datos[0]['nombre'] ?> "   ></td>
  </tr>
  <tr>
    <td>DIRECCION</td>
    <td><input name="direccion" id  = "direccion" type="text"  value = "<?php  echo $datos[0]['direccion']?> "></td>
  </tr>
  <tr>
    <td>TELEFONO</td>
    <td><input name="telefono" id  = "telefono" type="telefono"  value = "<?php  echo $datos[0]['telefono']?> "></td>
  </tr>
  <tr>
    <td>EMAIL</td>
    <td><input name="email" id  = "email" type="text"  value = "<?php  echo $datos[0]['email']?> "></td>
  </tr>
  <tr>
    <td>OBSERVACIONES </td>
    <td><input name="observaci" id  = "observaci" type="text"  value = "<?php  echo $datos[0]['observaci']?> "></td>
  </tr>
  <tr>
    <td>TIPO</td>
    <td>

				<select name="id_tipo" id="id_tipo">
				<?php  colocar_select_general_condicion_mejorada($tipo_operario,$conexion,'id','descripcion',$datos[0]['tipo_operario']) ?>
				</select>		
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="idcliente" id  = "idcliente" type="hidden"  value = "<?php  echo $datos[0]['idcliente']?> "></td>
  </tr>
  <tr>
    <td><button   id = "actualizar_cliente" ><h3>Actualizar</h3></button></td>
    <td><button   id = "btn_eliminartecnico" ><h3>Eliminar</h3></button></td>
  </tr>
</table>
</div>	
			
			<?php
			 }
 else      { echo '<br> NO EXISTE INFORMACION ACERCA DE ESTA PERSONA';}			
			  
 ?>


</body>
</html>
<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../js/jquery-2.1.1.js"></script>   

<script language="JavaScript" type="text/JavaScript">
            
			$(document).ready(function(){
               
			   
			   /////////////////
			  
			   ////////////////
			   
			   
			  
						$("#actualizar_cliente").click(function(){
							var data =  'idcliente=' + $("#idcliente").val();
								data += '&identi=' + $("#identi").val();
								data += '&nombre=' + $("#nombre").val();
								data += '&telefono=' + $("#telefono").val();
								data += '&direccion=' + $("#direccion").val();
								data += '&email=' + $("#email").val();
								data += '&observaci=' + $("#observaci").val();
								data += '&id_tipo=' + $("#id_tipo").val();

							$.post('actualize_datos_cliente.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#muestre").html(a);
								//alert(data);
							});	
						 });
					////////////////////////
					$("#btn_eliminartecnico").click(function(){
							var data =  'idcliente=' + $("#idcliente").val();
							$.post('elimine_datos_cliente.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#div_muestre_datos_tecnico").html(a);
								//alert(data);
							});	
						 });

					////////////////////////
		
					
		 });	//fin de la funcion principal 		
          	
</script>


