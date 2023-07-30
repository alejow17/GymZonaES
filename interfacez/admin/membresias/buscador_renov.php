<?php
require_once("../../../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();

// $buscador = $conexion->prepare("SELECT usuarios.*, renovaciones.* FROM usuarios JOIN renovaciones ON usuarios.documento = renovaciones.doc_cl AND usuarios.nombre LIKE LOWER('%".$_POST["buscar"]."%')");

$buscador = $conexion->prepare("SELECT usuarios.*, renovaciones.* FROM usuarios JOIN renovaciones ON usuarios.documento = renovaciones.doc_cl AND usuarios.nombre LIKE LOWER('%".$_POST["buscar"]."%')");

$buscador->execute();
$numero = $buscador->rowCount();
?>

<h3 class="card-tittle">Resultados encontrados (<?php echo $numero; ?>):
</h3>

<table class="table table-bordered">
                <tr style="text-align: center;">
                    <th style="text-align: center;">Documento</th>
                    <th style="text-align: center;">Nombre</th>
                    <th style="text-align: center;">Fecha de inicio</th>
                    <th style="text-align: center;">Fecha de vencimiento</th>
                    <th style="text-align: center;">Fecha de pago</th>
                </tr>
        <?php
            while ($cons = $buscador->fetch())
            {
        ?>
        
                <tr style="text-align: center;">
                    <td style="width:90px;text-align: center;"><?=$cons['doc_cl']?></td>
                    <td style="width:90px;text-align: center;"><?=$cons['nombre']?></td>
                    <td style="width:100px;text-align: center;"><?=$cons['fecha_ini']?></td>
                    <td style="width:90px;text-align: center;"><?=$cons['fecha_fin']?></td>
                    <td style="width:90px;text-align: center;"><?=$cons['fecha_pago']?></td>
                </tr>
        <?php
        }
        ?>
        </table>
        <div class="descargas">
            <h3>REPORTE</h3>
            <a href="Exel.php" class="btn btn-success exel">EXCEL</a>
            <a href="PDF.php" class="btn btn-danger">PDF</a>
        </div>