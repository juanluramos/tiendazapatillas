<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$id = $_POST['id'] ?? null;
$producto_id = $_POST['producto_id'] ?? null;
$stock = $_POST['stock'] ?? null;

if (!$id || !$producto_id || $stock === null) {
    die("Datos incompletos");
}

// Evitar stock negativo
if ($stock < 0) {
    die("El stock no puede ser negativo");
}

$q = $conexion->prepare("
    UPDATE producto_talla
    SET stock = ?
    WHERE id = ?
");
$q->bind_param("ii", $stock, $id);
$q->execute();

// Volver a la gestión de tallas del producto
header("Location: producto_talla.php?id=$producto_id");
exit;
