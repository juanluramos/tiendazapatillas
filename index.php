<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TiendaZapatillas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php require_once "includes/header.php"; ?>

<section class="hero">
    <h1>Bienvenido a TiendaZapatillas 👟</h1>
    <p>Las mejores zapatillas, por talla y con stock real.</p>

    <div class="hero-actions">
        <a class="btn" href="pages/productos.php">Ver productos</a>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <a class="btn btn-secondary" href="pages/panel.php">Mi cuenta</a>
        <?php else: ?>
            
            <a class="btn btn-secondary" href="pages/registro.php">Registrate</a>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <h2>Compra fácil y segura</h2>
    <p>
        Elige tu modelo, selecciona tu talla y compra con total tranquilidad.
        Gestiona tus pedidos desde tu cuenta personal.
    </p>
</section>

<section class="section">
    <h2>Gestión profesional</h2>
    <p>
        Stock por talla, pedidos con seguimiento y panel de administración completo.
    </p>
</section>

</body>
</html>

