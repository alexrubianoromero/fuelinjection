<?php
include('../valotablapc.php');
include('../funciones_summers.php');

$sql= "select c.no_factura,c.valor,c.saldo,c.fecha_creacion,t.nombre, 
c.id,c.observaciones
from cxp c
inner join proveedores t on c.id_tecnico = t.idcliente
  where c. tipocxp = 2  ";

  if(isset($_REQUEST['historico'])) { 
    $sql .= " and c.saldo <= 0 ";
   }else
   { $sql .= " and c.saldo >0 ";}
// if(isset($_REQUEST['idorden'])){
//   $sql .= "  and c.id_orden = '".$_REQUEST['idorden']."' "; 
// }  
//   echo $sql;
$consultacxp = mysql_query($sql,$conexion);
$sumatotal = 0;
$totalsaldos = 0;
echo '<table class="table">';
echo '<tr>';
// echo '<td>tipocxp</td>';
//echo '<td>orden</td>';
echo '<td>No Factura</td>';
echo '<td>Valor</td>';
echo '<td>Saldo</td>';
echo '<td>Fecha Creacion</td>';
echo '<td>Proveedor</td>';
echo '<td>Observaciones</td>';
echo '<td>Ver_Abonos</td>';
echo '<td>Abonos</td>';
echo '</tr>';
while ($cxp = mysql_fetch_assoc($consultacxp)){
  $suma_abonos = suma_abonos($cxp['id'],$conexion,$tabla23);
    echo '<tr>';
    if($cxp['tipocxp']==1){ $tipo = 'Empleado';} 
    // echo '<td>'.$tipo .'</td>';
   // echo '<td>'.$cxp['orden'].'</td>';
     echo '<td>'.$cxp['no_factura'].'</td>';
    echo '<td>'.$cxp['valor'].'</td>';
    echo '<td>'.$cxp['saldo'].'</td>';
    echo '<td>'.$cxp['fecha_creacion'].'</td>';
    echo '<td>'.$cxp['nombre'].'</td>';
    echo '<td>'.$cxp['observaciones'].'</td>';
    echo '<td align="right"><button class="ver_abonos"  id="ver_abonos"  value ="'.$cxp['id'].'" size="50px">'.number_format ($suma_abonos,0).'</button></td>';
    echo '<td>';
        if($cxp['saldo']>0)    {
          echo  '<button class="crear_abono" id="crear_abono" value ="'.$cxp['id'].'">Abonar</button>';
        }
    echo '</td>';
    echo '</tr>';
    $sumatotal  += $cxp['valor'];
    $totalsaldos  += $cxp['saldo'];
}
echo '<tr>';
echo '<td></td><td>'. $sumatotal.'</td><td>'.$totalsaldos.'</td><td></td><td></td><td></td><td></td>';
echo '</tr>';
echo '</table>';
echo '<div id="div_abonos"></div>';

?>
<script src = "../js/jquery.js"></script>
<script src = "../js/appcxpproveedores.js"></script>
