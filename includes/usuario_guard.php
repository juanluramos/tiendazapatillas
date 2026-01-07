<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /tiendazapatillas/pages/login.php?error=Debes iniciar sesión");
    exit;
}
