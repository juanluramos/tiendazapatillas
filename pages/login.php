<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php require_once "../includes/header.php"; ?>

<div class="auth-container">
  <div class="auth-card">
    <h2>Iniciar sesión</h2>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-error">
        <?= htmlspecialchars($_GET['error']) ?>
      </div>
    <?php endif; ?>

    <form action="procesar_login.php" method="POST">
      <label>Email</label>
      <input type="email" name="email" required>

      <br><br>

      <label>Contraseña</label>
      <input type="password" name="password" required>

      <br><br>

      <button class="btn" type="submit">
        Entrar
      </button>
    </form>

    <p style="text-align:center; margin-top:15px;">
      ¿No tienes cuenta?
      <a href="registro.php">Regístrate</a>
    </p>
  </div>
</div>

</body>
</html>
