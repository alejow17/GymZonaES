<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();

session_start();
include "../../../control-ingreso/validar-sesion.php";

if(isset($_GET['eliminar'])) {
    $documento = $_GET['eliminar'];

    // Realizar la consulta para eliminar el usuario con el documento especificado
    $eliminar = $conexion->prepare("DELETE FROM usuarios WHERE documento = :documento");
    $eliminar->bindParam(":documento", $documento);

    if($eliminar->execute()) {
        echo '<script>alert("Usuario eliminado correctamente.");</script>';
        echo '<script>window.location="../listar/listar-usuarios.php";</script>';
    } else {
        echo '<script>alert("Error al eliminar el usuario. Por favor, inténtelo de nuevo.");</script>';
        echo '<script>window.location="../listar/listar-usuarios.php";</script>';
    }
} else {
    echo '<script>window.location="../listar/listar-usuarios.php";</script>';
}
?>
