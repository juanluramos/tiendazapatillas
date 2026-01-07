<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require_once "../includes/conexion.php";

// Obtener productos
$sql = "
    SELECT id, nombre, descripcion, precio, imagen
    FROM productos
    ORDER BY id DESC
";
$productos = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Productos · TiendaZapatillas</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <?php require_once "../includes/header.php"; ?>

    <div class="container">
        <h2>Productos disponibles 👟</h2>

        <div class="grid">
            <?php while ($p = $productos->fetch_assoc()): ?>

                <?php
                // Tallas del producto
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

                <div class="card">
                    <?php if (!empty($p['imagen'])): ?>
                        <img src="../assets/img/productos/<?= htmlspecialchars($p['imagen']) ?>"
                            alt="<?= htmlspecialchars($p['nombre']) ?>">
                    <?php endif; ?>

                    <h3><?= htmlspecialchars($p['nombre']) ?></h3>

                    <p><?= htmlspecialchars($p['descripcion']) ?></p>

                    <div class="price">
                        <?= number_format((float)$p['precio'], 2) ?> €
                    </div>

                    <?php if ($tallas->num_rows > 0): ?>
                       <?php if (isset($_SESSION['usuario_id'])): ?>

    <!-- Usuario logueado -->
    <form action="carrito_agregar.php" method="POST">

        <input type="hidden" name="producto_id" value="<?= $p['id'] ?>">


        <label>Talla:</label>
        <select name="talla" required>
            <?php if ($tallas->num_rows == 0): ?>
                <option value="">No disponible</option>
            <?php else: ?>
                <?php while ($t = $tallas->fetch_assoc()): ?>
                    <option value="<?= $t['talla'] ?>">
                        <?= $t['talla'] ?> (<?= $t['stock'] ?> uds)
                    </option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select>

        <br><br>

        <button type="submit">Añadir al carrito 🛒</button>

    </form>

<?php else: ?>

    <!-- Usuario NO logueado -->
    <p style="margin-top:10px;">
        <a class="btn btn-secondary" href="login.php">
            Inicia sesión para comprar
        </a>
    </p>

<?php endif; ?>

                    <?php else: ?>
                        <p><em>No disponible</em></p>
                    <?php endif; ?>
                </div>

            <?php endwhile; ?>
        </div>
    </div>

</body>

</html>