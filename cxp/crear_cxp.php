<?php
    include('../valotablapc.php');
    include('../funciones_summers.php');
    // echo '<pre>';
    // print_r($_REQUEST);
    // echo '</pre>';

   $orden =  traer_orden($tabla14,'id',$_REQUEST['idorden'],$conexion);
?>
<input type="hidden" id="idorden"  value="<?php echo $_REQUEST['idorden']?>" >
<input type="hidden" id="tipocxp"  value="1" >
ORDEN: <input type="text" id="orden"  value="<?php echo $orden ?>" onFocus="blur()">
Tecnico: 
<select id="id_tecnico"> <?php colocar_select_general($tabla21,$conexion,'idcliente','nombre');  ?></select>
   Valor: <input type="text" id="valor">
   <br><br>
   Observaciones : <textarea id="observaciones" cols="50" rows ="4"></textarea>
   <br><br>
   <button id = "btn_grabar_cxp" class="btn btn-primary">Grabar Cuenta</button>


   <script src = "../js/jquery.js"></script>
<script src = "../js/appcxp.js"></script>