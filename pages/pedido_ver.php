<?php
require_once "../includes/usuario_guard.php";
require_once "../includes/conexion.php";



$pedido_id  = $_GET['id'] ?? null;
$usuario_id = $_SESSION['usuario_id'];

if (!$pedido_id) {
    die("Pedido no válido");
}

// Pedido (solo si es del usuario)
$qPedido = $conexion->prepare("
    SELECT id, fecha, total, estado
    FROM pedidos
    WHERE id = ? AND usuario_id = ?
");
$qPedido->bind_param("ii", $pedido_id, $usuario_id);
$qPedido->execute();
$pedido = $qPedido->get_result()->fetch_assoc();

if (!$pedido) {
    die("Pedido no encontrado");
}

// Detalle
$qDetalle = $conexion->prepare("
    SELECT d.cantidad, d.talla, d.precio, p.nombre
    FROM pedido_detalle d
    JOIN productos p ON p.id = d.producto_id
    WHERE d.pedido_id = ?
");
$qDetalle->bind_param("i", $pedido_id);
$qDetalle->execute();
$detalles = $qDetalle->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido #<?= (int)$pedido['id'] ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php require_once "../includes/header.php"; ?>

<div class="container">
    <h2>Pedido #<?= (int)$pedido['id'] ?></h2>

    <p>
        <strong>Fecha:</strong> <?= htmlspecialchars($pedido['fecha']) ?><br>
        <strong>Estado:</strong>
        <span class="badge badge-<?= $pedido['estado'] ?>">
            <?= ucfirst($pedido['estado']) ?>
        </span>
    </p>

    <table>
        <tr>
            <th>Producto</th>
            <th>Talla</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
        </tr>

        <?php while ($d = $detalles->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($d['nombre']) ?></td>
            <td><?= htmlspecialchars($d['talla']) ?></td>
            <td><?= (int)$d['cantidad'] ?></td>
            <td><?= number_format($d['precio'], 2) ?> €</td>
            <td><?= number_format($d['precio'] * $d['cantidad'], 2) ?> €</td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="cart-total">
        Total del pedido: <?= number_format($pedido['total'], 2) ?> €
    </div>

    <a class="btn btn-secondary" href="pedidos.php">⬅ Volver a mis pedidos</a>
</div>

</body>
</html>
