<?php
    require_once("../../../bd/conexion.php");
    $basedatos = new Database();
    $conexion = $basedatos->conectar();
    session_start();
    include "../../../control-ingreso/validar-sesion.php";
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="../ventas/servicios.php"</script>';
    }
?>

<?php
    $consulta = $conexion->prepare("SELECT * FROM roles");
    $consulta->execute();
    $consul=$consulta->fetch();
?>

<?php 
    if ((isset($_POST["btn-registrar"])))
    {
        $servicio=$_POST['servicio'];
        $precio=$_POST['precio'];

        $consulta2= $conexion -> prepare("SELECT * FROM servicios WHERE desc_servicio= '$servicio'");
        $consulta2->execute();
        $consull=$consulta2->fetch();

        if ($consull) {
            echo '<script>alert ("EL SERVICIO O COMBO YA EXITEN //CAMBIELOS//");</script>';
            echo '<script>windows.location="crear-servicios.php"</script>';
        }

        else if ($servicio=="" || $precio=="")
        {
            echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
            echo '<script>windows.location="crear-servicios.php"</script>';
        }

        else
        {
            $consulta3 = $conexion -> prepare ("INSERT INTO servicios (desc_servicio, precio) VALUES ('$servicio','$precio')");
            $consulta3->execute();
            echo '<script>alert ("Registro exitoso, gracias");</script>';
            echo'<script>window.location="../ventas/servicios.php"</script>';
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
    <link rel="stylesheet" href="crear-usuarios.css">
</head>
<body>
    <div class="form-container">
            <form class="volver" method="post">
                <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
            </form>
        <h2>CREAR SERVICIO</h2>
        <form method="post">
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="servicio" class="form-control" pattern="{0,50}" maxlength="30" onkeyup="minuscula(this)" id="usuario" name="servicio" required>
            </div>
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="precio" class="form-control" pattern="[0-9]{0,50}" onkeyup="numeros(this),espacios(this)" maxlength="30" id="nombre" name="precio" required>
            </div>
            <br><br>
            <button type="submit" value="registrar" name="btn-registrar" class="btn btn-warning boton-registrar">Registrar</button>
        </form>
    </div>
</body>
<script>
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