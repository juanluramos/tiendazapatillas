<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$id     = $_POST['id'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$desc   = $_POST['descripcion'] ?? '';
$precio = $_POST['precio'] ?? null;

if (!$id || !$nombre || $precio === null) {
    die("Datos incompletos");
}

$imagenFinal = $_POST['imagen_actual'] ?? null;

// si se sube nueva imagen
if (!empty($_FILES['imagen']['name'])) {

    $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg','jpeg','png','webp'];

    if (!in_array($ext, $permitidas)) {
        die("Formato de imagen no permitido");
    }

    $imagenFinal = uniqid("prod_") . "." . $ext;
    $ruta = "../../assets/img/productos/" . $imagenFinal;

    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta)) {
        die("Error al guardar la imagen");
    }
}

$q = $conexion->prepare("
    UPDATE productos 
    SET nombre = ?, descripcion = ?, precio = ?, imagen = ?
    WHERE id = ?
");
$q->bind_param("ssdsi", $nombre, $desc, $precio, $imagenFinal, $id);
$q->execute();

header("Location: productos.php");
exit;
