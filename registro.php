<?php
    require_once("bd/conexion.php");
    $basedatos = new Database();
    $conexion = $basedatos->conectar();
?>

<?php
    if(isset($_POST['btn_volver'])){
        echo '<script>window.location="login.html"</script>';
    }
?>  

<?php 
    if ((isset($_POST["btn-registrar"])))
    {
        $documento=$_POST['documento'];
        $nombre=$_POST['nombre'];
        $usuario=$_POST['usuario'];
        $contra=$_POST['contra'];

        $consulta2= $conexion -> prepare("SELECT * FROM usuarios WHERE documento= '$documento'");
        $consulta2->execute();
        $consull=$consulta2->fetch();

        if ($consull) {
            echo '<script>alert ("DOCUMENTO O USUARIO EXITEN //CAMBIELOS//");</script>';
            echo '<script>windows.location="registrousu.php"</script>';
        }

        else if ($documento=="" || $nombre=="" || $usuario=="" || $contra=="")
        {
            echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
            echo '<script>windows.location="registrousu.php"</script>';
        }

        else
        {
            $consulta3 = $conexion -> prepare ("INSERT INTO usuarios (documento, nombre, usuario, password,id_roles,id_estado_login) VALUES ('$documento','$nombre','$usuario','$contra',3,2)");
            $consulta3->execute();
            echo '<script>alert ("Registro exitoso, gracias");</script>';
            echo'<script>window.location="login.html"</script>';
        }
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style1.css">
    <link href="img/logo-zona-gym.png" rel="icon">
</head>
<body>
    <div class="form-container">
        <h2>REGISTRO</h2>
        <form method="post" >
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="Documento de identidad" pattern="[0-9]{6,10}" maxlength="10" onkeyup="numeros(this)" class="form-control" id="documento" name="documento" required>
            </div>
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="Nombre" class="form-control" pattern="[A-Z]{0,50}" onkeyup="mayuscula(this)" maxlength="30" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="Usuario" class="form-control" pattern="{0,50}" maxlength="30" onkeyup="minuscula(this),espacios(this)" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <input type="password" autocomplete="off" onkeyup="espacios(this)" placeholder="Contraseña" class="form-control" id="contra" name="contra" required>
            </div><br>
            <a class="ingresar" href="login.html">Ingresar</a><br>
            <button type="submit" value="registrar" name="btn-registrar" class="btn btn-warning btn-re">Registrarme</button>
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
