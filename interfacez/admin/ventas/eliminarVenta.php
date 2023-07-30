<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
$sentencia = $conexion->prepare("DELETE FROM ventas WHERE id = ?;");
$resultado = $sentencia->execute([$id]);
if($resultado === TRUE){
	header("Location: ./ventas.php");
	exit;
}
else echo "Algo salió mal";
?>