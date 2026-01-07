<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$id = $_GET['id'] ?? null;
$producto_id = $_GET['producto_id'] ?? null;

if (!$id || !$producto_id) {
    die("Datos no válidos");
}

// Borrar talla
$q = $conexion->prepare("
    DELETE FROM producto_talla
    WHERE id = ?
");
$q->bind_param("i", $id);
$q->execute();

// Volver a la gestión de tallas del producto
header("Location: producto_talla.php?id=$producto_id");
exit;
