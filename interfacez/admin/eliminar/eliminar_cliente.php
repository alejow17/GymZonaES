<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();

if (isset($_GET['eliminar'])) {
    $documento = $_GET['eliminar'];

    // Realizar la consulta de eliminación utilizando PDO
    $consulta = $conexion->prepare("DELETE FROM usuarios WHERE documento = :documento");
    $consulta->bindParam(':documento', $documento);
    $consulta->execute();

    // Redirigir a la página de listar usuarios después de eliminar
    header("Location: ../listar/listar-clientes.php");
    exit();
}
?>
