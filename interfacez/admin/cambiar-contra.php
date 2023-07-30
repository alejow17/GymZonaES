<?php
    session_start();
    require_once("../../bd/conexion.php");
    include ("../../control-ingreso/validarindex.php");
    $basedatos = new Database();
    $conexion = $basedatos->conectar();
    $_SESSION['document'];
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="index-admin.php"</script>';
    }
?>

<?php
    if(isset($_POST['cambiar'])){

        $contra = $_POST['contra1'];
        $contra2 = $_POST['contra2'];

        if ($_POST['contra1']=="" || $_POST['contra2']=="")
            {
                    echo '<script>alert ("Datos vacios no ingreso la clave");</script>';
                    echo '<script>window.location="cambiar-contra.php"</script>';
            }

            if ($contra !=  $contra2)
            {
                echo '<script>alert ("Datos no coinciden");</script>';
                echo '<script>window.location="cambiar-contra.php"</script>';
            }

            else
            {
                $options = ['cost' => 12];
                $hash = password_hash($contra, PASSWORD_DEFAULT, $options);
                $documento = $_SESSION['document'];
                $consulta = $conexion->prepare("UPDATE usuarios SET password = '$hash' WHERE documento = '".$_SESSION['document']."'");
                $consulta->execute();
                echo '<script>alert ("Cambio de clave exitosa");</script>';
                echo '<script>window.location="index-admin.php"</script>';
            }
    }
?>

<html>
            <head>
                <meta charset="utf-8">
                <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
                <!-- bootstrap sin internet -->
                <link rel="stylesheet" href="../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">

                <link rel="stylesheet" href="./cambiar-contra.css">
                <link rel="stylesheet" href="../../css/fonts/fonts.css">
                <!-- favicon -->
                <link rel="icon" href="../../img/logo-zona-gym.png">
                <title>Cambiar Contraseña</title>
            </head>
            <body>
                <div class="form-container">
                <form class="volver" method="post">
                    <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
                </form>
                <form method="POST" name="form1" id="form1" autocomplete="off">
                    <h2 class="titulo1" >CAMBIAR CONTRASEÑA</h2>
                    <input type="password" style="height:35px;" pattern=".{6,12}" maxlength="12" title="Debe tener de 6 a 12 digitos" onkeyup="espacios(this)" class="contra" name="contra1" id="cont" placeholder="Nueva clave"><br><br>
                    <input type="password" style="height:35px;" pattern=".{6,12}" maxlength="12" title="Debe tener de 6 a 12 digitos" onkeyup="espacios(this)" class="contra" name="contra2" id="conta" placeholder="Confirme clave"><br><br>
                    <input type="submit" class="btn btn-warning boton-cambiar" name="cambiar" id="cambiar" value="Cambiar">
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