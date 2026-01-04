<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require_once "../includes/conexion.php";

// 1. Sacamos los productos
$sql = "
SELECT 
    id,
    nombre,
    descripcion,
    precio,
    imagen
FROM productos
ORDER BY id
";

$productos = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>

<body>

<h2>Productos disponibles 👟</h2>

<div style="display:grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">

<?php while ($p = $productos->fetch_assoc()): ?>

    <?php
    // 2. Tallas del producto actual
    $qTallas = $conexion->prepare("
        SELECT talla, stock 
        FROM producto_tallas 
        WHERE producto_id = ?
        ORDER BY talla
    ");
    $qTallas->bind_param("i", $p['id']);
    $qTallas->execute();
    $tallas = $qTallas->get_result();
    ?>

    <div style="border:1px solid #ccc; padding:12px; border-radius:10px;">

        <img src="../assets/img/<?php echo $p['imagen']; ?>"
             alt="<?php echo $p['nombre']; ?>"
             style="width:100%; height:180px; object-fit:cover">

        <h3><?php echo $p['nombre']; ?></h3>

        <p><?php echo $p['descripcion']; ?></p>

        <strong><?php echo number_format($p['precio'], 2); ?> €</strong><br><br>

        <!-- Formulario hacia el carrito -->
        <form action="carrito_agregar.php" method="POST">

            <!-- IMPORTANTE: coincidir con carrito_agregar.php -->
            <input type="hidden" name="producto_id" value="<?php echo $p['id']; ?>">

            <label>Talla:</label>
            <select name="talla" required>
                <?php if ($tallas->num_rows == 0): ?>
                    <option value="">No disponible</option>
                <?php else: ?>
                    <?php while ($t = $tallas->fetch_assoc()): ?>
                        <option value="<?php echo $t['talla']; ?>">
                            <?php echo $t['talla']; ?> (<?php echo $t['stock']; ?> uds)
                        </option>
                    <?php endwhile; ?>
                <?php endif; ?>
            </select>

            <br><br>

            <button type="submit">Añadir al carrito 🛒</button>

        </form>

    </div>

<?php endwhile; ?>

</div>

</body>
</html>

