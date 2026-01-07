<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "../includes/usuario_guard.php";
require_once "../includes/conexion.php";

$usuario_id = $_SESSION['usuario_id'];

$sql = "
SELECT c.id,
       c.talla,
       c.cantidad,
       p.nombre,
       p.precio
FROM carrito c
JOIN productos p ON p.id = c.id_producto
WHERE c.id_usuario = ?
";

$q = $conexion->prepare($sql);
$q->bind_param("i", $usuario_id);
$q->execute();
$res = $q->get_result();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <?php require_once "../includes/header.php"; ?>

    <div class="container">
        <h2>Tu carrito 🛒</h2>

        <?php if ($res->num_rows === 0): ?>
            <p>Tu carrito está vacío.</p>
            <a class="btn" href="productos.php">Ver productos</a>
        <?php else: ?>

            <table class="cart-table">
                <tr>
                    <th>Producto</th>
                    <th>Talla</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                    <th></th>
                </tr>

                <?php
                $total = 0;
                while ($item = $res->fetch_assoc()):
                    $linea = $item['cantidad'] * $item['precio'];
                    $total += $linea;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['nombre']) ?></td>
                        <td><?= htmlspecialchars($item['talla']) ?></td>
                        <td><?= (int)$item['cantidad'] ?></td>
                        <td><?= number_format((float)$item['precio'], 2) ?> €</td>
                        <td><?= number_format($linea, 2) ?> €</td>
                        <td>
                            <a class="btn btn-danger"
                                href="/tiendazapatillas/pages/carrito_eliminar.php?id=<?= (int)$item['id'] ?>"
                                onclick="return confirm('¿Eliminar este producto?');">
                                ✖
                            </a>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>

            <div class="cart-total">
                <strong>Total: <?= number_format($total, 2) ?> €</strong>
            </div>

            <div class="cart-actions">
                <a class="btn btn-secondary" href="productos.php">Seguir comprando</a>
                <a class="btn" href="finalizar_compra.php">Finalizar compra</a>
            </div>

        <?php endif; ?>
    </div>

</body>

</html>