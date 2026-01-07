<?php
require_once "../../includes/admin_guard.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo producto</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php require_once "../../includes/header.php"; ?>

<div class="container">
    <h2>Nuevo producto</h2>

    <form action="producto_guardar.php" method="POST" enctype="multipart/form-data">

        <label>Nombre</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Descripción</label><br>
        <textarea name="descripcion"></textarea><br><br>

        <label>Precio</label><br>
        <input type="number" step="0.01" name="precio" required min="0"><br><br>

        <label>Imagen</label><br>
        <input type="file" name="imagen" accept="image/jpeg,image/png,image/webp" required><br><br>

        <button type="submit" class="btn">Guardar producto</button>
    </form>

    <br>
    <a href="productos.php">⬅ Volver</a>
</div>

</body>
</html>

