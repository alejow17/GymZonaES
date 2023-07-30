<?php
class Database{
    private $hostname = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "zonafit_bd";
    private $chasrset = "utf8";
    
    function conectar()
    {
        try{
            $conexion = "mysql:host=". $this->hostname. "; dbname=". $this->database. "; chasrset=". $this->chasrset;
            $opcion = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_FOUND_ROWS => true
            ];

            $pdo = new PDO($conexion, $this->username,$this->password,$opcion);

            return $pdo;
        }
        catch(PDOException $e)
        {
            echo 'Error de  conexion' .$e->getMessage();
            exit;
        }
    }
}
?>