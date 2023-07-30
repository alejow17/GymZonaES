<?php
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();

$buscador = $conexion->prepare("SELECT (SELECT nombre FROM usuarios WHERE documento = ventas.vendedor) AS vendedor, nombre, doc_cliente, ventas.total, ventas.fecha, ventas.id, GROUP_CONCAT(productos.codigo, '..', productos.descripcion, '..', productos_vendidos.cantidad SEPARATOR '__') AS productos FROM ventas INNER JOIN productos_vendidos ON productos_vendidos.id_venta = ventas.id INNER JOIN productos ON productos.id = productos_vendidos.id_producto INNER JOIN usuarios ON usuarios.documento = ventas.doc_cliente  AND nombre LIKE LOWER('%".$_POST["buscar"]."%') GROUP BY ventas.id ORDER BY ventas.id");
$buscador->execute();
$ventas = $buscador->fetchAll(PDO::FETCH_OBJ);
$numero = $buscador->rowCount();
?>

<h3 class="card-tittle">Resultados encontrados (<?php echo $numero; ?>):
</h3>

<table class="table table-bordered">
            <thead>
                <tr style="text-align: center;">
                    <th>Vendedor</th>
                    <th>Documento cliente</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Productos vendidos</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($ventas as $venta){ ?>
                <tr style="text-align: center;">
                    <td><?php echo $venta->vendedor ?></td>
                    <td><?php echo $venta->doc_cliente ?></td>
                    <td><?php echo $venta->nombre ?></td>
                    <td><?php echo $venta->fecha ?></td>
                    <td>
                        <table class="table table-bordered">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach(explode("__", $venta->productos) as $productosConcatenados){ 
                                $producto = explode("..", $productosConcatenados)
                                ?>
                                <tr style="text-align: center;">
                                    
                                    <td><?php echo $producto[1] ?></td>
                                    <td><?php echo $producto[2] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
					</td>
					<td><?php echo '$'. $venta->total ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>