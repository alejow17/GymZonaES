<?php
require_once("barcode/vendor/autoload.php");
require_once("../../../bd/conexion.php");
session_start();
$basedatos = new Database();
$conexion = $basedatos->conectar();

// Pagination variables
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$entriesPerPage = 5;
$offset = ($page - 1) * $entriesPerPage;

$doc = $_SESSION['document'];
$countQuery = $conexion->query("SELECT COUNT(*) FROM productos WHERE coach = '$doc';");
$totalEntries = $countQuery->fetchColumn();
$totalPages = ceil($totalEntries / $entriesPerPage);

$sentencia = $conexion->query("SELECT *,(SELECT nombre from usuarios WHERE documento = coach) AS nomvendedor FROM productos WHERE coach = '$doc' LIMIT $offset, $entriesPerPage;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
?>

<?php
if (isset($_POST['boton_volver'])) {
	echo '<script>window.location="../index-admin.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<link rel="stylesheet" href="listar-productos.css">
	<!-- favicon -->
	<link rel="icon" href="../../../img/logo-zona-gym.png">
	<title>Productos</title>
</head>

<body>
	<nav class="navega">
		<!-- el nav hace que todo quede en fila... el nav-tabs hace que se dividan las sesiones -->
		<!-- justify-contend-end que el menu quede al lado derecho de la pantalla -->
		<ul class="nav nav-tabs justify-content-center">
			<li class="nav-item">
				<a class="nav-link text-light p-3" aria-current="page" href="../index-admin.php"><b>MENU</b></a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-light p-3 dropdown-toggle"
					href="../listar/listar-usuarios.php"><b>USUARIOS</b></a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-light p-3" href="../listar/listar-roles.php"><b>ROLES</b></a>
			</li>
			<li class="nav-item">
				<a class="nav-link active text-bg-warning p-3" href="../ventas/listar.php"><b
						style="color: white;">PRODUCTOS</b></a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-light p-3" href="../servicios/lista_ventas_servicios.php"><b>SERVICIOS</b></a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-light p-3" href="../ventas/ventas.php"><b>VENTAS</b></a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-light p-3" href="../membresias/listar-membresias.php"><b>MEMBRESIAS</b></a>
			</li>
		</ul>
	</nav>
	<div class="col-xs-12 contenedor1">
		<form class="volver" method="post">
			<button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
		</form>
		<form method="post">
			<h1>PRODUCTOS</h1>
			<a class="btn btn-success" href="./nuevo-producto.php">Crear producto<i class="fa fa-plus"></i></a>
			<a class="btn btn-primary" style="float:right" href="listar-codigos-barras.php">Codigos de barras<i
					class="fa fa-plus"></i></a>
		</form>
		<br>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Coach</th>
					<th>Código producto</th>
					<th>Descripción</th>
					<th>Precio de venta</th>
					<th>Existencia</th>
					<th>Editar</th>
					<th>Eliminar</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($productos as $producto) {
					$prod_id = $producto->codigo
						?>
					<tr>
						<td>
							<?php echo $producto->nomvendedor ?>
						</td>
						<td>
							<?php echo $producto->codigo ?>
						</td>
						<td>
							<?php echo $producto->descripcion ?>
						</td>
						<td>
							<?php echo $producto->precioVenta ?>
						</td>
						<td>
							<?php echo $producto->existencia ?>
						</td>
						<td><a class="btn btn-warning" href="<?php echo "editar.php?id=" . $producto->id ?>"><img
									style="width:30px;" src="../../../iconos/pencil.png" alt="borrar"></a></td>
						<td><a class="btn btn-danger"
								onclick="return confirm('Quiere eliminar <?php echo $producto->descripcion ?>?')"
								href="<?php echo "eliminar.php?id=" . $producto->id ?>"><img style="width:30px;"
									src="../../../iconos/delete.png" alt="borrar"></a></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class="container text-center">
			<?php
			// Previous page link
			if ($page > 1) {
				echo '<a class="btn btn-warning" href="?page=' . ($page - 1) . '">&laquo; Previo</a>';
			}

			// Page numbers
			for ($i = 1; $i <= $totalPages; $i++) {
				echo '<a class="btn btn-warning" style="margin-right: 5px; margin-left: 5px;" href="?page=' . $i . '"';
				if ($page == $i) {
					echo ' class="active"';
				}
				echo '>' . $i . '</a>';
			}

			// Next page link
			if ($page < $totalPages) {
				echo '<a class="btn btn-warning" href="?page=' . ($page + 1) . '">Siguiente &raquo;</a>';
			}
			?>
		</div>
	</div>
</body>

</html>