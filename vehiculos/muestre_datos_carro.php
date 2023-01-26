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
<? include("../empresa.php");
include('../valotablapc.php');
include('../funciones.php');

$sql_clientes = "select idcliente,nombre,identi from $tabla3 where id_empresa = '".$_SESSION['id_empresa']."'   ";
$clientes = mysql_query($sql_clientes,$conexion);

$sql_carro = "select ca.idcarro,ca.placa,ca.marca,ca.tipo,ca.modelo,ca.color,cli.nombre , cli.identi,ca.vencisoat,ca.revision
from $tabla4 ca
inner join $tabla3 cli   on (cli.idcliente = ca.propietario)
 where ca.placa = '".$_POST['placa']."'  ";
//echo '<br>'. $sql_carro;
$consulta_placas = mysql_query($sql_carro,$conexion);
$filas = mysql_num_rows($consulta_placas); 
if ($filas  > 0)
			{   
			 $datos = get_table_assoc($consulta_placas);
			 	/*
				echo '<pre>';
				print_r($datos);
				echo '</pre>';
				*/
			 
			 ?>
			<table width="976" border="1">
  <tr>
    <td width="276">&nbsp;</td>
    <td width="684">&nbsp;</td>
  </tr>
  <tr>
    <td>PLACA (no modificable)</td>
    <td><input name="placa" id  = "placa" type="text"  value = "<?php  echo $datos[0]['placa']?> "  onfocus = "blur()"> </td>
  </tr>
  <tr>
    <td>PROPIETARIO</td>
    <td><input name="propietario" id  = "propietario" type="text"  value = "<?php  echo $datos[0]['nombre'].'-'.$datos[0]['identi'] ?> "   onfocus = "blur()" >
    <input type="checkbox" name="cambiopropietario" id = "cambiopropietario" value="1"><label   for="cambiopropietario" >CAMBIAR PROPIETARIO</label><?php
	echo "<select name='nuevopropietario' id='nuevopropietario'>";
	echo "<option value='' selected>...</option>";     
	while($row = mysql_fetch_array($clientes))
			{
             echo "<h2><option value= ".$row[0].">".$row[1]."-".$row[2]."</h2></option>";
     		}
	 echo "</select>";
	
	?></td>
  </tr>

 <div id = "divpropietario">
 <div>

  <tr>
    <td>MARCA</td>
    <td><input name="marca" id  = "marca" type="text"  value = "<?php  echo $datos[0]['marca']?> "></td>
  </tr>
  <tr>
    <td>TIPO</td>
    <td><input name="tipo" id  = "tipo" type="text"  value = "<?php  echo $datos[0]['tipo']?> "></td>
  </tr>
  <tr>
    <td>MODELO</td>
    <td><input name="modelo" id  = "modelo" type="text"  value = "<?php  echo $datos[0]['modelo']?> "></td>
  </tr>
  <tr>
    <td>COLOR</td>
    <td><input name="color" id  = "color" type="text"  value = "<?php  echo $datos[0]['color']?> "></td>
  </tr>
  <tr>
    <td>VENCIMIENTO SOAT </td>
    <td><input name="vencisoat" id  = "vencisoat" type="text"  value = "<?php  echo $datos[0]['vencisoat']?> "></td>
  </tr>
  <tr>
    <td>VENCIMIENTO TECNOMECANICA </td>
    <td><input name="revision" id  = "revision" type="text"  value = "<?php  echo $datos[0]['revision']?> "></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="idcarro" id  = "idcarro" type="hidden"  value = "<?php  echo $datos[0]['idcarro']?> "></td>
  </tr>
  <tr>
    <td colspan="2"><button type ="button"  id = "actualizar_carro" ><h3>Actualizar</h3></button></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>

			
			<?php
			 }
 else      { echo '<br> NO EXISTE INFORMACION ACERCA DE ESTA PLACA ';}			
			  
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
			   
			   
			  
						$("#actualizar_carro").click(function(){
							var data =  'idcarro=' + $("#idcarro").val();
								data += '&nuevopropietario=' + $("#nuevopropietario").val();
								//data += '&cambiopropietario=' + $("#cambiopropietario").val();
								data += '&cambiopropietario=' + $("#cambiopropietario:checked").val();

								data += '&marca=' + $("#marca").val();
								data += '&tipo=' + $("#tipo").val();
								data += '&modelo=' + $("#modelo").val();
								data += '&color=' + $("#color").val();
								data += '&vencisoat=' + $("#vencisoat").val();
								data += '&revision=' + $("#revision").val();

							$.post('actualize_datos_carro.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#muestre").html(a);
								//alert(data);
							});	
						 });
					////////////////////////
		
					
		 });	//fin de la funcion principal 		
          	
</script>


