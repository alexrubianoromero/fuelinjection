<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="ISO-8859-1">
	<title>orde captura</title>
    <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/style.css">
<script src="./js/jquery.js" type="text/javascript"></script>
<style>
.headt td{
/* background-color: #433;*/
 height: 20px;
}
.headt2 td{
/* background-color: #433;*/
 height: 16px;
}
</style>
</head>
<body>
<?php


/*
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';

*/



include('../valotablapc.php');  
include('../funciones.php');
$tamano_letra ="10px";
$tamano_letra_items ="9px";
/*
$sql_numero_factura = "select * from $tabla14 where id = '".$_GET['idorden']."' ";
$consulta_facturas = mysql_query($sql_numero_factura,$conexion);
$filas = mysql_num_rows($consulta_facturas);
*/
//echo 'filas ='.$filas;
//exit();



$sql_placas = "select cli.nombre,cli.identi,cli.direccion,cli.telefono,car.placa,car.marca,car.modelo,car.color,car.tipo,
 o.fecha,o.observaciones,o.radio,o.antena,o.repuesto,o.herramienta,o.otros,o.iva as iva ,o.orden,o.kilometraje,o.mecanico,o.id,
 e.identi,e.telefonos as telefonos_empresa ,e.direccion as direccion_empresa 
from $tabla4 as car
inner join $tabla3 as cli on (cli.idcliente = car.propietario)
inner join $tabla14 as o  on (o.placa = car.placa)
inner join $tabla10 as e on  (e.id_empresa = o.id_empresa) 
 where o.id = '".$_GET['idorden']."'   and   o.id_empresa = '".$_SESSION['id_empresa']."' ";
 
 //echo '<br>'.$sql_placas;
$datos = mysql_query($sql_placas,$conexion);
$filas = mysql_num_rows($datos); 
if ($filas == 0 ) {echo '<BR><BR>ESTA ORDEN NO SE PUEDE MODIFICAR';}
//echo '<br>filas =='.$filas;
$ancho_tabla = '90%';
 $datos = get_table_assoc($datos); 


$sql_items_orden = "select * from $tabla15 where no_factura = '".$_GET['idorden']."' order by id_item ";
$consulta_items = mysql_query($sql_items_orden,$conexion);
$factupan = $_GET['idorden'];
/*
echo '<pre>';
print_r($datos);
echo '</pre>';
exit();
*/



//$fechapan =  time();
?>
<div id = "divorden" align="center">
  <form action="" method="post">
    <table border = "1" width="<?php  echo $ancho_tabla;  ?>"  style="font-size:<?php echo $tamano_letra; ?>">
      <tr>
        <td colspan="2" rowspan="4"><div align="center"><img src="../logos/fuelinjection.png" width="147" height="52"></div></td>
        <td colspan="2"><h3>ORDEN DE TRABAJO</h3></td>
        <td >
                 <input name="orden" id = "orden" type="text" size="20" value = "<? echo $datos[0]['orden']  ?>"  >
                <input name="orden_numero" id = "orden_numero"  type="hidden" size="20" value = "<? echo $_GET['idorden']  ?>"  >
        </td>
      </tr>
      <tr>
        <td colspan="2"><div align="center"><?php  echo $datos[0]['identi']   ?> </div></td>
        <td>CLAVE</td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">TELS <?php  echo $datos[0]['telefonos_empresa']   ?> </div></td>
        <td><input name="clave" id = "clave" type="text" size="20" ></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center"><?php  echo $datos[0]['direccion_empresa']   ?> </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="85">FECHA</td>
        <td colspan="2"><input size=10 name=fecha id = "fecha"  value= <? echo $datos[0]['fecha']  ;?>></td>
        <td width="123">MARCA</td>
        <td width="141"><input name="marca" id = "marca" type="text"  value = "<? echo $datos[0]['marca']  ?>"></td>
      </tr>
      <tr>
        <td>NOMBRE</td>
        <td colspan="2"><input name="nombre"  id = "nombre" type="text"  value = "<?php echo $datos[0]['nombre']; ?> "></td>
        <td>TIPO</td>
        <td><input name="tipo" type="text"  value = "<? echo $datos[0]['tipo']  ?>"></td>
      </tr>
      <tr>
        <td>CC/NIT</td>
        <td colspan="2"><input name="identificacion" type="text"  value = "<?php echo $datos[0]['identi']; ?> "></td>
        <td>MODELO</td>
        <td><input name="modelo" type="text"  value = "<? echo $datos[0]['modelo']  ?>"></td>
      </tr>
      <tr>
        <td>DIRECCION</td>
        <td colspan="2"><input name="direccion" type="text" size="50" value = "<? echo $datos[0]['direccion']  ?>"  ></td>
        <td>PLACA</td>
        <td><input name="placa" id = "placa" type="text" size="10" value = "<? echo $datos[0]['placa']  ?>"  ></td>
      </tr>
      <tr>
        <td>TELEFONO</td>
        <td colspan="2"><input name="telefono" type="text" size="40" value = "<? echo $datos[0]['telefono']  ?>"></td>
        <td>COLOR</td>
        <td><input name="color" type="text" size="20" value = "<? echo $datos[0]['color']  ?>" ></td>
      </tr>
	   <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	  <td>KILOMETRAJE</td>
	  <td><input name="kilometraje"  id = "kilometraje"  type="text" size="20" value = "<? echo $datos[0]['kilometraje']  ?>" ></td></tr>
	  <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	  <td>OPERARIO</td>
	  <td><input name="mecanico"   id = "mecanico"  type="text" size="20" value = "<? echo $datos[0]['mecanico']  ?>" ></td></tr>
      <tr>
      <tr>
        <td colspan="11"><div align="center">TRABAJO A REALIZAR </div></td>
      </tr>
      <tr>
        <td height="80" colspan="11"><label>
          <textarea name="descripcion"  id = "descripcion" cols="90" rows="4"> <?php  echo $datos[0]['observaciones']?>
    </textarea>
        </label></td>
      </tr>
    </table>
	  
    
  <br>
	  <table width="<?php  echo $ancho_tabla;  ?>" border = "0" style="font-size:<?php echo $tamano_letra; ?>">
      <tr>
        <td colspan="11"><div align="center">PARTES Y RESPUESTOS </div></td>
      </tr>
    </table>
  
		  <div id = "nuevodiv">
				 <?php 
				  include('mostrar_items.php');
				  mostrar_items($factupan);
				?>
		 </div>
		 <br>
  <table border = "1" width="<?php  echo $ancho_tabla;  ?>"  style="font-size:<?php echo $tamano_letra; ?>">
      <tr>
        <td colspan="7"><div align="center">INVENTARIO</div></td>
      </tr>
      <tr>
        <td width="85">RADIO</td>
        <td width="144">
		<?  if ($datos[0]['radio']=="1"){echo '<input name = "radio" id="radio"  type="checkbox" checked  value = "1" >';} 
		    else {echo '<input  name = "radio" id="radio"  type="checkbox" unchecked   value = "1"  >';}  ?>		</td>
        <td width="199">HERRAMIENTA</td>
        <td colspan="4"><label>
     
		  <?  if ($datos[0]['herramienta']=="1"){echo '<input name = "herramienta" id="herramienta"  type="checkbox" checked value = "1" >';} else {echo '<input  name = "herramienta" id="herramienta"  type="checkbox" unchecked value = "1" >';}  ?>
        </label></td>
      </tr>
      <tr>
        <td>ANTENA</td>
        <td><label><?  if ($datos[0]['antena']=="1"){echo '<input name = "antena" id="antena"  type="checkbox" checked value = "1"  >';} else {echo '<input  name = "antena" id="antena"  type="checkbox" unchecked value = "1" >';}  ?>
        </label></td>
        <td colspan="5" rowspan="2">OTROS
          <label>
            <textarea name="otros" id = "otros" cols="50" rows="2"> <?php  echo $datos[0]['otros']?></textarea>
          </label></td>
      </tr>
      <tr>
        <td>REPUESTO</td>
        <td><label><?php  if ($datos[0]['repuesto']=="1"){echo '<input name = "repuesto" id="repuesto"  type="checkbox" checked value = "1" >';} else {echo '<input  name = "repuesto" id="repuesto"  type="checkbox" unchecked value = "1" >';}  ?>
		  
        </label></td>
      </tr>
      <tr>
        <td>IVA</td>
        <td><input name="iva" type="text" id = "iva"  value = "<?php echo $datos[0]['iva']; ?>"</td>
        <td>&nbsp;</td>
        <td width="123">&nbsp;</td>
        <td width="141">&nbsp;</td>
        <td width="48">&nbsp;</td>
        <td width="-1">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7"></td>
      </tr>

    </table>
  </form>
</div>
<br><br><hr></hr><br>

<div id="desprendible">
<table width="<?php  echo $ancho_tabla;  ?>"  border="0">
  <tr>
    <td width="277"><div align="center"><img src="../logos/croquis.png" width="270" height="320"></div></td>
    <td width="469">
      <div align="right">
        <table width="100%" border="1" style="font-size:<?php echo $tamano_letra_items; ?>">
          <tr class="headt" align="center">
            <td class="ancho">EXTERIOR</td>
            <td>SI</td>
            <td>NO</td>
            <td>EXTERIOR</td>
            <td>SI</td>
            <td>NO</td>
            <td>INTERIOR</td>
            <td>SI</td>
            <td>NO</td>
            <td>BAUL</td>
            <td>SI</td>
            <td>NO</td>
          </tr>
          <?php
  
  pintar_inventario($_REQUEST['idorden'],$id_empresa,$tabla24,$tabla10,$conexion,$tabla25);
  ?>
          </table>
      </div></td>
  </tr>

</table>

</div>
</body>
</html>
<?php
function pintar_inventario($idorden,$id_empresa,$tabla24,$tabla10,$conexion,$tabla25){
$sql_datos_empresa = "select tipo_taller from $tabla10 where id_empresa = '".$_SESSION['id_empresa']."'  ";  
//echo 'br>'.$sql_datos_empresa;
$consulta_empresa = mysql_query($sql_datos_empresa,$conexion);
$datos_empresa = mysql_fetch_assoc($consulta_empresa);
$sql_nombres_items_inventarios = "select * from $tabla24  where decarroomoto = '".$datos_empresa['tipo_taller']."'   and id_empresa = '".$id_empresa."' ";
//echo 'consulta<br>'.$sql_nombres_items_inventarios.'<br>';
$consulta_nombres_items = mysql_query($sql_nombres_items_inventarios,$conexion);
$filas_nombres_items = mysql_num_rows($consulta_nombres_items);
//$nombres2_items = get_table_assoc($consulta_nombres_items);
$filasxcolumna = $filas_nombres_items/4;
$contador = 0;

//for ($i=1;$i<= $filasxcolumna;$i++)
while($nombres = mysql_fetch_assoc($consulta_nombres_items))
{
	 if($contador < $filasxcolumna)
	 {
	    $valor = traer_valor($idorden,$tabla25,$nombres['id_nombre_inventario'],$conexion);
   
	       echo '<tr class ="headt2">';
	       echo '<td>'.$nombres['nombre'].'</td>';
          
         if($valor =='')
         {
            echo '<td></td>';
             echo '<td></td>';
         }
       else
       {
             if($valor =='S')
              {echo '<td>'.$valor.'</td>';
               echo '<td></td>';
              }
             else{
              echo '<td></td>';
              echo '<td>'.$valor.'</td>';
             }
       }
    	  
         //////segunda columna de valores 
         $id_nombre_columna2 = $nombres['id_nombre_inventario'] + $filasxcolumna;
         $nombre =traer_nombre_inventario($id_nombre_columna2,$tabla24,$conexion);
         $valor = traer_valor($idorden,$tabla25,$id_nombre_columna2,$conexion);
          echo '<td>'.$nombre.'</td>';
          
        if($valor =='')
         {
            echo '<td></td>';
             echo '<td></td>';
         }
       else
       {
             if($valor =='S')
              {echo '<td>'.$valor.'</td>';
               echo '<td></td>';
              }
             else{
              echo '<td></td>';
              echo '<td>'.$valor.'</td>';
             }
       }
      
         //////////////////////////fin segunda columande valores
         //////////////////////////inicio tercera columna

         $id_nombre_columna3 = $nombres['id_nombre_inventario'] + ($filasxcolumna*2);
         //echo '<br>'.$id_nombre_columna3;
         $nombre =traer_nombre_inventario($id_nombre_columna3,$tabla24,$conexion);
         $valor = traer_valor($idorden,$tabla25,$id_nombre_columna3,$conexion);
          echo '<td>'.$nombre.'</td>';
      
               if($valor =='')
         {
            echo '<td></td>';
             echo '<td></td>';
         }
       else
       {
             if($valor =='S')
              {echo '<td>'.$valor.'</td>';
               echo '<td></td>';
              }
             else{
              echo '<td></td>';
              echo '<td>'.$valor.'</td>';
             }
       }
      

         ///////////////////////////fin tercera columna
       //////////////////////cuarta columna

         $id_nombre_columna4 = $nombres['id_nombre_inventario'] + ($filasxcolumna*3);
         //echo '<br>'.$id_nombre_columna3;
         $nombre =traer_nombre_inventario($id_nombre_columna4,$tabla24,$conexion);
         $valor = traer_valor($idorden,$tabla25,$id_nombre_columna3,$conexion);
          echo '<td>'.$nombre.'</td>';
      
               if($valor =='')
         {
            echo '<td></td>';
             echo '<td></td>';
         }
       else
       {
             if($valor =='S')
              {echo '<td>'.$valor.'</td>';
               echo '<td></td>';
              }
             else{
              echo '<td></td>';
              echo '<td>'.$valor.'</td>';
             }
       }
      


       /////fin de cuarta columna



         echo '</tr>';
	  } // fin  if($contador < $filasxcolumna)
	  else
	  {  break;} 
 	$contador++;
}//fin de while 

}//fin de funcion pintar inventario
function traer_valor($idorden,$tabla25,$id_inventario,$conexion)
{
  $sql_traer_relacion = "select valor from $tabla25 where id_orden = '".$idorden."' and id_nombre_inventario = '".$id_inventario."'  ";
     $consulta_valor = mysql_query($sql_traer_relacion,$conexion);
     $arreglo_valor = mysql_fetch_assoc($consulta_valor);
     $valor = $arreglo_valor['valor'];
     return $valor;
}//fin de funcin de traer valor 
function traer_nombre_inventario($id_nombre_inventario,$tabla24,$conexion){
   $sql_traer_nombre = "select nombre from $tabla24 where id_nombre_inventario = '".$id_nombre_inventario."'  ";
   //echo'<br>'.$sql_traer_nombre;
   $consulta_nombre = mysql_query($sql_traer_nombre,$conexion);
   $arreglo_nombre = mysql_fetch_assoc($consulta_nombre);
   $nombre = $arreglo_nombre['nombre'];
   return $nombre;
}//fin de funcion traer_nombre_inventario;
?>
<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../js/jquery-2.1.1.js"></script>   

<script language="JavaScript" type="text/JavaScript">
            
			$(document).ready(function(){
               
						//////////////////
			   $("#codigopan").keyup(function(e){
					//$("#cosito").html( $("#nombrepan").val() );
					if (e.which == 13)
					{
							//alert('digito enter');
							var data1 ='codigopan=' + $("#codigopan").val();
							//$.post('buscarelnombre.php',data1,function(b){
							$.post('traer_codigo_descripcion.php',data1,function(b){
							        //  $("#descripan").val() =  descripcion;
									$("#descripan").val(b[0].descripcion);
									$("#valor_unit").val(b[0].valor_unit);
									$("#exispan").val(b[0].existencias);
									$("#cantipan").val('');
									$("#cantipan").focus();
									$("#totalpan").val(0);
							 //(data1);
							},
							'json');
					}// fin del if 		
			   });//finde codigopan
			  
				/////////////////////////////////	
						$("#agregar_item").click(function(){
							var data =  'codigopan =' + $("#codigopan").val();
							data += '&descripan=' + $("#descripan").val();
							data += '&valor_unit=' + $("#valor_unit").val();
							data += '&cantipan=' + $("#cantipan").val();
							data += '&totalpan=' + $("#totalpan").val();
							data += '&exispan=' + $("#exispan").val();
							data += '&orden_numero=' + $("#orden_numero").val();
							$.post('procesar_items.php',data,function(a){
							$("#nuevodiv").html(a);
								//alert(data);
							});	
						 });
				
					///////////////////////////////////
						$('#cantipan').keyup(function(b){
					if (b.which == 13)
					{

				         resultado = '78910';
						 resultado2 = $('#cantipan').val() *  $('#valor_unit').val() ;
						$('#totalpan').val(resultado2);  
					}	
						
					});
					
					/////////////////////////
					$("#actualizar_orden").click(function(){
							var data =  'orden_numero=' + $("#orden_numero").val();
							data += '&clave=' + $("#clave").val();
							data += '&fecha=' + $("#fecha").val();
							data += '&placa=' + $("#placa").val();
							data += '&descripcion=' + $("#descripcion").val();
							data += '&radio=' + $("#radio:checked").val();
							data += '&herramienta=' + $("#herramienta:checked").val();
							data += '&antena=' + $("#antena:checked").val();
							data += '&repuesto=' + $("#repuesto:checked").val();
							data += '&otros=' + $("#otros").val();
							data += '&iva=' + $("#iva").val();
							data += '&kilometraje=' + $("#kilometraje").val();
							data += '&mecanico=' + $("#mecanico").val();
							$.post('actualizar_orden.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#divorden").html(a);
								//alert(data);
							});	
						 });
					////////////////////////
					
			
			});		////finde la funcion principal de script
			
			
			
			
			
</script>

