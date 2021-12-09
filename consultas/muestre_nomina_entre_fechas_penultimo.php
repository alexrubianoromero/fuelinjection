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

$sql_ordenes = "select mecanico from $tabla14 where fecha between '".$_REQUEST['fechain']."'   and   '".$_REQUEST['fechafin']."'   and id_empresa = '".$_SESSION['id_empresa']."' and anulado = '0'
and estado in (1)  group by mecanico  ";
?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<style>
   #color_gris{
   	background: #C0C0C0;
   }
</style>
<body>

<?php
//echo '<br>consulta<br>'.$sql_ordenes;
echo '<h3>RESUMEN NOMINA  DEL '.$_REQUEST['fechain'].'  AL '.$_REQUEST['fechafin'].'</h3> ';

 $gran_total = 0;
$consulta_ordenes_fecha = mysql_query($sql_ordenes,$conexion);
while($mecanicos = mysql_fetch_assoc($consulta_ordenes_fecha))
	{
	   
	   echo '<table border = "1" width = "90%"> ';
//echo '<tr><td></td><td>NOMBRE MECANICO</td><td>VALOR MANOS DE OBRA </td></tr>';
	   //tener en cuenta si esta en blanco el nombre del macanico 
	   //echo '<br>'.$mecanicos['mecanico'];
	   
	 
	   $traer_nombre_mecanico = "select nombre from $tabla21  where  id_empresa = '".$_SESSION['id_empresa']."'  and idcliente = '".$mecanicos['mecanico']."' ";
	   $nombre_mecanico = mysql_query($traer_nombre_mecanico,$conexion);
	   $nombre_mecanico  = mysql_fetch_assoc($nombre_mecanico); 
	   $nombre_mecanico =$nombre_mecanico['nombre'];
	   
	     echo '<tr id="color_gris">';
	   echo '<td width ="20%">TECNICO</td>'; 
	   
	   if($mecanicos['mecanico']=='')
	   		{
			echo '<td width ="40%">MECANICO NO ASIGNADO</td>'; 
			}
			else
			{
	      	 echo '<td width ="40%">'.$nombre_mecanico.'</td>'; 
	   		}
		 echo '<td width = "20%" align = "center"> VR MANO OBRA</td>';	
		 echo '<td width = "20%" align = "center"> VR MECANICO</td>';	
		 //echo '<td width = "20%" align = "center"> MODIFICAR</td>';	
		 

	    echo '</tr>';
	   ///////// calculo de manos de obra 
	   //////// buscar todas las ordenes dentro de esas fechas asignadas al mencanico y revisar cada item de esa orden y traer los que sean de codigo de nomina
	   ////////traer los id de las ordenes de ese mecanico 
	   $sql_id_ordenes_mecanico = "select orden,id,placa  from $tabla14 where fecha between '".$_REQUEST['fechain']."'  and   '".$_REQUEST['fechafin']."'    and id_empresa = '".$_SESSION['id_empresa']."' and anulado = '0'  and mecanico = '".$mecanicos['mecanico']."' and estado in (1,2)";
	  // echo '<br>consulta_mecanicos'.
	   $consulta_id_ordenes = mysql_query($sql_id_ordenes_mecanico,$conexion);
	   $suma_parcial_items = 0;
	   $suma_parcial_valor_mecanico=0;
	   ////////////////////////////////////////////////
	   while($id_ordenes = mysql_fetch_assoc($consulta_id_ordenes))
	   {
	       
		   ///  ahora se debe sumar los items que ssean de nomina de acuerdo al id de la orden 
			$suma_item_nomina_por_orden = "
						select sum(io.total_item) as suma from $tabla15 io
							inner join $tabla12 p on (p.codigo_producto=io.codigo )
								where io.no_factura = '".$id_ordenes['id']."'
								and p.nomina = '1'
								and p.id_empresa = '".$_SESSION['id_empresa']."'
								";
			$consulta_items = mysql_query($suma_item_nomina_por_orden,$conexion);					
			$suma_item_nomina = mysql_fetch_assoc($consulta_items);
			$suma_item_nomina = $suma_item_nomina['suma'];


			$suma_item_vr_mecanico = "
						select sum(io.valor_mecanico) as suma from $tabla15 io
							inner join $tabla12 p on (p.codigo_producto=io.codigo )
								where io.no_factura = '".$id_ordenes['id']."'
								and p.nomina = '1'
								and p.id_empresa = '".$_SESSION['id_empresa']."'
								"; 
			$consulta_suma_valor_mecanico = mysql_query($suma_item_vr_mecanico,$conexion);	
			$arr_suma_vr_mecanico = mysql_fetch_assoc($consulta_suma_valor_mecanico);
			$suma_vr_mecanico = $arr_suma_vr_mecanico['suma'];				
		   
		   $tipo_moto = traer_tipo_moto($tabla4,$id_ordenes['placa'],$conexion,$_SESSION['id_empresa']);
		   
		   echo  '<tr>';
		    echo '<td >ORDEN</td>';
		   echo '<td width = "40%"><a href="../orden/orden_imprimir.php?idorden='.$id_ordenes['id'].'"  target = "_blank">'.$id_ordenes['orden'].'</a>'.' placa '.$id_ordenes['placa'].' linea '.$tipo_moto.'</td>';
		   //echo '<td><td>';
		  
		   echo '<td align= "right"  width = "20%">'.number_format($suma_item_nomina, 0, ',', '.').'</td>';
		   //////////////////////////el valor del item para el mecanico 
		   //echo '<td align= "right"  width = "20%">'.number_format($suma_vr_mecanico, 0, ',', '.').'</td>';
		   echo '<td align= "right"  width = "20%"><button id="modif_vr_mecanico" class= "modif_vr_mecanico" value="'.$id_ordenes['id'].'">'.number_format($suma_vr_mecanico, 0, ',', '.').'</button></td>';
		  
		  // echo '<td><button id="" name = "" value =""  >MODIFICAR</button></td>';
		    echo  '</tr>';
		 	$suma_parcial_items = $suma_parcial_items +  $suma_item_nomina;
		 	$suma_parcial_valor_mecanico = $suma_parcial_valor_mecanico + $suma_vr_mecanico;
		 	////////////////EL PORCENTAJE 50%
		 	$vr_porcentaje_tecnico = ($suma_parcial_items *50)/100;

		 	/////////////////////////////Sumar los recibos de caja dentro de esas fechas 

		 	$sql_sumar_recibos = "select sum(lasumade)  as sumarecibos   from $tabla23   
		 	     where id_operario = '".$mecanicos['mecanico']."' 
		 	     and fecha_recibo between '".$_REQUEST['fechain']."' and '".$_REQUEST['fechafin']."'  
		 	     and tipo_recibo = '2'
		 	     "  ;

		 	     //echo '<br>'.$sql_sumar_recibos;

		 	$consulta_suma_recibos = mysql_query($sql_sumar_recibos,$conexion);
		 	$arr_suma_recibos = mysql_fetch_assoc($consulta_suma_recibos);  
		 	$suma_recibos = $arr_suma_recibos['sumarecibos'];

		 	$vr_a_pagar = $suma_parcial_valor_mecanico - $suma_recibos;

			
	   }// fin de while($id_ordenes = mysql_fetch_assoc($consulta_id_ordenes))
	   /////////////////////////////////////////////////////////////
	   
	   		echo '<tr>';
			echo '<td width = "20%"></td><td width = "40%">TOTAL MANOS DE OBRA</td>';

			echo '<td  align= "right" width ="20%">'.number_format($suma_parcial_items, 0, ',', '.').'</td>';
			echo '<td  align= "right" width ="20%">'.number_format($suma_parcial_valor_mecanico, 0, ',', '.').'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td width = "20%"></td><td width = "40%"></td>
			<td  align= "right" width ="20%"></td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td></td>';

			echo '<td width = "20%"></td><td width = "20%" align="right">VALOR TECNICO</td>';
						echo '<td  align= "right" width ="20%">'.number_format($suma_parcial_valor_mecanico, 0, ',', '.').'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td></td>';

			echo '<td width = "20%"></td><td width = "20%" align="right">PRESTAMOS</td>
			<td  align= "right" width ="20%">'.number_format($suma_recibos, 0, ',', '.').'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td></td>';

			echo '<td width = "20%"></td><td width = "20%" align="right">VALOR A PAGAR</td>
			<td  align= "right" width ="20%">'.number_format($vr_a_pagar, 0, ',', '.').'</td>';
			echo '</tr>';
	 $gran_total =  $gran_total + $vr_a_pagar;
	   
echo '</table>';
	   echo '<br><br><br>Recibi a Conformidad_________________________ <br><br><br><br>';
	}// fin del ciclo de los nombres encontrados en las ordenes 


echo '<table border = "1" width = "90%"> ';
echo '<tr>';
echo '<td></td><td>GRAN TOTAL A PAGAR </td>
<td  align= "right">'.number_format($gran_total, 0, ',', '.').'</td>';
echo '</tr>';
echo '</table>';

//
/*
		$sql_ordenes_mecanico = "select * from $tabla14 where fecha between '2016-08-01'   and   '2016-08-15'   and id_empresa = '".$_SESSION['id_empresa']."' and anulado = '0'  and mecanico = '".$mecanicos['mecanico']."'  ";
		$consulta_solo_mecanico = mysql_query($sql_ordenes_mecanico,$conexion);
		while($orden_mecanico)
		{
		
		}// fin de 

*/

function traer_tipo_moto($tabla4,$placa,$conexion,$id_empresa)
	{
		$sql_traer_linea = "select tipo from $tabla4  where placa = '".$placa."' and id_empresa = '".$id_empresa."' ";	
		//echo '<br>'.$sql_traer_linea.'<br>';
		$consulta_placa =  mysql_query($sql_traer_linea,$conexion);
		$tipo = mysql_fetch_assoc($consulta_placa);
		$tipo = $tipo['tipo'];
		return $tipo;
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
					$(".modif_vr_mecanico").click(function(){
							//var data =  'id_orden =' + $(this).attr('value');
							var data =  'fechain=' + $("#fechain").val();
							data += '&fechafin=' + $("#fechafin").val();
							data += '&id_orden=' + $(this).attr('value');
							//data += '&mecanico=' + $("#mecanico").val();
							$.post('../orden/muestre_mano_obra_orden.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#datos").html(a);
								//alert(data);
							});	
						 });
					////////////////////////
					
			
			});		////finde la funcion principal de script
			
			
			
			
			
</script>


