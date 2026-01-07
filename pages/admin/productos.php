<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$res = $conexion->query("
    SELECT id, nombre, precio, imagen 
    FROM productos 
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin · Productos</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php require_once "../../includes/admin_header.php"; ?>

<div class="container">
    <h2>Productos (Administración)</h2>

    <a class="btn" href="producto_nuevo.php">+ Nuevo producto</a>
    <br><br>

    <table>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>

        <?php while ($p = $res->fetch_assoc()): ?>
        <tr>
            <td><?= (int)$p['id'] ?></td>
            <td><?= htmlspecialchars($p['nombre']) ?></td>
            <td><?= number_format((float)$p['precio'], 2) ?> €</td>
            <td>
                <?php if (!empty($p['imagen'])): ?>
                    <img src="../../assets/img/productos/<?= htmlspecialchars($p['imagen']) ?>"
                         width="60" style="border-radius:6px;">
                <?php endif; ?>
            </td>
            <td>
                <a class="btn btn-secondary" href="producto_editar.php?id=<?= $p['id'] ?>">
                    Editar
                </a>

                <a class="btn btn-secondary" href="producto_talla.php?id=<?= $p['id'] ?>">
                    Tallas
                </a>

                <a class="btn btn-danger"
                   href="producto_borrar.php?id=<?= $p['id'] ?>"
                   onclick="return confirm('¿Eliminar este producto?');">
                    Eliminar
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="index.php">⬅ Volver al panel</a>
</div>

</body>
</html>

