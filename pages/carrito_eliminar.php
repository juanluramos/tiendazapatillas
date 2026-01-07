<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "../includes/usuario_guard.php";
require_once "../includes/conexion.php";


$id_usuario = $_SESSION['usuario_id'];
$id_carrito = $_GET['id'] ?? null;

if (!$id_carrito) {
    die("Producto no válido");
}

/*
    1) OBTENER DATOS DEL CARRITO
*/
$sel = $conexion->prepare("
    SELECT id_producto, talla, cantidad
    FROM carrito
    WHERE id = ? AND id_usuario = ?
");

$sel->bind_param("ii", $id_carrito, $id_usuario);
$sel->execute();
$res = $sel->get_result();

if (!$linea = $res->fetch_assoc()) {
    die("No existe el producto en tu carrito");
}

$id_producto = $linea['id_producto'];
$talla       = $linea['talla'];
$cantidad    = $linea['cantidad'];

/*
    2) DEVOLVER STOCK
*/
$upd = $conexion->prepare("
    UPDATE producto_tallas
    SET stock = stock + ?
    WHERE producto_id = ? AND talla = ?
");

$upd->bind_param("iis", $cantidad, $id_producto, $talla);
$upd->execute();

/*
    3) BORRAR DEL CARRITO
*/
$del = $conexion->prepare("
    DELETE FROM carrito 
    WHERE id = ? AND id_usuario = ?
");

$del->bind_param("ii", $id_carrito, $id_usuario);
$del->execute();

header("Location: carrito.php");
exit;
