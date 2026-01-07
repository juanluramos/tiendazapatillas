<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$producto_id = $_POST['producto_id'] ?? null;
$talla = $_POST['talla'] ?? null;
$stock = $_POST['stock'] ?? null;

if (!$producto_id || !$talla || $stock === null) {
    die("Faltan datos");
}

// Normalizar talla
$talla = trim($talla);

// Comprobar si ya existe la talla
$check = $conexion->prepare("
    SELECT id 
    FROM producto_tallas 
    WHERE producto_id = ? AND talla = ?
");
$check->bind_param("is", $producto_id, $talla);
$check->execute();
$existe = $check->get_result()->fetch_assoc();

if ($existe) {
    die("Esta talla ya existe para este producto");
}

// Insertar talla
$q = $conexion->prepare("
    INSERT INTO producto_tallas (producto_id, talla, stock)
    VALUES (?, ?, ?)
");
$q->bind_param("isi", $producto_id, $talla, $stock);
$q->execute();

header("Location: producto_talla.php?id=$producto_id");
exit;
