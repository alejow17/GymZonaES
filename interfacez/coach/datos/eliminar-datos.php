	<?php
if(!isset($_GET["id_datos_fisicos"])) exit();
$id = $_GET["id_datos_fisicos"];
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();

$sentencia = $conexion->prepare("DELETE FROM datos_fisicos WHERE id_datos_fisicos = ?;");
$resultado = $sentencia->execute([$id]);
if($resultado === TRUE){
	header("Location: ../membresias/listar-membresias.php");
	exit;
}
else echo "Algo salió mal";
?>