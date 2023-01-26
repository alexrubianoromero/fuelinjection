<?php
session_start();
include('../valotablapc.php');
 function  consulta_assoc($tabla,$campo,$parametro,$conexion)
  {
       $sql="select * from $tabla  where ".$campo." = '".$parametro."' ";
       //echo '<br>'.$sql;
       $con = mysql_query($sql,$conexion);
       $arr_con = mysql_fetch_assoc($con);
       return $arr_con;
  }
 
$datos_orden = consulta_assoc($tabla14,'id',$_REQUEST['id_orden'],$conexion);
$datos_carro = consulta_assoc($tabla4,'placa',$datos_orden['placa'],$conexion);
$datos_cliente = consulta_assoc($tabla3,'idcliente',$datos_carro['propietario'],$conexion);


$fechapan =  time();
$fechapan = date ( "Y/m/j" , $fechapan );
?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>Muestre Ordenes</title>
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">

</head>s
<body>
<div id="div_facturar_nuevo" align="center">
     <div id ="div_encabezado_facturar" align="center">
     	<input type="hidden" id="id_orden" value="<?php  echo $_REQUEST['id_orden']  ?>"> 
     	<input type="hidden" id="placa" value="<?php  echo $datos_orden['placa']  ?>"> 
     	<h1>EMITIR DOCUMENTO SOPORTE</h1>
     	<h3>Informacion Orden</h3>
     	
     	<br>
     	<label>ORDEN:</label><?php  echo $datos_orden['orden'] ;  ?>
     	<br>
     		<label>FECHA ORDEN:</label><?php  echo $datos_orden['fecha']  ?>
     		<br>
     		<label>PLACA:</label><?php  echo $datos_orden['placa'] ;  ?>
     				<br><br>
     	<label>FECHA :</label><input type="text"  id="fecha" value ="<?php echo $fechapan; ?>" class="fila_llenar">
     		
     			<br><br>
     		<label>No :</label><input type="text"  id="no_factura" class="fila_llenar" >
     			<br><br>
     		<label>FORMA DE PAGO:</label><input type="text"  id="forma_pago"  class="fila_llenar">

     		<br><br><br>
     		<button id="btn_facturar">Generar</button>
     </div>
     <div id="div_resultados_facturar" align="center">
     </div>	


 </div>	
</body>
</html>

<script src="../js/jquery-2.1.1.js"></script>   


<script language="JavaScript" type="text/JavaScript">
$(document).ready(function(){
	/////////////////////////////////	
		$("#btn_facturar").click(function(){
		//alert('sfsdfsd');
							       /////////////////////////////////
				if($("#fecha").val().length < 1)
		        { alert('digite fecha ');
		      $(fecha).focus();
		          return false;
		         }
							       
              if($("#no_factura").val().length < 1)
		        { alert('digite No Factura ');
		      $(no_factura).focus();
		          return false;
		         }
		          if($("#forma_pago").val().length < 1)
		        { alert('digite forma_pago ');
		      $(forma_pago).focus();
		          return false;
		         }
         
							var data =  'id_orden=' + $("#id_orden").val();
							data += '&no_factura=' + $("#no_factura").val();
							data += '&forma_pago=' + $("#forma_pago").val();
							data += '&fecha=' + $("#fecha").val();
							data += '&placa=' + $("#placa").val();
							$.post('crear_factura_nuevo.php',data,function(a){
							$("#div_facturar_nuevo").html(a);
								//alert(data);
							});	

		});
				
					///////////////////////////////////

});

</script>