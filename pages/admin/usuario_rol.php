<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$id  = $_POST['id'] ?? null;
$rol = $_POST['rol'] ?? null;

if (!$id || !in_array($rol, ['usuario','admin'])) {
    die("Datos incorrectos");
}

// Evitar cambiarse a uno mismo
if ($id == $_SESSION['usuario_id']) {
    die("No puedes cambiar tu propio rol");
}

$q = $conexion->prepare("
    UPDATE usuarios
    SET rol = ?
    WHERE id = ?
");
$q->bind_param("si", $rol, $id);
$q->execute();

header("Location: usuarios.php");
exit;
