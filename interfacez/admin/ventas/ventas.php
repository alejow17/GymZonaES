<?php
session_start();
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();

// Paginación
$cantidad_registros = $conexion->query("SELECT COUNT(*) as total FROM ventas")->fetch()['total'];
$registros_por_pagina = 6;
$paginas_totales = ceil($cantidad_registros / $registros_por_pagina);

// Obtener página actual
$pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$pagina_actual = $pagina_actual < 1 ? 1 : $pagina_actual;
$pagina_actual = $pagina_actual > $paginas_totales ? $paginas_totales : $pagina_actual;

// Calcular el índice del primer registro de la página actual
$indice_primer_registro = ($pagina_actual - 1) * $registros_por_pagina;

$sentencia = $conexion->query("SELECT (SELECT nombre FROM usuarios WHERE documento = ventas.vendedor) AS vendedor,ventas.total, ventas.fecha, ventas.id, GROUP_CONCAT(productos.codigo, '..', productos.descripcion, '..', productos_vendidos.cantidad SEPARATOR '__') AS productos, nombre, ventas.doc_cliente FROM ventas INNER JOIN productos_vendidos ON productos_vendidos.id_venta = ventas.id INNER JOIN productos ON productos.id = productos_vendidos.id_producto INNER JOIN usuarios ON usuarios.documento = ventas.doc_cliente AND DATE(fecha) = CURDATE() GROUP BY ventas.id ORDER BY ventas.id DESC;");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if (isset($_POST['boton_volver'])) {
	echo '<script>window.location="../index-admin.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap sin internet-->
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="ventas.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <!--  mas opciones en la barra de navegabilidad -->
    <script src="jquery.min.js"></script>
    <script src="../../../css/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <title>VENTAS</title>

</head>

<body>
    <nav class="navega">
        <!-- el nav hace que todo quede en fila... el nav-tabs hace que se dividan las sesiones -->
        <!-- justify-contend-end que el menu quede al lado derecho de la pantalla -->
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
                <a class="nav-link text-light p-3 btn" aria-current="page"
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
                <a class="nav-link text-light p-3" href="../ventas/listar.php"><b
                        style="color: white; ">PRODUCTOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../servicios/lista_ventas_servicios.php"><b>SERVICIOS</b></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link active text-bg-warning p-3 dropdown-toggle" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <b style="color: white">VENTAS</b>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="ventas.php">Ventas diarias</a></li>
                    <li><a class="dropdown-item" href="ventasfecha.php">Ventas por fecha</a></li>
                    <li><a class="dropdown-item" href="ventas_por_cliente.php">Ventas por cliente</a></li>
                    <li><a class="dropdown-item" href="vender.php">Nueva venta</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../membresias/listar-membresias.php"><b>MEMBRESIAS</b></a>
            </li>
        </ul>
    </nav>
    <div class="col-xs-12 contenedor1">
        <form class="volver" method="post">
            <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
        </form>
        <h1 style="text-align: center;">VENTAS DIARIAS</h1>
        <br>
        <div id="datos_buscador" class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr style="text-align: center;">
                        <th>Vendedor</th>
                        <th>Documento cliente</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Productos vendidos</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($ventas as $venta) { ?>
                        <tr style="text-align: center;">
                            <td>
                                <?php echo $venta->vendedor ?>
                            </td>
                            <td>
                                <?php echo $venta->doc_cliente ?>
                            </td>
                            <td>
                                <?php echo $venta->nombre ?>
                            </td>
                            <td>
                                <?php echo $venta->fecha ?>
                            </td>
                            <td>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (explode("__", $venta->productos) as $productosConcatenados) {
                                            $producto = explode("..", $productosConcatenados)
                                                ?>
                                            <tr style="text-align: center;">

                                                <td>
                                                    <?php echo $producto[1] ?>
                                                </td>
                                                <td>
                                                    <?php echo $producto[2] ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <?php echo '$' . $venta->total ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($pagina_actual > 1): ?>
                        <li class="page-item"><a class="btn btn-warning" href="?pagina=<?= $pagina_actual - 1 ?>">Anterior</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $paginas_totales; $i++): ?>
                        <li class="page-item <?= $i === $pagina_actual ? 'active' : '' ?>">
                            <a class="btn btn-warning" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($pagina_actual < $paginas_totales): ?>
                        <li class="page-item"><a class="btn btn-warning" href="?pagina=<?= $pagina_actual + 1 ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <div class="descargas">
            <h3>REPORTE</h3>
            <a href="Exel.php" class="btn btn-success exel">EXEL</a>
            <a href="PDF.php" class="btn btn-danger">PDF</a>
        </div>
    </div>
    <script type="text/javascript">
        function buscar_ahora(buscar) {
            var parametros = {
                "buscar": buscar
            };
            $.ajax({
                data: parametros,
                type: 'POST',
                url: 'buscador.php',
                success: function (data) {
                    document.getElementById("datos_buscador").innerHTML = data;
                }
            });
        }
        //   buscar_ahora();
    </script>
</body>
</html>