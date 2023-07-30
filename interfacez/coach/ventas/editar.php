<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
$sentencia = $conexion->prepare("SELECT * FROM productos WHERE id = ?;");
$sentencia->execute([$id]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
if($producto === FALSE){
	echo "¡No existe algún producto con ese ID!";
	exit();
}



?>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="editar-producto.css">
		<title>Editar producto</title>
	</head>
	<div class="col-xs-12 contenedor1">
		<h1>EDITAR PRODUCTO</h1>
		<form method="post" action="guardarDatosEditados.php">
			<input type="hidden" name="id" value="<?php echo $producto->id; ?>">
	
			<label for="codigo">Código de barras:</label>
			<input value="<?php echo $producto->codigo ?>" class="form-control" name="codigo" readonly type="text" id="codigo" placeholder="Escribe el código">

			<label for="descripcion">Nombre del producto:</label>
			<input value="<?php echo $producto->descripcion ?>" id="descripcion" name="descripcion" cols="30" rows="5" class="form-control text-area"></input>

			<label for="precioVenta">Precio de venta:</label>
			<input value="<?php echo $producto->precioVenta ?>" class="form-control" name="precioVenta" type="number" id="precioVenta" placeholder="Precio de venta">

			<label for="existencia">Existencia:</label>
			<input value="<?php echo $producto->existencia ?>" class="form-control" name="existencia" readonly required type="number" id="existencia" placeholder="Cantidad o existencia">
			
			<label for="adicion">Cantidad a añadir:</label>
			<input value="0" class="form-control" name="adicion" type="number" id="adicion" placeholder="Cantidad a añadir">

			<br><br><input class="btn btn-warning" type="submit" value="Guardar">
			<a class="btn btn-danger" href="./listar.php">Cancelar</a>
		</form>
	</div>
