<?php
    require_once("../../../bd/conexion.php");
    $basedatos = new Database();
    $conexion = $basedatos->conectar();
    session_start();
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="../listar/listar-roles.php"</script>';
    }
?>

<?php 
    if ((isset($_POST["btn-crear"])))
    {
        $nom_rol =$_POST['nom_rol'];

        $consulta = $conexion -> prepare ("INSERT INTO roles (roles) VALUES ('$nom_rol')");
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
        <h2 class="titulo1" style="font-size:50px;">CREAR ROL</h2>
        <form method="post">
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="Nombre Rol" class="form-control nom-rol" maxlength="30" id="nombre" name="nom_rol" required>
            </div><br>
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
</script>
</html>