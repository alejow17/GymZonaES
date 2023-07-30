<?php
ob_start();
?>

<?php
require_once("../../../bd/conexion.php");
session_start();
include "../../../control-ingreso/validar-sesion.php";

$bd = new Database();
$conexion = $bd->conectar();
$documento = $_SESSION['document'];
$consulta = $conexion->prepare("SELECT (SELECT nombre FROM usuarios WHERE documento = $documento) AS nombre_coach, fecha, desc_servicio, doc_client, nombre, precio FROM venta_serv, servicios, usuarios WHERE doc_client = documento AND venta_serv.id_serv = servicios.id_servicio");
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
    <div class="container contenedor1">
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
        </div>
    </div>
</body>

</html>
<?php
    $html=ob_get_clean();
    //echo $html;

    require_once'../ventas/libreria/dompdf_1-0-2/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    $dompdf ->setOptions($options);

    $dompdf->loadHtml("$html");

    $dompdf->setPaper("letter");

    $dompdf->render();

    $dompdf->stream("listar_usuarios.pdf", array("Attachment" => true));
?>