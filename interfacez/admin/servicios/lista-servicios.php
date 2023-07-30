<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion-> prepare ("SELECT * FROM servicios");
$consulta->execute();
session_start();
include "../../../control-ingreso/validar-sesion.php";
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="lista_ventas_servicios.php"</script>';
    }
?>

<?php
    if(isset($_POST['btn_crear'])){
        echo '<script>window.location="crear_servicios.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap sin internet -->
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <title>listar usuarios</title>
</head>
<body>
    <div class="container contenedor1">
        <form class="volver" method="post">
        <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>    
        <h1>LISTA DE SERVICIOS</h1>
        <button value="Atras" name="btn_crear" class="btn btn-success">Crear</button>
        </form>
        <br>
        <table class="table table-bordered">
                <tr style="text-align: center;" >
                    <th style="text-align: center;">Servicio</th>
                    <th style="text-align: center;">Precio</th>
                    <th style="text-align: center;" colspan="2">Accion</th>
                </tr>
        <?php
            foreach($consulta as $cons)
            {
        ?>
                <tr style="text-align: center;" >
                    <td style="text-align: center;"><?=$cons['desc_servicio']?></td>
                    <td style="text-align: center;"><?=$cons['precio']?></td>
                    <td>
                        <form action="eliminar_servicios.php" method="get">
                            <input type="hidden" name="eliminar" value="<?=$cons['id_servicio']?>">
                            <button class="btn btn-danger botones" type="submit">Eliminar</button>
                        </form>
                    </td>
                    <td>
                        <form action="actualizar-servicios.php" method="get">
                            <input type="hidden" name="actualizar" value="<?=$cons['id_servicio']?>">
                            <button class="btn btn-warning botones" type="submit">Actualizar</button>
                        </form>
                    </td>
                </tr>
        <?php
        }
        ?>
        </table>
    </div>
</body>
</html>