<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php require_once "../includes/header.php"; ?>

<div class="auth-container">
    <div class="auth-card">
        <h2>Crear cuenta 👟</h2>
        <p>Regístrate para comprar y gestionar tus pedidos.</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <form action="procesar_registro.php" method="POST">

            <label>Nombre</label>
            <input type="text" name="nombre" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <button class="btn" type="submit">Crear cuenta</button>
        </form>

        <p class="auth-footer">
            ¿Ya tienes cuenta?
            <a href="login.php">Inicia sesión</a>
        </p>
    </div>
</div>

</body>
</html>
