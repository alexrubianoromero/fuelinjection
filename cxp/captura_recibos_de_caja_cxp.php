<?php
session_start();
date_default_timezone_set('america/bogota');
include('../valotablapc.php');
include('../funciones_summers.php');


////////////validacion 
$fechapan =  time();
$fechapan = date ( "Y/m/j" , $fechapan );
// echo 'valor de fecha<br>'.$fechapan;
$traer_registro_del_dia = "select * from $tabla22 where  fecha = '".$fechapan."' and   id_empresa = '".$_SESSION['id_empresa']."'  ";
$consulta_fecha = mysql_query($traer_registro_del_dia,$conexion);
$filas_fecha = mysql_num_rows($consulta_fecha);
if($filas_fecha > 0 )
{ // si existe saldo inicial del dia 
}
else{
    echo '<br><h2>NO  ES POSIBLE CREAR RECIBOS PARA EL DIA DE  HOY</h2> <br>';
  echo '<br><h2>NO SE ENCUENTRA EL SALDO INICIAL DEL DIA DE HOY AL PARECER NO SE HA REALIZADO CIERRE DE CAJA DEL DIA ANTERIOR</h2><BR>';
  die();
}


/////////////

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// die();
$datos_cxp= consulta_assoc($cxp,'id',$_REQUEST['id'],$conexion);
$datos_tecnico= consulta_assoc($tabla21,'idcliente',$datos_cxp['id_tecnico'],$conexion);
$datos_orden= consulta_assoc($tabla14,'id',$datos_cxp['id_orden'],$conexion);
// echo '<pre>';
// print_r($datos_cxp);
// echo '</pre>';
//$tipo_recibo = '0';
if($_REQUEST['tipo_recibo']== '1'){ $tipo_recibo = 'INGRESO DINERO';} 
if($_REQUEST['tipo_recibo']== '2'){ $tipo_recibo = 'EGRESO (SALIDA DE DINERO)';} 
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
$fechapan =  time();
// echo '<br>'. date ( 'Y/m/j' , $fechapan );
$sql_numero_recibo = "select contarecicaja,saldocajamenor  from $tabla10 where id_empresa = '".$_SESSION['id_empresa']."' ";
$consulta_numero_recibo = mysql_query($sql_numero_recibo,$conexion);
$numero_actual = mysql_fetch_assoc($consulta_numero_recibo);

/*
echo '<pre>';
print_r($numero_actual);
echo '</pre>';
*/
$siguiente_numero = $numero_actual['contarecicaja'] + 1;



$sql_tecnicos  = "select * from $tabla21   where id_empresa = '".$_SESSION['id_empresa']."' ";
$consulta_tecnicos = mysql_query($sql_tecnicos,$conexion);

?>
<Div id="contenidos2">
	DATOS CXP  ORDEN No : <?php   echo $datos_orden['orden'] ?> Valor Cuenta : <?php   echo $datos_cxp['valor'] ?>
    SALDO: <?php   echo $datos_cxp['saldo'] ?>
    <section>
<?php
if ($tipo_recibo == ''  )
{
   echo 'NO SE DEFINIO UN TIPO DE RECIBO VALIDO ';
}
else
{//	
 
echo '<H2>RECIBO DE '.$tipo_recibo.'</H2>';
?>
<input type="hidden" id="id_cxp" value = "<?php  echo $_REQUEST['id'];  ?>" >
<table width="95%" border="1">
  <tr>
    <td>Saldo caja_actual </td>
    <td> <input name="saldo_actual" type="text"  id = "saldo_actual" value = "<?php  echo $numero_actual['saldocajamenor'] ?>" onFocus="blur()" ></td>
  </tr>
  <tr>
    <td>RECIBO NUMERO </td>
    <td> <input name="numero_recibo" type="text"  id = "numero_recibo" value = "<?php echo ' '.$siguiente_numero   ?>"   onFocus="blur()">
	  <input name="tipo_recibo" type="hidden"  id = "tipo_recibo" value = "<?php  echo $_POST['tipo_recibo'];?>"></td>
  </tr>
  <tr>
    <td width="22%">FECHA:</td>
    <td width="78%"><input size="10" name="fecha" id = "fecha"  value=" <?php echo date ( 'Y/m/j' , $fechapan );?>"  onFocus="blur()" ></td>
  </tr>
  <tr>
    <td>
	 <?php
	 if($_POST['tipo_recibo']== '1'){$recibidopagado =  'RECIBIDO DE';}
	  if($_POST['tipo_recibo']== '2'){$recibidopagado= 'PAGADO A';}
	  echo $recibidopagado;
	 ?>	</td>
    <td><label>
      <input name="dequienoaquin" type="text"  id = "dequienoaquin" size="40%" value="<?php echo $datos_tecnico['nombre'] ?>">
    </label>   <input type="hidden" id="id_mecanico" name="id_mecanico" value = "<?php echo $datos_cxp['id_tecnico'] ?>"> </td>
  </tr>
  <tr>
    <td>LA SUMA DE (numeros sin puntos)</td>
    <td><input type="text" name="lasumade"  id = "lasumade" size="60%"></td>
  </tr>
  <tr>
    <td>POR CONCEPTO DE : </td>
    <td><textarea name="porconceptode" id = "porconceptode" cols="80%" rows="2"></textarea></td>
  </tr>
  <tr>
    <td>OBSERVACIONES</td>
    <td><textarea name="observaciones" id = "observaciones" cols="80%" rows="2"><?php echo $datos_cxp['observaciones']   ?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><button type ="button"  id = "btn_grabar_recibo" >
			      <h4>GRABAR_RECIBO</h4>
	      </button></td>
    </tr>
</table>
<?php 
}// fin de si es un tipo de recibo valido

include('../colocar_links2.php');
?>
</section>

</Div>
	
</body>
</html>
<script src = "../js/jquery.js"></script>
<script src = "../js/appcxp.js"></script>
  





 


