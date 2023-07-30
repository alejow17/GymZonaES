<?php
require_once("../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
session_start();

$maxIntentos = 3;

if ($_POST["ingresar"]) {
    $usuario = $_POST['usuario'];
    $contra = $_POST['contra'];

    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
    $consulta->bindParam(':usuario', $usuario);
    $consulta->execute();
    $consul = $consulta->fetch();

    $options = ['cost' => 12];

    if ($consul) {
        if ($consul['id_estado_login'] == 1) {
            $alerta = "Tu cuenta ha sido bloqueada debido a múltiples intentos fallidos. Inténtalo nuevamente más tarde.";
            header("Location: ../login.php?alerta=".urlencode($alerta));
            exit();
        } else if (password_verify($contra, $consul['password'])) {
            if (password_needs_rehash($consul['password'], PASSWORD_DEFAULT, $options)) {
                $hash = password_hash($contra, PASSWORD_DEFAULT, $options);
                $query = 'UPDATE usuarios SET usuarios.password = :passwd WHERE documento = :id';
                $values = [':passwd' => $hash, ':id' => $consul['documento']];

                try {
                    $res = $conexion->prepare($query);
                    $res->execute($values);
                } catch (PDOException $e) {
                    echo 'Query error.';
                    die();
                }
            }

            $_SESSION['document'] = $consul['documento'];
            $_SESSION['name'] = $consul['nombre'];
            $_SESSION['user'] = $consul['usuario'];
            $_SESSION['roles'] = $consul['id_roles'];

            $consultaResetIntentos = $conexion->prepare("UPDATE usuarios SET intentos_login = 0 WHERE documento = :id");
            $consultaResetIntentos->bindParam(':id', $consul['documento']);
            $consultaResetIntentos->execute();

            if ($_SESSION['roles'] == 1) {
                header("Location: ../interfacez/admin/index-admin.php");
                exit();
            } else if ($_SESSION['roles'] == 2) {
                header("Location: ../interfacez/coach/index-coach.php");
                exit();
            } else if ($_SESSION['roles'] == 3) {
                header("Location: ../interfacez/usuario/index-usuario.php");
                exit();
            }
        } else {
            $intentosFallidos = $consul['intentos_login'] + 1;
            $consultaActualizarIntentos = $conexion->prepare("UPDATE usuarios SET intentos_login = :intentos WHERE documento = :id");
            $consultaActualizarIntentos->bindParam(':intentos', $intentosFallidos);
            $consultaActualizarIntentos->bindParam(':id', $consul['documento']);
            $consultaActualizarIntentos->execute();

            if ($intentosFallidos >= $maxIntentos) {
                $consultaBloquearCuenta = $conexion->prepare("UPDATE usuarios SET id_estado_login = 1 WHERE documento = :id");
                $consultaBloquearCuenta->bindParam(':id', $consul['documento']);
                $consultaBloquearCuenta->execute();

                $alerta = "Tu cuenta ha sido bloqueada debido a múltiples intentos fallidos. Inténtalo nuevamente más tarde.";
                header("Location: ../login.php?alerta=".urlencode($alerta));
                exit();
            } else {
                $alerta = "Contraseña incorrecta. Intenta nuevamente.";
                header("Location: ../login.php?alerta=".urlencode($alerta));
                exit();
            }
        }
    } else {
        $alerta = "Usuario no encontrado. Intenta nuevamente.";
        header("Location: ../login.php?alerta=".urlencode($alerta));
        exit();
    }
}
?>
