<?php
require_once("barcode/vendor/autoload.php");
require_once("../../../bd/conexion.php");
session_start();
$basedatos = new Database();
$conexion = $basedatos->conectar();
$sentencia = $conexion->prepare("SELECT * FROM productos WHERE codigo=:codigo");
$sentencia->bindValue(':codigo', $_GET['doc']);
$sentencia->execute();
$productos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
     if(isset($_POST['boton_volver'])){
         echo '<script>window.location="listar-codigos-barras.php"</script>';
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
			<form method="post"> 
                <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
        	</form>
			<br>
			<table style="margin-left:25%;width: 500px;" class="table table-bordered">
				<thead>
					<tr style="text-align: center;" >
                        <th>Código de barras</th>
						<th>Descripción</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($productos as $producto){
				    $codigo_barras = $producto['codigo'];
				    ?>
					<tr style="text-align: center;" >
    				<td><svg id='<?php echo "barcode".$codigo_barras; ?>'></svg></td>
    				<td><?php echo $producto['descripcion']?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>

<script type="text/javascript">

		var codigos_barras = <?php echo json_encode(array_column($productos, 'codigo')); ?>;
		codigos_barras.forEach(function(codigo_barras) {
			JsBarcode("#barcode"+codigo_barras, codigo_barras, {
				format: "CODE128",
				lineColor: "#000000",
				width: 2,
				height: 50,
				displayValue: true
			});
		});

	</script>
