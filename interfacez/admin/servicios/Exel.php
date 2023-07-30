<?php
header("content-Type: application/xls");
header("content-Disposition: attachment; filename= servicios_vendidos.xls");
require_once("../../../bd/conexion.php");
session_start();
include "../../../control-ingreso/validar-sesion.php";

$bd = new Database();
$conexion = $bd->conectar();
$documento = $_SESSION['document'];
$consulta = $conexion->prepare("SELECT (SELECT nombre FROM usuarios WHERE documento = $documento) AS nombre_coach, fecha, desc_servicio, doc_client, nombre, precio FROM venta_serv, servicios, usuarios WHERE doc_client = documento AND venta_serv.id_serv = servicios.id_servicio");
$consulta->execute();

date_default_timezone_set('America/Bogota');
$fecha_actual = date('Y-m-d');
$docu = $_SESSION['name'];
?>

<?php
if (isset($_POST['boton_codigos'])) {
	echo '<script>window.location="lista-codigos.php"</script>';
}
?>

<?php
if (isset($_POST['boton_volver'])) {
	echo '<script>window.location="../index-admin.php"</script>';
}
?>

<?php
if (isset($_POST['btn_crear'])) {
	echo '<script>window.location="../membresias/crear-membresia.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<div class="container contenedor1">
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr>
					<th style="text-align: center;">Vendedor</th>
					<th style="text-align: center;">Documento de cliente</th>
					<th style="text-align: center;">Nombre de cliente</th>
					<th style="text-align: center;">Fecha</th>
					<th style="text-align: center;">Servicio</th>
					<th style="text-align: center;">Total</th>
				</tr>
				<?php
				foreach ($consulta as $cons) {
				?>

					<tr>
						<td style="text-align: center;">
							<?= $cons['nombre_coach'] ?>
						</td>
						<td style="text-align: center;">
							<?= $cons['doc_client'] ?>
						</td>
						<td style="text-align: center;">
							<?= $cons['nombre'] ?>
						</td>
						<td style="text-align: center;">
							<?= $cons['fecha'] ?>
						</td>
						<td style="text-align: center;">
							<?= $cons['desc_servicio'] ?>
						</td>
						<td style="text-align: center;">
							<?= $cons['precio'] ?>
						</td>
					</tr>
				<?php
				}
				?>

			</table>
		</div>
	</div>
</body>

</html>