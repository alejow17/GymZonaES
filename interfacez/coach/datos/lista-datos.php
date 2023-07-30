<?php
define('FACTOR_HOMBRE', 0.9);
define('FACTOR_MUJER', 0.85);

require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
include "../../../control-ingreso/validar-sesion.php";

$doc = $_GET['datos'];
$sentencia = $conexion->query("SELECT doc_cl, genero FROM membresias WHERE doc_cl='$doc'");
$sent = $sentencia->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['datos'])) {
  $doc = $_GET['datos'];
}

$consulta1 = $conexion->prepare("SELECT * FROM usuarios WHERE documento = :doc");
$consulta1->bindParam(':doc', $doc);
$consulta1->execute();
$cons1 = $consulta1->fetch(PDO::FETCH_ASSOC);

$consulta2 = $conexion->prepare("SELECT * FROM datos_fisicos WHERE documento = :doc ORDER BY fecha DESC");
$consulta2->bindParam(':doc', $doc);
$consulta2->execute();
$cons2 = $consulta2->fetchAll(PDO::FETCH_ASSOC);

$consulta3 = $conexion->prepare("SELECT edad, peso, estatura, grasa_v FROM datos_fisicos WHERE documento = :doc ORDER BY fecha DESC LIMIT 1");
$consulta3->bindParam(':doc', $doc);
$consulta3->execute();
$ultimoRegistro = $consulta3->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['boton_volver'])) {
  echo '<script>window.location="../membresias/listar-membresias.php"</script>';
}

if (isset($_POST['btn_crear'])) {
  echo '<script>window.location="nuevos-datos.php"</script>';
}

if (isset($_POST['btn_eliminar'])) {
  $id = $_POST['id_datos_fisicos'];
  $consulta = $conexion->prepare("DELETE FROM datos_fisicos WHERE id_datos_fisicos = :id_datos_fisicos");
  $consulta->bindParam(':id_datos_fisicos', $id);
  $consulta->execute();
  echo '<script>alert("Registro eliminado correctamente")</script>';
  echo '<script>window.location="../membresias/listar-membresias.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<style>
  .casilla-medidas {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #fff;
    padding: 10px;
    border: 1px solid #ccc;
  }

  body {
    background-color: #f5f5f5;
    color: #333;
    font-family: Arial, sans-serif;
  }

  .container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
  }

  .btn {
    display: inline-block;
    padding: 8px 12px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
  }

  .btn-success {
    background-color: #28a745;
  }

  .table {
    width: 50%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }

  .table th,
  .table td {
    padding: 8px;
    border: 1px solid #ccc;
    text-align: center;
  }

  .table th {
    background-color: #f8f8f8;
    font-weight: bold;
  }

  /* Estilos para los colores de la grasa visceral */
  .grasa-baja {
    background-color: blue;
    color: white;
  }

  .grasa-estable {
    background-color: green;
    color: white;
  }

  .grasa-alta {
    background-color: red;
    color: white;
  }
</style>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--Boobtstrap-->
  <script src="../../../css/bootstrap-5.3.0-alpha3-dist/js/bootstrap.js"></script>
  <!-- bootstrap sin internet -->
  <link rel="stylesheet" href="../../../css/bootstrap-5.3.0-alpha3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="../listar/listar-usuarios.css">
  <!-- favicon -->
  <link rel="icon" href="../../../img/logo-zona-gym.png">
  <title>Lista Medidas</title>
</head>

<body>
  <div class="container">
    <form method="post">
      <button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
      <h1>LISTA DE DATOS</h1>
    </form>
    <?php foreach ($sent as $se) { ?>
      
      <a class="btn btn-success" href="<?php echo "nuevos-datos.php?id=" . $se->doc_cl ?>">NUEVOS DATOS</a><br>
    <?php } ?>
    <br>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Documento</th>
            <th scope="col">Nombre</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (count($cons1) === 0) {
            echo '<tr><td colspan="2">No se encontraron registros.</td></tr>';
          } else {
            ?>
              <tr>
                <td>
                  <?php echo $cons1['documento'] ?>
                </td>
                <td>
                  <?php echo $cons1['nombre'] ?>
                </td>
              </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr style="font-size: 12px;">
            <th scope="col">Fecha</th>
            <th scope="col">Edad</th>
            <th scope="col">Peso</th>
            <th scope="col">Estatura</th>
            <th scope="col">Pecho</th>
            <th scope="col">BMI</th>
            <th scope="col">Cintura</th>
            <th scope="col">Cadera</th>
            <th scope="col">Brazo Izquierdo</th>
            <th scope="col">Brazo Derecho</th>
            <th scope="col">Grasa</th>
            <th scope="col">Grasa V</th>
            <th scope="col">Agua</th>
            <th scope="col">Musculo</th>
            <th scope="col">Hueso</th>
            <th scope="col">Metabolismo</th>
            <th scope="col">Proteina</th>
            <th scope="col">Obesidad</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (count($cons2) === 0) {
            echo '<tr><td colspan="17">No se encontraron registros.</td></tr>';
          } else {
            foreach ($cons2 as $cons2) { ?>
              <tr style="font-size: 13px;">
                <td class="fecha">
                  <?php echo $cons2['fecha'] ?>
                </td>
                <td>
                  <?php echo $cons2['edad'] ?>
                </td>
                <td>
                  <?php echo $cons2['peso'] . "kg"?>
                </td>
                <td>
                  <?php echo $cons2['estatura'] . "cm" ?>
                </td>
                <td>
                  <?php echo $cons2['pecho'] . "cm"?>
                </td>
                <td>
                  <?php echo $cons2['bmi'] ?>
                </td>
                <td>
                  <?php echo $cons2['cintura'] . "cm"?>
                </td>
                <td>
                  <?php echo $cons2['cadera'] . "cm"?>
                </td>
                <td>
                  <?php echo $cons2['brazo_izquierdo'] . "cm"?>
                </td>
                <td>
                  <?php echo $cons2['brazo_derecho'] . "cm"?>
                </td>
                <td>
                  <?php echo $cons2['grasa'] ?>
                </td>
                <td>
                  <?php echo $cons2['grasa_v'] ?>
                </td>
                <td>
                  <?php echo $cons2['agua'] ?>
                </td>
                <td>
                  <?php echo $cons2['musculo'] ?>
                </td>
                <td>
                  <?php echo $cons2['hueso'] ?>
                </td>
                <td>
                  <?php echo $cons2['metabolismo'] ?>
                </td>
                <td>
                  <?php echo $cons2['proteina'] ?>
                </td>
                <td>
                  <?php echo $cons2['obesidad'] ?>
                </td>
              </tr>
          <?php }
          } ?>
        </tbody>
      </table>
    </div><br>

    <div class="table-responsive">
      <h2 style="font-size:25px;color:white;">TU PESO IDEAL</h2>
      <p style="font-size:15px;color:white;">Este se determinará según tu edad, peso y altura.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Edad</th>
            <th scope="col">Peso actual</th>
            <th scope="col">Peso Ideal</th>
            <th scope="col">Mensaje de Recomendación</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $generoUsuario = ''; // Inicializamos la variable para guardar el género del usuario
          foreach ($sent as $se) {
            // Obtenemos el género del usuario de la tabla de membresías
            $generoUsuario = $se->genero;
          }

          $edad = $ultimoRegistro['edad'] ?? ''; // Usar operador de fusión de null para asignar un valor predeterminado
          $peso = $ultimoRegistro['peso'] ?? '';
          $estatura = $ultimoRegistro['estatura'] ?? '';
          $pesoIdeal = '';
          $recomendacion = '';

          if ($edad && $peso && $estatura) {
            // Realizar el cálculo del "Peso Ideal" y obtener la recomendación solo si existen los datos necesarios
            $pesoIdeal = calcularPesoIdeal($generoUsuario, $edad, $estatura);
            $recomendacion = obtenerRecomendacion($peso, $pesoIdeal);
          }
          ?>
          <tr>
            <td><?php echo $edad; ?></td>
            <td><?php echo $peso . "kg"; ?></td>
            <td><?php echo $pesoIdeal . "kg"; ?></td>
            <td><?php echo $recomendacion; ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="table-responsive">
      <h2 style="font-size:25px;color:white;">GRASA VISCERAL</h2>
      <p style="color:white;">Esta se determina comparando la grasa visceral con los datos recomendables.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Grasa Visceral</th>
            <th scope="col">Recomendación</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $grasaVisceral = $ultimoRegistro['grasa_v'] ?? '';
          $recomendacionGrasaV = '';

          if ($grasaVisceral) {
            $recomendacionGrasaV = obtenerRecomendacionGrasaV($grasaVisceral);
          }

          $colorGrasaVisceral = '';
          if ($grasaVisceral < 10) {
            $colorGrasaVisceral = 'background-color: blue; color: white;';
          } elseif ($grasaVisceral >= 10 && $grasaVisceral <= 20) {
            $colorGrasaVisceral = 'background-color: green; color: white;';
          } else {
            $colorGrasaVisceral = 'background-color: red; color: white;';
          }
          ?>
          <tr>
            <td><?php echo $grasaVisceral; ?></td>
            <td style="<?php echo $colorGrasaVisceral ?>"><?php echo $recomendacionGrasaV; ?></td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</body>
</html>

<?php

function calcularPesoIdeal($genero, $edad, $estatura)
{
    // Calcular el peso ideal según el género utilizando la Fórmula de Devine
    if ($genero === 'M') {
        // Para hombres
        $pesoIdeal = 50 + 0.91 * ($estatura - 152.4) + 0.825 * $edad;
    } else {
        // Para mujeres
        $pesoIdeal = 45.5 + 0.91 * ($estatura - 152.4) + 0.675 * $edad;
    }

    return $pesoIdeal;
}

function obtenerRecomendacion($peso, $pesoIdeal)
{
  // Comparar el peso actual con el peso ideal
  $diferencia = $peso - $pesoIdeal;
  if ($diferencia < 0) {
    $recomendacion = "Debes aumentar " . abs($diferencia) . " kg para alcanzar tu peso ideal.";
  } elseif ($diferencia > 0) {
    $recomendacion = "Debes reducir " . $diferencia . " kg para alcanzar tu peso ideal.";
  } else {
    $recomendacion = "Tu peso es ideal. ¡Felicidades!";
  }
  return $recomendacion;
}

function obtenerRecomendacionGrasaV($grasaVisceral)
{
  // Comparar el valor de la grasa visceral con los rangos recomendados
  if ($grasaVisceral < 10) {
    $recomendacion = "Tu nivel de grasa visceral es bajo. No es necesario reducirlo.";
  } elseif ($grasaVisceral >= 10 && $grasaVisceral <= 20) {
    $recomendacion = "Tu nivel de grasa visceral es moderado. Mantén un estilo de vida saludable para mantenerlo bajo control.";
  } else {
    $recomendacion = "Tu nivel de grasa visceral es alto. Se recomienda tomar medidas para reducirlo, como hacer ejercicio y mejorar la alimentación.";
  }
  return $recomendacion;
}