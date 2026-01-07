<?php
require_once "../../includes/admin_guard.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de administración</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php require_once "../../includes/admin_header.php"; ?>

<div class="container">
    <h2 class="admin-title">Panel de administración ⚙️</h2>

    <div class="admin-grid">

        <div class="admin-card">
            <h3>📦 Productos</h3>
            <p>Crear, editar, eliminar productos y gestionar tallas y stock.</p>
            <a class="btn" href="productos.php">Gestionar productos</a>
        </div>

        <div class="admin-card">
            <h3>🧾 Pedidos</h3>
            <p>Consultar pedidos, ver detalles y cambiar estados.</p>
            <a class="btn" href="pedidos.php">Ver pedidos</a>
        </div>

        <div class="admin-card">
    <h3>👤 Usuarios</h3>
    <p>Listado de usuarios registrados y roles.</p>
    <a class="btn" href="usuarios.php">Ver usuarios</a>
</div>


        <div class="admin-card">
            <h3>🏪 Tienda</h3>
            <p>Volver a la tienda pública.</p>
            <a class="btn btn-secondary" href="/tiendazapatillas/pages/productos.php">
                Ir a la tienda
            </a>
        </div>


    </div>
</div>

</body>
</html>
