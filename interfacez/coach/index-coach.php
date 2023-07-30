<?php
require_once("../../bd/conexion.php");
session_start();
include("../../control-ingreso/validar-sesion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
$sesion = $_SESSION['roles'];
$icono = $conexion->prepare("SELECT * FROM roles WHERE id_roles='$sesion'");
$icono->execute();
$iconos = $icono->fetch();

$consulta1 = $conexion->prepare("SELECT * FROM usuarios,roles WHERE usuarios.id_roles=roles.id_roles");
$consulta1->execute();
$consul = $consulta1->fetch();
?>

<?php
if ($_SESSION['roles'] !=2){
    session_destroy();
    header('location:../../index.html');
    exit;
}
?>

<?php
if (isset($_POST['btncerrar'])) {
    session_destroy();
    header('location:../../index.html');
}
?>

<?php
if (isset($_POST['cambiar_contra'])) {
    session_start();
    header('location:cambiar_contra.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Coach</title>
    <!-- bootstrap sin internet -->
    <link rel="stylesheet" href="../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <!-- favicon -->
    <link rel="icon" href="../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="index-coach.css">
</head>

<body>
    <div class="botones">
        <form method="POST">
            <tr>
                <td colspan="2" text-align="center">
                    <input class="btn btn-danger" type="submit" value="Cerrar sesion" name="btncerrar" />
                </td>
            </tr>
        </form>
        <br>
        <form action="cambiar-contra.php" method="POST">
            <input type="hidden" value=<?= $consul['documento'] ?> name="documento" />
            <button class="btn btn-danger" type="submit">Cambiar contraseña</button>
        </form>
    </div>
    <h1>MENU COACH <img style="width: 80px;" src="../admin/crear/<?php echo$iconos['imagen']?>"></img></h1>
    <div class="container my-center contenedor1">
        <!-- División 1 -->
        <div class="row my-4">
            <div class="col-md-6 text-center">
                <a style="text-decoration: none;" href="listar/listar-usuarios.php">
                    <div class="fondo-hover">
                        <img src="../../img/usuarios.png" alt="Imagen de ejemplo">
                        <h2>USUARIOS</h2>
                    </div>
                </a>
            </div>
            <!-- División 2 -->
            <div class="col-md-6 text-center">
                <a style="text-decoration: none;" href="servicios/lista_ventas_servicios.php">
                    <div class="fondo-hover">
                        <img src="../../iconos/zumba.png" alt="Imagen de ejemplo">
                        <h2>SERVICIOS</h2>
                    </div>
                </a>
            </div>
            <!-- División 3 -->
        </div>
        <!-- División 4 -->
        <div class="row my-4">
            <div class="col-md-4 text-center">
                <a style="text-decoration: none;" href="ventas/listar.php">
                    <div class="fondo-hover">
                        <img src="../../img/productos.png" alt="Imagen de ejemplo">
                        <h2>PRODUCTOS</h2>
                    </div>
                </a>
            </div>
            <!-- División 5 -->
            <div class="col-md-4 text-center">
                <a style="text-decoration: none;" href="ventas/ventas.php">
                    <div class="fondo-hover">
                        <img src="../../img/ventas.png" alt="Imagen de ejemplo">
                        <h2>VENTAS</h2>
                    </div>
                </a>
            </div>
            <!-- División 6 -->
            <div class="col-md-4 text-center">
                <a style="text-decoration: none;" href="membresias/listar-membresias.php">
                    <div class="fondo-hover">

                        <img src="../../img/suscripcion.png" alt="Imagen de ejemplo">
                        <h2>MEMBRESIAS</h2>
                    </div>
                </a>
            </div>
        </div>
    </div>


</body>

</html>