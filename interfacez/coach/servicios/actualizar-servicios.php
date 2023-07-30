<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";
$servicio = $_GET['actualizar'];
$consulta = $conexion-> prepare ("SELECT * FROM servicios WHERE id_servicio=$servicio");
$consulta->execute();
$consul1=$consulta->fetch();
?>


<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="lista-servicios.php"</script>';
    }
?>

<?php 
    if ((isset($_POST["btn_actualizar"])))
    {
        $descripcion=$_POST['descripcion'];
        $precio=$_POST['precio'];

        $consulta2= $conexion -> prepare("SELECT * FROM servicios WHERE id_servicio= '$servicio'");
        $consulta2->execute();
        $consull=$consulta2->fetch();

        $consulta3 = $conexion -> prepare ("UPDATE servicios SET desc_servicio='$descripcion', precio='$precio' WHERE id_servicio='$servicio'");
        $consulta3->execute();
        echo '<script>alert ("Registro exitoso, gracias");</script>';
        echo'<script>window.location="lista-servicios.php"</script>';
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
    <title>Actualizar servicios</title>
</head>
<body>
    <div class="container contenedor1">
        <form method="post">
            <button value="Atras" name="boton_volver" class="btn btn-danger">Atras</button>
        </form>
        <br>
        <h1 class="titulo" style="font-size: 45px;" >ACTUALIZAR SERVICIOS</h1><br>
        <form method="post">
        <table class="table table-bordered">
                        <tr>
                            <th style="text-align: center;">Servicio</th>
                            <th style="text-align: center;">Precio</th>
                            <th style="text-align: center;">Accion</th>
                        </tr>
                
                        <tr>
                            <input type="hidden" name="id" value="<?=$consul1["id_servicio"]; ?>">
                            <td style="text-align: center;"><input required name="descripcion" value="<?php echo $consul1['desc_servicio']?>" ></td>
                            <td style="text-align: center;"><input maxlength="30" required pattern="{0,30}" name="precio" value="<?php echo $consul1['precio']?>"></td>
                            <td>
                                <input class="btn btn-warning" type="submit" name="btn_actualizar" value="Actualizar">
                            </td>
                        </tr>
                        </table>
        </form> 
    </div>
</body>
</html>
