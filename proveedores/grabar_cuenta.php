<?php
    include('../valotablapc.php');
    // echo '<pre>';
    // print_r($_REQUEST);
    // echo '</pre>';
$sql = "insert into $cxp (tipocxp,no_factura,valor,saldo,fecha_creacion,id_tecnico,observaciones) values 
    ('".$_REQUEST['tipocxp']."'
    ,'".$_REQUEST['nofactura']."'
    ,'".$_REQUEST['valor']."'
    ,'".$_REQUEST['valor']."'
    ,now()
    ,'".$_REQUEST['id_tecnico']."'
    ,'".$_REQUEST['observaciones']."'
    )";

   $consulta_grabar = mysql_query($sql,$conexion);  
//  echo '<br>'.$sql;
echo 'CUENTA GRABADA ';   
?>