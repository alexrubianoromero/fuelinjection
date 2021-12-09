<?php
include('../valotablapc.php');
$sql = "SELECT  * FROM  cxp WHERE id_orden = '".$_REQUEST['idorden']."'  "; 
// echo $sql;
$consulta = mysql_query($sql,$conexion); 
]$arreglo = mysql_fetch_assoc($consulta);
$i = 0;
while($cuentas = mysql_fetch_assoc($consulta))
{
    echo 'sdfdsf';
            echo  'asdasdasdasdasdasdas';
    $i++;
}  

echo '<pre>';
print_r($arreglo);
echo '</pre>';

?>

