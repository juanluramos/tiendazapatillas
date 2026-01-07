<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$id = $_GET['id'];

$q = $conexion->prepare("SELECT imagen FROM productos WHERE id = ?");
$q->bind_param("i", $id);
$q->execute();
$res = $q->get_result();
$p = $res->fetch_assoc();

$conexion->begin_transaction();

try {

    // borrar tallas
    $conexion->prepare("DELETE FROM producto_tallas WHERE producto_id = $id")->execute();

    // borrar carrito
    $conexion->prepare("DELETE FROM carrito WHERE id_producto = $id")->execute();

    // borrar producto
    $conexion->prepare("DELETE FROM productos WHERE id = $id")->execute();

    // borrar imagen
    if ($p && $p['imagen']) {
        @unlink("../../assets/img/productos/" . $p['imagen']);
    }

    $conexion->commit();

} catch (Exception $e) {
    $conexion->rollback();
    die("Error al borrar");
}

header("Location: productos.php");
exit;
