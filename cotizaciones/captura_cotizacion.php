<?php
session_start();
/*
echo '<pre>';
print_r($_REQUEST);
echo '</pre>';
*/
include('../valotablapc.php');
if($_SESSION['id_empresa']=='')
{
         include('../sesion_caducada.php');
}	
else
{	



  $sql_numero_cotizacion ="select contador_cotizaciones from $tabla10 ";
$consulta_cot = mysql_query($sql_numero_cotizacion,$conexion);
$arreglo_contador=mysql_fetch_assoc($consulta_cot);
$numero_cot = $arreglo_contador['contador_cotizaciones'] +1;

////////////




  function  consulta_assoc_coti12($tabla,$campo,$parametro,$conexion)
  {
       $sql="select * from $tabla  where ".$campo." = '".$parametro."' ";
       //echo '<br>'.$sql;
       $con = mysql_query($sql,$conexion);
       $arr_con = mysql_fetch_assoc($con);
      
       return $arr_con;
  }
  
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



 if($_REQUEST['placa_buscar'] =='') 
 {
 	echo 'POR FAVOR DIGITE UNA PLACA PARA CREAR LA COTIZACION ';
 }
 else{
 	$sql_buscar_placa = "select * from $tabla4 where placa = '".$_REQUEST['placa_buscar']."'  "; 
    //echo '<br>'.$sql_buscar_placa;
 	$con_placa = mysql_query($sql_buscar_placa,$conexion);
 	$filas_placa = mysql_num_rows($con_placa);
 	if($filas_placa < 1)
 	{echo 'PLACA NO EXISTE';}
 	else	
 	{
 	$datos_moto = consulta_assoc_coti12($tabla4,'placa',$_REQUEST['placa_buscar'],$conexion);
 	$datos_propietario = consulta_assoc_coti12($tabla3,'idcliente',$datos_moto['propietario'],$conexion);
    $idcarro = $datos_moto['idcarro'];
    $fechapan =  time();
    $fechapan = date ( "Y/m/j" , $fechapan );
    
$columnas = '3';
?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>Document</title>

	<meta name='viewport' content='width=device-width initial-scale=1'>
<meta name='mobile-web-app-capable' content='yes'>
<link rel='stylesheet' href='../css/bootstrap.min.css'>
<script src='../js/bootstrap.min.js'></script>
<style>
   #bordesito {
    /*border:1px solid black;*/
   }
   #div_encabezado_items{
    display:none;
}
#div_observaciones{
     display:none;
}
#formato_tabla thead{
    background-color: #E8E1E0;
    text-align: center;

}
#busqueda_codigos{
display:none;
}
#codigo_a_escoger{
  color:black;
}
</style>
</head>
<body>
<div id="container">
 <div id="div_total">   
    <div id="div_arriba">
    </div>
    <div id="informacion_basica">
        <input type="hidden" name="idcarro" id="idcarro"  value ="<?php  echo $idcarro ; ?>">
    <form>
    	<div class="row">
    		<div class="col-md-<?php echo $columnas ; ?> col-xs-12" id="bordesito">
    			<div class="form-group">
    				<label for ="nombre_cot">Nombre:</label> 
                    <?php  echo $datos_propietario['nombre'] ?>
                   
    			</div>
    		</div><!--div_col-->

    		<div class="col-md-<?php echo $columnas ; ?> col-xs-12" id="bordesito">
    			<div class="form-group">
    				
                    <label for ="telefono_cot">Telefono:</label> 
                    <?php  echo $datos_propietario['telefono'] ?>
                  
    			</div>
    		</div><!--div_col-->

    		<div class="col-md-<?php echo $columnas ; ?> col-xs-12" id="bordesito">
    			<div class="form-group">
    				<label for ="direccion_cot">Direccion:</label> <?php  echo $datos_propietario['direccion'] ?>
    			</div>
    		</div><!--div_col-->

    		<div class="col-md-<?php echo $columnas ; ?> col-xs-12" id="bordesito">
    			<div class="form-group">

    				<label><?php  echo $datos_propietario['email'] ?></label> 
    			</div>
    		</div><!--div_col-->
    	</div> <!--div_class row-->

    	<div class="row">

    		<div class="col-md-<?php echo $columnas; ?> col-xs-12" id="bordesito">
    			<div class="form-group">
    				<label for ="marca_cot">Marca:</label> <?php  echo $datos_moto['marca'] ?>
    			</div>
    		</div><!--div_col-->


    		<div class="col-md-<?php echo $columnas ; ?> col-xs-12" id="bordesito">
    			<div class="form-group">
    				<label for ="linea_cot">Modelo:</label> <?php  echo $datos_moto['tipo'] ?>
                 </div>   
    		</div><!--div_col-->

            <div class="col-md-<?php echo $columnas ; ?> col-xs-12" id="bordesito">
                <div class="form-group">
                    <label for ="linea_cot">Año:</label> <?php  echo $datos_moto['modelo'] ?>
                 </div>   
            </div><!--div_col-->

            <div class="col-md-<?php echo $columnas ; ?> col-xs-12" id="bordesito">
                <div class="form-group">
                    <label for ="linea_cot">Color:</label> <?php  echo $datos_moto['color'] ?>
                 </div>   
            </div><!--div_col-->
        


    		
    	</div> <!--div_class row-->    
    </form>
     </div> <!--informacion_basica-->
      FECHA: <?php echo $fechapan; ?>
    <input type="hidden" id="fecha"  name ="fecha" value ="<?php echo $fechapan;  ?>">
     COT No <input type="text" id="no_cotizacion" value= "<?php echo $numero_cot;  ?>" onfocus="blur();" size="5px;">
       <input type="hidden" id="id_cotizacion" name = "id_cotizacion" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
     KILOMETRAJE <input type="" id="kilometraje" class="fila_llenar">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
     <button id="btn_crear_cotizacion" class="btn btn-info">CREAR COTIZACION</button>
    <!--   __________________________________________________________________________  --> 
    <br><br>
    <div id="div_observaciones">
        <textarea cols="80%" rows="3" placeholder = "observaciones" class="fila_llenar" id="observaciones"></textarea>
    </div>  
<!--    falta la parte de buscar los items de inventario   -->
BUSCAR DESCRIPCION 
<input type="text"  id="input_buscar_codigo" name = "input_buscar_codigo" class="fila_llenar">
<div id="busqueda_codigos"  ></div> 
  <br>
    <div id="div_encabezado_items">
      <!--
      <input type="text" value ="<?php  echo $_REQUEST['id_empresa'];  ?>">
    -->
    <table width="<?php echo $ancho_tabla ?>" border="1" class="table" id="formato_tabla">
        <thead>
        <tr>
            <td>ITEM</td>
            <td>TIPO</td>
            <td>Codigo</td>
            <td>Descripcion</td>
            <td>Valor</td>
            <td>Cantidad</td>
            <!--<td>Total Item</td>-->
            <td>ACCION</td>
        </tr>
    </thead>
    <tbody>
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
       </tbody> 
    </table>
    <div id="div_items">
       
    </div>

    <div id="finalizar" align="center">
        <br>
        <button id="finalizar_cotizacion">FINALIZAR COTIZACION</button>
    </div>  
</div>
    

   <!--   __________________________________________________________________________  -->   

   
    <div id="div_repuestos">
    	
    </div>	
   </div> <!--div_total-->
</div><!--container-->
</body>
</html>	
<?php
} // DE SI PLACA EXISTE
}  // fin de else de is placa en blanco
}  //fin de session

?>



<script src="../js/modernizr.js"></script>   
<script src="../js/prefixfree.min.js"></script>
<script src="../jquery-2.1.1.js"></script>  


<script>
  $(document).ready(function(){
            /////////////////////////////////////
              $("#input_buscar_codigo").click(function(){
              $("#busqueda_codigos").toggle("slow");
            });
            /////////////////////////////////
             $("#input_buscar_codigo").keydown(function(e){
                var data =  'descricodigo=' + $("#input_buscar_codigo").val();
              
              //$("#replica").val($("#mitexto").val());
              $.post('buscar_codigo.php',data,function(a){
                        //$(window).attr('location', '../index.php);
                $("#busqueda_codigos").html(a);
                          //alert(data);
              }); 
   
              });

            //////////////////////////////////
            
                $("#btn_crear_cotizacion").click(function(event) {
                    //alert("asdasda");
                         if($("#kilometraje").val().length < 1)
                            { alert('digite kilometraje ');
                          $(kilometraje).focus();
                              return false;
                             }
                        var id_empresa = sessionStorage.getItem("id_empresa") ;
                        //alert(id_empresa);
                        
                         var id_usuario = sessionStorage.getItem("id_usuario") ;
                        var data ='no_cotizacion=' + $("#no_cotizacion").val();
                        data += '&idcarro=' + $("#idcarro").val();
                        data += '&fecha=' + $("#fecha").val();
                        data += '&kilometraje=' + $("#kilometraje").val();
                        data += '&observaciones=' + $("#observaciones").val();
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
                     $("#div_observaciones").css("display","block");  
        
         

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
                                { alert('digite tipo de item ');
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
                    var data =  'id_cotizacion=' + $("#id_cotizacion").val();
                    data += '&observaciones=' + $("#observaciones").val();
                            $.post('../cotizaciones/grabar_observaciones_coti.php',data,function(a){
                            //$("#div_total").html(a);
                                //alert(data);
                            }); 

                            $.post('../cotizaciones/mostrar_cotizaciones.php',data,function(a){
                            $("#div_total").html(a);
                                //alert(data);
                            });     
                        $("#div_encabezado_items").css("display","none");       
                        $("#div_items").css("display","none");  

        });

    //////////////////////
    });
</script>

