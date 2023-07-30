<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion-> prepare ("SELECT * FROM servicios");
$consulta->execute();
session_start();
?>

<?php
    // if(isset($_POST['boton_volver'])){
    //     echo '<script>window.location="../index-admin.php"</script>';
    // }
?>

<?php
    if(isset($_POST['btn_crear'])){
        echo '<script>window.location="../crear/crear_servicios.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Boobtstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>listar usuarios</title>
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
</head>
<body>
    <nav class="navega">
        <!-- el nav hace que todo quede en fila... el nav-tabs hace que se dividan las sesiones -->
        <!-- justify-contend-end que el menu quede al lado derecho de la pantalla -->
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
                <a class="nav-link text-light p-3" aria-current="page" href="../../admin/index-admin.php"><b>MENU</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../listar/listar-usuarios.php"><b>USUARIOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../listar/listar-roles.php"><b>ROLES</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../../admin/ventas/listar.php"><b>PRODUCTOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-bg-warning p-3" href="./servicios.php"><b style="color:white;" >SERVICIOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="./ventas.php"><b >VENTAS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../membresias/listar-membresias.php"><b >MEMBRESIAS</b></a>
            </li>
        </ul>    
    </nav>

    <div class="container contenedor1">
        <form class="volver" method="post">
        <!-- <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>     -->
        <h1>LISTA DE SERVICIOS</h1>
        <button value="Atras" name="btn_crear" class="btn btn-success">Crear</button>
        </form>
        <br>
        <table class="table table-bordered">
                <tr>
                    <th style="text-align: center;">Servicio</th>
                    <th style="text-align: center;">Precio</th>
                    <th style="text-align: center;" colspan="2">Accion</th>
                </tr>
        <?php
            foreach($consulta as $cons)
            {
        ?>
                <tr>
                    <td style="text-align: center;"><?=$cons['desc_servicio']?></td>
                    <td style="text-align: center;"><?=$cons['precio']?></td>
                    <td>
                        <form action="../eliminar/eliminar_servicios.php" method="get">
                            <input type="hidden" name="eliminar" value="<?=$cons['id_servicio']?>">
                            <button class="btn btn-danger botones" type="submit">Eliminar</button>
                        </form>
                    </td>
                    <td>
                        <form action="../actualizar/actualizar-servicios.php" method="get">
                            <input type="hidden" name="actualizar" value="<?=$cons['id_servicio']?>">
                            <button class="btn btn-warning botones" type="submit">Actualizar</button>
                        </form>
                    </td>
                </tr>
        <?php
        }
        ?>
        </table>
    </div>
</body>
</html>