<?php
session_start();
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();

// Paginación
$cantidad_registros = $conexion->query("SELECT COUNT(*) as total FROM ventas")->fetch()['total'];
$registros_por_pagina = 5;
$paginas_totales = ceil($cantidad_registros / $registros_por_pagina);

// Obtener página actual
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina_actual = $pagina_actual < 1 ? 1 : $pagina_actual;
$pagina_actual = $pagina_actual > $paginas_totales ? $paginas_totales : $pagina_actual;

// Calcular el índice del primer registro de la página actual
$indice_primer_registro = ($pagina_actual - 1) * $registros_por_pagina;



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
    <!-- bootstrap -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->

    <!-- bootstrap sin internet -->
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./ventas.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <!--  mas opciones en la barra de navegabilidad -->
    <script src="jquery.min.js"></script>
    <script src="../../../css/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>

    <title>Ventar Por Fecha</title>
</head>

<body>
    <nav class="navega">
        <!-- el nav hace que todo quede en fila... el nav-tabs hace que se dividan las sesiones -->
        <!-- justify-contend-end que el menu quede al lado derecho de la pantalla -->
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
                <a class="nav-link text-light p-3 btn" aria-current="page" href="../../admin/index-admin.php"><b>MENU</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../listar/listar-usuarios.php"><b>USUARIOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../listar/listar-roles.php"><b>ROLES</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../ventas/listar.php"><b style="color: white; ">PRODUCTOS</b></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light p-3" href="../servicios/lista_ventas_servicios.php"><b>SERVICIOS</b></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link active text-bg-warning p-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
    <!--
    $rutaEnServidor='../../carpeta'
    $rutaTemporal=$_FILES['imagen']['tmp_name'];
    $nombreImagen=$_FILES['imagen']['name'];
    $rutaDestino=$rutaEnServidor.'/'.$nombreImagen;
    move_uploaded_file($rutaTemporal,$rutaDestino) 
-->
    <div class="col-xs-12 contenedor1">
        <form class="volver" method="post">
            <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
        </form>
        <h1 style="text-align: center;">VENTAS POR FECHA</h1>

        <div class=" mt-5">
            <div class="">
                <h5 style="color: white;" >BUSQUE SUS VENTAS ENTRE SUS FECHAS</h5>
            </div><br>
            <form action="" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Desde</label>
                            <input type="date" name="from_date" value="<?php if (isset($_GET['from_date'])) {
                                                                            echo $_GET['from_date'];
                                                                        } ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Hasta</label>
                            <input type="date" name="to_date" value="<?php if (isset($_GET['to_date'])) {
                                                                            echo $_GET['to_date'];
                                                                        } ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <br>
                            <button type="submit" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
                    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                        $from_date = $_GET['from_date'];
                        $to_date = $_GET['to_date'];
                        $sentencia = $conexion->prepare("SELECT 
                            (SELECT nombre FROM usuarios WHERE documento = ventas.vendedor) AS vendedor, 
                            nombre, 
                            doc_cliente, 
                            ventas.total, 
                            ventas.fecha, 
                            ventas.id, 
                            GROUP_CONCAT(productos.codigo, '..', productos.descripcion, '..', productos_vendidos.cantidad SEPARATOR '__') AS productos 
                            FROM ventas 
                            INNER JOIN productos_vendidos ON productos_vendidos.id_venta = ventas.id 
                            INNER JOIN productos ON productos.id = productos_vendidos.id_producto 
                            INNER JOIN usuarios ON usuarios.documento = ventas.doc_cliente 
                            AND fecha >= '$from_date 00:00:00' AND fecha <= '$to_date 23:59:59'
                            GROUP BY ventas.id 
                            ORDER BY ventas.id 
                            LIMIT :inicio, :registros_por_pagina");
                        $sentencia->bindParam(':inicio', $indice_primer_registro, PDO::PARAM_INT);
                        $sentencia->bindParam(':registros_por_pagina', $registros_por_pagina, PDO::PARAM_INT);
                        $sentencia->execute();
                        $ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);

                        if ($sentencia->execute()) {
                            foreach ($ventas as $venta) {
                    ?>
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
                    <?php
                            }
                        } else {
                            echo "No se encontro la busqueda.";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="descargas">
            <h3>REPORTE</h3>
            <a href="Exel.php" class="btn btn-success exel">EXCEL</a>
            <a href="PDF.php" class="btn btn-danger">PDF</a>
        </div>
    </div>
    <script type="text/javascript">
        function buscar_ahora(buscar) {
            var parametros = {
                "buscar": buscar
            };
            var parametros = {
                "buscar1": buscar1
            };
            $.ajax({
                data: parametros,
                type: 'POST',
                url: 'buscadorfecha.php',
                success: function(data) {
                    document.getElementById("datos_buscador").innerHTML = data;
                }
            });
        }
        //   buscar_ahora();
    </script>
</body>

</html>