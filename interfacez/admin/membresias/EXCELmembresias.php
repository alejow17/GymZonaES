<?php
    header("content-Type: application/xls");
    header("content-Disposition: attachment; filename= lista_membresias.xls");
    session_start();
require_once("../../../bd/conexion.php");
include "../../../control-ingreso/validar-sesion.php";
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion->prepare("SELECT (SELECT nombre FROM usuarios WHERE documento = membresias.doc_coach) AS nombre_coach, id_membresias, membresias.doc_cl ,usuarios.nombre, membresias.genero, membresias.fecha_inicio, membresias.fecha_fin, membresias.fecha_pago, membresias.discapacidad , estado.id_estado ,estado.estado FROM membresias INNER JOIN estado ON membresias.id_estado=estado.id_estado INNER JOIN usuarios ON usuarios.documento = membresias.doc_cl AND membresias.doc_coach");
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
            <h1>MEMBRESIAS</h1>
        <br>
        <h2>Si las fechas no se muestran por favor expanda las columnas</h2>
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
                        <td style="width:90px;text-align: center; background-color: <?= $color ?>;"><?= $cons['estado'] ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>