<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";
$documento = $_GET['actualizar'];
$consulta = $conexion-> prepare ("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_roles=roles.id_roles WHERE usuarios.documento=$documento");
$consulta->execute();
$consul1=$consulta->fetch();
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="../listar/listar-clientes.php"</script>';
    }
?>

<?php
    $consulta = $conexion->prepare("SELECT * FROM roles");
    $consulta->execute();
    $consul=$consulta->fetch();
?>

<?php 
    if ((isset($_POST["btn_actualizar"])))
    {
        $nombre=$_POST['nombre'];

        $consulta2= $conexion -> prepare("SELECT * FROM usuarios WHERE documento= '$documento'");
        $consulta2->execute();
        $consull=$consulta2->fetch();

        $consulta3 = $conexion -> prepare ("UPDATE usuarios SET nombre='$nombre' WHERE documento='$documento'");
        $consulta3->execute();
        echo '<script>alert ("Registro exitoso, gracias");</script>';
        echo'<script>window.location="../listar/listar-clientes.php"</script>';
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
    <title>Actualizar usuario</title>
</head>
<body>
    <div class="container contenedor1">
        <form method="post">
            <button value="Atras" name="boton_volver" class="btn btn-danger">Atras</button>
        </form>
        <br>
        <h1 class="titulo" style="font-size: 45px; margin-bottom: 10px;">ACTUALIZAR CLIENTE</h1><br>
        <form method="post">
        <table class="table table-bordered">
                        <tr style="text-align: center;" >
                            <th style="text-align: center;">Documento</th>
                            <th style="text-align: center;">Nombres</th>
                            <th style="text-align: center;">Accion</th>
                        </tr>
                        <tr style="text-align: center;" >
                            <td style="text-align: center;"><input name="doc" value="<?php echo $consul1['documento']?>" readonly></td>
                            <td style="text-align: center;"><input onkeyup="letras(this)" maxlength="20" pattern="{0,30}" name="nombre" required value="<?php echo $consul1['nombre']?>"></td>
                            <td>
                                <input class="btn btn-warning" type="submit" name="btn_actualizar" value="Actualizar">
                            </td>
                        </tr>
                        </table>
        </form> 
    </div>
</body>
<script>
    function mayuscula(e){
        e.value = e.value.toUpperCase();
    }
    function minuscula(e){
        e.value = e.value.toLowerCase();
    }
    function numeros(e){
        e.value = e.value.replace(/[^0-9\.]/g, '');
    }
    function espacios(e){
        e.value = e.value.replace(/ /g, '');
    }
    function letras(e){
        e.value = e.value.replace(/[^A-Za-z]/g, ' ');
    }
</script>
</html>
