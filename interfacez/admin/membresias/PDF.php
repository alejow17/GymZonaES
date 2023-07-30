<?php
ob_start();
?>

<?php
session_start();
require_once("../../../bd/conexion.php");
include "../../../control-ingreso/validar-sesion.php";
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion->prepare("SELECT usuarios.*, renovaciones.* FROM usuarios JOIN renovaciones ON usuarios.documento = renovaciones.doc_cl");
$consulta->execute();
date_default_timezone_set('America/Bogota');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
</head>

<body>
    <div class="container contenedor1">
        <h1>LISTA RENOVACIONES</h1><br>
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

$dompdf->stream("renovaciones.pdf", array("Attachment" => true));
?>