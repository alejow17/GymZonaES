<?php
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";
date_default_timezone_set('America/Bogota');
?>

<?php
if (isset($_POST['boton_volver'])) {
    echo '<script>window.location="lista_ventas_servicios.php"</script>';
}
?>

<?php
$consulta = $conexion->prepare("SELECT * FROM usuarios where id_roles = 3");
$consulta->execute();

$servicios = $conexion->prepare("SELECT * FROM servicios");
$servicios->execute();
$selectserv = $servicios->fetch();
$fecha_actual = date('Y-m-d');

$selectcoach = $conexion->prepare("SELECT * FROM usuarios WHERE id_roles < 3");
$selectcoach->execute();
$selectresult = $selectcoach->fetch();


?>

<?php
if ((isset($_POST["btn-registrar"]))) {

    $coach = $_SESSION['document'];
    $servicio = $_POST['servicio'];
    $doc_client = $_POST['doc_client'];

    if ($fecha_actual == "" || $coach == "" || $servicio == "" || $doc_client == "") {
        echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
        echo '<script>windows.location="vender_servicios.php"</script>';
    } else {
        $consulta3 = $conexion->prepare("INSERT INTO venta_serv (fecha, coach, id_serv, doc_client) VALUES ('$fecha_actual','$coach', '$servicio','$doc_client')");
        $consulta3->execute();
        echo '<script>alert ("Registro exitoso, gracias");</script>';
        echo '<script>window.location="lista_ventas_servicios.php"</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

    <!-- bootstrap sin internet -->
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../crear/crear-usuarios.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <title>Venta servicio</title>
</head>

<body>
    <div class="form-container">
        <form class="volver" method="post">
            <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
        </form>
        <h2 class="titulo" style="font-size: 45px;">VENTA DE SERVICIOS</h2><br>
        <form method="post">
            <div class="form-group input-group">
                <span class="input-group-text">Fecha de compra</span>
                <input type="text" autocomplete="off" placeholder="" value="<?php echo $fecha_actual ?>" class="form-control" name="fecha" readonly>
            </div><br>
            <div class="form-group">
    <select required class="form-select" name="servicio">
        <option value="">Seleccione servicio</option>
        <?php
        do {
            $precio = $selectserv['precio'];
        ?>
            <option value="<?php echo ($selectserv['id_servicio']) ?>"><?php echo ($selectserv['desc_servicio'] . " - $" . $precio) ?></option>
        <?php
        } while ($selectserv = $servicios->fetch());
        ?>
    </select>
</div>
            <br>
            <div class="form-group">
                <select class="form-select" required class="select" name="doc_client">
                    <option disabled selected value="">Seleccione cliente</option>
                    <?php
                    $consul = $consulta->fetch();
                    if ($consul) {
                        do {
                    ?>
                            <option value="<?php echo ($consul['documento']) ?>"><?php echo ($consul['nombre']) ?></option>
                        <?php
                        } while ($consul = $consulta->fetch());
                    } else {
                        ?>
                        <option value="" disabled>No hay usuarios</option>
                    <?php
                    }
                    ?>
                </select>

            </div>
            <br><br>
            <button type="submit" value="registrar" name="btn-registrar" class="btn btn-warning boton-registrar">Registrar</button>
        </form>
    </div>
</body>
<script>
    function mayuscula(e) {
        e.value = e.value.toUpperCase();
    }

    function minuscula(e) {
        e.value = e.value.toLowerCase();
    }

    function numeros(e) {
        e.value = e.value.replace(/[^0-9\.]/g, '');
    }

    function espacios(e) {
        e.value = e.value.replace(/ /g, '');
    }
</script>

</html>