<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";
?>




<?php
    if(isset($_POST['btn_volver'])){
        echo '<script>window.location="../listar/listar-roles.php"</script>';
    }
?>


<?php
if(isset($_POST['btn_actu']))
{
    $identificador = $_POST['doc'];
    $name = $_POST['name'];

    // Verificar si se subió una imagen
    if(isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0) {
        $imagen = $_FILES['imagen'];

        // Verificar que el archivo es una imagen jpg o png
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($imagen['type'], $allowed_types)) {
            echo '<script>alert ("Solo se permiten archivos de imagen JPG o PNG.");</script>';
            exit;
        }

        // Verificar que el tamaño del archivo no excede los 400kb
        if ($imagen['size'] > 400000) {
            echo '<script>alert ("El tamaño del archivo no puede exceder los 400kb.");</script>';
            exit;
        }

        // Mover la imagen a la carpeta "files"
        $target_dir = "files/";
        $target_file = $target_dir . basename($imagen["name"]);
        move_uploaded_file($imagen["tmp_name"], $target_file);

        // Actualizar la ruta de la imagen en la base de datos
        $consultar = $conexion -> prepare ("UPDATE roles SET roles='$name', imagen='$target_file' WHERE id_roles='$identificador'");
    } else {
        // Actualizar solo el nombre del rol en la base de datos
        $consultar = $conexion -> prepare ("UPDATE roles SET roles='$name' WHERE id_roles='$identificador'");
    }

    $consultar->execute();
    echo '<script>alert ("Registro actualizado con exito");</script>';
    echo '<script>window.location="../listar/listar-roles.php"</script>';
}
?>

<?php
if (isset($_GET['actu']))
{
    $id = $_GET['actualizar'];
    $consulta2 = $conexion -> prepare("SELECT * FROM roles WHERE id_roles = '$id'");
    $consulta2->execute();
    $cons=$consulta2->fetch();
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
    <title>Actualizar Rol</title>
</head>
<body>
    <div class="container contenedor1">
        <form method="post">
            <button value="Atras" name="btn_volver" class="btn btn-danger">Atras</button>
        </form>
        <h1  class="titulo" style="font-size: 50px;" >ACTUALIZAR ROL</h1>
        <br>    
        <form method="post">
        <table class="table table-bordered">
                        <tr>
                            <th style="text-align: center;">Numero</th>
                            <th style="text-align: center;">Imagen</th>
                            <th style="text-align: center;">Roles</th>
                            <th style="text-align: center;">Accion</th>
                        </tr>
                
                        <tr>
                            <td style="text-align: center;"><input name="doc" value="<?php echo $cons['id_roles']?>" readonly></td>
                            <td>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group mb-3">
                                        <input class="form-control" aria-label="file example" type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" required>
                                    </div>
                                </form>
                            </td>
                            <td style="text-align: center;"><input maxlength="20" pattern="{0,50}" type="text" name="name" required value="<?php echo $cons['roles']?>"></td>
                            <td>
                                <input class="btn btn-warning" type="submit" name="btn_actu" value="Actualizar">
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