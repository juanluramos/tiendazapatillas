<?php
//require_once "../includes/usuario_guard.php";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi cuenta</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php require_once "../includes/header.php"; ?>

<div class="container">
    <h2>Hola, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?> 👋</h2>
<p>Bienvenido a tu área personal.</p>


    <div class="admin-grid">
        <div class="admin-card">
            <h3>🛒 Mi carrito</h3>
            <p>Revisa los productos que has añadido.</p>
            <a class="btn" href="carrito.php">Ver carrito</a>
        </div>

        <div class="admin-card">
            <h3>📦 Mis pedidos</h3>
            <p>Consulta el estado de tus pedidos.</p>
            <a class="btn" href="pedidos.php">Ver pedidos</a>
        </div>

        <div class="admin-card">
            <h3>👟 Tienda</h3>
            <p>Seguir comprando zapatillas.</p>
            <a class="btn btn-secondary" href="productos.php">Ir a la tienda</a>
        </div>

        <div class="admin-card">
            <h3>🚪 Cerrar sesión</h3>
            <p>Salir de tu cuenta de forma segura.</p>
            <a class="btn btn-danger" href="logout.php">Salir</a>
        </div>
    </div>
</div>

</body>
</html>
