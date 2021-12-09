<?php
session_start();
/*
echo '<pres>';
print_r($_REQUEST);
echo '<pres>';
*/
include('../valotablapc.php');
include('../funciones.php');
echo '<input type="hidden"   id="fechain"  value = "'.$_REQUEST['fechain'].'" >';
echo '<input type="hidden"   id="fechafin"  value = "'.$_REQUEST['fechafin'].'" >';

$sql_mecanicos  = "
select io.id_mecanico,t.nombre,o.placa  from $tabla15 io 
inner join $tabla14 o on (o.id = io.no_factura)
inner join $tabla12 p on (p.codigo_producto = io.codigo)
inner join $tabla21 t on (t.idcliente = io.id_mecanico)
where o.fecha between  '".$_REQUEST['fechain']."' and '".$_REQUEST['fechafin']."'
and p.nomina = '1'
group by id_mecanico
";

//echo 'consulta<br>'.$sql_mecanicos;

?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../css/style.css">
</head>
<style>
   .color_gris{
   	background: #C0C0C0;
   }
   table{
   	border-collapse: collapse;
   	width: 80%;
   }
</style>
<body>

<?php
$grantotal= 0;

$consulta_mecanicos = mysql_query($sql_mecanicos,$conexion);
while($mecanicos = mysql_fetch_assoc($consulta_mecanicos))
{
		$total_trabajos=0;
        $total_descuentos = 0;
   		
   		$sql_sumar_recibos = "select sum(lasumade)  as sumarecibos   from $tabla23   
		 	     where id_operario = '".$mecanicos['id_mecanico']."' 
		 	     and fecha_recibo between '".$_REQUEST['fechain']."' and '".$_REQUEST['fechafin']."'  
		 	     and tipo_recibo = '2'
		 	     "  ;

	     //echo '<br>consulta recibos <br>'.$sql_sumar_recibos;	 	     
		 	$consulta_suma_recibos = mysql_query($sql_sumar_recibos,$conexion);
		 	$arr_suma_recibos = mysql_fetch_assoc($consulta_suma_recibos);  
		 	$suma_recibos = $arr_suma_recibos['sumarecibos'];
		//////aqui comienza el dibujo de la tabla 	
		echo '<table border="1">';
   		echo '<tr >';
   		echo '<td colspan="3" align="center">'.Strtoupper($mecanicos['nombre']).'</td>';
   		echo '</tr>';
   		echo '<tr>';
   		echo '<tr class="color_gris">';
   		echo '<td align="center">ORDEN/PLACA</td>';
   		echo '<td align="center">DESCRIPCION</td>';
   		echo '<td align="center">VR MECANICO</td>';

   		///consultar los items del mecanico en las fechas indicadas 
   		$sql_items_mecanico = "select o.orden,o.id,io.* from $tabla15 io
   		inner join $tabla14 o on (o.id = io.no_factura)
   		inner join $tabla12 p on (p.codigo_producto = io.codigo)
   		where o.fecha between  '".$_REQUEST['fechain']."' and '".$_REQUEST['fechafin']."'
   		and p.nomina = '1'
   		and io.id_mecanico = '".$mecanicos['id_mecanico']."'
   		order by o.orden asc
   		 ";

   		//echo 'consulta2<br> '.$sql_items_mecanico;
   		$consulta_items_mecanico = mysql_query($sql_items_mecanico,$conexion);
   		 

   		//aqui comienza el ciclo que dibuja todos lostrabajos del mecanico 
   		//de acuerdo a las fechas 


   		while($items = mysql_fetch_assoc($consulta_items_mecanico))
		{
   		echo '</tr>';
   		//echo '<td align="center">'.$items['orden'].'</td>';
   		echo '<td align="center">';
   		echo '<a href="../orden/orden_imprimir.php?idorden='.$items['id'].'"  
   		target = "_blank">'.$items['orden'].'</a>';
   		echo ' '.$mecanicos['placa'];
   		echo '</td>';
   		echo '<td>'.$items['descripcion'].'</td>';
   		/*
   		echo '<td align="right">';
   		echo '<a href = "../orden/muestre_mano_obra_orden_solo1_mecanico.php?id_item='.$items['id_item'].'">'.number_format($items['valor_mecanico'], 0, ',', '.').'</a>';
   		//echo number_format($items['valor_mecanico'], 0, ',', '.');	
   		echo '</td>';
		*/
   		//////////////////////
		  
   		echo '<td align= "right"  width = "20%"><button id="modif_vr_mecanico" class= "modif_vr_mecanico" 
   		value="'.$items['id_item'].'">'.number_format($items['valor_mecanico'], 0, ',', '.').'</button></td>';
		  

   		///////////////
   		//muestre_mano_obra_orden_solo1_mecanico.php
   		echo '</tr>';
   		$total_trabajos= $total_trabajos + $items['valor_mecanico'] ;

        }//fin de while de los items de mecanico
        //aqui debe terminar el ciclo de los trabajos del mecanico para essa fechas 

   		echo '</tr>';
   		echo '<td></td>';
   		echo '<td>TOTAL TRABAJOS</td>';
   		echo '<td align="right">'.number_format($total_trabajos, 0, ',', '.').'</td>';
   		echo '</tr>';

   		echo '</tr>';
   		echo '<td></td>';
   		echo '<td>TOTAL DESCUENTOS</td>';
   		echo '<td align="right">'.number_format($suma_recibos, 0, ',', '.').'</td>';
   		echo '</tr>';

   		$vr_a_pagar = $total_trabajos - $suma_recibos;
   		echo '</tr>';
   		echo '<td></td>';
   		echo '<td>TOTAL A PAGAR</td>';
   		echo '<td align="right">'.number_format($vr_a_pagar, 0, ',', '.').'</td>';
   		echo '</tr>';

   		echo '<tr >';
   		echo '<td colspan="3" align="center"><br><br><br>Recibi a conformidad </td>';
   		echo '</tr>';
   		echo '</table>';
   		echo '<br><br>';
   
}//	

?>
</body>
</html>
<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../js/jquery-2.1.1.js"></script> 


<script language="JavaScript" type="text/JavaScript">
            
			$(document).ready(function(){
               
					
					/////////////////////////
					$(".modif_vr_mecanico").click(function(){
							//var data =  'id_orden =' + $(this).attr('value');
							var data =  'fechain=' + $("#fechain").val();
							data += '&fechafin=' + $("#fechafin").val();
							data += '&id_item=' + $(this).attr('value');
							//data += '&mecanico=' + $("#mecanico").val();
							$.post('../orden/muestre_mano_obra_orden_solo1_mecanico.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#datos").html(a);
								//alert(data);
							});	
						 });
					////////////////////////
					
			
			});		////finde la funcion principal de script
			
			
			
			
			
</script>


