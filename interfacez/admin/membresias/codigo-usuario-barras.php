<?php
require_once("../../../bd/conexion.php");
session_start();
include "../../../control-ingreso/validar-sesion.php";
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion-> prepare ("SELECT * FROM membresias INNER JOIN estado ON membresias.id_estado=estado.id_estado INNER JOIN usuarios ON documento=doc_cl WHERE membresias.doc_cl='".$_GET['doc']."'");
$consulta->execute();
date_default_timezone_set('America/Bogota');
$fecha_actual = date('Y-m-d H:i:s');
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="listar-membresias.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Boobtstrap-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->

    <!-- bootstrap sin internet -->
    <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
    <!-- favicon -->
    <link rel="icon" href="../../../img/logo-zona-gym.png">
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <title>Imprimir Membresias</title>
</head>
<body>
    <div class="container contenedor1">
        <form method="post">
        <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>  
        </form>
        <br>
        <div class="table-responsive">
        <table style="margin-left:25%;width: 450px;float: center;" class="table table-bordered">
                <tr>
                    <th style="text-align: center;">Codigo de barras</th>
                    <th style="text-align: center;">Nombre</th>
                </tr>
        <?php
            foreach($consulta as $cons)
            {
                $doc = $cons['doc_cl'];
        ?>
        
                <tr>
                    <td><img src="barcode.php?text=<?php echo $cons['doc_cl'] ?>&size=40&codetype=Code39&print=true" /></td>
                    <td style="text-align: center;"><?=$cons['nombre']?></td>
                </tr>
        <?php
        }
        ?>
        </table>
        </div>
    </div>
</body>
</html>
