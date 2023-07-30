<?php
require_once("../../../bd/conexion.php");
session_start();
include "../../../control-ingreso/validar-sesion.php";
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion -> prepare("SELECT * FROM roles WHERE id_roles>1");
$consulta->execute();
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="../index-admin.php"</script>';
    }
?>

<?php
    if(isset($_POST['btn_crear'])){
        echo '<script>window.location="../crear/crear-roles.php"</script>';
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
    <title>Listar Roles</title>
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
                <a class="nav-link text-light p-3 dropdown-toggle" href="../listar/listar-usuarios.php"><b>USUARIOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-bg-warning p-3" href="../listar/listar-roles.php"><b style="color: white; ">ROLES</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../ventas/listar.php"><b>PRODUCTOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../servicios/lista_ventas_servicios.php"><b>SERVICIOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3 dropdown-toggle" href="../ventas/ventas.php"><b>VENTAS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../membresias/listar-membresias.php"><b>MEMBRESIAS</b></a>
            </li>
        </ul>    
    </nav>

    <div class="container contenedor1">
        <form method="post">
        <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button> 
        <h1>LISTA DE ROLES</h1>
        <button value="Atras" name="btn_crear" class="btn btn-success">Crear</button>
        </form>
        <br>
        <table class="table table-bordered">
                <tr style="text-align: center;">
                    <th>Imagen</th>
                    <th style="text-align: center;">roles</th>
                    <th style="text-align: center;" colspan="2">Accion</th>
                </tr>
        <?php
            foreach($consulta as $cons)
            {
        ?>
                <tr style="text-align: center;">
                    <td style="text-align: center;"><img src="../crear/<?php echo $cons['imagen']?>" width="45" height="45"></img></td>
                    <td style="text-align: center;"><?=$cons['roles']?></td>
                    <td>
                        <form action="../eliminar/eliminar-rol.php" method="get">
                            <input type="hidden" name="eliminar" value="<?=$cons['id_roles']?>">
                            <button class="btn btn-danger" type="submit"><img style="width:30px;" src="../../../iconos/delete.png" alt="borrar"></button>
                        </form>
                    </td>
                    <td>
                        <form action="../actualizar/actualizar-rol.php" method="get">
                            <input type="hidden" name="actualizar" value="<?=$cons['id_roles']?>">
                            <button name="actu" class="btn btn-warning" type="submit"><img style="width:30px;" src="../../../iconos/pencil.png" alt="rulers"></button>
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