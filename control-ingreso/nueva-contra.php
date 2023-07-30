<?php
    require_once("../bd/conexion.php");
    $basedatos = new Database();
    $conexion = $basedatos->conectar();
    session_start();

    if(isset($_POST['cambiar'])){

        $contra = $_POST['contra1'];
        $contra2 = $_POST['contra2'];

        if ($contra!=$contra2)
            {   
                    echo '<script>alert ("Contraseñas no coinciden");</script>';
                    echo '<script>window.location="../recuperar-contra.html"</script>';
            }


            else
            {
                /* Set the "cost" parameter to 12. */
                $options = ['cost' => 12];
                $documento = $_SESSION['document'];
                $hash = password_hash($contra, PASSWORD_DEFAULT, $options);
                $consulta = $conexion->prepare("UPDATE usuarios SET password = '$hash' WHERE documento = '$documento'");
                $consulta->execute();
                echo '<script>alert ("Cambio de clave exitosa");</script>';
                echo '<script>window.location="../index.html"</script>';
            }
    }
?>

<?php
    if($_POST["inicio"]){

        $documento = $_POST["documento"];
        
        // sirve para imprimir lo que trae la variable echo $document; //
        $consulta2 = $conexion->prepare("SELECT * FROM usuarios WHERE documento = '$documento'");
        $consulta2->execute();
        $consul=$consulta2->fetch();

        if($consul){
            $_SESSION['document']=$consul['documento'];
    ?>

<html>
            <head>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <link rel="stylesheet" href="../css/style1.css">
                <!-- bootstrap sin internet -->
                <link rel="stylesheet" href="../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
                <!-- favicon -->
                <link rel="icon" href="../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
                <title>Nueva contraseña</title>
                <meta charset="utf-8">
                <link href="img/logo-zona-gym.png" rel="icon">
            </head>
            <body>
                <div class="form-container">
                    <form method="POST" name="form1" id="form1" autocomplete="off">
                        <h2 class="titulo1">CAMBIAR CONTRASEÑA</h2>
                        <input type="password" style="border-radius:1rem;text-align:center;margin-left:8%;height:35px;width:250px;" pattern=".{6,12}" maxlength="11" title="Debe tener de 6 a 12 digitos" onkeyup="espacios(this)" class="contra" name="contra1" id="cont" placeholder="Nueva clave" required><br><br>
                        <input type="password" style="border-radius:1rem;text-align:center;margin-left:8%;height:35px;width:250px;" pattern=".{6,12}" maxlength="11" title="Debe tener de 6 a 12 digitos" onkeyup="espacios(this)" class="contra" name="contra2" id="conta" placeholder="Confirme clave" required><br><br>
                        <a class="ingresar" href="../index.html">Volver pagina principal</a><br>
                        <input type="submit" class="btn btn-warning btn-re" name="cambiar" id="Cambiar" value="Cambiar">
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
        <?php
    }
    else
    {
        echo '<script>alert ("El documento no exite en la base de datos");</script>';
        echo '<script>window.location="../recuperar-contra.html"</script>';
    }
}

?> 