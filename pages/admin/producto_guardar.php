<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

// -------------------------
// VALIDACIÓN DE CAMPOS
// -------------------------
$nombre = trim($_POST['nombre'] ?? '');
$desc   = trim($_POST['descripcion'] ?? '');
$precio = $_POST['precio'] ?? null;

if ($nombre === '' || !is_numeric($precio) || $precio < 0) {
    header("Location: producto_nuevo.php?error=Datos inválidos");
    exit;
}

// -------------------------
// VALIDACIÓN DE IMAGEN
// -------------------------
if (
    !isset($_FILES['imagen']) ||
    $_FILES['imagen']['error'] !== UPLOAD_ERR_OK
) {
    header("Location: producto_nuevo.php?error=Error al subir la imagen");
    exit;
}

$ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
$permitidas = ['jpg', 'jpeg', 'png', 'webp'];

if (!in_array($ext, $permitidas)) {
    header("Location: producto_nuevo.php?error=Formato de imagen no permitido");
    exit;
}

if ($_FILES['imagen']['size'] > 5 * 1024 * 1024) {
    header("Location: producto_nuevo.php?error=Imagen demasiado grande");
    exit;
}

// -------------------------
// GUARDAR IMAGEN
// -------------------------
$dir = "../../assets/img/productos/";

if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

if (!is_writable($dir)) {
    die("❌ La carpeta de imágenes no es escribible");
}

$nombreImagen = uniqid("prod_", true) . "." . $ext;
$ruta = $dir . $nombreImagen;

if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
    die("Error al guardar la imagen");
}

// -------------------------
// INSERT EN BD
// -------------------------
$q = $conexion->prepare("
    INSERT INTO productos (nombre, descripcion, precio, imagen)
    VALUES (?, ?, ?, ?)
");

if (!$q) {
    die("Error prepare: " . $conexion->error);
}

$q->bind_param("ssds", $nombre, $desc, $precio, $nombreImagen);

if (!$q->execute()) {
    die("Error execute: " . $q->error);
}

// -------------------------
// REDIRECCIÓN FINAL
// -------------------------
header("Location: productos.php?ok=Producto creado");
exit;
