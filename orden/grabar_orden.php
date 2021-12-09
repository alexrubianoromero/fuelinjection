<?php
session_start();
/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
exit();
*/
if ($_POST['radio']== 'undefined'){$_POST['radio'] = 0;}
if ($_POST['antena']== 'undefined'){$_POST['antena'] = 0;}
if ($_POST['repuesto']== 'undefined'){$_POST['repuesto'] = 0;}
if ($_POST['herramienta']== 'undefined'){$_POST['herramienta'] = 0;}


include('../valotablapc.php');

//////////////////actualizar las fechas de vencimiento 
$sql_actualizar_fechas_vencimiento = "update $tabla4   set  vencisoat = '".$_REQUEST['vencisoat']."' , revision = '".$_REQUEST['vencitecno']."'    where   idcarro = '".$_REQUEST['idcarro']."' ";
$consulta_actualizar = mysql_query($sql_actualizar_fechas_vencimiento,$conexion);

$sql_grabar_orden = "insert into $tabla14 (orden,placa,sigla,fecha,observaciones,radio,antena,repuesto,herramienta,otros,
	iva,id_empresa,estado,kilometraje,mecanico,tipo_orden,kilometraje_cambio,nivel_gasolina) 
values (
'".$_POST['orden_numero']."',
'".$_POST['placa']."',
'".$_POST['clave']."',
'".$_POST['fecha']."',
'".$_POST['descripcion']."',
'".$_POST['radio']."',
'".$_POST['antena']."',
'".$_POST['repuesto']."',
'".$_POST['herramienta']."',
'".$_POST['otros']."',
'16',
'".$_SESSION['id_empresa']."',
'0',
'".$_POST['kilometraje']."',
'".$_POST['mecanico']."',
'1',
'".$_POST['kilometraje_cambio']."',
'".$_POST['nivel_gasolina']."'
)";
// el  que se graba en tipo_orden de ordenes indica que es una orden normal 
//porque cuando se graba una venta ya se indica un tipo de orden 2 
//esto para evitar confucion entre un numero de orden normal y un numero de orden de venta que se crea con el numero de factura
//echo '<br>'.$sql_grabar_orden;

$consulta_grabar = mysql_query($sql_grabar_orden,$conexion); 
$sql_actualizar_contaor = "update $tabla10 set  contaor = '".$_POST['orden_numero']."'  where   id_empresa = '".$_SESSION['id_empresa']."' "; 
$consulta = mysql_query($sql_actualizar_contaor,$conexion);


//ahora se debe actulizar el numero del consecutivo del campo contaor de  la tabla empresa 
//ahora despues de grabar la orden con el consecutivo que se trae de empresa 
///se debe actualizar el numero del id de la orden para los items creados para que los items queden bien creados con el numero del id de la orden
$sql_traer_id_orden = "select max(id) as id  from $tabla14 where placa = '".$_POST['placa']."'   and id_empresa = '".$_SESSION['id_empresa']."'  ";
//echo '<br>'.$sql_traer_id_orden;
$consulta_id_orden = mysql_query($sql_traer_id_orden,$conexion);
$id_orden = mysql_fetch_assoc($consulta_id_orden);
/*
echo '<pre>';
print_r($id_orden);
echo '</pre>';
*/

//echo "<br>id orden asignado= ".$id_orden['id'];
//despues de obtener el id vamoa a actulizarlo para los items de la orden  osea lo reemplazamos para todos los items que 
//tengan el numero de la orden $_POST['orden_numero']  ny de la empresa respectiva y les colocamnos el id de la orden   en el campo no_factura porque  como el programa 
//es multicliente la idea es que todos los clientes tendras su numeroacion de ordenes y de facturas pero el progrma se basara en los id respectivos

/*
$sql_actualizar_id_orden_item = "update $tabla15  set     no_factura = '".$id_orden['id']."'  where   no_factura = '".$_POST['orden_numero']."' and id_empresa = '".$_SESSION['id_empresa']."' ";
//echo '<br>'.$sql_actualizar_id_orden_item;
$consulta_actualizar_items = mysql_query($sql_actualizar_id_orden_item,$conexion) ;
*/
///////////////////////////////////////////////////////// TRANSLADAR ITEMS DE TEMPORAL A DEFINITIVO
////CONSULTA PARA TRAER LOS ITEMS DE TEMPORAL Y LUEGO CON UN CICLO LOS VAMOS GUARDANDO UNO A UNO EN LA UBICACION DEFINITIVA

$sql_traer_items_temporal = "select * from $tabla18    where  no_factura =  '".$_POST['orden_numero']."'   and id_empresa = '".$_SESSION['id_empresa']."' order by id_item ";
$consulta_temporal_definitivo = mysql_query($sql_traer_items_temporal,$conexion);
while($items  =  mysql_fetch_array($consulta_temporal_definitivo))
		{

			//echo '<br>'.$items[3];
			$sql_grabar_items = " insert into $tabla15   (no_factura,codigo,descripcion,cantidad,total_item,valor_unitario,id_empresa,estado) 
			values ('".$id_orden['id']."','".$items[2]."','".$items[3]."','".$items[4]."','".$items[5]."','".$items[7]."','".$items[8]."','0')";
			$consulta_trasladar_item = mysql_query($sql_grabar_items,$conexion);
			//falta actualizar los valores de inventario;
			//tengo que traer el valor existente en la base 
			$sql_valor_existente = "select codigo_producto,cantidad from $tabla12 where codigo_producto =  '".$items[2]."'   and id_empresa = '".$_SESSION['id_empresa']."'    ";	
			//echo '<br>'.$sql_valor_existente;
			$consulta_valor_inventario = mysql_query($sql_valor_existente,$conexion); 
			$valor_actual_inventario = mysql_fetch_assoc($consulta_valor_inventario);
			
/*
			echo '<pre>';
			print_r($valor_actual_inventario);
			echo '</pre>';	
			*/
	// echo '<br>cantidad base'.$valor_actual_inventario['cantidad'];
  // echo '<br>cantidad item '.$items[4];


			$valor_final_inventario = $valor_actual_inventario['cantidad']  -  $items[4];
			$sql_actualizar_inventario = "update $tabla12 set cantidad = '".$valor_final_inventario."'   
					 where codigo_producto = '".$items[2]."'  and id_empresa = '".$_SESSION['id_empresa']."'  ";
					
      //echo '<br>consulta '.$sql_actualizar_inventario;

					$actualizar_inventario = mysql_query($sql_actualizar_inventario,$conexion);  
		} // temina el proceso de los items
///////////////////////////////////////////////////////////
		
		
////////////////////////////////////////////////////////
		///////////////////////hay que borrar la tabla temporal 
		$sql_borrar_temporal = "delete from $tabla18 where id_empresa = '".$_SESSION['id_empresa']."' ";
		$consulta_borrar = mysql_query($sql_borrar_temporal,$conexion);

////////////////////////////////////////////////
$sql_datos_empresa = "select ruta_imagen,nombre,tipo_taller,identi,telefonos,direccion from $tabla10 where id_empresa = '".$_SESSION['id_empresa']."'  ";  
$consulta_empresa = mysql_query($sql_datos_empresa,$conexion);
$datos_empresa = mysql_fetch_assoc($consulta_empresa);


$sql_nombres_items_inventarios = "select * from $tabla24  where decarroomoto = '".$datos_empresa['tipo_taller']."'   and id_empresa = '".$_SESSION['id_empresa']."' ";
//echo 'consulta<br>'.$sql_nombres_items_inventarios.'<br>';
$consulta_nombres_items = mysql_query($sql_nombres_items_inventarios,$conexion);
$filas_nombres_items = mysql_num_rows($consulta_nombres_items);
//$nombres2_items = get_table_assoc($consulta_nombres_items);
$contador = 0;
//$id_orden['id'];
//echo 'pasooooo11111111111111111111111';

while ($nombres_items = mysql_fetch_assoc($consulta_nombres_items))
{
	$valor = $nombres_items['id_nombre_inventario']; //osea el valor que digito el usuario para el id_nombre_inventario
	$obse = 'obse_'.$nombres_items['id_nombre_inventario'];
	//echo '<br>id inventario'.$_REQUEST[$id_inventario].'<br>';
	$sql_grabar_relacion_inventario = "insert into $tabla25 (id_orden,id_nombre_inventario,valor,id_empresa,observaciones) 
	values ('".$id_orden['id']."','".$nombres_items['id_nombre_inventario']."','".$_REQUEST[$valor]."','".$_SESSION
		['id_empresa']."','".$_REQUEST[$obse]."') ";	
		//echo '<br>'.$sql_grabar_relacion_inventario;	
	$consulta_grabar_relacion = mysql_query($sql_grabar_relacion_inventario,$conexion);	
}//// fin de while ($contador <  $filas_nombres_items)

//////////////////////////////////////////////



echo "<br><br><br>ORDEN No ".$_POST['orden_numero']."   GRABADA";
echo "<br><a href='../menu_principal.php' >Pagina Principal</a>";
echo "<br><a href='index.php' >Menu Ordenes</a>";
//<a href="#">#</a>
?>