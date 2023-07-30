<?php
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
session_start();
include('../../../control-ingreso/validar-sesion.php');
date_default_timezone_set('America/Bogota');
$fecha_actual = date('Y-m-d H:i:s');
$fecha_fin = date('Y-m-d H:i:s', strtotime('next month'));
$docu = $_SESSION['document'];
?>

<?php
$cliente = $conexion->prepare("SELECT documento, nombre FROM usuarios WHERE id_roles = 3");
$cliente->execute();
$selectcliente = $cliente->fetchAll();
?>

<?php
if (isset($_POST['boton_volver'])) {
    echo '<script>window.location="../membresias/listar-membresias.php"</script>';
}
?>

<?php
if ((isset($_POST["btn-registrar"]))) {
    $doc_cl = $_POST['documento'];
    $genero = $_POST['genero'];
    $discapacidad = $_POST['discapacidad'];

    $consulta1 = $conexion->prepare("SELECT * FROM membresias WHERE doc_cl= '$doc_cl'");
    $consulta1->execute();
    $consull = $consulta1->fetch();

    if ($consull) {
        echo '<script>alert ("DOCUMENTO O USUARIO EXISTEN //CAMBIELOS//");</script>';
        echo '<script>windows.location="registrousu.php"</script>';
    } else {
        $consulta3 = $conexion->prepare("INSERT INTO membresias (doc_coach, doc_cl, genero, fecha_inicio, fecha_fin, fecha_pago, id_estado, discapacidad) VALUES ('$docu' ,'$doc_cl','$genero','$fecha_actual','$fecha_fin', '$fecha_actual',1, '$discapacidad')");
        $consulta3->execute();
        $consulta4 = $conexion->prepare("INSERT INTO renovaciones (doc_cl, fecha_ini, fecha_fin, fecha_pago) VALUES ('$doc_cl','$fecha_actual','$fecha_fin','$fecha_actual')");
        $consulta4->execute();
        echo '<script>alert ("Registro exitoso, gracias");</script>';
        echo '<script>window.location="../membresias/listar-membresias.php"</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->

    <!-- bootstrap sin internet -->
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../crear/crear-usuarios.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <title>Nueva Membresia</title>
</head>

<body>
    <div class="form-container">
        <form class="volver" method="post">
            <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
        </form>
        <h2 class="titulo1">NUEVA MEMBRESIA</h2>
        <form method="post" autocomplete="off">
            <div>
                <select name="documento" class="form-select" aria-label="Genero" required>
                    <option selected disabled value="">Seleccione el cliente</option>
                    <?php foreach ($selectcliente as $clientes) { ?>
                        <option value="<?php echo $clientes['documento'] ?>"><?php echo $clientes['nombre'] ?></option>
                    <?php } ?>
                </select>
            </div><br>
            <div class="">
                <select name="genero" class="form-select" aria-label="Genero" required>
                    <option selected disabled value="">Genero</option>
                    <option value="hombre">Hombre</option>
                    <option value="mujer">Mujer</option>
                    <option value="otro">Otro</option>
                </select>
            </div><br>
            <div name="discapacidad" class="input-group">
                <span class="input-group-text">Discapacidades</span>
                <textarea name="discapacidad" class="form-control" aria-label="Discapacidades"></textarea>
                    </div>
            <div class="form-group">
                <label style="text-align:center;color:white;">Fecha de pago</label>
                <input placeholder="Fecha de inico" class="form-control" id="inicio" name="inicio" readonly
                    value="<?php echo $fecha_actual ?>" required>
            </div>
            <div class="row g-3">
                <div class=" col">
                <label style="margin-left:10%;text-align:center;color:white;">Fecha de Inicio</label>
                    <input placeholder="Fecha de inico" class="form-control" id="inicio" name="inicio" readonly
                        value="<?php echo $fecha_actual ?>" required>
                </div>
                <br>
                <div class="form-group col">
                    <label style="margin-left:10%;text-align:center;color:white;">Fecha de vencimiento</label>
                    <input placeholder="Fecha de vencimiento" class="form-control" id="vencimiento" name="vencimiento"
                        value="<?php echo $fecha_fin ?>" readonly required>
                </div>
            </div><br><br>
            <button type="submit" value="registrar" name="btn-registrar"
                class="btn btn-warning boton-registrar">Registrar</button>
        </form>
    </div>
</body>

</html>