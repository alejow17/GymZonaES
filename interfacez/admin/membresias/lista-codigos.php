<?php
session_start();
require_once("../../../bd/conexion.php");
include "../../../control-ingreso/validar-sesion.php";
$bd = new Database();
$conexion = $bd->conectar();
$consulta = $conexion-> prepare ("SELECT * FROM membresias");
$consulta->execute();
?>

<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="../membresias/listar-membresias.php"</script>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Boobtstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Membresias</title>
    <link rel="stylesheet" href="../listar/listar-usuarios.css">
    <script src="JsBarcode.all.min.js"></script>
    
</head>
<body>
    <div class="container contenedor1">
        <form method="post">
        <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>  
        <h1>CODIGOS DE BARRAS</h1>
        </form>
        <br>
        <div class="table-responsive">
        <table class="table table-bordered">
                <tr>
                    <th style="text-align: center;">Codigo de barras</th>
                    <th style="text-align: center;">Documento</th>
                    <th style="text-align: center;">Nombre</th>
                    <th style="text-align: center;">Accion</th>
                </tr>
        <?php
            foreach($consulta as $cons) {
                $codigo_barras = $cons['documento'];
            ?>
                <script>
                    JsBarcode("#barcode<?php echo $codigo_barras; ?>", "<?php echo $codigo_barras; ?>", {
                        format: "codabar",
                        lineColor: "#000",
                        width: 2,
                        height: 30,
                        displayValue: true
                    });
                </script>
                <tr>
                    <td><svg id='<?php echo "barcode".$codigo_barras; ?>'></td>
                    <td style="text-align: center;"><?=$cons['documento']?></td>
                    <td style="text-align: center;"><?=$cons['nombre']?></td>
                    <td style="text-align:center;" >
                        <form action="codigo-usuario-barras.php" method="get">
                            <input type="hidden" name='doc' value="<?=$cons['documento']?>">
                            <button name="boton-imprimir" class="btn btn-primary"  type="submit">Imprimir</button>
                        </form>
                    </td>
                </tr>
        <?php
        }
        ?>
        </table>
        </div>
    </div>
</body>
<script type="text/javascript">

		function arrayjsonbarcode(j){
			json=JSON.parse(j);
			arr=[];
			for (var x in json) {
				arr.push(json[x]);
			}
			return arr;
		}

		var valores = <?php echo json_encode($consulta->fetchAll(PDO::FETCH_COLUMN)); ?>;
        for (var i = 0; i < valores.length; i++) {
        JsBarcode("#barcode" + valores[i], valores[i].toString(), {
        format: "codabar",
        lineColor: "#000",
        width: 2,
        height: 30,
        displayValue: true
    });
}

		
	</script>
</html>