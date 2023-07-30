<?php
#Salir si alguno de los datos no está presente
if(!isset($_POST["codigo"]) || !isset($_POST["descripcion"]) || !isset($_POST["precioVenta"]) || !isset($_POST["existencia"])) exit();

#Si todo va bien, se ejecuta esta parte del código...

require_once("../../../bd/conexion.php");
session_start();
$basedatos = new Database();
$conexion = $basedatos->conectar();
$docu = $_SESSION['document'];
$codigo = $_POST["codigo"];
$descripcion = $_POST["descripcion"];
$precioVenta = $_POST["precioVenta"];
$existencia = $_POST["existencia"];

$sentencia = $conexion->prepare("INSERT INTO productos(id, codigo, coach, descripcion, precioVenta, existencia) VALUES (?, ?, ?, ?, ?, ?);");
$resultado = $sentencia->execute([$codigo, $codigo, $docu, $descripcion, $precioVenta, $existencia]);

if($resultado === TRUE){
	header("Location: ./listar.php");
	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista";


?>
<?php include_once "pie.php" ?>