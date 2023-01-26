<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>orde captura</title>
    <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/style.css">
<script src="./js/jquery.js" type="text/javascript"></script>
<style>
   
</style>
</head>
<body>
<?php


/*
echo '<pre>';
print_r($_GET);
echo '</pre>';
exit();
*/




include('../valotablapc.php');  
include('../funciones.php'); 
$ancho_tabla = "90%";
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
 where o.id = '".$_GET['idorden']."'   and   o.id_empresa = '".$_SESSION['id_empresa']."'  and o.estado = '0' ";
 
 //echo '<br>'.$sql_placas;
$datos = mysql_query($sql_placas,$conexion);
$filas = mysql_num_rows($datos); 
if ($filas == 0 ) {echo '<BR><BR>ESTA ORDEN NO SE PUEDE MODIFICAR';}
//echo '<br>filas =='.$filas;

 $datos = get_table_assoc($datos); 


$sql_items_orden = "select * from $tabla15 where no_factura = '".$_GET['idorden']."' order by id_item ";
$consulta_items = mysql_query($sql_items_orden,$conexion);
$factupan = $_REQUEST['idorden'];

$sql_tecnicos  = "select * from $tabla21   where id_empresa = '".$_SESSION['id_empresa']."' ";
$consulta_tecnicos = mysql_query($sql_tecnicos,$conexion);

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
<div id = "divorden">
  <form action="" method="post">
    <table border = "1">
      <tr>
        <td colspan="2" rowspan="4"><div align="center"><img src = "../logos/fuelinjection.png"  width="200px" height="100px"></div></td>
        <td colspan="2"><h3>ORDEN DE TRABAJO</h3></td>
        <td >
                 <input name="orden" id = "orden" type="text" size="20" value = "<? echo $datos[0]['orden']  ?>"  >
                <input name="orden_numero" id = "orden_numero"  type="hidden" size="20" value = "<? echo $_REQUEST['idorden']  ?>"  >
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
	  <td><input name="mecanico"   id = "mecanico"  type="text" size="20" 
      value = "<? echo $nombre_mecanico  ?>" ></td></tr>
      </tr>
       <tr><td>&nbsp;</td><td>&nbsp;</td><td align="right" colspan= "2">&nbsp;CAMBIAR OPERARIO
       </td>
      <td>
  

                <select id = "nuevo_mecanico" name = "nuevo_mecanico" class="fila_llenar" >
            <option value ="">Escoger Operario</option>
            <?php
                while($tecnicos = mysql_fetch_assoc($consulta_tecnicos))
                {
                     echo '<option value ="'.$tecnicos['idcliente'].'">'.$tecnicos['nombre'].'</option>';
                }
            ?>
              </select>
     

</td></tr>
      </tr>

      <tr>
        <td colspan="11"><div align="center">TRABAJO A REALIZAR </div></td>
      </tr>
      <tr>
        <td height="80" colspan="11"><label>
          <textarea class="fila_llenar" name="descripcion"  id = "descripcion" cols="90" rows="4"> <?php  echo $datos[0]['observaciones']?>
    </textarea>
        </label></td>
      </tr>
    
	  
  
  
  <br>
	  <table width="679" border = "1">
      <tr>
        <td colspan="11"><div align="center">PARTES Y RESPUESTOS </div></td>
      </tr>
      <tr>
   
    <td><div align="center">COD </div></td>
    <td><div align="center">DESCRIPCION</div></td>
     
    <td><div align="center">VR Unit </div></td>
    <td><div align="center">MECANICO</div></td>
    <td><div align="center">VR Mecanico </div></td>
    <td>EXIS</td>
    <td>CANT.</td>
    <td>TOTAL</td>
    <td><div align="center"></div></td>
  </tr>

  <tr>
  
    <td><label>
      <input name="codigopan" type="text" id = "codigopan" size="5px" class="fila_llenar"/>
    </label></td>
    <td><input type="text" name="descripan" id = "descripan" size="15px"  class="fila_llenar" />
    <div id = "descripcion"></div></td>
    
    <td><input type="text" name="valor_unit" id = "valor_unit" size = "7px" class="fila_llenar" /></td>
    <td><select id = "id_mecanico_item" class="fila_llenar">
        <?php
            select_listar_mecanicos($tabla21,$conexion);
        ?>

        </select>
    </td>
    <td width="82"><input type="text" name="valor_mecanico" id = "valor_mecanico" size = "7px" class="fila_llenar" /></td>
    <td width="87"><input name="exispan" type="text" id = "exispan" size = "7px" onfocus="blur();" /></td>
    <td width="85"><input name="cantipan" type="text" id = "cantipan"  size = "7px" class="fila_llenar" /></td>
    <td width="77"><input name="totalpan" type="text" id = "totalpan" size = "7px" onfocus="blur();"  /></td>
    <td width="75"><button type = "button" id = "agregar_item">Agregar</button></td>
  </tr>
    </table>
  
		  <div id = "nuevodiv">
				 <?php 
				  include('mostrar_items.php');
				  mostrar_items($factupan);
				?>
		 </div>
		 <br>
  </table>
  <table border = "1">
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
        <td><label><?  if ($datos[0]['repuesto']=="1"){echo '<input name = "repuesto" id="repuesto"  type="checkbox" checked value = "1" >';} else {echo '<input  name = "repuesto" id="repuesto"  type="checkbox" unchecked value = "1" >';}  ?>
		  
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
      <tr>
        <td colspan="7"><button type ="button"  id = "actualizar_orden" ><h4>ACTUALIZAR_ORDEN</h4></button></td>
      </tr>
    </table>
  </form>

 <h2><a href="../menu_principal.php">Menu Principal</a> <h2>
  
 <a href="index.php">Menu Ordenes</a> 
</div>
</body>
</html>
<?php
function select_listar_mecanicos($tabla,$conexion){
  $sql_estados = "select * from $tabla   ";
  //echo '<br>'.$sql_personas;
  $con_estados = mysql_query($sql_estados,$conexion);
  echo '<option value="" >...</option>';
  while($estados = mysql_fetch_assoc($con_estados))
  {
    echo '<option value="'.$estados['idcliente'].'" >'.$estados['nombre'].'</option>';
  }
}

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
              data += '&valor_mecanico=' + $("#valor_mecanico").val();
              data += '&id_mecanico_item=' + $("#id_mecanico_item").val();

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
              data += '&nuevo_mecanico=' + $("#nuevo_mecanico").val();

							$.post('actualizar_orden.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#divorden").html(a);
								//alert(data);
							});	
						 });
					////////////////////////
            $(".eliminar").click(function(){
              
              var data =  'eliminar =' + $(this).attr('value');
                data += '&idorden=' + $("#orden_numero").val();
              $.post('eliminar_items.php',data,function(a){
                $("#nuevodiv").html(a);
                //alert(data);
              }); 
             });

          ////////////////////////



          ////////////////////////////
					
			
			});		////finde la funcion principal de script
			
			
			
			
			
</script>

