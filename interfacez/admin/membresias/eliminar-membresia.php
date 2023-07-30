<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";
?>




<?php
    if(isset($_POST['btn_volver'])){
        echo '<script>window.location="../membresias/listar-membresias.php"</script>';
    }
?>


<?php
    if(isset($_POST['btn_eliminar']))
    {
        $id = $_POST['docu'];//variable formulario
            
        $consulta = $conexion -> prepare("DELETE FROM membresias WHERE doc_cl=$id");
        $consulta->execute();
        echo '<script>alert ("Registro eliminado con exito");</script>';
        echo '<script>window.location="../membresias/listar-membresias.php"</script>';
    }
?>

<?php
if (isset($_GET['eliminar']))
{
    $identificador = $_GET['eliminar'];//input listar usuarios
    $consulta2 = $conexion -> prepare("SELECT * FROM membresias, usuarios WHERE documento = doc_cl AND id_membresias = $identificador");
    $consulta2->execute();
    $consul=$consulta2->fetch();
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
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <title>Eliminar</title>
</head>
<script type="text/javascript">
    function ConfirmDelete()
    {
        var respuesta = confirm("Estas seguro de eliminar el registro");

        if (respuesta == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>
<body>
    <div class="container contenedor1">
        <form method="post">
            <button value="Atras" name="btn_volver" class="btn btn-danger">Atras</button>
        </form>
        <h1 class="titulo" style="font-size: 50px;" >ELIMINAR</h1>
        <br>    
        <form method="post">
        <table class="table table-bordered">
                        <tr>
                            <th style="text-align: center;">Documento</th>
                            <th style="text-align: center;">Nombre</th>
                            <th style="text-align: center;">Fecha de inicio</th>
                            <th style="text-align: center;">Fecha de vencimiento</th>
                            <th style="text-align: center;">Accion</th>
                        </tr>
                
                        <tr>
                            <td style="text-align: center;"><input name="docu" value="<?php echo $consul['doc_cl']?>" readonly></td>
                            <td style="text-align: center;"><input value="<?php echo $consul['nombre']?>" readonly></td>
                            <td style="text-align: center;"><input value="<?php echo $consul['fecha_inicio']?>" readonly></td>
                            <td style="text-align: center;"><input value="<?php echo $consul['fecha_fin']?>" readonly></td>
                            <td>
                                <input class="btn btn-danger" type="hidden" name="btn_eliminar" value="Eliminar">
                                <button onclick="return ConfirmDelete()" class="btn btn-danger" type="submit">Eliminar</button>  
                            </td>
                        </tr>
                        </table>
                </div>
            </form>
            <?php
            }
            ?>  
</body>
</html>