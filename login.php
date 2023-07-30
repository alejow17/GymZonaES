<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enlaces a los estilos CSS -->
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="./css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/fonts/fonts.css">
    <!-- Favicon -->
    <link href="img/logo-zona-gym.png" rel="icon">
    <title>Ingreso</title>
</head>
<body onload="form1.usuario.focus()">
    <div class="form-container">
        <h2 class="titulo1">INGRESO</h2><br>
        <!-- el formulario lo direcciona al ingresar.php -->
        <form method="post" name="form1" action="control-ingreso/ingresar.php">
            <?php
                if (isset($_GET['alerta'])) {
                    $alerta = $_GET['alerta'];
                    echo '<div class="alert alert-danger" role="alert">'.$alerta.'</div>';
                }
            ?>
            <div class="form-group">
                <input type="text" autocomplete="off" placeholder="Usuario" class="form-control" maxlength="20" id="usuario" onkeyup="espacios(this)" name="usuario" required>
            </div><br>
            <div class="form-group">
                <input type="password" autocomplete="off" onkeyup="espacios(this)" placeholder="Contraseña" maxlength="20" class="form-control" id="contra" name="contra" required>
            </div><br>
            <a class="ingresar" style="text-align: center;" href="recuperar-contra.html">Olvidaste tu Contraseña?</a><br><br>
            <a class="ingresar" href="index.html">Ir al inicio</a><br>
            <input type="submit" name="ingresar" class="btn btn-warning btn-re" id="ingresar" value="Ingresar">
        </form>
    </div>
</body>
<!-- Tu código JavaScript -->
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
