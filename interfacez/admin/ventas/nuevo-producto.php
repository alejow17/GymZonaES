<?php
    if(isset($_POST['boton_volver'])){
        echo '<script>window.location="listar.php"</script>';
    }
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="nuevo_producto.css">
</head>
<div class="col-xs-12 contenedor1">
	<form class="volver" method="post">
    	<button name="boton_volver" class="btn btn-danger btn-atras">Atras</button>
	</form>
	<h1>CREAR PRODUCTO</h1>
	<form method="post" action="nuevo.php" autocomplete="off">
		
		<input class="form-control" name="codigo" required type="number" id="codigo" placeholder="Código del producto">

		<input required id="descripcion" name="descripcion" cols="30" rows="5" placeholder="Digite el nombre del producto" class="form-control"></input>

		
		<input class="form-control" name="precioVenta" required type="number" id="precioVenta" placeholder="Precio de venta">

		
		<input class="form-control" name="existencia" required type="number" id="existencia" placeholder="Cantidad o existencia">
		<br><br><input class="btn btn-warning btn_guardar" type="submit" value="Guardar">
	</form>
</div>