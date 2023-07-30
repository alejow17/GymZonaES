<?php
if(!isset($_POST["total"])) exit;

session_start();

$total = $_POST["total"];
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
date_default_timezone_set('America/Bogota');
$ahora = date("Y-m-d H:i:s");
$nombre = $_SESSION["document"];
$docu_cli = $_POST["cliente"];

$sentencia = $conexion->prepare("INSERT INTO ventas(vendedor, doc_cliente, fecha, total) VALUES (?, ?, ?, ?);");
$sentencia->execute([$nombre, $docu_cli, $ahora, $total]);

$sentencia = $conexion->prepare("SELECT id FROM ventas ORDER BY id DESC LIMIT 1;");
$sentencia->execute();
$resultado = $sentencia->fetch(PDO::FETCH_OBJ);

$idVenta = $resultado === false ? 1 : $resultado->id;



$conexion->beginTransaction();
$sentencia = $conexion->prepare("INSERT INTO productos_vendidos(id_producto, id_venta, cantidad) VALUES (?, ?, ?);");
$sentenciaExistencia = $conexion->prepare("UPDATE productos SET existencia = existencia - ? WHERE id = ?;");
if ($total != 0) {
    foreach ($_SESSION["carrito"] as $producto) {
        $total += $producto->total;
        
        $sentencia->execute([$producto->id, $idVenta, $producto->cantidad]);
        $sentenciaExistencia->execute([$producto->cantidad, $producto->id]);
    }
    $conexion->commit();
    unset($_SESSION["carrito"]);
    $_SESSION["carrito"] = [];
    header("Location: ./vender.php?status=1");
}else{
    header("Location: ./vender.php?status=6");
    exit;
}
