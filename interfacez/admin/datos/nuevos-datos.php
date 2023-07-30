<?php
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";
date_default_timezone_set('America/Bogota');
$fecha = date('Y-m-d');
$proteina = NULL;
if (isset($_POST['boton_volver'])) {
    echo '<script>window.location="../membresias/listar-membresias.php"</script>';
}

if (isset($_POST['submit'])) {
    $docu = $_GET['id'];
    $edad = $_POST['edad'];
    $estatura = $_POST['estatura'];
    $pecho = $_POST['pecho'];
    $cintura = $_POST['cintura'];
    $cadera = $_POST['cadera'];
    $brazo_izquierdo = $_POST['brazo_izquierdo'];
    $brazo_derecho = $_POST['brazo_derecho'];
    $peso = $_POST['peso'];

    // Validar que los campos contengan valores numéricos válidos
    if (!is_numeric($edad) || !is_numeric($estatura) || !is_numeric($pecho) || !is_numeric($cintura) || !is_numeric($cadera) || !is_numeric($brazo_izquierdo) || !is_numeric($brazo_derecho) || !is_numeric($peso)) {
        echo "<script>alert('Por favor, ingresa valores numéricos válidos.');</script>";
        exit; // Detener la ejecución del script si hay datos inválidos
    }

    $estatura_metros = $estatura / 100; // Convertir la estatura de cm a metros
    $imc = $peso / ($estatura_metros * $estatura_metros);
    $bmi = round($imc, 2);

    // Obtener el género del usuario desde la tabla de membresías
    $consulta_genero = $conexion->prepare("SELECT genero FROM membresias WHERE doc_cl = :doc_cl");
    $consulta_genero->bindParam(":doc_cl", $docu);
    $consulta_genero->execute();
    $resultado_genero = $consulta_genero->fetch(PDO::FETCH_ASSOC);

    // Validar y obtener el valor del género (0 para mujer, 1 para hombre)
    if ($resultado_genero['genero'] === 'Femenino') {
        $sexo = 0;
    } else {
        $sexo = 1;
    }

    // Calcular el porcentaje de grasa corporal 
    $porcentaje_grasa_corporal = 1.2 * $bmi + 0.23 * $edad - 10.8 * $sexo - 5.4;

    // Redondear el porcentaje de grasa corporal a dos decimales
    $grasa = round($porcentaje_grasa_corporal, 2);

    // Estimar la grasa visceral basada en el IMC
    if ($bmi < 18.5) {
        // Si el IMC es menor a 18.5, se considera un valor promedio de grasa visceral de 10
        $grasa_v = 10;
    } elseif ($bmi >= 18.5 && $bmi < 25) {
        // Si el IMC está entre 18.5 y 24.9, se considera un valor promedio de grasa visceral de 7
        $grasa_v = 7;
    } elseif ($bmi >= 25 && $bmi < 30) {
        // Si el IMC está entre 25 y 29.9, se considera un valor promedio de grasa visceral de 14
        $grasa_v = 14;
    } else {
        // Si el IMC es mayor o igual a 30, se considera un valor promedio de grasa visceral de 20
        $grasa_v = 20;
    }

    // Calcular los valores de agua, hueso y músculo
    // Calcular los valores de agua, hueso y obesidad
    $musculo = 100 - ($grasa + $grasa_v);
    $total = $grasa + $musculo + $grasa_v;

    $agua_porcentaje = 50; // Puedes ajustar este valor según tus necesidades
    $hueso_porcentaje = 15; // Puedes ajustar este valor según tus necesidades

    $agua = $total * ($agua_porcentaje / 100);
    $hueso = $total * ($hueso_porcentaje / 100);

    $obesidad =  ($grasa + $musculo + $grasa_v + $agua + $hueso) - 100;


    // Cálculo del metabolismo basal
    if ($sexo === 0) { // Mujer
        $metabolismo = 655 + (9.6 * $peso) + (1.8 * $estatura) - (4.7 * $edad);
    } else { // Hombre
        $metabolismo = 66 + (13.7 * $peso) + (5 * $estatura) - (6.8 * $edad);
    }

    // Factor de actividad
    $factor_actividad = 1.2; // Valor por defecto para actividad sedentaria (poco o ningún ejercicio)
    // Ajustar el factor de actividad según el nivel de actividad física del individuo si se desea una estimación más precisa
    // Por ejemplo, para actividad ligera (ejercicio ligero o deportes 1-3 días a la semana), usar $factor_actividad = 1.375
    // Para actividad moderada (ejercicio moderado o deportes 3-5 días a la semana), usar $factor_actividad = 1.55
    // Para actividad intensa (ejercicio intenso o deportes 6-7 días a la semana), usar $factor_actividad = 1.725
    // Para actividad muy intensa (ejercicio muy intenso, trabajo físico o entrenamiento doble), usar $factor_actividad = 1.9

    // Calcular el metabolismo total multiplicando el metabolismo basal por el factor de actividad
    $metabolismo *= $factor_actividad;

    // Calcular el valor de proteina
    $proteina = $peso * 0.83;

    // Insertar los datos en la base de datos
    $consulta = $conexion->prepare("INSERT INTO datos_fisicos (documento, fecha, edad, estatura, pecho, cintura, cadera, brazo_izquierdo, brazo_derecho, peso, bmi, grasa, musculo, agua, grasa_v, hueso, metabolismo, proteina, obesidad) VALUES (:documento, :fecha, :edad, :estatura, :pecho, :cintura, :cadera, :brazo_izquierdo, :brazo_derecho, :peso, :bmi, :grasa, :musculo, :agua, :grasa_v, :hueso, :metabolismo, :proteina, :obesidad)");

    $consulta->bindParam(":documento", $docu);
    $consulta->bindParam(":fecha", $fecha);
    $consulta->bindParam(":edad", $edad);
    $consulta->bindParam(":estatura", $estatura);
    $consulta->bindParam(":pecho", $pecho);
    $consulta->bindParam(":cintura", $cintura);
    $consulta->bindParam(":cadera", $cadera);
    $consulta->bindParam(":brazo_izquierdo", $brazo_izquierdo);
    $consulta->bindParam(":brazo_derecho", $brazo_derecho);
    $consulta->bindParam(":peso", $peso);
    $consulta->bindParam(":bmi", $bmi);
    $consulta->bindParam(":grasa", $grasa);
    $consulta->bindParam(":musculo", $musculo);
    $consulta->bindParam(":agua", $agua);
    $consulta->bindParam(":grasa_v", $grasa_v);
    $consulta->bindParam(":hueso", $hueso);
    $consulta->bindParam(":metabolismo", $metabolismo);
    $consulta->bindParam(":proteina", $proteina);
    $consulta->bindParam(":obesidad", $obesidad);

    $consulta->execute();
    echo "<script>alert('Los datos se registraron exitosamente.');</script>";
    echo '<script>window.location="../membresias/listar-membresias.php"</script>';
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
    <link rel="stylesheet" href="nuevos-datos.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <title>Crear Medidas</title>
</head>

<body>
    <div class="form-container">
        <form class="volver" method="post">
            <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
        </form>
        <h2 class="titulo" style="font-size:45px;">NUEVOS DATOS</h2>
        <form method="post">
            <div>
                <input value="<?php echo $fecha ?>" readonly>
            </div><br>
            <div class="form-group">
                <input type="text" maxlength="2" autocomplete="off" placeholder="Edad" class="form-control"
                    onkeyup="numeros(this)" name="edad" required><br>
            </div>
            <div class="form-group">
                <input type="text" maxlength="4" step="0.01" autocomplete="off" placeholder="Estatura"
                    class="form-control" onkeyup="numeros(this)" name="estatura" required>
            </div><br>
            <div class="form-group">
                <input type="text" maxlength="5" step="0.01" autocomplete="off" placeholder="Pecho" class="form-control"
                    onkeyup="numeros(this)" name="pecho" required>
            </div><br>
            <div class="form-group">
                <input type="text" maxlength="5" step="0.01" autocomplete="off" placeholder="Cintura"
                    class="form-control" onkeyup="numeros(this)" name="cintura" required>
            </div><br>
            <div class="form-group">
                <input type="text" maxlength="5" step="0.01" autocomplete="off" placeholder="Cadera"
                    class="form-control" onkeyup="numeros(this)" name="cadera" required>
            </div><br>
            <div class="form-group">
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off"
                    placeholder="Brazo Izquierdo" class="form-control" name="brazo_izquierdo" required>
            </div><br>
            <div class="form-group">
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off"
                    placeholder="Brazo Derecho" class="form-control" name="brazo_derecho" required>
            </div><br>
            <div class="form-group">
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off"
                    placeholder="Peso" class="form-control" name="peso" required>
            </div><br>
            <button type="submit" name="submit" class="btn btn-warning boton-registrarr">Registrar</button>
        </form>
    </div>
</body>
<script>
    function mayuscula(e) {
        e.value = e.value.toUpperCase();
    }
    function minuscula(e) {
        e.value = e.value.toLowerCase();
    }
    function numeros(e) {
        e.value = e.value.replace(/[^0-9\.]/g, '');
    }
    function espacios(e) {
        e.value = e.value.replace(/ /g, '');
    }
</script>

</html>