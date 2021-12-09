<?php
session_start();
include('../valotablapc.php');
include('../num2letras.php'); 
$ancho_tabla = "99%";
$ancho_tabla_fecha = "100%";
$tamano_letra = '12px';
$tamano_letra_cliente = '12px';
$tamano_letra_fecha = '15px';
$ancho_tabla_items = '99%';
$tamano_letra_items = '12px';
  function  consulta_assoc($tabla,$campo,$parametro,$conexion)
  {
       $sql="select * from $tabla  where ".$campo." = '".$parametro."' ";
       //echo '<br>'.$sql;
       $con = mysql_query($sql,$conexion);
       $arr_con = mysql_fetch_assoc($con);
       return $arr_con;
  }

$datos_factura = consulta_assoc($tabla11,'id_factura',$_REQUEST['id_factura'],$conexion);
$datos_orden = consulta_assoc($tabla14,'id',$datos_factura['id_orden'],$conexion);
$datos_carro = consulta_assoc($tabla4,'placa',$datos_orden['placa'],$conexion);
$datos_cliente = consulta_assoc($tabla3,'idcliente',$datos_carro['propietario'],$conexion);

$sql_iva = "select * from iva ";
$con_iva = mysql_query($sql_iva,$conexion);
$arr_iva = mysql_fetch_assoc($con_iva);
?>
<!DOCTYPE html>
<html lang="es"  >
<head>
	<meta >
	<title>Muestre Ordenes</title>
	<link rel="stylesheet" href="../css/style.css">
    <style type="text/css">
<!--
#Layer1 {
	position:absolute;
	width:99%;
	height:115px;
	z-index:1;
	left: 13px;
	top: 296px;
	/*border: 1px solid black;*/
}
#espacio1{
position:relative;
width:2px;
height:8px;
/*border: 1px solid black; */
}
#espacio2{
position:relative;
width:8px;
height:25px;
/*border: 1px solid black; */
}
-->
    </style>
</head>
<body>
<div id="impresion_factura">	
<p>
  

    <?php
$colum1 = '10%';
$colum2 = '15%';
$colum3 = '70%';
$colum4 = '15%';

$fecha2=date("d-m-Y",strtotime($datos_factura['fecha'] ));
	$dia = substr($fecha2,0,2);
	$mes = substr($fecha2,3,2);
	$ano  = substr($fecha2,6,4);
	
	$dia_separado = '&nbsp;&nbsp;&nbsp;&nbsp;'.substr($dia,0,1).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.substr($dia,1,2);
	
	$mes_separado = substr($mes,0,1).'&nbsp;&nbsp;'.substr($mes,1,2);
	$ano_digito1 = substr($ano,2,1);
	$ano_digito2 = substr($ano,3,2);
?>
<br>
<br>
<br>
<div id="espacio1">

</div>
<table width="<?php  echo $ancho_tabla_fecha; ?>" border="0" cellspacing="1" cellpadding="1" 
 style="font-size:<?php echo $tamano_letra_fecha; ?>">
<tr>
<td width="75%"></td>
<td width="10%" align="center"><?php  echo $dia_separado ?></td>
<td width="7%" align="center"> <?php  echo $mes_separado ?></td>
<td width="5%" align="right"> <?php  echo $ano_digito1 ?>&nbsp;&nbsp;</td>
<td width="5%" align="left">&nbsp;<?php  echo $ano_digito2 ?> </td>
</tr>
</table>
<div id="espacio2">
</div>
<table width="<?php  echo $ancho_tabla; ?>" border="0" cellspacing="1" cellpadding="1" 
 style="font-size:<?php echo $tamano_letra_cliente; ?>">
<tr>
<td width="10%"></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $datos_cliente['nombre']; ?></td>
<td width="10%"></td>
<td align="right"><?php  echo $datos_cliente['identi']; ?></td>
</tr>
<tr height="48px">
  <td></td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $datos_cliente['direccion']; ?></td>
  <td></td>
  <td align="right"><?php  echo $datos_cliente['telefono']; ?></td>
</tr>
</table>
<table width="<?php  echo $ancho_tabla; ?>" border="0" cellspacing="1" cellpadding="1" 
 style="font-size:<?php echo $tamano_letra; ?>">
<tr>
<td width="<?php echo $colum1; ?>"></td>
<td width="<?php echo $colum2; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $datos_carro['placa']; ?></td>
<td width="<?php echo $colum1; ?>"></td>
<td  width="<?php echo $colum2; ?>" ><?php  echo $datos_orden['kilometraje']; ?></td>
<td width="5%"></td>
<td  width="20%"><?php  echo $datos_carro['marca']; ?>
</td>
<td width="<?php echo $colum1; ?>"></td>
<td width="<?php echo $colum2; ?>" align="right"><?php  echo $datos_factura['forma_pago']; ?></td>
</tr>

</table>
<br>
<table width="<?php  echo $ancho_tabla; ?>" border="0" cellspacing="1" cellpadding="1" 
 style="font-size:<?php echo $tamano_letra; ?>">
 <tr>
 <td height="192">
<div id="Layer1">
  
   	<?php
	$suma_total_items =mostrar_items_parametro($tabla15,$datos_orden['id'],$conexion,$ancho_tabla_items,$tamano_letra_items);
   ?>
 </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<br><br><br>
  </td>
 </tr>
 </table>
<br>
<table width="<?php  echo $ancho_tabla; ?>" border="0" cellspacing="1" cellpadding="1" 
 style="font-size:<?php echo $tamano_letra; ?>">
  <tr height="40px">
  <td width="<?php echo $colum3 ?>"></td>
   <td width="<?php echo $colum4 ?>"></td>
  <td width="<?php echo $colum4 ?>" align="right"><?php  echo '$'.number_format($suma_total_items, 0, ',', '.');  ?></td>
  </tr>
  <?php  
      $valor_iva = ($suma_total_items*19)/100;
	  $total_factura = $suma_total_items + $valor_iva;
	   $letras = num2letras($total_factura);
  ?>
  <tr height="25px">
    <td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php  echo $letras.' Pesos M/cte';  ?></td>
	<td></td>
    <td align="right" ><?php  echo '$'.number_format($valor_iva, 0, ',', '.');  ?></td>
  </tr>
  <tr height="25px">
    <td></td>
    <td></td>
    <td align="right" ><?php  echo '$'.number_format($total_factura, 0, ',', '.');  ?></td>
  </tr>
</table>
</div>
</body>
</html> 


<?php
function mostrar_items_parametro($tabla,$id_cotizacion,$conexion,$ancho_tabla_items,$tamano_letra_items){
   $sql_items = "select * from $tabla  where no_factura = '".$id_cotizacion."'  ";
   //and repman = '".$parametro."'       ";
	 //
  //echo'<br>consulta'.$sql_items;
  $consulta_items_cotizacion =mysql_query($sql_items,$conexion);
  $filas = mysql_num_rows($consulta_items_cotizacion);
  
 //echo '<br>'.$filas;
  $no_item =1;
  $suma_item = 0;
  //echo '<table border="1"  width="'.$ancho_tabla.'">';
  if($parametro == 'M'){$nombre_bloque = '<strong><em>MANO DE OBRA</em></strong>';}
  /*else {$nombre_bloque = 'ACEITES Y REPUESTOS';}*/
  
    if($parametro == 'A'){$nombre_bloque = '<strong><em>ACEITE EXCENTO DE IVA</em></strong>';}
	 if($parametro == 'R'){$nombre_bloque = '<strong><em>REPUESTOS</em></strong>';}
	 
 ?>
<table id="tabla_items"
 width="<?php   echo $ancho_tabla_items; ?>" border="0" 
 style="font-size:<?php echo $tamano_letra_items; ?>">
 <?php
 /*
  echo '<tr>';
echo '<td  width= "10%">111</td>';
echo '<td width= "80%">222</td>';
echo '<td width= "15%" align ="right">333</td>';
 echo '</tr>';
 */
 /*
 echo '<tr>';
echo '<td  width= "10%"></td>';
echo '<td width= "80%">'.$nombre_bloque.'</td>';
echo '<td width= "15%" align ="right"></td>';
 echo '</tr>';
 */
 
 /*
   echo '<tr>';
echo '<td  width= "10%"></td>';
echo '<td width= "80%"></td>';
echo '<td width= "15%" align ="right"></td>';
 echo '</tr>';
 */
 while ($item = mysql_fetch_assoc($consulta_items_cotizacion))
 {
        echo '<tr height="19px">'; 
		echo '<td  width= "10%" align="center">'.$item['cantidad'].'</td>';
      //echo '<td align="center">'.$no_item.'</td>';
 
	  echo '<td width= "65%">&nbsp;&nbsp;&nbsp;&nbsp; '.$item['descripcion'].'</td>';
	       echo '<td width= "15%">'.'$'.number_format($item['valor_unitario'], 0, ',', '.').'</td>';
      echo '<td width= "15%" align ="right">'.'$'.number_format($item['total_item'], 0, ',', '.').'</td>';
     echo '<td width= "5%"></td>';
	  echo '</tr>';
      $no_item ++;
      $suma_item = $suma_item + $item['total_item'];
	  //echo '<br>qweqeqw'.$suma_item;
  }//fin de while
  ?>
  </table>
  <?php
  // if($parametro != 'A'){
   //completar_espacios_cotiza($filas);}
 return $suma_item;
  //echo '</table>';
  
}


 ?>
