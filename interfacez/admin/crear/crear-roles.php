<?php
    require_once("../../../bd/conexion.php");
    $basedatos = new Database();
    $conexion = $basedatos->conectar();
    session_start();
    include "../../../control-ingreso/validar-sesion.php";
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="../listar/listar-roles.php"</script>';
    }
?>

<?php 
    if(isset($_POST["btn-crear"])) {
    $nom_rol = $_POST['nom_rol'];
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

    // Insertar el nombre del rol y la ruta de la imagen en la base de datos
    $consulta = $conexion->prepare("INSERT INTO roles (roles, imagen) VALUES (?, ?)");
    $consulta->bindParam(1, $nom_rol);
    $consulta->bindParam(2, $target_file);
    $consulta->execute();

    echo '<script>alert ("Rol Creado");</script>';
    echo'<script>window.location="../listar/listar-roles.php"</script>';
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
    <link rel="stylesheet" href="crear-usuarios.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <title>Crear rol</title>
</head>
<body>
    <div class="form-container">
            <form class="volver" method="post">
                <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
            </form>
                <h2 class="titulo" style="font-size:50px;">CREAR ROL</h2>
            <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" style="width:400px;" autocomplete="off" placeholder="Nombre Rol" onkeyup="soloLetras(this)" class="form-control" maxlength="30" id="nombre" name="nom_rol" required>
            </div><br>
                <div class="form-group mb-3">
                    <label style="font-weight:700;color:white;" for="imagen">IMAGEN:</label>
                    <input class="form-control" aria-label="file example" type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" required>
                </div>
                <button type="submit" value="registrar" name="btn-crear" class="btn btn-warning boton-registrarr">Crear</button>
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
    function soloLetras(e){
        e.value = e.value.replace(/ [^a-zA-Z] /g, '');
    }
</script>
</html>