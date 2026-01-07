<?php
require_once "../includes/usuario_guard.php";
require_once "../includes/conexion.php";


$usuario_id = $_SESSION['usuario_id'];

// obtener carrito
$q = $conexion->prepare("
    SELECT c.id_producto, c.talla, c.cantidad, p.precio
    FROM carrito c
    JOIN productos p ON p.id = c.id_producto
    WHERE c.id_usuario = ?
");
$q->bind_param("i", $usuario_id);
$q->execute();
$items = $q->get_result();

if ($items->num_rows === 0) {
    die("Carrito vacío");
}

$conexion->begin_transaction();

try {
    // calcular total
    $total = 0;
    $lineas = [];

    while ($i = $items->fetch_assoc()) {
        $linea = $i['precio'] * $i['cantidad'];
        $total += $linea;
        $lineas[] = $i;
    }

    // crear pedido
    $qp = $conexion->prepare("
        INSERT INTO pedidos (usuario_id, total)
        VALUES (?, ?)
    ");
    $qp->bind_param("id", $usuario_id, $total);
    $qp->execute();
    $pedido_id = $conexion->insert_id;

    // detalle
    $qd = $conexion->prepare("
        INSERT INTO pedido_detalle 
        (pedido_id, producto_id, talla, cantidad, precio)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($lineas as $l) {
        $qd->bind_param(
            "iisid",
            $pedido_id,
            $l['id_producto'],
            $l['talla'],
            $l['cantidad'],
            $l['precio']
        );
        $qd->execute();
    }

    // vaciar carrito
    $qc = $conexion->prepare("DELETE FROM carrito WHERE id_usuario = ?");
    $qc->bind_param("i", $usuario_id);
    $qc->execute();

    $conexion->commit();

} catch (Exception $e) {
    $conexion->rollback();
    die("Error al finalizar pedido");
}

header("Location: pedidos.php");
exit;
