<?php
session_start();
require_once("../../../bd/conexion.php");
include "../../../control-ingreso/validar-sesion.php";
$bd = new Database();
$conexion = $bd->conectar();
// Pagination variables
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$entriesPerPage = 5;
$offset = ($page - 1) * $entriesPerPage;
$consulta = $conexion->prepare("SELECT (SELECT nombre FROM usuarios WHERE documento = membresias.doc_coach) AS nombre_coach, id_membresias, membresias.doc_cl ,usuarios.nombre, membresias.genero, membresias.fecha_inicio, membresias.fecha_fin, membresias.fecha_pago, membresias.discapacidad , estado.id_estado ,estado.estado FROM membresias INNER JOIN estado ON membresias.id_estado=estado.id_estado INNER JOIN usuarios ON usuarios.documento = membresias.doc_cl AND membresias.doc_coach LIMIT $offset, $entriesPerPage");
$consulta->execute();
$countQuery = $conexion->query("SELECT COUNT(*) FROM membresias");
$totalEntries = $countQuery->fetchColumn();
$totalPages = ceil($totalEntries / $entriesPerPage);
$consulta2 = $conexion->prepare("SELECT * FROM renovaciones, usuarios WHERE doc_cl = documento ORDER BY id_renovar DESC LIMIT 1");
$consulta2->execute();
$cons = $consulta2->fetch();

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

<?php
$query = "UPDATE membresias SET id_estado=2 WHERE fecha_fin < '$fecha_actual' AND id_estado = 1";
$stmt = $conexion->query($query);
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
    <!-- mas opciones en la barra de navegabilidad -->
    <script src="jquery.min.js"></script>

    <title>Membresias</title>

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
                <a class="nav-link text-light p-3" href="../servicios/lista_ventas_servicios.php"><b>SERVICIOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3 dropdown-toggle" href="../ventas/ventas.php"><b>VENTAS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active text-bg-warning p-3" href="../membresias/listar-membresias.php"><b
                        style="color: white">MEMBRESIAS</b></a>
            </li>
        </ul>
    </nav>

    <div class="container contenedor1">
        <form class="volver" method="post">
            <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
        </form>
        <form method="post">
            <h1>MEMBRESIAS</h1>
            <button value="Atras" name="btn_crear" class="btn btn-success">Crear</button>
            <a style="float:right;" class="btn btn-primary" href="lista-renovaciones.php">LISTA RENOVACIONES</a>
        </form>
        <div class="mb-3">

            <input type="hidden" class="form-control" id="buscar" name="buscar">

            <label class="form-label">Que usuario quiere ver?</label>
            <input autofocus onkeyup="buscar_ahora($('#buscar_1').val());" type="text" class="form-control"
                id="buscar_1" name="buscar_1">
            <br>
            <button class="btn btn-primary" onclick="buscar_ahora($('#buscar').val());">Mostrar todos</button>

        </div>
        <br>
        <div id="datos_buscador" class="table-responsive">
            <table class="table table-bordered">
                <tr style="text-align: center;">
                    <th style="text-align: center;">Coach</th>
                    <th style="text-align: center;">Nombre</th>
                    <th style="text-align: center;">Fecha de inicio</th>
                    <th style="text-align: center;">Fecha de vencimiento</th>
                    <th style="text-align: center;">Fecha de pago</th>
                    <th style="text-align: center;">Estado</th>
                    <th style="text-align: center;" colspan="4">Accion</th>
                </tr>
                <?php
                foreach ($consulta as $cons) {
                    // Verificar el valor de id_estado
                    if ($cons['id_estado'] == 1) {
                        $color = 'rgb(6, 213, 0)'; // Verde si es estado 1
                    } else {
                        $color = 'rgb(209, 0, 0)'; // Rojo si es estado 2
                    }
                    ?>

                    <tr style="text-align: center;">
                        <td style="width:90px;text-align: center;">
                            <?= $cons['nombre_coach'] ?>
                        </td>
                        <td style="width:90px;text-align: center;">
                            <?= $cons['nombre'] ?>
                        </td>
                        <td style="width:100px;text-align: center;">
                            <?= $cons['fecha_inicio'] ?>
                        </td>
                        <td style="width:90px;text-align: center;">
                            <?= $cons['fecha_fin'] ?>
                        </td>
                        <td style="width:90px;text-align: center;">
                            <?= $cons['fecha_pago'] ?>
                        </td>
                        <td style="width:90px;text-align: center; background-color: <?= $color ?>;"><?= $cons['estado'] ?>
                        </td>
                        <td style="width:30px;text-align:center;">
                            <form action="../datos/lista-datos.php" method="get">
                                <input type="hidden" name="datos" value="<?= $cons['doc_cl'] ?>">
                                <button type="submit" class="btn btn-warning"><img style="width:30px;"
                                        src="../../../iconos/waist.png" alt="medidas"></button>
                            </form>
                        </td>
                        <td style="width:30px; text-align:center;">
                            <form action="../membresias/renovar-membresia.php" method="get">
                                <input type="hidden" name="renovar" value="<?= $cons['doc_cl'] ?>">
                                <button name="renov" class="btn btn-success" type="submit"><img style="width:30px;"
                                        src="../../../iconos/hand.png" alt="renovar"></button>
                            </form>
                        </td>
                        <td style="width:30px; text-align:center;">
                            <form action="../membresias/eliminar-membresia.php" method="get">
                                <input type="hidden" name="eliminar" value="<?= $cons['id_membresias'] ?>">
                                <button class="btn btn-danger" type="submit"><img style="width:30px;"
                                        src="../../../iconos/delete.png" alt="borrar"></button>
                            </form>
                        </td>
                        <td style="width:30px; text-align:center;">
                            <form action="codigo-usuario-barras.php" method="get">
                                <input type="hidden" name='doc' value="<?= $cons['doc_cl'] ?>">
                                <button name="boton-imprimir" class="btn btn-light" type="submit"><img style="width:30px;"
                                        src="../../../iconos/barcode.png" alt="codigo_barras"></button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <div class="container text-center">
                <?php
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
            <div style="float: right;" class="descargas">
                <h3>REPORTE</h3>
                <a href="EXCELmembresias.php" class="btn btn-success exel">EXCEL</a>
                <a href="PDFmembresias.php" class="btn btn-danger">PDF</a>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    function buscar_ahora(buscar) {
        var parametros = { "buscar": buscar };
        $.ajax({
            data: parametros,
            type: 'POST',
            url: 'buscador.php',
           
        });
    }
     //   buscar_ahora();
</script>

</html>