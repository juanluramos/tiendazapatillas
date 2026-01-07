<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">


</head>
<body>
    
</body>
</html>
<header>
  <div class="container">
    <nav style="display:flex; justify-content:space-between; align-items:center;">
      <strong>👟 TiendaZapatillas</strong>
      <div>
        <a href="/tiendazapatillas/">Inicio</a>
        <a href="/tiendazapatillas/pages/productos.php">Productos</a>

        <?php if (isset($_SESSION['usuario_id'])): ?>
          <a href="/tiendazapatillas/pages/panel.php">Mi cuenta</a>
          <a href="/tiendazapatillas/pages/logout.php">Salir</a>
        <?php else: ?>
          <a href="/tiendazapatillas/pages/login.php">Login</a>
          <a href="/tiendazapatillas/pages/registro.php">Registro</a>
        <?php endif; ?>
      </div>
    </nav>
  </div>
</header>

