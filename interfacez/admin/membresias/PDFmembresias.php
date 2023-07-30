<?php
ob_start();
?>
<?php
session_start();
require_once("../../../bd/conexion.php");
include "../../../control-ingreso/validar-sesion.php";
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion->prepare("SELECT (SELECT nombre FROM usuarios WHERE documento = membresias.doc_coach) AS nombre_coach, id_membresias, membresias.doc_cl ,usuarios.nombre, membresias.genero, membresias.fecha_inicio, membresias.fecha_fin, membresias.fecha_pago, membresias.discapacidad , estado.id_estado ,estado.estado FROM membresias INNER JOIN estado ON membresias.id_estado=estado.id_estado INNER JOIN usuarios ON usuarios.documento = membresias.doc_cl AND membresias.doc_coach");
$consulta->execute();
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

    <div class="container contenedor1">
            <h1>MEMBRESIAS</h1>
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
<?php
$html = ob_get_clean();
//echo $html;

require_once '../ventas/libreria/dompdf_1-0-2/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml("$html");

$dompdf->setPaper("letter");

$dompdf->render();

$dompdf->stream("membresias.pdf", array("Attachment" => true));
?>