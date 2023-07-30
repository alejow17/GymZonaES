<?php
require_once("../../../bd/conexion.php");
session_start();
include "../../../control-ingreso/validar-sesion.php";

$bd = new Database();
$conexion = $bd->conectar();
$entriesPerPage = 5;
$documento = $_SESSION['document'];
$consulta = $conexion->prepare("SELECT (SELECT nombre FROM usuarios WHERE documento = coach AND venta_serv.id_serv = servicios.id_servicio) AS nombre_coach, fecha, desc_servicio, doc_client, nombre, precio FROM venta_serv, servicios, usuarios WHERE doc_client = documento AND venta_serv.id_serv = servicios.id_servicio");
$consulta->execute();



date_default_timezone_set('America/Bogota');
$fecha_actual = date('Y-m-d');
$docu = $_SESSION['name'];
?>

<?php
if (isset($_POST['boton_codigos'])) {
    echo '<script>window.location="lista-codigos.php"</script>';
}
?>

<?php
if (isset($_POST['boton_volver'])) {
    echo '<script>window.location="../index-admin.php"</script>';
}
?>

<?php
if (isset($_POST['btn_crear'])) {
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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->

    <!-- bootstrap sin internet -->
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <title>Servicios vendidos</title>
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
            <li class="nav-item">
                <a class="nav-link text-light p-3 dropdown-toggle"
                    href="../listar/listar-usuarios.php"><b>USUARIOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../listar/listar-roles.php"><b>ROLES</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../ventas/listar.php"><b>PRODUCTOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-bg-warning p-3" href="../servicios/lista_ventas_servicios.php"><b
                        style="color: white">SERVICIOS</b></a>
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
        </form>
        <form method="post">
            <h1 style="font-size:45px;color:white;">SERVICIOS VENDIDOS</h1>
            <a class="btn btn-success" href="vender_servicios.php">Vender servicio</button>
                <a style="float: right;" class="btn btn-primary" href="lista-servicios.php" role="button">Servicios
                    actuales</a>
        </form>
        <br>
        <div class="table-responsive">

            <table class="table table-bordered">
                <tr>
                    <th style="text-align: center;">Vendedor</th>
                    <th style="text-align: center;">Documento de cliente</th>
                    <th style="text-align: center;">Nombre de cliente</th>
                    <th style="text-align: center;">Fecha</th>
                    <th style="text-align: center;">Servicio</th>
                    <th style="text-align: center;">Total</th>
                </tr>
                <?php
                foreach ($consulta as $cons) {
                    ?>

                    <tr>
                        <td style="text-align: center;">
                            <?= $cons['nombre_coach'] ?>
                        </td>
                        <td style="text-align: center;">
                            <?= $cons['doc_client'] ?>
                        </td>
                        <td style="text-align: center;">
                            <?= $cons['nombre'] ?>
                        </td>
                        <td style="text-align: center;">
                            <?= $cons['fecha'] ?>
                        </td>
                        <td style="text-align: center;">
                            <?= $cons['desc_servicio'] ?>
                        </td>
                        <td style="text-align: center;">
                            <?= $cons['precio'] ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>

            </table>
            <div class="container text-center">
                <?php
                // Count the total number of entries
                $countQuery = $conexion->prepare("SELECT COUNT(*) FROM venta_serv INNER JOIN servicios ON venta_serv.id_serv = servicios.id_servicio INNER JOIN usuarios ON usuarios.documento = venta_serv.coach WHERE usuarios.documento = :coach");
                $countQuery->bindParam(':coach', $documento);
                $countQuery->execute();
                $totalEntries = $countQuery->fetchColumn();
                $totalPages = ceil($totalEntries / $entriesPerPage);
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                // Calculate the pagination offset
                $offset = ($page - 1) * $entriesPerPage;

                // Retrieve the paginated data
                $buscador = $conexion->prepare("SELECT usuarios.nombre AS nombre_coach, fecha, desc_servicio, doc_client, nombre, precio
                    FROM venta_serv
                    INNER JOIN servicios ON venta_serv.id_serv = servicios.id_servicio
                    INNER JOIN usuarios ON usuarios.documento = venta_serv.coach
                    WHERE usuarios.documento = :coach
                    LIMIT :limit OFFSET :offset");
                $buscador->bindParam(':coach', $documento);
                $buscador->bindParam(':limit', $entriesPerPage, PDO::PARAM_INT);
                $buscador->bindParam(':offset', $offset, PDO::PARAM_INT);
                $buscador->execute();

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
    </div>
</body>

</html>