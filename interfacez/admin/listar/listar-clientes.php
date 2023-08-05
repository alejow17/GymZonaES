<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
// Pagination variables
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$entriesPerPage = 5;
$offset = ($page - 1) * $entriesPerPage;
$consulta = $conexion->prepare("SELECT usuarios.documento, usuarios.nombre, usuarios.telefono, usuarios.correo, usuarios.nacimiento, genero.genero
                                FROM usuarios
                                INNER JOIN roles ON usuarios.id_roles = roles.id_roles
                                LEFT JOIN genero ON usuarios.id_genero = genero.id_genero
                                WHERE usuarios.id_roles = 3
                                LIMIT $offset, $entriesPerPage");
$consulta->execute();
session_start();
include "../../../control-ingreso/validar-sesion.php";
?>

<?php
if (isset($_POST['boton_volver'])) {
    echo '<script>window.location="../index-admin.php"</script>';
}
?>

<?php
// if(isset($_POST['btn_crear'])){
//     echo '<script>window.location="../crear/crear-usuarios.php"</script>';
// }
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
    <link rel="stylesheet" href="listar-usuarios.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <!--  mas opciones en la barra de navegabilidad -->
    <script src="jquery.min.js"></script>
    <script src="../../../css/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <title>listar usuarios</title>
</head>

<body>
    <nav class="navega">
        <!-- el nav hace que todo quede en fila... el nav-tabs hace que se dividan las sesiones -->
        <!-- justify-contend-end que el menu quede al lado derecho de la pantalla -->
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
                <a class="nav-link text-light p-3" aria-current="page"
                    href="../../admin/index-admin.php"><b>MENU</b></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link active text-bg-warning p-3 dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <b style="color: white">USUARIOS</b>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="./listar-usuarios.php">Lista de Usuarios</a></li>
                    <li><a class="dropdown-item" href="../crear/crear-usuarios.php">Crear Usuarios</a></li>
                    <li><a class="dropdown-item" href="./listar-clientes.php">Lista de clientes</a></li>
                    <li><a class="dropdown-item" href="../crear/crear-cliente.php">Crear Cliente</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../listar/listar-roles.php"><b>ROLES</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../../admin/ventas/listar.php"><b>PRODUCTOS</b></a>
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
        <form class="volver" method="post">
            <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
            <h1>LISTA DE CLIENTES</h1>
            <!-- <button value="Atras" name="btn_crear" class="btn btn-success">Crear</button> -->
        </form>
        <br>
        <table class="table table-bordered">
            <tr style="text-align: center;">
                <th style="text-align: center;">Documento</th>
                <th style="text-align: center;">Nombre</th>
                <th style="text-align: center;">Genero</th>
                <th style="text-align: center;">Telefono</th>
                <th style="text-align: center;">Correo</th>
                <th style="text-align: center;">Nacimiento</th>
                <th style="text-align: center;" colspan="2">Accion</th>
            </tr>
            <?php
            foreach ($consulta as $cons) {
                ?>
                <tr style="text-align: center;">
                    <td style="text-align: center;">
                        <?= $cons['documento'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $cons['nombre'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $cons['genero'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $cons['telefono'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $cons['correo'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $cons['nacimiento'] ?>
                    </td>
                    <td>
                        <form action="../eliminar/eliminar_cliente.php" method="get">
                            <input type="hidden" name="eliminar" value="<?= $cons['documento'] ?>">
                            <button class="btn btn-danger botones" type="submit"
                                onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                <img style="width:30px;" src="../../../iconos/delete.png" alt="borrar">
                            </button>
                        </form>

                    </td>
                    <td>
                        <form action="../actualizar/actualizar-cliente.php" method="get">
                            <input type="hidden" name="actualizar" value="<?= $cons['documento'] ?>">
                            <button class="btn btn-warning botones" type="submit"><img style="width:30px;"
                                    src="../../../iconos/pencil.png" alt="rulers"></button>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <div class="container text-center">
            <?php
            $countQuery = $conexion->prepare("SELECT COUNT(*) FROM usuarios INNER JOIN roles ON usuarios.id_roles=roles.id_roles WHERE usuarios.id_roles=3");
            $countQuery->execute();
            $totalEntries = $countQuery->fetchColumn();
            $totalPages = ceil($totalEntries / $entriesPerPage);

            // Previous page link
            if ($page > 1) {
                echo '<a class="btn btn-warning" href="?page=' . ($page - 1) . '">&laquo; Previo</a>';
            }

            // Page numbers
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a class="btn btn-warning" style="margin-right: 5px; margin-left: 5px;" href="?page=' . $i . '"';
                if ($page == $i) {
                    echo ' class="active"';
                }
                echo '>' . $i . '</a>';
            }

            // Next page link
            if ($page < $totalPages) {
                echo '<a class="btn btn-warning" href="?page=' . ($page + 1) . '">Siguiente &raquo;</a>';
            }
            ?>
        </div>
    </div>
</body>

</html>