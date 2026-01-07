<?php
require_once __DIR__ . "/../../includes/admin_guard.php";
require_once __DIR__ . "/../../includes/conexion.php";

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID de producto no válido");
}

$q = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
$q->bind_param("i", $id);
$q->execute();
$res = $q->get_result();

if (!$p = $res->fetch_assoc()) {
    die("Producto no encontrado");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php require_once __DIR__ . "/../../includes/header.php"; ?>

<div class="container">

    <h2>✏️ Editar producto</h2>

    <form class="form-card"
          action="producto_actualizar.php"
          method="POST"
          enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
        <input type="hidden" name="imagen_actual" value="<?= htmlspecialchars($p['imagen']) ?>">

        <div class="form-group">
            <label>Nombre</label>
            <input type="text"
                   name="nombre"
                   value="<?= htmlspecialchars($p['nombre']) ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Descripción</label>
            <textarea name="descripcion"
                      rows="4"><?= htmlspecialchars($p['descripcion']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Precio (€)</label>
            <input type="number"
                   step="0.01"
                   name="precio"
                   value="<?= htmlspecialchars($p['precio']) ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Imagen actual</label>
            <?php if (!empty($p['imagen'])): ?>
                <div class="image-preview">
                    <img src="../../assets/img/productos/<?= htmlspecialchars($p['imagen']) ?>"
                         alt="Imagen actual">
                </div>
            <?php else: ?>
                <p class="muted">Sin imagen</p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Nueva imagen (opcional)</label>
            <input type="file" name="imagen" accept="image/*">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                💾 Guardar cambios
            </button>

            <a href="productos.php" class="btn btn-secondary">
                ⬅ Volver
            </a>
        </div>

    </form>

</div>

</body>
</html>
