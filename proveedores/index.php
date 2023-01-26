<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Document</title>
        
</head>
<body>
<div class="container">
    <input type="hidden" id="idorden"  value="<?php echo $_REQUEST['idorden']?>">
    
    <h1>Cuentas Por Pagar Proveedores</h1>
    <button id ="btn_listar_cuentas" class="btn btn-primary">Listar_Cuentas</button>
    <button id ="btn_crear_cuenta" class="btn btn-primary">Crear_Cuenta</button>
    <button id ="btn_crear_proveedor" class="btn btn-primary">Crear_Proveedor</button>
    <button id ="btn_listar_cuentas_historico" class="btn btn-primary">Historico</button>
    <a href="../menu_principal.php" class="btn btn-primary" role="button">  Menu Principal </a>
    <br><br>
    <div id="div_resultados_cxp" >
     <?php
            include('listadocxp.php');   
     ?>
    </div>
</div>    
</body>
</html>
<script src = "../js/jquery.js"></script>
<script src = "../js/appcxpproveedores.js"></script>