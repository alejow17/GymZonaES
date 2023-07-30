<?php
session_start();
require_once("../../../bd/conexion.php");
include "../../../control-ingreso/validar-sesion.php";
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion->prepare("SELECT usuarios.*, renovaciones.* FROM usuarios JOIN renovaciones ON usuarios.documento = renovaciones.doc_cl");
$consulta->execute();
date_default_timezone_set('America/Bogota');

// Definimos el tamaño de cada página
$tamano_pagina = 10;

// Obtenemos el número de página actual
if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
} else {
    $pagina = 1;
}

// Obtenemos el número total de resultados
$total_resultados = $consulta->rowCount();

// Calculamos el número total de páginas
$total_paginas = ceil($total_resultados / $tamano_pagina);

// Calculamos el índice del primer resultado en la página actual
$indice_primer_resultado = ($pagina - 1) * $tamano_pagina;

// Preparamos la consulta con la paginación
$consulta_paginada = $conexion->prepare("SELECT usuarios.*, renovaciones.* FROM usuarios JOIN renovaciones ON usuarios.documento = renovaciones.doc_cl LIMIT :inicio, :tamano");
$consulta_paginada->bindParam(":inicio", $indice_primer_resultado, PDO::PARAM_INT);
$consulta_paginada->bindParam(":tamano", $tamano_pagina, PDO::PARAM_INT);
$consulta_paginada->execute();
?>

<?php
if (isset($_POST['boton_volver'])) {
    echo '<script>window.location="listar-membresias.php"</script>';
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
    <script src="jquery.min.js"></script>
    <title>LISTA RENOVACIONES</title>
</head>

<body>
    <div class="container contenedor1">
        <form class="volver" method="post">
            <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
        </form>
        <h1>LISTA RENOVACIONES</h1><br>
        <div class="mb-3">

            <input type="hidden" class="form-control" id="buscar" name="buscar">

            <label class="form-label">Escriba el nombre del usuario a buscar</label>
            <input onkeyup="buscar_ahora($('#buscar_1').val());" type="text" class="form-control" id="buscar_1" name="buscar_1">
            <br>
            <button class="btn btn-primary" onclick="buscar_ahora($('#buscar').val());">Mostrar todos</button>

        </div>
        <div id="datos_buscador" class="table-responsive">
            <table class="table table-bordered">
                <tr style="text-align: center;">
                    <th style="text-align: center;">Documento</th>
                    <th style="text-align: center;">Nombre</th>
                    <th style="text-align: center;">Fecha de inicio</th>
                    <th style="text-align: center;">Fecha de vencimiento</th>
                    <th style="text-align: center;">Fecha de pago</th>
                </tr>
                <?php
                foreach ($consulta_paginada as $cons) {
                ?>

                    <td style="width:90px;text-align: center;">
                        <?= $cons['doc_cl'] ?>
                    </td>
                    <td style="width:90px;text-align: center;">
                        <?= $cons['nombre'] ?>
                    </td>
                    <td style="width:100px;text-align: center;">
                        <?= $cons['fecha_ini'] ?>
                    </td>
                    <td style="width:90px;text-align: center;">
                        <?= $cons['fecha_fin'] ?>
                    </td>
                    <td style="width:90px;text-align: center;">
                        <?= $cons['fecha_pago'] ?>
                    </td>
                    <tr style="text-align: center;">
                    </tr>
                <?php
                }
                ?>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($pagina > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $pagina - 1 ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Anterior</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                        <li class="page-item <?php if ($i == $pagina) : ?>active<?php endif; ?>">
                            <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($pagina < $total_paginas) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?pagina=<?= $pagina + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Siguiente</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
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
                url: 'buscador_renov.php',
                success: function(data) {
                    document.getElementById("datos_buscador").innerHTML = data;
                }
            });
        }
        //   buscar_ahora();
    </script>
</body>

</html>