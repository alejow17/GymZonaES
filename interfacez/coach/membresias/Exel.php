<?php
    header("content-Type: application/xls");
    header("content-Disposition: attachment; filename= lista_renovaciones.xls");
    session_start();
require_once("../../../bd/conexion.php");
include "../../../control-ingreso/validar-sesion.php";
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion->prepare("SELECT usuarios.*, renovaciones.* FROM usuarios JOIN renovaciones ON usuarios.documento = renovaciones.doc_cl");
$consulta->execute();
date_default_timezone_set('America/Bogota');
?>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="container contenedor1">
        <h1>LISTA RENOVACIONES</h1><br>
        <p>En caso de no ver las fechas en el reporte aumentar el tamaño de las columnas</p>
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
                foreach ($consulta as $cons) {
                ?>
                <tr style="text-align: center;">
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
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>