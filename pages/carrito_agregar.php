<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require_once "../includes/conexion.php";

// 1) Debe haber sesión
if (!isset($_SESSION['usuario_id'])) {
    die("Debes iniciar sesión para comprar");
}

$id_usuario  = $_SESSION['usuario_id'];
$id_producto = $_POST['producto_id'] ?? null;
$talla       = $_POST['talla'] ?? null;

// 2) Validar datos
if (empty($id_producto) || empty($talla)) {
    die("Faltan datos del producto");
}

// 3) Comprobar stock disponible
$stockQ = $conexion->prepare("
    SELECT stock 
    FROM producto_tallas
    WHERE producto_id = ? AND talla = ?
");
$stockQ->bind_param("is", $id_producto, $talla);
$stockQ->execute();
$r = $stockQ->get_result();

if (!$row = $r->fetch_assoc()) {
    die("No existe stock para esa talla");
}

if ($row['stock'] <= 0) {
    die("No queda stock disponible para esta talla");
}

// 4) Mirar si ya está en carrito
$check = $conexion->prepare("
    SELECT id, cantidad 
    FROM carrito 
    WHERE id_usuario = ? 
      AND id_producto = ? 
      AND talla = ?
");
$check->bind_param("iis", $id_usuario, $id_producto, $talla);
$check->execute();
$res = $check->get_result();

// INICIAR “mini-transacción” para evitar desastres
$conexion->begin_transaction();

try {

    if ($item = $res->fetch_assoc()) {

        // 5A) Ya existe -> sumamos 1
        $update = $conexion->prepare("
            UPDATE carrito 
            SET cantidad = cantidad + 1 
            WHERE id = ?
        ");
        $update->bind_param("i", $item['id']);
        $update->execute();

    } else {

        // 5B) No existe -> insertamos
        $insert = $conexion->prepare("
            INSERT INTO carrito (id_usuario, id_producto, talla, cantidad)
            VALUES (?, ?, ?, 1)
        ");
        $insert->bind_param("iis", $id_usuario, $id_producto, $talla);
        $insert->execute();
    }

    // 6) Restar stock (solo 1 unidad)
    $rest = $conexion->prepare("
        UPDATE producto_tallas
        SET stock = stock - 1
        WHERE producto_id = ? AND talla = ? AND stock > 0
    ");
    $rest->bind_param("is", $id_producto, $talla);
    $rest->execute();

    // Confirmar cambios
    $conexion->commit();

} catch (Exception $e) {

    // Algo falló -> volver atrás
    $conexion->rollback();
    die("Error al procesar la compra: " . $e->getMessage());
}

echo "Producto añadido al carrito 🛒 <br><br>";
echo "<a href='productos.php'>Seguir comprando</a> | ";
echo "<a href='carrito.php'>Ver carrito</a>";

