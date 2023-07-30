<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
?>




<?php
    if(isset($_POST['btn_volver'])){
        echo '<script>window.location="../listar/listar-roles.php"</script>';
    }
?>


<?php
    if(isset($_POST['btn_eliminar']))
    {
        $id = $_POST['doc'];//variable formulario
            
        $consulta = $conexion -> prepare("DELETE FROM roles WHERE id_roles=$id");
        $consulta->execute();
        echo '<script>alert ("Registro eliminado con exito");</script>';
        echo '<script>window.location="../listar/listar-roles.php"</script>';
    }
?>

<?php
if (isset($_GET['eliminar']))
{
    $identificador = $_GET['eliminar'];//input listar usuarios
    $consulta2 = $conexion -> prepare("SELECT * FROM roles WHERE id_roles = $identificador");
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
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <title>Eliminar Rol</title>
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
        <h1 class="titulo" style="font-size: 50px;" >ELIMINAR ROL</h1>
        <br>    
        <form method="post">
        <table class="table table-bordered">
                        <tr>
                            <th style="text-align: center;">Numero</th>
                            <th style="text-align: center;">Roles</th>
                            <th style="text-align: center;">Accion</th>
                        </tr>
                
                        <tr>
                            <td style="text-align: center;"><input name="doc" value="<?php echo $consul['id_roles']?>" readonly></td>
                            <td style="text-align: center;"><input name="name" value="<?php echo $consul['roles']?>" readonly></td>
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