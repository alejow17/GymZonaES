<?php
    require_once("../../../bd/conexion.php");
    $basedatos = new Database();
    $conexion = $basedatos->conectar();
    session_start();
    include "../../../control-ingreso/validar-sesion.php";
    date_default_timezone_set('America/Bogota');
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="../listar/listar-usuarios.php"</script>';
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
        $documento=$_POST['documento'];
        $nombre=$_POST['nombre'];
        $nacimiento = $_POST['nacimiento'];
        $usuario=$_POST['usuario'];
        $contra=$_POST['contra'];
        $rol = $_POST['rol'];
        $options = ['cost' => 12];
        $hash = password_hash($contra, PASSWORD_DEFAULT, $options);

        $consulta2= $conexion -> prepare("SELECT * FROM usuarios WHERE documento= '$documento'");
        $consulta2->execute();
        $consull=$consulta2->fetch();
        $consulta3= $conexion -> prepare("SELECT * FROM usuarios WHERE usuario= '$usuario'");
        $consulta3->execute();
        $consulll=$consulta3->fetch();

        if ($consull) {
            echo '<script>alert ("El documento ya se ha registrado, ingrese otro.");</script>';
            echo '<script>windows.location="registrousu.php"</script>';
        }

        else if ($consulll) {
            echo '<script>alert ("El usuario ya existe, por favor ingrese otro.");</script>';
            echo '<script>windows.location="registrousu.php"</script>';
        }

            else if ($documento=="" || $nombre=="" || $usuario=="" || $contra=="" || $rol=="")
            {
                echo '<script>alert ("EXISTEN DATOS VACIOS");</script>';
                echo '<script>windows.location="registrousu.php"</script>';
            }

        else
        {
            $consulta3 = $conexion -> prepare ("INSERT INTO usuarios (documento, nombre, nacimiento, usuario, password, id_roles, id_estado_login) VALUES ('$documento','$nombre', '$nacimiento','$usuario','$hash','$rol',2)");
            $consulta3->execute();
            echo '<script>alert ("Registro exitoso, gracias");</script>';
            echo'<script>window.location="../listar/listar-usuarios.php"</script>';
        }
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
    <link rel="stylesheet" href="../../../css/fonts/fonts.css">
    <title>Crear Usuario</title>
</head>
<body onload="limitarFechas()">
    <div class="form-container">
            <form class="volver" method="post">
                <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
            </form>
        <h2 class="titul1">CREAR USUARIO</h2>
        <form method="post" >
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="Documento de identidad" pattern="[0-9]{6,10}" title="debe tener de 6 a 10 numeros" maxlength="10" onkeyup="numeros(this)" class="form-control" id="documento" name="documento" required><br>
            </div>
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="Nombre" class="form-control" pattern="[a-zA-Z ]+" onkeyup="letras(this)" maxlength="50" id="nombre" name="nombre" required><br>
            </div>
            <div class="form-group input-group">
                <span class="input-group-text">Fecha de nacimiento</span>
                <input type="date" autocomplete="off" placeholder="" class="form-control" maxlength="30" id="fecha" name="nacimiento" required>
            </div><br>
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="Usuario" class="form-control" pattern="{0,50}" maxlength="20" onkeyup="espacios(this)" id="usuario" name="usuario" required><br>
            </div>
            
            <div class="form-group">
                <input type="password" autocomplete="off" pattern=".{6,12}" maxlength="12" title="Debe tener de 6 a 12 digitos" onkeyup="espacios(this)" placeholder="Contraseña" class="form-control" id="contra" name="contra" required>
            </div><br>
            <select class="form-select" name="rol">
            <option value="">Seleccione tipo de usuario</option>
                <?php

                do{

                ?>
            <option value="<?php echo ($consul['id_roles'])?>"><?php echo ($consul['roles'])?></option>
            <?php
                }while($consul=$consulta->fetch());

            ?>
        </select><br><br>
            <button type="submit" value="registrar" name="btn-registrar" class="btn btn-warning boton-registrar">Registrar</button>
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

    var fechaInput = document.getElementById('fecha');

    // Calcular las fechas mínima y máxima permitidas
    var fechaMaxima = new Date();
    fechaMaxima.setFullYear(fechaMaxima.getFullYear() - 7); // Restar un año
    var fechaMinima = new Date();
    fechaMinima.setFullYear(fechaMinima.getFullYear() - 80); // Restar 120 años

    // Formatear las fechas mínima y máxima en formato de fecha adecuado (YYYY-MM-DD)
    var fechaMaximaFormateada = fechaMaxima.toISOString().split('T')[0];
    var fechaMinimaFormateada = fechaMinima.toISOString().split('T')[0];

    // Establecer los atributos min y max del campo de entrada de fecha
    fechaInput.setAttribute('min', fechaMinimaFormateada);
    fechaInput.setAttribute('max', fechaMaximaFormateada);
</script>

</html>