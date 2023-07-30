<?php
require_once("../../../bd/conexion.php");
session_start();
include('../../../control-ingreso/validar-sesion.php');

$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion-> prepare ("SELECT * FROM membresias INNER JOIN estado ON membresias.id_estado=estado.id_estado");
$consulta->execute();

date_default_timezone_set('America/Bogota');
$fecha_actual = date('Y-m-d H:i:s');
$docu = $_SESSION['name'];
?>

<?php
    if(isset($_POST['boton_codigos'])){
        echo '<script>window.location="lista-codigos.php"</script>';
    }
?>

<?php
    // if(isset($_POST['boton_volver'])){
    //     echo '<script>window.location="../index-admin.php"</script>';
    // }
?>

<?php
    if(isset($_POST['btn_crear'])){
        echo '<script>window.location="../membresias/crear-membresia.php"</script>';
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
    <title>Membresias</title>
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
                <a class="nav-link text-light p-3" href="../ventas/listar.php"><b>PRODUCTOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="#"><b>SERVICIOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../ventas/ventas.php"><b>VENTAS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-bg-warning p-3" href="../membresias/listar-membresias.php"><b style="color: white">MEMBRESIAS</b></a>
            </li>
        </ul>    
    </nav>

    <div class="container contenedor1">
        <form method="post"> 
            <h1>DISCAPACIDADES</h1>
            <button value="Atras" name="btn_crear" class="btn btn-success">Crear</button>
            <button style="margin-left:838px;" value="codigos" name="boton_codigos" class="btn btn-primary" >Codigos de barras</button>
        </form>
        <br>
        <div class="table-responsive">
        <table class="table table-bordered">
                <tr>
                    <th style="text-align: center;">Nombre</th>
                    <th style="text-align: center;">Documento</th>
                    <th style="text-align: center;">Discapacidades</th>
                    <th style="text-align: center;" colspan="3">Accion</th>
                </tr>
        <?php
            foreach($consulta as $cons)
            {
             // Verificar el valor de id_estado
            if ($cons['id_estado'] == 1) {
                $color = 'rgb(6, 213, 0)'; // Verde si es estado 1
            } else {
                $color = 'rgb(209, 0, 0)'; // Rojo si es estado 2
            }
        ?>
        
                <tr>
                    <td style="text-align: center;"><?=$cons['nombre']?></td>
                    <td style="text-align: center;"><?=$cons['documento']?></td>
                    <td style="text-align: center;"><?=$cons['discapacidad']?></td>
                    <td>
                        <form action="../membresias/eliminar-membresia.php" method="get">
                            <input type="hidden" name="eliminar" value="<?=$cons['id_membresias']?>">
                            <button class="btn btn-danger" type="submit">ELIMINAR</button>
                        </form>
                    </td>
                </tr>
        <?php
        }
        ?>
        </table>
        </div>
    </div>
</body>
</html>