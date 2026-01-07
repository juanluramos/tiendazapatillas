<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

// Obtener pedidos con nombre de usuario
$res = $conexion->query("
    SELECT p.id,
           u.nombre AS usuario,
           p.fecha,
           p.total,
           p.estado
    FROM pedidos p
    JOIN usuarios u ON u.id = p.usuario_id
    ORDER BY p.fecha DESC
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin · Pedidos</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php require_once "../../includes/admin_header.php"; ?>

<div class="container">
    <h2>Pedidos (Administración) 📦</h2>

    <?php if ($res->num_rows === 0): ?>
        <p>No hay pedidos todavía.</p>
    <?php else: ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>

        <?php while ($p = $res->fetch_assoc()): ?>
        <tr>
            <td>#<?= (int)$p['id'] ?></td>
            <td><?= htmlspecialchars($p['usuario']) ?></td>
            <td><?= htmlspecialchars($p['fecha']) ?></td>
            <td><?= number_format((float)$p['total'], 2) ?> €</td>
            <td>
                <?php
                    $estado = $p['estado']; // pendiente | enviado | cancelado
                    $clase = "badge badge-$estado";
                ?>
                <span class="<?= $clase ?>">
                    <?= htmlspecialchars(ucfirst($estado)) ?>
                </span>
            </td>
            <td>
                <a class="btn btn-secondary"
                   href="pedido_ver.php?id=<?= $p['id'] ?>">
                    Ver pedido
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php endif; ?>

    <br>
    <a class="btn btn-secondary" href="index.php">⬅ Volver al panel</a>
</div>

</body>
</html>
