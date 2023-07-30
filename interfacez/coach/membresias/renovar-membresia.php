<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";
date_default_timezone_set('America/Bogota');

?>

<?php
if (isset($_POST['btn_volver'])) {
    echo '<script>window.location="../membresias/listar-membresias.php"</script>';
}
?>

<?php
if (isset($_GET['renov'])) {
    $id = $_GET['renovar'];
    $consulta2 = $conexion->prepare("SELECT * FROM renovaciones, usuarios WHERE doc_cl = '$id' AND doc_cl = documento ORDER BY id_renovar DESC LIMIT 1");
    $consulta2->execute();
    $cons = $consulta2->fetch();
    $datestatement = $cons['fecha_fin'];
    $extrarenov = date('Y-m-d', strtotime("$datestatement +1 month"));

    if (isset($_POST['btn_actu'])) {
        $doc_cl = $_POST['doc_cl'];
        $fecha_ini = $_POST['fecha_ini'];
        $fecha_final = $_POST['fecha_fin'];
        $fecha_pago = $_POST['fecha_pago'];

        $consultar = $conexion->prepare("UPDATE membresias SET fecha_inicio='$fecha_ini', fecha_fin='$extrarenov', fecha_pago='$datestatement', id_estado=1 WHERE doc_cl='$doc_cl'");
        $consultar->execute();
        $consulta4 = $conexion->prepare("INSERT INTO renovaciones (doc_cl, fecha_ini, fecha_fin, fecha_pago) VALUES ('$doc_cl','$fecha_ini','$fecha_final','$fecha_pago')");
        $consulta4->execute();
        echo '<script>alert ("Membresia renovada con exito");</script>';
        echo '<script>window.location="../membresias/listar-membresias.php"</script>';
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->

        <!-- bootstrap sin internet -->
        <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../listar/listar-usuarios.css">
        <!-- favicon -->
        <link rel="icon" href="../../../img/logo-zona-gym.png">
        <title>Renovar</title>
    </head>

    <body>
        <div class="container contenedor1">
            <form method="post">
                <button value="Atras" name="btn_volver" class="btn btn-danger">Atras</button>
            </form>
            <h1>RENOVAR</h1>
            <br>
            <form method="post">
                <div class="form-group">
                    <input type="hidden" name="doc_cl" value="<?php echo $cons['doc_cl'] ?>">
                    <input placeholder="Documento del cliente" class="form-control" id="inicio" readonly
                        value="<?php echo $cons['nombre'] ?>" required>
                </div>
                <br>
                <div class="form-group">
                    <h6 style="color:white;">FECHA INICIO</h6>
                    <input placeholder="Fecha de inico" class="form-control" id="inicio" name="fecha_ini" readonly
                        value="<?php echo $cons['fecha_fin'] ?>" required>
                </div>
                <br>
                <div class="form-group">
                    <h6 style="color:white;">FECHA FIN</h6>
                    <input placeholder="Fecha de inico" class="form-control" id="inicio" name="fecha_fin" readonly
                        value="<?php echo $extrarenov ?>" required>
                </div>
                <br>
                <div class="form-group">
                    <h6 style="color:white;">FECHA DE PAGO (YYYY-MM-DD)</h6>
                    <input type="text" placeholder="Fecha de inico" class="form-control" id="inicio" name="fecha_pago"
                        value="<?php echo $datestatement ?>" pattern="\d{4}-\d{2}-\d{2}" required>
                </div>
                <br>
                <div class="form-group">
                    <button style="float: center;" type="submit" value="btn_actu" name="btn_actu"
                        class="btn btn-warning boton-registrar">Renovar</button>
                </div>
        </div>
        </form>
        <?php
}
?>
</body>

</html>