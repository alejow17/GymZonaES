	<?php
if(!isset($_GET["id_datos_fisicos"])) exit();
$id = $_GET["id_datos_fisicos"];
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
$sentencia = $conexion->prepare("SELECT * FROM datos_fisicos WHERE id_datos_fisicos = '$id'");
$resultado = $sentencia->execute();
$resul = $sentencia->fetch(PDO::FETCH_OBJ);
?>
<?php
    session_start();
    include "../../../control-ingreso/validar-sesion.php";
    date_default_timezone_set('America/Bogota');
    $fecha = date('Y-m-d');
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="../membresias/listar-membresias.php"</script>';
    }
?>

<?php 
if($resul){
    if(isset($_POST['submit'])) { 
        $edad = $_POST['edad'];
        $estatura = $_POST['estatura'];
        $pecho = $_POST['pecho'];
        $cintura = $_POST['cintura'];
        $cadera = $_POST['cadera'];
        $brazo_izquierdo = $_POST['brazo_izquierdo'];
        $brazo_derecho = $_POST['brazo_derecho'];
        $peso = $_POST['peso'];
        $bmi = $_POST['bmi'];
        $grasa = $_POST['grasa'];
        $musculo = $_POST['musculo'];
        $agua = $_POST['agua'];
        $grasa_v = $_POST['grasa_v'];
        $hueso = $_POST['hueso'];
        $metabolismo = $_POST['metabolismo'];
        $proteina = $_POST['proteina'];
        $obesidad = $_POST['obesidad'];
    
        $consulta = $conexion->prepare("UPDATE datos_fisicos SET edad=:edad, estatura=:estatura, pecho=:pecho,  cintura=:cintura, cadera=:cadera, brazo_izquierdo=:brazo_izquierdo, brazo_derecho=:brazo_derecho, peso=:peso, bmi=:bmi, grasa=:grasa, musculo=:musculo, agua=:agua, grasa_v=:grasa_v, hueso=:hueso, metabolismo=:metabolismo, proteina=:proteina, obesidad=:obesidad WHERE id_datos_fisicos='$id'");
    
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
        echo "<script>alert('Los datos se actualizaron exitosamente.');</script>";
        echo'<script>window.location="../membresias/listar-membresias.php"</script>';
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
            <h2 class="titulo" style="font-size:45px;">EDITAR DATOS</h2>
            <form method="post">
            <div>
            <input value="<?php echo$fecha ?>" readonly>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Edad</label>
                <input type="text" maxlength="2" autocomplete="off" placeholder="Edad" value="<?php echo $resul->edad ?>" class="form-control" onkeyup="numeros(this)" name="edad" required><br>
            </div>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Estatura</label>
                <input type="text" maxlength="4" step="0.01" autocomplete="off" placeholder="Estatura" value="<?php echo $resul->estatura ?>" class="form-control" onkeyup="numeros(this)" name="estatura" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Pecho</label>
                <input type="text"  maxlength="5" step="0.01" autocomplete="off" placeholder="Pecho" value="<?php echo $resul->pecho ?>" class="form-control" onkeyup="numeros(this)" name="pecho" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Cintura</label>
                <input type="text"  maxlength="5" step="0.01" autocomplete="off" placeholder="Cintura" value="<?php echo $resul->cintura; ?>" class="form-control" onkeyup="numeros(this)" name="cintura" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Cadera</label>
                <input type="text"  maxlength="5" step="0.01" autocomplete="off" placeholder="Cadera" value="<?php echo $resul->cadera; ?>" class="form-control" onkeyup="numeros(this)" name="cadera" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Brazo izquierdo</label>
                <input type="text"  onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Brazo Izquierdo" value="<?php echo $resul->brazo_izquierdo; ?>" class="form-control" name="brazo_izquierdo" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Brazo derecho</label>
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Brazo Derecho" value="<?php echo $resul->brazo_derecho; ?>" class="form-control" name="brazo_derecho" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Peso</label>
                <input type="text"  onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Peso" value="<?php echo $resul->peso; ?>" class="form-control" name="peso" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">B.M.I</label>
                <input type="text"  onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="BMI" value="<?php echo $resul->bmi; ?>" class="form-control" name="bmi" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Grasa</label>
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Grasa" value="<?php echo $resul->grasa; ?>" class="form-control" name="grasa" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Musculo</label>
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Músculo" value="<?php echo $resul->musculo; ?>" class="form-control" name="musculo" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Agua</label>
                <input type="text"  onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Agua" value="<?php echo $resul->agua; ?>" class="form-control" name="agua" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Grava V</label>
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Grasa Visceral" value="<?php echo $resul->grasa_v; ?>" class="form-control" name="grasa_v" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Hueso</label>
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Hueso" value="<?php echo $resul->hueso; ?>" class="form-control" name="hueso" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Metabolismo</label>
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Metabolismo" value="<?php echo $resul->metabolismo; ?>" class="form-control" name="metabolismo" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Proteina</label>
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Proteina" value="<?php echo $resul->proteina; ?>" class="form-control" name="proteina" required>
            </div><br>
            <div class="form-group">
				<label for="formGroupExampleInput" style="color: #fff;" class="form-label">Obesidad</label>
                <input type="text" onkeyup="numeros(this)" maxlength="5" step="0.01" autocomplete="off" placeholder="Obesidad" value="<?php echo $resul->obesidad; ?>" class="form-control" name="obesidad" required>
            </div><br>
            <button type="submit" name="submit" class="btn btn-warning boton-registrarr">Actualizar</button>
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
<?php }else{echo "<script>alert('Algo salio mal.');</script>";
        echo'<script>window.location="../membresias/lista-datos.php"</script>';} ?>