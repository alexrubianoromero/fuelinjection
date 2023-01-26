<?php
session_start();
function colocar_select_general_1($tabla,$conexion,$campo1,$campo2){
    $sql_general = "select * from $tabla   ";
    //echo '<br>'.$sql_personas;
    $con_general = mysql_query($sql_general,$conexion);
    echo '<option value="" >...</option>';
    while($general  = mysql_fetch_assoc($con_general))
    {
        echo '<option value="'.$general[$campo1].'" >'.$general [$campo2].'</option>';
    }
}

?>
<!DOCTYPE html><head>
<meta charset="UTF-8"/>
    <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/style.css">
<script src="../js/jquery.js" type="text/javascript"></script>
	<meta name='viewport' content='width=device-width initial-scale=1'>
<meta name='mobile-web-app-capable' content='yes'>
<link rel='stylesheet' href='../css/bootstrap.min.css'>
<script src='../js/bootstrap.min.js'></script>

<title>Untitled Document</title>
<style>
#div_fecha{
	font-size: 20px;
	border:1px solid black;
}
</style>
</head>
<?php
include('../valotablapc.php');

$sql_iva = "select iva from $tabla17 ";
$consulta_iva = mysql_query($sql_iva,$conexion);
$arr_iva = mysql_fetch_assoc($consulta_iva);
$iva = $arr_iva['iva'];
$sql_numero_cotizacion ="select cot.id_cotizacion,cot.no_cotizacion,
cot.kilometraje, cot.fecha, cot.observaciones,
cli.identi,cli.direccion,cli.nombre,cli.email,cli.telefono,c.color,c.marca,c.placa,c.modelo 
from $cotizaciones cot
inner join $tabla4 c on (c.idcarro = cot.idcarro)
inner join $tabla3 cli on (cli.idcliente = c.propietario)
where 
id_cotizacion = '".$_REQUEST['id_cotizacion']."'  ";
$consulta_cotizacion = mysql_query($sql_numero_cotizacion,$conexion);
$arr_cot = mysql_fetch_assoc($consulta_cotizacion);
$ancho_tabla= "90%";
?>
<body>
<div class="container">
<div id = "datos_cotizacion"  align="center">
<div id="div_fecha">
  NO Cotizacion :<?php echo $arr_cot['no_cotizacion']; ?> FECHA: <?php echo $arr_cot['fecha']; ?> 
    	<input type="hidden" id="id_cotizacion" name = "id_cotizacion" value ="<?php echo  $_REQUEST['id_cotizacion']; ?>" >
</div>
<table width="<?php echo $ancho_tabla ?>" border="0">
  <tr>
    <td>Empresa</td>
    <td><?php  echo $arr_cot['nombre']  ?></td>
	  <td>ID</td>
      <td colspan="3"><label><?php  echo $arr_cot['identi']  ?>
      </label></td>
	</tr>
	 <tr>
    <td>Direccion</td>
    <td><label><?php  echo $arr_cot['direccion']  ?></label></td>
	  <td>Telefono</td>
	    <td><?php  echo $arr_cot['telefono']  ?></td>
	    <td>Marca</td>
	    <td><?php  echo $arr_cot['marca']  ?></td>
    </tr>
	 <tr>
	   <td>Nombre</td>
	   <td><?php echo $arr_cot['nombre']; ?></td>
	   <td>Kilome</td>
	   <td><input type="text" name="kilometraje" id="kilometraje" value ="<?php echo $arr_cot['kilometraje']   ?>" class="fila_llenar"></td>
	   <td>Modelo</td>
	   <td><?php  echo $arr_cot['modelo']  ?></td>
	 </tr>
	 <tr>
	   <td>Mail</td>
	   <td><?php echo $arr_cot['email']; ?></td>
	   <td>Color</td>
	   <td><?php echo $arr_cot['color']; ?></td>
	   <td>Placas</td>
	   <td><?php  echo $arr_cot['placa']  ?><input type="hidden" name="idcarro" id="idcarro" ></td>
  </tr>
  </table>
  <br>
    <div id="div_observaciones">
        <textarea cols="80%" rows="3" placeholder = "observaciones" class="fila_llenar" id="observaciones"><?php  echo $arr_cot['observaciones']  ?></textarea>

    </div> 
<div id="div_encabezado_items">
	<table width="<?php echo $ancho_tabla ?>" border="1">
		<tr>
			<td>ITEM</td>
			<td> R/M</td>
			<td>Codigo</td>
			<td>Descripcion</td>
			<td>Valor</td>
			<td>Cantidad</td>
			<!--<td>Total Item</td>-->
			<td>ACCION</td>
		</tr>
		<tr>
			<td>ITEM</td>
			<td><select id ="repman" class="fila_llenar">
		     <?php
                colocar_select_general_1($tipo_codigo_inventario,$conexion,'letra_identificacion','nombre_tipo');
            ?>
			</select>
			</td>
			<td><input type="text" id="codigopan" name = "codigopan" class="fila_llenar" placeholder="CODIGO Y ENTER"></td>
			<td><input type="text" id="descripan"  id="descripan" class="fila_llenar"></td>
			<td><input type="text" id="valor_unit"  name="valor_unit"class="fila_llenar"></td>
			<td><input type="text" id="cantipan" id="cantipan" class="fila_llenar" placeholder="CANTIDAD Y ENTER"></td>
			<!--<td><input type="text" id="totalpan" id="totalpan" onfocus="blur();"></td>-->
			<td><button type = "button" id = "agregar_item">Agregar</button></td>
		
		</tr>	
	</table>
	<div id="div_items">
		<?php
        include('mostrar_items.php');

		mostrar_items($_REQUEST['id_cotizacion']);
?>
	</div>

<div id="finalizar" align="center">
		<br>
		
		<button id="btn_autorizar_cotizacion" class="btn btn-success">CONVERTIR EN  ORDEN  DE TRABAJO</button>
		
		<button id="finalizar_cotizacion" class="btn btn-info">ACTUALIZAR COTIZACION</button>
	</div>	

	
 </div>

</div>  <!--container-->
</div>
</body>
</html>

<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../jquery-2.1.1.js"></script>  
<script src="jquery-2.1.1.js"></script>   

<script>
  $(document).ready(function(){
        
		
		//////////////////
			   $("#placa").keyup(function(e){
					//$("#cosito").html( $("#nombrepan").val() );
					if (e.which == 13)
					{
							var data1 ='placa=' + $("#placa").val();
							//$.post('buscarelnombre.php',data1,function(b){
							$.post('traer_datos_placa.php',data1,function(b){
							        //  $("#descripan").val() =  descripcion;
									$("#tipo").val(b[0].tipo);
									$("#identi").val(b[0].identi);
									$("#nombre").val(b[0].nombre);
									$("#marca").val(b[0].marca);
									$("#modelo").val(b[0].modelo);
									$("#color").val(b[0].color);
									$("#direccion").val(b[0].direccion);
									$("#telefono").val(b[0].telefono);
									$("#email").val(b[0].email);
									$("#idcarro").val(b[0].idcarro);
									$("#idcliente").val(b[0].idcliente);
									$("#empresa").val(b[0].nombre);


							 //(data1);
							},
							'json');
						$("#btn_crear_cotizacion").css("display","block");	

						
					}// fin del if 		
			   });//finde placapan
			  
			/////////////////////////////////
			
				$("#btn_crear_cotizacion").click(function(event) {
					//alert("asdasda");
						   var id_empresa = sessionStorage.getItem("id_empresa") ;
                         var id_usuario = sessionStorage.getItem("id_usuario") ;

						var data ='no_cotizacion=' + $("#no_cotizacion").val();
						data += '&idcarro=' + $("#idcarro").val();
						data += '&fecha=' + $("#fecha").val();
						data += '&id_empresa=' + id_empresa;


							$.post('grabar_encabezado_cotizacion.php',data,function(b){
							//$(window).attr('location', '../index.php);
							$("#div_items").html(b);
							$("#id_cotizacion").val(b[0].id_cotizacion);
							
								//alert(data);
							},
							'json');
					$("#btn_crear_cotizacion").css("display","none");	
					$("#div_encabezado_items").css("display","block");	
		
				

				});
			
			/////////////////////////////////
		
    $("#concepto").change(function(event){
            var id = $("#concepto").find(':selected').val();
            $("#producto1").load('genera-select.php?id='+id);
            $("#producto2").load('genera-select.php?id='+id);
            $("#producto3").load('genera-select.php?id='+id);
        });
    /*
    $("#select2").change(function(event){
            var id = $("#select2").find(':selected').val();
            $("#select3").load('genera-select2.php?id='+id);
        });
       */ 
    ///////////////////////////
	///////////////////////////////////
				
					$("#casilla_empresa").click(function(event) {
							    if($(this).is(":checked")) 
								{ 
										 $("#buscarcliente").load('pregunte_datos_nuevo_carro.php');
										//alert('Se hizo check en el checkbox.');
							  	} else {
										//alert('Se destildo el checkbox');
										$("#buscarcliente").html('');
							  }	  
					  });
					  //////////////////////////
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
									$("#valor_unit").focus();
									$("#cantipan").val('');
									//$("#cantipan").focus();
									$("#totalpan").val(0);
							 //(data1);
							},
							'json');
					}// fin del if 		
			   });//finde codigopan
			  //////////////////////////////////
			  	//////////////////////////////////
					$('#cantipan').keyup(function(b){
					if (b.which == 13)
					{

				         resultado = '78910';
						 resultado2 = $('#cantipan').val() *  $('#valor_unit').val() ;
						$('#totalpan').val(resultado2);  
					}	
						
					});
					
					/////////////////////////
	/////////////////////////
	/////////////////////////////////	
						$("#agregar_item").click(function(){
							  if($("#repman").val().length < 1)
                                { alert('digite valor tipo de item ');
                              $(repman).focus();
                                  return false;
                                 }
                                   if($("#descripan").val().length < 1)
                                { alert('digite descripcion del item ');
                              $(descripan).focus();
                                  return false;
                                 }

                                 
                                 if($("#valor_unit").val().length < 1)
                                { alert('digite valor unitario ');
                              $(valor_unit).focus();
                                  return false;
                                 }

                                if($("#cantipan").val().length < 1)
                                { alert('digite cantidad ');
                              $(cantipan).focus();
                                  return false;
                                 }

                            var id_empresa = sessionStorage.getItem("id_empresa") ;
                            var id_usuario = sessionStorage.getItem("id_usuario") ;

                            var total_item = $("#valor_unit").val() * $("#cantipan").val();    
							var data =  'codigopan =' + $("#codigopan").val();
							data += '&descripan=' + $("#descripan").val();
							data += '&valor_unit=' + $("#valor_unit").val();
							data += '&cantipan=' + $("#cantipan").val();
							//data += '&totalpan=' + $("#totalpan").val();
                            data += '&totalpan=' + total_item;
							data += '&id_cotizacion=' + $("#id_cotizacion").val();
							data += '&repman=' + $("#repman").val();
							data += '&id_empresa=' + id_empresa;
							data += '&id_usuario=' + id_usuario;



							$.post('procesar_items.php',data,function(a){
							$("#div_items").html(a);
								//alert(data);
							});	
						 });
	////////////////////////
			$('#cantipan').keyup(function(b){
					if (b.which == 13)
					{

				         resultado = '78910';
						 resultado2 = $('#cantipan').val() *  $('#valor_unit').val() ;
						$('#totalpan').val(resultado2);  
					}	
						
					});
					
	///////////////////////
	
	///////////////////
		$(".eliminar").click(function(){
							var data =  'eliminar=' + $(this).attr('value');
							$.post('eliminar_items_cotizacion.php',data,function(a){
							$("#div_items").html(a);
								//alert(data);
							});	

						 });

	//////////////////
		$("#finalizar_cotizacion").click(function(){

					

					 var id_empresa = sessionStorage.getItem("id_empresa") ;
                       var id_usuario = sessionStorage.getItem("id_usuario") ;


					var data =  'id_cotizacion=' + $("#id_cotizacion").val();
						data += '&kilometraje=' + $("#kilometraje").val();
						data += '&observaciones=' + $("#observaciones").val();
						data += '&id_empresa=' + id_empresa;

							$.post('modif_cotizacion.php',data,function(a){
							//$("#datos_cotizacion").html(a);
								//alert(data);
							});	


					/*		
					var data =  'id_cotizacion=' + $("#id_cotizacion").val();
						data += '&kilometraje=' + $("#kilometraje").val();
						*/
							$.post('../cotizaciones/consulta_cotizaciones_general.php',data,function(a){
							$("#datos_cotizacion").html(a);
								//alert(data);
							});		


		});

	//////////////////////
	$("#btn_autorizar_cotizacion").click(function(){
					var id_empresa = sessionStorage.getItem("id_empresa") ;
                  var id_usuario = sessionStorage.getItem("id_usuario") ;

					var data =  'id_cotizacion=' + $("#id_cotizacion").val();
					data += '&id_empresa=' + '11';
					data += '&id_usuario=' + id_usuario;

						

							$.post('../cotizaciones/crear_orden_cotizacion.php',data,function(a){
							$("#datos_cotizacion").html(a);
								//alert(data);
							});	


					/*		
					var data =  'id_cotizacion=' + $("#id_cotizacion").val();
						data += '&kilometraje=' + $("#kilometraje").val();
						*/
						
							$.post('../cotizaciones/consulta_cotizaciones_general.php',data,function(a){
							$("#datos_cotizacion").html(a);
								//alert(data);
							});	
									 
		});

	//////////////////////////////
    });
</script>


