<?php
session_start();
/*
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';
*/
//exit();
include('../valotablapc.php');
 $fechapan =  time();
    $fechapan = date ( "Y/m/j" , $fechapan );

  function  consulta_assoc_crear($tabla,$campo,$parametro,$conexion)
  {
       $sql="select * from $tabla  where ".$campo." = '".$parametro."' ";
       //echo '<br>'.$sql;
       $con = mysql_query($sql,$conexion);
       $arr_con = mysql_fetch_assoc($con);
       return $arr_con;
  }




function sumar_items($tabla,$campo,$parametro,$conexion){
  $sql =" select sum(total_item)  as suma from $tabla where no_factura = '".$parametro."'  ";
   $con = mysql_query($sql,$conexion);
       $arr_con = mysql_fetch_assoc($con);
       return $arr_con['suma'];
}



$datos_empresa =  consulta_assoc_crear($tabla10,'id_empresa',$_SESSION['id_empresa'],$conexion);
$datos_coti = consulta_assoc_crear($cotizaciones,'id_cotizacion',$_REQUEST['id_cotizacion'],$conexion);
$datos_carro = consulta_assoc_crear($tabla4,'idcarro',$datos_coti['idcarro'],$conexion);
$suma_items_coti = sumar_items($item_orden_cotizaciones,'no_factura',$datos_coti['id_cotizacion'],$conexion);

$siguiente_numero_orden = $datos_empresa['contaor'] + 1;
//echo '<br>'.$siguiente_numero_orden;

$sql_crear_orden = "insert into $tabla14   
(fecha, placa ,kilometraje,observaciones,valor,orden,id_empresa,estado,anulado,
  saldo,usuario_creacion,tipo_medida_kms_millas_horas,resolucion,tipo_orden) 
values( 
'".$fechapan."'
,'".$datos_carro['placa']."'
,'".$datos_coti['kilometraje']."'
,'".$datos_coti['observaciones']."'
,'".$suma_items_coti."'
,'".$siguiente_numero_orden."'
,'".$_REQUEST['id_empresa']."'
,'0'
,'0'
,'".$suma_items_coti."'
,'".$_REQUEST['id_usuario']."'
,'1'
,'0'
,'1'
) ";

//echo '<br>Crear Orden<br>'.$sql_crear_orden.'<br>';

$con_crear_orden = mysql_query($sql_crear_orden,$conexion);
//exit();
/////////traer el id de la orden que se grabo
$sql_maximo_id = "select max(id) as maximo from $tabla14 ";
$con_maximo = mysql_query($sql_maximo_id,$conexion);
$arr_maximo = mysql_fetch_assoc($con_maximo);
$maximo_id = $arr_maximo['maximo'];
//echo 'maximo<br>'.$maximo_id;
///////actualizar el estado de la cotizacion  y colocar el id de la orden

$sql_act_estado_coti = "update $cotizaciones set  
estado = '1' 
,id_orden = '".$maximo_id."'
 where id_cotizacion = '".$_REQUEST['id_cotizacion']."'     ";
 $con_act = mysql_query($sql_act_estado_coti,$conexion);
//////////falta pasar los items 
 $sql_traer_items = "select * from $item_orden_cotizaciones where no_factura =  '".$_REQUEST['id_cotizacion']."' ";
  //echo '12312<br>'.$sql_traer_items;
  $con_items = mysql_query($sql_traer_items,$conexion);
  //echo 'paso1111111111111111';


  ///////////////pasar los items
  while($items=mysql_fetch_assoc($con_items))
  {
     $sql_insertar_item_orden ="insert into $tabla15 (no_factura,codigo,descripcion,cantidad
      ,total_item,valor_unitario,id_empresa,estado,repman
      )   
    values ('".$maximo_id."','".$items['codigo']."','".$items['descripcion']."','".$items['cantidad']."'
      ,'".$items['total_item']."'   ,'".$items['valor_unitario']."','".$items['id_empresa']."'
       ,'".$items['estado']."' ,'".$items['repman']."' 
      )   ";
      //echo 'insertar itemorden<br>'.$sql_insertar_item_orden;
      //exit();
     $con_insertar = mysql_query($sql_insertar_item_orden,$conexion);
     //hacer los descuentos del inventario 
     //////buscar el codigo en productos traer las existencias y restarle 
     //la cantidad del item respectivo 

     $sql_traer_existencias_producto = "select * from $tabla12   
     where codigo_producto =  '".$items['codigo']."' ";

     //echo 'existencias<br>'.$sql_traer_existencias_producto.'<br>';
     $con_existencias = mysql_query($sql_traer_existencias_producto,$conexion);
     $arr_producto = mysql_fetch_assoc($con_existencias);
     $existencias = $arr_producto['cantidad'];
     $nuevo_valor_existencias = $existencias -  $items['cantidad'];

     $sql_act_existencias = "update $tabla12 set cantidad =  '".$nuevo_valor_existencias."'   
     where  codigo_producto =  '".$items['codigo']."' "; 
     $con_actu_producto = mysql_query($sql_act_existencias,$conexion);
     //tener en cuenta lo de los movimientos de inventario 

     //echo '<br>'.$sql_act_existencias;


  } //fin de while






/////////////actualizar contador de ordenes de empresa 
$sql_actualizar_empresa = "update $tabla10 set contaor = '".$siguiente_numero_orden."'   ";
$con_act_emp = mysql_query($sql_actualizar_empresa,$conexion);

//echo '<br>'.$sql_actualizar_empresa;


?>
<html>
<head>
  <title></title>
</head>
<body>
<h1>ESTA COTIZACION SE HA CONVERTIDO EN ORDEN CON TODOS SUS ITEMS </h1>
</body>
</html>