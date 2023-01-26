<?php
//  include('../conexion_poo.php');
 include('../config.php');

Class modelo{
     public $conexion;  
     public $conexionPdo;
     private $config;

       public function __construct(){
            //$this->conexion = new conexionBaseDatos();
            //$this->conexionPdo = new conexionPdo();
            $this->config = new config();
            // echo '<pre>';
            // print_r($this->conexion->obtenerConexion());
            // echo '<pre>';
       }

       public function buscarCxpPorIdOrden($idOrden){
           echo $this->config::$valor; 
        //    $sql = "
        //             SELECT  c.tipocxp,o.orden,c.valor,c.saldo,c.fecha_creacion, t.nombre as nombre  
        //             FROM  cxp as c 
        //             LEFT JOIN  tecnicos t on t.idcliente = c.id_tecnico 
        //             INNER JOIN  ordenes o on o.id = c.id_orden
        //             WHERE c.id_orden = '".$idOrden."' and c.saldo > 0 
        //    "; 

        //    $objPdo = $this->conexionPdo->conectar();
            //  echo $sql;
          //  $newConnection2 = $this->conexion->obtenerConexion();
          // $consulta = mysql_query($sql,$newConnection2);

        //   $objPdo = $this->conexionPdo->connect();
        //   $consulta = $objPdo->excecute($sql);
        //     echo '<pre>';
        //     print_r($consulta);
        //     echo '</pre>'; 
           return $consulta ; 
       }


       
}


?>