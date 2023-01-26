<?php
//include('valotablapc.php');

class conexionBaseDatos {
    //public $conexion;
        public $servidor = "localhost";
        public $usuario = "root";
        public $clave  = "";
        public $nombrebase = "base_fuelinjection";

        public function __construct(){
        }
        public function  obtenerConexion(){
            return  mysql_connect($this->servidor,$this->usuario,$this->clave);
            
        }
}

class conexionPdo{

    public function conectar($db){
        try {
           //$conn = new PDO('mysql:host=localhost;dbname=base_prueba','root','');
           $conn = new PDO("mysql:host={$db['host']};dbname={$db['db']}", $db['username'], $db['password']);
           $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
           return $conn; 
        }catch(PDOException $e){
           exit($e->getMessage());
        }
   
     }


    // private $db = [
    //     'host' => 'localhost',
    //     'username' => 'root',
    //     'password' => "",
    //     'db' => 'base_fuelinjection' 
    // ];


    // public function connect($db=null)
    //         {
    //             try {
    //                 echo $db;
    //                 $db = (($db)?$db:$this->db); 
    //                 $conn = new PDO("mysql:host={$db['host']};dbname={$db['db']}", $db['username'], $db['password']);
    //                 // set the PDO error mode to exception
    //                 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //                 return $conn;
    //             } catch (PDOException $exception) {
    //                 exit($exception->getMessage());
    //             }
    //         }

            


}




?>