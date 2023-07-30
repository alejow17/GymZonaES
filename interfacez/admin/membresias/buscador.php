<?php
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
// Pagination variables
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$entriesPerPage = 5;
$offset = ($page - 1) * $entriesPerPage;
$buscador = $conexion->prepare("SELECT (SELECT nombre FROM usuarios WHERE documento = membresias.doc_coach) AS nombre_coach, id_membresias, membresias.doc_cl ,usuarios.nombre, membresias.genero, membresias.fecha_inicio, membresias.fecha_fin, membresias.fecha_pago, membresias.discapacidad , estado.id_estado ,estado.estado FROM membresias INNER JOIN estado ON membresias.id_estado=estado.id_estado INNER JOIN usuarios ON usuarios.documento = membresias.doc_cl AND membresias.doc_coach AND usuarios.nombre LIKE LOWER('%" . $_POST["buscar"] . "%')");
$buscador->execute();
$numero = $buscador->rowCount();
$countQuery = $conexion->prepare("SELECT COUNT(*) FROM membresias INNER JOIN estado ON membresias.id_estado=estado.id_estado INNER JOIN usuarios ON usuarios.documento = membresias.doc_cl AND membresias.doc_coach AND usuarios.nombre LIKE LOWER('%" . $_POST["buscar"] . "%')");
$countQuery->execute();
$totalEntries = $countQuery->fetchColumn();
$totalPages = ceil($totalEntries / $entriesPerPage);

$searchResults = '';
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


    <?php foreach ($buscador as $cons) { ?>

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
    <a href="EXCELmembresias.php" class="btn btn-success exel">EXCEL</a>
    <a href="PDFmembresias.php" class="btn btn-danger">PDF</a>
</div>
<?php
$paginationLinks = '';

if ($totalPages > 1) {
    $paginationLinks .= '<div class="container text-center">';

    if ($page > 1) {
        $paginationLinks .= '<a class="btn btn-warning" href="?page=' . ($page - 1) . '">&laquo; Previo</a>';
    }

    for ($i = 1; $i <= $totalPages; $i++) {
        $paginationLinks .= '<a class="btn btn-warning" style="margin-right: 5px; margin-left: 5px;" href="?page=' . $i . '"';
        if ($page == $i) {
            $paginationLinks .= ' class="active"';
        }
        $paginationLinks .= '>' . $i . '</a>';
    }

    if ($page < $totalPages) {
        $paginationLinks .= '<a class="btn btn-warning" href="?page=' . ($page + 1) . '">Siguiente &raquo;</a>';
    }

    $paginationLinks .= '</div>';
}

$response = array(
    'resultados' => $searchResults,
    'pagination' => $paginationLinks
);

// Return the response as JSON

?>