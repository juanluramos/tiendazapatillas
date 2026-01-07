<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$producto_id = $_GET['id'] ?? null;
if (!$producto_id) {
    die("Producto no válido");
}

// Obtener datos del producto
$pq = $conexion->prepare("
    SELECT nombre 
    FROM productos 
    WHERE id = ?
");
$pq->bind_param("i", $producto_id);
$pq->execute();
$producto = $pq->get_result()->fetch_assoc();

if (!$producto) {
    die("Producto no encontrado");
}

// Obtener tallas del producto
$tq = $conexion->prepare("
    SELECT id, talla, stock
    FROM producto_tallas
    WHERE producto_id = ?
    ORDER BY talla
");
$tq->bind_param("i", $producto_id);
$tq->execute();
$tallas = $tq->get_result();
?>

<h2>Tallas y stock · <?= htmlspecialchars($producto['nombre']) ?></h2>

<!-- AÑADIR TALLA -->
<h3>Añadir talla</h3>

<form action="talla_guardar.php" method="POST">
    <input type="hidden" name="producto_id" value="<?= $producto_id ?>">

    <label>Talla</label>
    <input type="text" name="talla" required>

    <label>Stock</label>
    <input type="number" name="stock" min="0" required>

    <button type="submit">Añadir</button>
</form>

<hr>

<!-- LISTADO DE TALLAS -->
<h3>Tallas existentes</h3>

<table border="1" cellpadding="6">
<tr>
    <th>Talla</th>
    <th>Stock</th>
    <th>Acciones</th>
</tr>

<?php while ($t = $tallas->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($t['talla']) ?></td>
    <td><?= (int)$t['stock'] ?></td>
    <td>
        <!-- Actualizar stock -->
        <form action="talla_actualizar.php" method="POST" style="display:inline">
            <input type="hidden" name="id" value="<?= $t['id'] ?>">
            <input type="hidden" name="producto_id" value="<?= $producto_id ?>">
            <input type="number" name="stock" value="<?= (int)$t['stock'] ?>" min="0">
            <button type="submit">Actualizar</button>
        </form>

        <!-- Eliminar talla -->
        <a href="talla_borrar.php?id=<?= $t['id'] ?>&producto_id=<?= $producto_id ?>"
           onclick="return confirm('¿Eliminar esta talla?');">
           ❌
        </a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<p>
    <a href="productos.php">⬅ Volver a productos</a>
</p>
