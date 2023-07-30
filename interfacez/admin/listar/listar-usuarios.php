<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";

// Pagination variables
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$entriesPerPage = 5;
$offset = ($page - 1) * $entriesPerPage;
$consulta = $conexion->prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_roles=roles.id_roles WHERE usuarios.documento!=0987654321 AND usuarios.id_roles<3 LIMIT $offset, $entriesPerPage");
$consulta->execute();

if (isset($_POST['boton_volver'])) {
    echo '<script>window.location="../index-admin.php"</script>';
}

// Función para cambiar el estado de un usuario bloqueado a activo
if (isset($_GET['cambiar_estado']) && $_GET['cambiar_estado'] == 1) {
    $documento = $_GET['documento'];

    $cambiarEstado = $conexion->prepare("UPDATE usuarios SET id_estado_login = 2 WHERE documento = :documento");
    $cambiarEstado->bindParam(':documento', $documento);
    $cambiarEstado->execute();
} elseif (isset($_GET['cambiar_estado']) && $_GET['cambiar_estado'] == 2) {
    $documento = $_GET['documento'];

    $cambiarEstado = $conexion->prepare("UPDATE usuarios SET id_estado_login = 1 WHERE documento = :documento");
    $cambiarEstado->bindParam(':documento', $documento);
    $cambiarEstado->execute();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Boobtstrap-->
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="listar-usuarios.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <!--  mas opciones en la barra de navegabilidad -->
    <script src="jquery.min.js"></script>
    <script src="../../../css/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <title>Lista de Usuarios</title>
</head>

<body>
    <nav class="navega">
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
            <h1>LISTA DE USUARIOS</h1>
        </form>
        <br>
        <table class="table table-bordered">
            <tr style="text-align: center;">
                <th style="text-align: center;">Documento</th>
                <th style="text-align: center;">Nombre</th>
                <th style="text-align: center;">Nacimiento</th>
                <th style="text-align: center;">Usuario</th>
                <th style="text-align: center;">Tipo de usuario</th>
                <th style="text-align: center;">Estado</th>
                <th style="text-align: center;">Acción</th>
                <th style="text-align: center;">Eliminar</th>
                <th style="text-align: center;">Editar</th>
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
                        <?= $cons['nacimiento'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $cons['usuario'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?= $cons['roles'] ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if ($cons['id_estado_login'] == 1) {
                            echo '<span class="text-danger">Inactivo</span>';
                        } else if ($cons['id_estado_login'] == 2) {
                            echo '<span class="text-success">Activo</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($cons['id_estado_login'] == 1) {
                            // Botón para cambiar el estado de bloqueado a activo
                            echo '<a class="btn btn-success btn-sm" href="?cambiar_estado=1&documento=' . $cons['documento'] . '" onclick="return confirm(\'¿Está seguro de cambiar el estado a activo?\')">Activar</a>';
                        } else if ($cons['id_estado_login'] == 2) {
                            // Botón para cambiar el estado de activo a inactivo
                            echo '<a class="btn btn-danger btn-sm" href="?cambiar_estado=2&documento=' . $cons['documento'] . '" onclick="return confirm(\'¿Está seguro de cambiar el estado a inactivo?\')">Desactivar</a>';
                        }
                        ?>
                    </td>
                    <td>
                        <form action="../eliminar/eliminar_usuarios.php" method="get">
                            <input type="hidden" name="eliminar" value="<?= $cons['documento'] ?>">
                            <button class="btn btn-danger botones" type="submit"
                                onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                                <img style="width:30px;" src="../../../iconos/delete.png" alt="borrar">
                            </button>
                        </form>

                    </td>
                    <td>
                        <form action="../actualizar/actualizar-usuarios.php" method="get">
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
            $totalEntries = $conexion->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
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
    <script>
    // Función para cambiar el estado de un usuario y refrescar la página
    function cambiarEstadoUsuario(cambiar_estado, documento) {
        const confirmMessage = (cambiar_estado === 1) ? '¿Está seguro de cambiar el estado a activo?' : '¿Está seguro de cambiar el estado a inactivo?';
        if (confirm(confirmMessage)) {
            // Realiza una solicitud al servidor para cambiar el estado
            fetch(`?cambiar_estado=${cambiar_estado}&documento=${documento}`)
                .then(response => response.text())
                .then(data => {
                    // Verifica que la respuesta sea válida (1 o 2)
                    if (data === '1' || data === '2') {
                        // Actualiza el estado en la tabla sin recargar la página
                        const estadoCell = document.querySelector(`td[data-documento="${documento}"] span`);
                        if (data === '1') {
                            estadoCell.textContent = 'Inactivo';
                            estadoCell.classList.remove('text-success');
                            estadoCell.classList.add('text-danger');
                        } else if (data === '2') {
                            estadoCell.textContent = 'Activo';
                            estadoCell.classList.remove('text-danger');
                            estadoCell.classList.add('text-success');
                        }
                        // Refresca la página después de cambiar el estado
                        location.reload();
                    } else {
                        // Maneja una respuesta inválida del servidor (opcional)
                        console.error('Respuesta inválida del servidor:', data);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>
</body>

</html>