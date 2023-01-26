<?php
date_default_timezone_set('America/Bogota');
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
<style type="text/css">

.style1 {color: #FF8080}
  .par {
    background: #F2F2F2;
  }
.btn-radio{
  width:20px;
  height: 20px;
  margin:5px;
  padding: 5px;
}

</style>
</head>
<body>
<span class="style1">
<?php

/*

echo '<pre>';
print_r($_GET);
echo '</pre>';
exit();
*/




include('../valotablapc.php');  
include('../funciones.php'); 

$sql_datos_empresa = "select ruta_imagen,nombre,tipo_taller,identi,telefonos,direccion from $tabla10 where id_empresa = '".$_SESSION['id_empresa']."'  ";  
$consulta_empresa = mysql_query($sql_datos_empresa,$conexion);
$datos_empresa = mysql_fetch_assoc($consulta_empresa);
if($datos_empresa['tipo_taller'] == '1') // OSEA SI ES TALLER DE VEHICULOS
      { $palabra_inventario1  = 'RADIO' ; 
	  $palabra_inventario2  = 'ANTENA' ; 
	  $palabra_inventario3  = 'REPUESTO' ; 
	  } 
else  { $palabra_inventario1  = 'CASCO' ; 
	  $palabra_inventario2  = 'MALETERO' ; 
	  $palabra_inventario3  = 'TANK BAG' ; } 

$sql_tecnicos  = "select * from $tabla21   where id_empresa = '".$_SESSION['id_empresa']."' ";
$consulta_tecnicos = mysql_query($sql_tecnicos,$conexion);
//$arr_tecnicos = mysql_fetch_assoc($consulta_tecnicos);
//$sql_numero_factura = "select * from $tabla14  ";
//$consulta_facturas = mysql_query($sql_numero_factura,$conexion);
//$filas = mysql_num_rows($consulta_facturas);
//echo 'filas ='.$filas;
//if ($filas == 0)
	//	{       $ordenpan = '1'; 
				//echo 'no hay valores en tabla factura';
	//	}
	//else  
	//	{ //echo 'si hay valores ';
/*
		     $sql_maxima_remision  = "select max(id) as maximo from $tabla14 where id_empresa = '".$_SESSION['id_empresa']."'  ";
			   $maximoid = mysql_query($sql_maxima_remision,$conexion);
			   $maximoid = mysql_fetch_assoc($maximoid);
*/
         $sql_maxima_remision  = "select contaor from $tabla10  where id_empresa = '".$_SESSION['id_empresa']."'  ";
         $maximoid = mysql_query($sql_maxima_remision,$conexion);
         $maximoid = mysql_fetch_assoc($maximoid);
			   	/*
				echo '<pre>';
				print_r($maximoid);
				echo '</pre>';
				echo '<br>muestre maximo'.$maximoid['contaor'];
				exit();
        */
        
				$ordenpan = $maximoid['contaor'] + 1 ;  

        //echo '<br>'.$ordenpan;
     

			   
		//}	
//exit();

$sql_placas = "select nombre,identi,direccion,telefono,placa,marca,modelo,color,tipo,car.vencisoat,car.revision,car.idcarro  from $tabla4 as car
inner join $tabla3 as cli on (cli.idcliente = car.propietario)
 where car.placa = '".$_GET['placa123']."' 
  and cli.id_empresa = '".$_SESSION['id_empresa']."'
 ";
 
 //echo '<br>'.$sql_placas;
$datos = mysql_query($sql_placas,$conexion);
$datos = get_table_assoc($datos);
/*
echo '<pre>';
print_r($datos);
echo '</pre>';
exit();
*/


$fechapan =  time();
///////////////////verificar las fechas de vencimiento de soat y obligatorio si no estan vencidos 
$fecha_actual  = date ( "Y-m-j" , $fechapan );
$otra_soat = $datos[0]['vencisoat'];
$fecha_tecno  = $datos[0]['revision'];

$aviso_soat =  cualesmayor($fecha_actual,$otra_soat);
$aviso_tecno =  cualesmayor($fecha_actual,$fecha_tecno);

function cualesmayor($fecha1,$fecha2)
	{	
		$fecha1 = strtotime($fecha1);
		$fecha2= strtotime($fecha2);
		if($fecha1 > $fecha2){ $aviso = 'ya esta vencido';}
		if($fecha1 < $fecha2){ $aviso = 'VIGENTE';}
		return $aviso;
	}



function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
// echo dias_transcurridos($otra_fecha,$fecha_actual);




///////////////////////////////////////////////////////////////////////////////////////////////
include('../colocar_links2.php');
?>
</span>
<div id = "divorden">
<form name = "capturaordenonda" method = "post"  action ="grabar_orden.php">
    <table border = "1" width = "95%">
      <tr>
        <td colspan="2" rowspan="4"></td>
        <td colspan="2"><h3>ORDEN DE TRABAJO</h3></td>
        <td><input name="orden_numero" id = "orden_numero" type="text" size="20" value = "<? echo $ordenpan  ?>"  ></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">Nit. <?php  echo $datos_empresa['identi'] ?> </div></td>
        <td>CLAVE</td>
      </tr>
      <tr>
        <td colspan="2"><div align="center">Tels<?php  echo $datos_empresa['telefonos'] ?></div></td>
        <td><input name="clave" id = "clave" type="text" size="20" ></td>
      </tr>
      <tr>
        <td colspan="2"><div align="center"><?php  echo $datos_empresa['direccion'] ?> </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="85">FECHA</td>
        <td colspan="2"><input size=10 name=fecha id = "fecha"  value= <? echo date ( "Y/m/j" , $fechapan );?>></td>
        <td width="172">MARCA</td>
        <td width="295"><input name="marca" id = "marca" type="text"  value = "<? echo $datos[0]['marca']  ?>"></td>
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
        <td><input name="placa" id = "placa" type="text" size="10" value = "<? echo $datos[0]['placa']  ?>"  >
		<input name="idcarro" id = "idcarro" type="hidden" size="10" value = "<? echo $datos[0]['idcarro']  ?>"  >
		</td>
      </tr>
      <tr>
        <td>TELEFONO</td>
        <td colspan="2"><input name="telefono" type="text" size="40" value = "<? echo $datos[0]['telefono']  ?>"></td>
        <td>COLOR</td>
        <td><input name="color" type="text" size="20" value = "<? echo $datos[0]['color']  ?>" ></td>
      </tr>
      <tr>
        <td>FECHA VENCIMIENTO SOAT </td>
        <td colspan="2"><input name="vencisoat" id = "vencisoat" type="date" size="20"  value = "<?php  echo $datos[0]['vencisoat']  ?>" class="fila_llenar"  ><?php echo $aviso_soat; ?></td>
        <td>KILOMETRAJE ACTUAL </td>
        <td><input name="kilometraje" id = "kilometraje" type="text" size="20" class="fila_llenar"></td>
      </tr>
      <tr>
        <td>FECHA VENCI TECNOMECANICA </td>
        <td colspan="2"><input name="vencitecno" id = "vencitecno" type="date" size="20"  value = "<?php  echo $datos[0]['revision']  ?>"  class="fila_llenar" ><?php echo $aviso_tecno; ?></td>
        <td>KILOMETRAJE CAMBIO </td>
        <td><input name="kilometraje_cambio" id = "kilometraje_cambio" type="text" size="20" class="fila_llenar" ></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>OPERARIO</td>
        <td>
<select id = "mecanico" name = "mecanico" class="fila_llenar" >
    <option value ="">Escoger Operario</option>
    <?php
        while($tecnicos = mysql_fetch_assoc($consulta_tecnicos))
        {
             echo '<option value ="'.$tecnicos['idcliente'].'">'.$tecnicos['nombre'].'</option>';
        }
    ?>
</select>  <!--
          <input name="mecanico" id = "mecanico" type="text" size="50"  class="fila_llenar" >
          -->
          </td>
      </tr>
    </table>
	 <br>
	 <table border = "1" width = "95%">
      <tr>
        <td colspan="11"><div align="center">TRABAJO A REALIZAR </div></td>
      </tr>
      <tr>
        <td height="134" colspan="11"><label>
          <textarea name="descripcion"  id = "descripcion" cols="120" rows="7"  class="fila_llenar" ></textarea>
        </label></td>
      </tr>
    </table>
	  <br>
	  
    <table width="679" border = "1">
      <tr>
        <td colspan="11"><div align="center">PARTES Y RESPUESTOS </div></td>
      </tr>
      <tr>
    <td><div align="center">ITEM</div></td>
    <td><div align="center">COD </div></td>
    <td><div align="center">DESCRIPCION</div></td>
    <td><div align="center">VR Unit </div></td>
    <td>EXIS</td>
    <td>CANT.</td>
    <td>TOTAL</td>
    <td><div align="center"></div></td>
  </tr>
  <tr>
    <td width="34">&nbsp;</td>
    <td width="38"><label>
      <input name="codigopan" type="text" id = "codigopan" size="5" />
    </label></td>
    <td width="149"><input type="text" name="descripan" id = "descripan" />
    <div id = "descripcion"></div></td>
    <td width="82"><input type="text" name="valor_unit" id = "valor_unit" size = "10" /></td>
    <td width="87"><input name="exispan" type="text" id = "exispan" size="10" /></td>
    <td width="85"><input name="cantipan" type="text" id = "cantipan"  size ="10"/></td>
    <td width="77"><input name="totalpan" type="text" id = "totalpan" size="15" /></td>
    <td width="75"><button type = "button" id = "agregar_item">Agregar</button></td>
  </tr>
    </table>
    

      <div id = "nuevodiv"></div>
	  <br>
	  <br>
	  <table border = 1>
      <tr>
        <td colspan="7"><div align="center">INVENTARIO</div></td>
      </tr>
      <tr>
        <td width="85"><label  for= "radio" ><?php echo $palabra_inventario1; ?></label></td>
        <td width="146"><input type="checkbox" name="radio" id="radio" value="1"></td>
        <td width="201"><label for ="herramienta"> HERRAMIENTA</label></td>
        <td colspan="4"><label>
          <input type="checkbox" name="herramienta" id = "herramienta" value="1">
        </label></td>
        </tr>
      <tr>
        <td><label  for = "antena"><?php echo $palabra_inventario2; ?></label></td>
        <td><label>
          <input type="checkbox" name="antena"  id = "antena" value="1">
        </label></td>
        <td colspan="5" rowspan="2">OTROS
          <label>
            <textarea name="otros" id = "otros" cols="50" rows="3"></textarea>
          </label></td>
      </tr>
      <tr>
        <td><label for="repuesto"  ><?php echo $palabra_inventario3; ?></label></td>
        <td><label>
          <input type="checkbox" name="repuesto"  id = "repuesto" value="1">
        </label></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="36">&nbsp;</td>
        <td width="3">&nbsp;</td>
        <td width="3">&nbsp;</td>
        <td width="117">&nbsp;</td>
      </tr>
        <td colspan="7">&nbsp;</td>
      </tr>
    </table>
		</table>
    <br>
<div id="gasolina">
  NIVEL DE GASOLINA  <select id="nivel_gasolina" name ="nivel_gasolina"  class="fila_llenar">
  <option value = "" >Escojer Nivel Gasolina </option>
  <option value = "0" >VACIO </option>
  <option value = "1" >1/4 </option>
  <option value = "2" >1/2 </option>
  <option value = "3" >3/4 </option>
  <option value = "4" >LLENO </option>
</select>
 </div> 
 <br>
    <div id="inventario_vehiculo">

  <?php
  /////////////////////////////////////////inventario/////////////////////////// comienxzo inventario 
  $sql_datos_empresa = "select ruta_imagen,nombre,tipo_taller,identi,telefonos,direccion from $tabla10 where id_empresa = '".$_SESSION['id_empresa']."'  ";  
$consulta_empresa = mysql_query($sql_datos_empresa,$conexion);
$datos_empresa = mysql_fetch_assoc($consulta_empresa);



    $sql_traer_nombres_inventario = "select * from  $tabla24  where decarroomoto='".$datos_empresa['tipo_taller']."' order by ordenacion ";
    //echo '<br>'.$sql_traer_nombres_inventario;
    $consulta_nombres_inventario = mysql_query($sql_traer_nombres_inventario,$conexion);
    $filas_inventario = mysql_num_rows($consulta_nombres_inventario);
    $items_por_columna = $filas_inventario/2;
    $fila=1;

    echo '<table border="1" >';
      echo '<tr>';
      echo '<td>COMPONENTE</td>';
      echo '<td>S</td>';
      echo '<td>N</td>';
   
  
      echo '<tr>';

    //while($nombres = mysql_fetch_assoc($consulta_nombres_inventario))
    while($nombres = mysql_fetch_assoc($consulta_nombres_inventario))
    {
       
        $resul = ($fila%2);
        if(($fila%2)==1)
         {echo '<tr class="par">';}
      
        //echo '<td>'.$resul.'</td>';
        echo '<td>'.$nombres['nombre'].'</td>';
        echo '<td><input type="radio" <input type="radio" name="'.$nombres['id_nombre_inventario'].'" value="S"  class="btn-radio" /></td>';
        echo '<td><input type="radio" <input type="radio" name="'.$nombres['id_nombre_inventario'].'" value="N"  class="btn-radio" /></td>';
        //echo '<td><input type="radio" <input type="radio" name="'.$nombres['id_nombre_inventario'].'" value="M"  class="btn-radio" /></td>';
       //echo '<td><input type="text" name ="obse_'.$nombres['id_nombre_inventario'].'" size="10px"></td>';
        


        ///////////////fin de la fila 
        echo '<tr>';
       
        $fila++;

    }//fin de while while($nombres = mysql_fetch_assoc($consulta_nombres_inventario))
    echo '</table>';
    //////////////////////////////////////////////////////////////////////////fin de inventario
   ?>
    </div>
	<table width="75%" border="1">
	<h1>
	<!-- <input name="enviar_informacion " type="submit"  value = "ENVIAR_INFORMACION"  > -->
	<input type="button" value="ENVIAR" onClick="valida_envia()" size ="75%"></h1>
	</table>
  </form>
</div>
</body>
</html>
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
							$.post('procesar_items_temporal.php',data,function(a){
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
					$("#grabar_orden").click(function(){
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
							data += '&kilometraje=' + $("#kilometraje").val();
							data += '&mecanico=' + $("#mecanico").val();
							data += '&kilometraje_cambio=' + $("#kilometraje_cambio").val();
							$.post('grabar_orden.php',data,function(a){
							//$(window).attr('location', '../index.php);
							$("#divorden").html(a);
								//alert(data);
							});	
						 });
					////////////////////////
					
			
			});		////finde la funcion principal de script
			
			
			
			
			
</script>
<script>
function valida_envia(){ 
	//valido fecha de entrega 
   /*
   	if (document.capturaordenonda.fecha_entrega.value.length==0){ 
      	alert("Tiene que escribir fecha entrega") 
      	document.capturaordenonda.fecha_entrega.focus() 
      	return 0; 
   	} 
*/
   	//valido el nombre 
   	if (document.capturaordenonda.kilometraje.value.length==0){ 
      	alert("Tiene que escribir kilometraje") 
      	document.capturaordenonda.kilometraje.focus() 
      	return 0; 
   	} 
		//valido el nombre 
    
   	if (document.capturaordenonda.mecanico.value.length==0){ 
      	alert("Tiene que seleccionar mecanico") 
      	document.capturaordenonda.mecanico.focus() 
      	return 0; 
   	} 
    
		//valido el gasolina 
		
   	if (document.capturaordenonda.nivel_gasolina.value.length==0){ 
      	alert("Tiene que seleccionar nivel de  gasolina") 
      	document.capturaordenonda.nivel_gasolina.focus() 
      	return 0; 
   	} 
	
  if (document.capturaordenonda.vencisoat.value.length==0){ 
        alert("Tiene que indicar la fecha de vencimiento de soat") 
        document.capturaordenonda.vencisoat.focus() 
        return 0; 
    } 
    if (document.capturaordenonda.vencitecno.value.length==0){ 
        alert("Tiene que indicar la fecha de vencimiento de tecnomecanica") 
        document.capturaordenonda.vencitecno.focus() 
        return 0; 
    } 
if (document.capturaordenonda.descripcion.value.length==0){ 
        alert("Tiene que indicar la descripcion del trabajo a realizar") 
        document.capturaordenonda.descripcion.focus() 
        return 0; 
    } 


   	////////////////////////////el formulario se envia 
   	alert("Muchas gracias por enviar el formulario"); 
   	document.capturaordenonda.submit(); 
	
	
}
</script>


