<?php
include('../valotablapc.php');
$sql = "select * from $tabla23   where id_cxp = '".$_REQUEST['id']."' ";
$consultacxp = mysql_query($sql,$conexion);

echo '<h3>ABONOS REALIZADOS </h3>';

echo '<table class="table table-striped table-hover">';
echo '<tr>';
echo '<td>Fecha_Abono</td>';
echo '<td>Valor_Abono</td>';
echo '</tr>';

while ($cxp = mysql_fetch_assoc($consultacxp)){
    echo '<tr>';
    echo '<td>'.$cxp['fecha_recibo'].'</td>';
    echo '<td>'.$cxp['lasumade'].'</td>';
    echo '</tr>';
    
}    

echo '</table>';



?>