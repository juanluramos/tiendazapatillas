<?php
require_once "../includes/usuario_guard.php";
require_once "../includes/conexion.php";


$usuario_id = $_SESSION['usuario_id'];

$q = $conexion->prepare("
    SELECT id, fecha, total, estado
    FROM pedidos
    WHERE usuario_id = ?
    ORDER BY fecha DESC
");
$q->bind_param("i", $usuario_id);
$q->execute();
$pedidos = $q->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis pedidos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php require_once "../includes/header.php"; ?>

<div class="container">
    <h2>Mis pedidos 📦</h2>

    <?php if ($pedidos->num_rows === 0): ?>
        <p>No has realizado ningún pedido todavía.</p>
        <a class="btn" href="productos.php">Ir a la tienda</a>
    <?php else: ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Total</th>
            <th>Estado</th>
        </tr>

        <?php while ($p = $pedidos->fetch_assoc()): ?>
        <tr>
            <td>#<?= (int)$p['id'] ?></td>
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
  <a class="btn btn-secondary" href="pedido_ver.php?id=<?= $p['id'] ?>">
    Ver
  </a>
</td>

        </tr>
        <?php endwhile; ?>
    </table>

    <?php endif; ?>
</div>

</body>
</html>
