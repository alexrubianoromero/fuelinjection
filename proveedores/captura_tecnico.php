<?php
session_start();
include('../valotablapc.php');
include('../funciones_summers.php');
?>
<!DOCTYPE html>
<html lang="es"  class"no-js">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

<h3>CREACION PROVEEDOR</h3>
<div id = "datos">
<table width="50%" border="1">
  <tr>
    <td>PROVEEDOR</td>
    <td><input type="text" name="nombre"  id = "nombre"></td>
  </tr>
  <tr>
    <td>CEDULA/NIT</td>
    <td><input type="text" name="cedula"  id = "cedula"></td>
  </tr>
  <tr>
    <td>TELEFONO</td>
    <td><input type="text" name="telefono"  id = "telefono"></td>
  </tr>
  <tr>
    <td>DIRECCION</td>
    <td><input type="text" name="direccion"  id = "direccion"></td>
  </tr>
  <tr>
    <td align = "center "colspan="2"><button type ="button"  id = "btn_grabar_proveedor" class="btn btn-primary btn-block" >GRABAR</button></td>
   
  </tr>
</table>

</div>
</body>
</html>
<script src = "../js/jquery.js"></script>
<script src = "../js/appcxpproveedores.js"></script>


  
