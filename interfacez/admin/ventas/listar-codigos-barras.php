<?php
require_once("barcode/vendor/autoload.php");
require_once("../../../bd/conexion.php");
session_start();
$basedatos = new Database();
$conexion = $basedatos->conectar();
$sentencia = $conexion->prepare("SELECT * FROM productos");
$sentencia->execute();

$sentenciaa = $conexion->prepare("SELECT codigo FROM productos");
$sentenciaa->execute();
?>

<?php
     if(isset($_POST['boton_volver'])){
         echo '<script>window.location="listar.php"</script>';
     }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- bootstrap -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<link rel="stylesheet" href="listar-productos.css">
		<!-- favicon -->
		<link rel="icon" href="../../../img/logo-zona-gym.png">
		<title>Productos</title>
		<script src="JsBarcode.all.min.js"></script>
		
	</head>

	<body>
		<div class="col-xs-12 contenedor1">
			<!-- <form class="volver" method="post">
				<button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
			</form> -->
			<form method="post"> 
            	<h1>PRODUCTOS</h1>
                <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
        	</form>
			<br>
			<table class="table table-bordered">
				<thead>
					<tr style="text-align: center;" >
                        <th>Codigo de barras</th>
						<th>Descripción</th>
						<th>Dueño</th>
						<th>Accion</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($sentencia as $pro){ 
						$codigo_barras = $pro['codigo'];
					?>
					<tr style="text-align: center;" >
						<td><svg id='<?php echo "barcode".$codigo_barras; ?>'></td>
                        <td><?php echo $pro['descripcion']?></td>
						<td style="text-align:center;"><?php echo $pro['coach']?></td>
						<td style="text-align:center;">
                        <form action="codigo-producto-barras.php" method="get">
                            <input type="hidden" name="doc" value="<?=$pro['codigo']?>">
                            <button name="boton-imprimir" class="btn btn-primary"  type="submit">Imprimir</button>
                        </form>
                    </td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>
<script type="text/javascript">

		function arrayjsonbarcode(j){
			json=JSON.parse(j);
			arr=[];
			for (var x in json) {
				arr.push(json[x]);
			}
			return arr;
		}

		var valores = <?php echo json_encode($sentenciaa->fetchAll(PDO::FETCH_COLUMN)); ?>;
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
</body>
</html>