<script src="../../../css/bootstrap-5.3.0-alpha3-dist/js/bootstrap.bundle.min.js"></script>
<nav class="navega">
    <!-- el nav hace que todo quede en fila... el nav-tabs hace que se dividan las sesiones -->
    <!-- justify-contend-end que el menu quede al lado derecho de la pantalla -->
    <ul class="nav nav-tabs justify-content-center">
        <li class="nav-item">
            <a class="nav-link text-light p-3 btn" aria-current="page"
                href="../../admin/index-admin.php"><b>MENU</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light p-3 dropdown-toggle" href="../listar/listar-usuarios.php"><b>USUARIOS</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light p-3" href="../listar/listar-roles.php"><b>ROLES</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light p-3" href="../ventas/listar.php"><b style="color: white; ">PRODUCTOS</b></a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light p-3" href="../servicios/lista_ventas_servicios.php"><b>SERVICIOS</b></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link active text-bg-warning p-3 dropdown-toggle" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <b style="color: white">VENTAS</b>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="ventas.php">Ventas diarias</a></li>
                <li><a class="dropdown-item" href="ventasfecha.php">Ventas por fecha</a></li>
                <li><a class="dropdown-item" href="ventas_por_cliente.php">Ventas por cliente</a></li>
                <li><a class="dropdown-item" href="vender.php">Nueva venta</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link text-light p-3" href="../membresias/listar-membresias.php"><b>MEMBRESIAS</b></a>
        </li>
    </ul>
</nav>