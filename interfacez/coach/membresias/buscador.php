<?php
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
session_start();

$coach = $_SESSION['document'];
$buscador = $conexion->prepare("SELECT (SELECT nombre FROM usuarios WHERE documento = membresias.doc_coach) AS nombre_coach, id_membresias, membresias.doc_cl ,usuarios.nombre, membresias.genero, membresias.fecha_inicio, membresias.fecha_fin, membresias.fecha_pago, membresias.discapacidad , estado.id_estado ,estado.estado FROM membresias INNER JOIN estado ON membresias.id_estado=estado.id_estado INNER JOIN usuarios ON usuarios.documento = membresias.doc_cl AND membresias.doc_coach = '$coach' AND usuarios.nombre LIKE LOWER('%" . $_POST["buscar"] . "%')");

$buscador->execute();
$numero = $buscador->rowCount();
?>

<h3 class="card-tittle">Resultados encontrados (
    <?php echo $numero; ?>):
</h3>

<table class="table table-bordered">
    <tr style="text-align: center;">
        <th style="text-align: center;">Vendedor</th>
        <th style="text-align: center;">Nombre</th>
        <th style="text-align: center;">Fecha de inicio</th>
        <th style="text-align: center;">Fecha de vencimiento</th>
        <th style="text-align: center;">Fecha de pago</th>
        <th style="text-align: center;">Estado</th>
        <th style="text-align: center;" colspan="4">Accion</th>
    </tr>


    <?php while ($cons = $buscador->fetch()) { ?>

        <tr>
            <td class="card-text" style="width:90px;text-align: center;">
                <?= $cons['nombre_coach'] ?>
            </td>
            <td class="card-text" style="width:90px;text-align: center;">
                <?= $cons['nombre'] ?>
            </td>
            <td class="card-text" style="width:100px;text-align: center;">
                <?= $cons['fecha_inicio'] ?>
            </td>
            <td class="card-text" style="width:90px;text-align: center;">
                <?= $cons['fecha_fin'] ?>
            </td>
            <td class="card-text" style="width:90px;text-align: center;">
                <?= $cons['fecha_pago'] ?>
            </td>
            <?php if ($cons['id_estado'] == 1) {
                $color = 'rgb(6, 213, 0)'; // Verde si es estado 1
            } else {
                $color = 'rgb(209, 0, 0)'; // Rojo si es estado 2
            }
            ?>
            <td class="card-text" style="width:90px;text-align: center; background-color: <?= $color ?>;"><?= $cons['estado'] ?>
            </td>
            <td class="card-text" style="width:30px;text-align:center;">
                <form action="../datos/lista-datos.php" method="get">
                    <input type="hidden" name="datos" value="<?= $cons['doc_cl'] ?>">
                    <button type="submit" class="btn btn-warning"><img style="width:30px;" src="../../../iconos/waist.png"
                            alt="medidas"></button>
                </form>
            </td>
            <td class="card-text" style="width:30px; text-align:center;">
                <form action="../membresias/renovar-membresia.php" method="get">
                    <input type="hidden" name="renovar" value="<?= $cons['doc_cl'] ?>">
                    <button name="renov" class="btn btn-success" type="submit"><img style="width:30px;"
                            src="../../../iconos/hand.png" alt="renovar"></button>
                </form>
            </td>
            <td class="card-text" style="width:30px; text-align:center;">
                <form action="../membresias/eliminar-membresia.php" method="get">
                    <input type="hidden" name="eliminar" value="<?= $cons['id_membresias'] ?>">
                    <button class="btn btn-danger" type="submit"><img style="width:30px;" src="../../../iconos/delete.png"
                            alt="borrar"></button>
                </form>
            </td>
            <td class="card-text" style="width:30px; text-align:center;">
                <form action="codigo-usuario-barras.php" method="get">
                    <input type="hidden" name='doc' value="<?= $cons['doc_cl'] ?>">
                    <button name="boton-imprimir" class="btn btn-light" type="submit"><img style="width:30px;"
                            src="../../../iconos/barcode.png" alt="codigo_barras"></button>
                </form>
            </td>
        </tr>

    <?php } ?>
</table>
<div style="float: right;" class="descargas">
    <h3>REPORTE</h3>
    <a href="Exel.php" class="btn btn-success exel">EXCEL</a>
    <a href="PDF.php" class="btn btn-danger">PDF</a>
</div>