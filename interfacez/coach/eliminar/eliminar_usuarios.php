<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
$documento = $_GET['eliminar'];
$consulta = $conexion-> prepare ("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_roles=roles.id_roles WHERE usuarios.documento=$documento");
$consulta->execute();
$consul=$consulta->fetch();
?>

<?php
session_start();
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="../listar/listar-usuarios.php"</script>';
    }
?>

<?php
    if(isset($_POST['btn_eliminar']))
    {
        $eliminar = $conexion -> prepare("DELETE FROM usuarios WHERE usuarios.documento=$documento");
        $eliminar->execute();
        echo '<script>alert ("Registro eliminado con exito");</script>';
        echo '<script>window.location="../listar/listar-usuarios.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Boobtstrap-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->

    <!-- bootstrap sin internet -->
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <title>Eliminar usuario</title>
</head>
<script type="text/javascript">
    function ConfirmDelete()
    {
        var respuesta = confirm("Estas seguro de eliminar el registro");

        if (respuesta == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>
<body>
    <div class="container contenedor1">
            <form class="volver" method="post">
                <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
            </form>
        <h1 class="titulo" style="font-size: 45px;" >ELIMINAR USUARIO</h1>
        <br>
        <form method="post">
        <table class="table table-bordered">
                <tr>
                    <th style="text-align: center;">Documento</th>
                    <th style="text-align: center;">Nombre</th>
                    <th style="text-align: center;">Usuario</th>
                    <th style="text-align: center;">Tipo de usuario</th>
                    <th style="text-align: center;">Accion</th>
                </tr>
                <tr>
                    <td style="text-align: center;"><?=$consul['documento']?></td>
                    <td style="text-align: center;"><?=$consul['nombre']?></td>
                    <td style="text-align: center;"><?=$consul['roles']?></td> 
                    <td style="text-align: center;"><?=$consul['usuario']?></td>
                    <td>
                        <input class="btn btn-danger" type="hidden" name="btn_eliminar" value="Eliminar">
                        <button onclick="return ConfirmDelete()" class="btn btn-danger" type="submit">Eliminar</button>
                    </td>
                </tr>
        </table>
    </div>
    </form>  