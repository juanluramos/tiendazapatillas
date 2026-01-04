<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?> 👋</h2>

<a href="logout.php">Cerrar sesión</a>
