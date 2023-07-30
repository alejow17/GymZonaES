<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";
$id = $_GET['eliminar'];
$consulta = $conexion-> prepare ("SELECT * FROM servicios WHERE id_servicio=$id");
$consulta->execute();
$consul=$consulta->fetch();
?>

<?php

?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="lista-servicios.php"</script>';
    }
?>

<?php
    if(isset($_POST['btn_eliminar']))
    {
        $eliminar = $conexion -> prepare("DELETE FROM servicios WHERE id_servicio=$id");
        $eliminar->execute();
        echo '<script>alert ("Registro eliminado con exito");</script>';
        echo '<script>window.location="lista-servicios.php"</script>';
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
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <title>Eliminar servicio</title>
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
        <h1 class="titulo" style="font-size: 45px;" >ELIMINAR SERVICIOS</h1>
        <br>
        <form method="post">
        <table class="table table-bordered">
                <tr>
                    <th style="text-align: center;">Servicio</th>
                    <th style="text-align: center;">Precio</th>
                    <th style="text-align: center;">Accion</th>
                </tr>
                <tr>
                    <td style="text-align: center;"><?=$consul['desc_servicio']?></td>
                    <td style="text-align: center;"><?=$consul['precio']?></td> 
                    <td>
                        <input class="btn btn-danger" type="hidden" name="btn_eliminar" value="Eliminar">
                        <button onclick="return ConfirmDelete()" class="btn btn-danger" type="submit">Eliminar</button>
                    </td>
                </tr>
        </table>
    </div>
    </form>  