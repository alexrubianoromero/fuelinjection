<?php
session_start();
include('../valotablapc.php');  
include('../funciones.php'); 
?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>imprimir orden</title>
    <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/style.css">
<script src="./js/jquery.js" type="text/javascript"></script>
<style>
h7{
  
  color: black;
  font-size: 14px;
  text-align: left; 

}
</style>
</head>
<body>
<?php

//include('../numerosALetras.class.php');
 // $n = new numerosALetras ( 159 ) ; 
//echo $n -> resultado ;
//$letras = $n -> resultado ;
//echo '<br>letras'.$letras; 

/*
echo '<pre>';
print_r($_GET);
echo '</pre>';
*/

//exit();






/*
$sql_numero_factura = "select * from $tabla14 where id = '".$_GET['idorden']."' ";
$consulta_facturas = mysql_query($sql_numero_factura,$conexion);
$filas = mysql_num_rows($consulta_facturas);
*/
//echo 'filas ='.$filas;
//exit();
$sql_empresa = "select * from $tabla10 where id_empresa = ".$_SESSION['id_empresa']." ";
$consulta_empresa = mysql_query($sql_empresa,$conexion); 
$datos_empresa = mysql_fetch_assoc($consulta_empresa);
$ruta_imagen = '../logos/'.$datos_empresa['ruta_imagen'];
/*
echo '<pre>';
print_r($datos_empresa);
echo '</pre>';
exit(); 
*/


$sql_placas = "select cli.nombre as nombre ,cli.identi as identi ,cli.direccion as direccion,cli.telefono as telefono ,car.placa as placa,car.marca,car.modelo,car.color,car.tipo,car.vencisoat,car.revision,
 o.fecha,o.observaciones,o.radio,o.antena,o.repuesto,o.herramienta,o.otros,o.iva as iva ,o.orden,o.kilometraje,o.mecanico,o.kilometraje_cambio
from $tabla4 as car
inner join $tabla3 as cli on (cli.idcliente = car.propietario)
inner join $tabla14 as o  on (o.placa = car.placa) 
 where o.id = '".$_GET['idorden']."' ";
 
 //echo '<br>'.$sql_placas;
$datos = mysql_query($sql_placas,$conexion);
$datos = get_table_assoc($datos);


$sql_items_orden = "select * from $tabla15 where no_factura = '".$_GET['idorden']."' order by id_item ";
$consulta_items = mysql_query($sql_items_orden,$conexion);

$sql_buscar_operario = "select * from $tabla21 where idcliente = '".$datos[0]['mecanico']."'  ";
$consulta_mecanico = mysql_query($sql_buscar_operario,$conexion);
$filas_mecanico = mysql_num_rows($consulta_mecanico);

if($filas_mecanico<1) 
{  // no encontro el id osea esta es el nombre
    $nombre_mecanico = $datos[0]['mecanico'];
}
else
{
    $arr_mecanico = mysql_fetch_assoc($consulta_mecanico);
    $nombre_mecanico = $arr_mecanico['nombre'];
}

/*
echo '<pre>';
print_r($datos);
echo '</pre>';
exit();
*/



//$fechapan =  time();
?>
<br>
<br>
<div  id = "imprimir">
<table width="79%" border="0">
  <tr>
    <td colspan="2" rowspan="2"><img src="<?php  echo $ruta_imagen    ?>" width="187" height="61"></td>
    <td colspan="2">&nbsp;</td>
    <td width="125">&nbsp;</td>
    <td colspan="2">ORDEN  No  </td>
    <td colspan="2"><?php  echo $datos[0]['orden'] ?></td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="34">&nbsp;</td>
    <td width="124">&nbsp;</td>
    <td width="106">&nbsp;</td>
    <td width="108">&nbsp;</td>
  </tr>
  <tr>
    <td width="138">FECHA</td>
    <td colspan="3"><?php echo $datos[0]['fecha']  ?></td>
    <td>MARCA</td>
    <td colspan="2"><?php echo $datos[0]['marca']  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>CLIENTE</td>
    <td colspan="3"><?php echo $datos[0]['nombre']  ?></td>
    <td>TIPO</td>
    <td colspan="2"><?php echo $datos[0]['tipo']  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>NIT</td>
    <td colspan="3"><?php echo $datos[0]['identi']  ?></td>
    <td>MODELO</td>
    <td colspan="2"><?php echo $datos[0]['modelo']  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>DIRECCION</td>
    <td colspan="3"><?php echo $datos[0]['direccion']  ?></td>
    <td>PLACA</td>
    <td colspan="2"><?php echo $datos[0]['placa']  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>TELEFONO</td>
    <td colspan="3"><?php echo $datos[0]['telefono']  ?></td>
    <td>COLOR</td>
    <td colspan="2"><?php echo $datos[0]['color']  ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>PLACA</td>
    <td colspan="3"><?php echo $datos[0]['placa']  ?></td>
    <td>KILOMETRAJE</td>
    <td colspan="2"><?php echo $datos[0]['kilometraje']  ?></td>
    <td>PROXIMO  </td>
    <td><?php echo $datos[0]['kilometraje_cambio']  ?></td>
  </tr>
  <tr>
    <td>VENCISOAT</td>
    <td colspan="3"><?php echo $datos[0]['vencisoat']  ?></td>
    <td>OPERARIO</td>
    <td colspan="2"><?php echo $nombre_mecanico ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>VENSI REVISION </td>
    <td colspan="3"><?php echo $datos[0]['revision']  ?></td>
    <td>&nbsp;</td>
    <td colspan="2"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="9"><div align="left">TRABAJO A REALIZAR </div></td>
    </tr>
  <tr>
    <td colspan="9"><label>
      <textarea name="textarea" cols="140" rows="3"><?php  echo $datos[0]['observaciones']    ?> </textarea>
    </label></td>
    </tr>
  
  <tr>
    <td colspan="9"><div align="left">PARTES Y RESPUESTOS </div></td>
    </tr>
  <tr>
    <td><div align="center">REFERENCIA</div></td>
    <td colspan="4"><div align="center">DESCRIPCION</div>      <div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
    <td><div align="center">CANT</div></td>
    <td><div align="center">VR. UNIDAD </div></td>
    <td><div align="center">VR. TOTAL </div></td>
  </tr>
  <!--  aqui se insertan los items -->
  <?php  $subtotal =  muestre_items_impre($_GET['idorden'],$tabla15,$conexion,$_SESSION['id_empresa']); 
  
  $valoriva = ($subtotal * $datos[0]['iva'])/100;
  if($subtotal > 750000)
	  			{
					$porcentaje_retencion = 4;
				}
	  else 		{
	  				$porcentaje_retencion = 0;
	  			}			
	  $retencion = ($valoriva * $porcentaje_retencion)/100;
	  $total = $subtotal + $valoriva  + $retencion ;
	  //$n = new numerosALetras($total) ; 
	  //$letras = $n -> resultado ;
	  
      //echo '<br>valor de conversion a letras <br>'.$n -> resultado ;
	  

   ?>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan = "8">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="3" rowspan="2"></td>
    <td colspan="3" rowspan="2">&nbsp;</td>
    <td>SUBTOTAL</td>
    <td><div align = "right"><?php  echo $subtotal  ?></div></td>
    <td></td>
  </tr>
  <?php
  
   
  ?>

  <tr>
    <td colspan="3" rowspan="5">&nbsp;</td>
  </tr>
  
  
 
  <tr>
    <td colspan="3"><div align="left"> <?php echo $datos_empresa['nombre'];  ?> </div></td>
    <td colspan="3">Recibi Firma Autorizada </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Firma Autorizada </td>
    <td colspan="3">Firma y Sello del Cliente </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="49">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td colspan="9">* Esta es la orden de trabajo no una factura *no esta incluido el iva * valida solo por 30 dias </td>
    </tr>
</table>
<?php 
//traer imagen para imprimir 
$sql_traer_imagenes = "select * from $tablaima  where idorden  = '".$_REQUEST['idorden']."' and id_empresa = '".$_SESSION['id_empresa']."' ";
//echo '<br>la consulta<br>'.$sql_traer_imagenes;
$consulta_imagenes = mysql_query($sql_traer_imagenes,$conexion);
//$imagenes = mysql_fetch_assoc($consulta_imagenes);

echo '<br>';
echo '<table border = "1">';
while($imagenes = mysql_fetch_assoc($consulta_imagenes))
		{
			echo '<tr>';
			
			echo '<td> 
			<img src="'.'../imagenes_modulo/'.$imagenes['ruta_imagen'].'" width="400" height="400"   />
			</td>';
			echo '</tr>';
		}
echo '</table>';		


//////////////////////////////////////////funcion de muestre_items
function muestre_items_impre($orden,$tabla,$conexion,$id_empresa)
    {
        $subtotal = 0;
        //echo 'pasooooooooooooooooo3333333333333333333'.$orden;
        $sql_items_orden = "select * from  $tabla where no_factura = '".$orden."' and id_empresa = '".$id_empresa."'  order by id_item ";
        //echo '<br>'.$sql_items_orden.'<br>';
        $consulta_items = mysql_query($sql_items_orden,$conexion);
        $no_item = 0 ;
     while($items = mysql_fetch_array($consulta_items))
       {
       $i++;
        echo '<tr>
           
                <td width="38"><h7>'.$items['codigo'].'</h7></td>
          <td width="60" colspan = "4"><h7> '.$items['descripcion'].'</h7></td>
        <td width="87"><h7><div align = "right"> '.$items['cantidad'].'</div></h7></td>
          <td width="82"><h7><div align = "right">'.$items['valor_unitario'].'</div></h7></td>
            <td width="85"><h7><div align = "right">'.$items['total_item'].'</div></h7></td>
          </tr>
        ';
        //<td width="34">'.$i.'</td>
        $subtotal = $subtotal + $items['total_item'];
       }
       return $subtotal; 
    }
///////////////////////////





?>

</div>
</body>
</html>
<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../js/jquery-2.1.1.js"></script>   
