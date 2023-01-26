<?php
session_start();
include('../valotablapc.php');

/*
echo '<pre>';
print_r($_REQUEST);
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

<?php
echo '<input type="hidden"   id="fechain"  value = "'.$_REQUEST['fechain'].'" >';
echo '<input type="hidden"   id="fechafin"  value = "'.$_REQUEST['fechafin'].'" >';

$sql_items_orden = "select * from $tabla15   where no_factura = '".$_REQUEST['id_orden']."' and codigo = 'man'  ";
$consulta_nomina = mysql_query($sql_items_orden,$conexion);
$filas_mano_obra = mysql_num_rows($consulta_nomina);
$arr_item_nomina = mysql_fetch_assoc($consulta_nomina);

if($filas_mano_obra > 0) 
{
echo '<h3>MODIFICACION DE VALORES A PAGAR POR MANO DE OBRA </h3>';

echo '<table border="1">';

echo '<tr>';

echo '<td>VALOR TALLER</td>';
echo '<td>VALOR A PAGAR MECANICO </td>';
echo '<td>ACTUALIZAR</td>';
echo '</tr>';

echo '<tr>';
echo '<input type="hidden"   id="id_item" value = "'.$arr_item_nomina['id_item'].'">';
echo '<td align= "right">'.$arr_item_nomina['total_item'].'</td>';
echo '<td align= "right"><input id = "valor_mecanico"  type="" value ="'.$arr_item_nomina['valor_mecanico'].'" class="fila_llenar"></td>';
echo '<td><button id="btn_actualizar_valor"    >ACTUALIZAR</td>';

echo '</tr>';
echo '</table>';
}
else
{
	echo '<br>Esta orden no tiene items con el codigo de mano de obra';
}
?>

</body>
</html>
<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../js/jquery-2.1.1.js"></script> 


<script language="JavaScript" type="text/JavaScript">
            
			$(document).ready(function(){
               
					
					/////////////////////////
					$("#btn_actualizar_valor").click(function(){
							//var data =  'id_orden =' + $(this).attr('value');
							var data =  'fechain=' + $("#fechain").val();
							data += '&fechafin=' + $("#fechafin").val();
							data += '&id_item=' + $("#id_item").val();
							data += '&valor_mecanico=' + $("#valor_mecanico").val();
							//data += '&mecanico=' + $("#mecanico").val();
							$.post('../orden/actualizar_mano_obra_orden.php',data,function(b){
							//$(window).attr('location', '../index.php);
							$("#datos").html(b);
								//alert(data);
							});	
							$.post('../consultas/muestre_nomina_entre_fechas.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#datos").html(a);
								//alert(data);
							});	


						 });
					////////////////////////
					
			
			});		////finde la funcion principal de script
			
			
			
			
			
</script>


