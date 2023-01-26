<?php
// include('../cxp/modelo.php');
 include('../config.php');

Class controladorCxp {
    protected $_modelo;
    protected $config;
        public function __construct(){
              $this->_idOrden = $_REQUEST['idorden'];
              $this->_modelo = new modelo();
              $this->config = new config();

        }
        public function muestreArreglo(){
            echo $this->config::$valor; 
        }

        public function muestreCxpOrden(){
           $registros = $this->_modelo->buscarCxpPorIdOrden($_REQUEST['idorden']);    
        //    echo '<table border = "1">';
        //          while($cxp = mysql_fetch_assoc($registros)){
        //                 echo '<tr>';
        //                 echo '<td>'.$cxp['id_orden'].'</td>';
        //                 echo '<td>'.$cxp['nombre'].'</td>';
        //                 echo '<td>'.$cxp['valor'].'</td>';
        //                 echo '<td>'.$cxp['saldo'].'</td>';
        //                 echo '<td>'.$cxp['fecha_creacion'].'</td>';
        //                 echo '<td><button class="abonar" id="abonar" value = "'.$cxp['id'].'">Abonar</button></td>';
        //                 echo '</tr>';
        //         }
        //     echo '</table>';
        }

      
}//fin de la clase principal 

?>