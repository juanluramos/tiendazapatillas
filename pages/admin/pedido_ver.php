<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Pedido no válido");
}

// Datos del pedido
$qPedido = $conexion->prepare("
    SELECT p.id, p.fecha, p.total, p.estado, u.nombre, u.email
    FROM pedidos p
    JOIN usuarios u ON u.id = p.usuario_id
    WHERE p.id = ?
");
$qPedido->bind_param("i", $id);
$qPedido->execute();
$pedido = $qPedido->get_result()->fetch_assoc();

if (!$pedido) {
    die("Pedido no encontrado");
}

// Detalle del pedido
$qDetalle = $conexion->prepare("
    SELECT d.cantidad, d.talla, d.precio, pr.nombre
    FROM pedido_detalle d
    JOIN productos pr ON pr.id = d.producto_id
    WHERE d.pedido_id = ?
");
$qDetalle->bind_param("i", $id);
$qDetalle->execute();
$detalles = $qDetalle->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido #<?= (int)$pedido['id'] ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php require_once "../../includes/admin_header.php"; ?>

<div class="container">
    <h2>Pedido #<?= (int)$pedido['id'] ?></h2>

    <p>
        <strong>Cliente:</strong>
        <?= htmlspecialchars($pedido['nombre']) ?> (<?= htmlspecialchars($pedido['email']) ?>)
    </p>

    <p>
        <strong>Fecha:</strong> <?= htmlspecialchars($pedido['fecha']) ?><br>
        <strong>Total:</strong> <?= number_format((float)$pedido['total'], 2) ?> €
    </p>

    <p>
        <strong>Estado:</strong>
        <span class="badge badge-<?= $pedido['estado'] ?>">
            <?= htmlspecialchars(ucfirst($pedido['estado'])) ?>
        </span>
    </p>

    <hr>

    <h3>Productos del pedido</h3>

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
            <td><?= number_format((float)$d['precio'], 2) ?> €</td>
            <td><?= number_format($d['cantidad'] * $d['precio'], 2) ?> €</td>
        </tr>
        <?php endwhile; ?>
    </table>

    <hr>

    <h3>Cambiar estado del pedido</h3>

    <form action="pedidos_estado.php" method="POST">
        <input type="hidden" name="id" value="<?= (int)$pedido['id'] ?>">

        <label>Estado</label>
        <select name="estado">
            <option value="pendiente" <?= $pedido['estado']=='pendiente'?'selected':'' ?>>Pendiente</option>
            <option value="enviado" <?= $pedido['estado']=='enviado'?'selected':'' ?>>Enviado</option>
            <option value="cancelado" <?= $pedido['estado']=='cancelado'?'selected':'' ?>>Cancelado</option>
        </select>

        <br><br>
        <button class="btn" type="submit">Actualizar estado</button>
    </form>

    <br>
    <a class="btn btn-secondary" href="pedidos.php">⬅ Volver a pedidos</a>
</div>

</body>
</html>
