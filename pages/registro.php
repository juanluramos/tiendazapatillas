<?php require_once "../includes/conexion.php"; ?>

<h2>Crear cuenta 👟</h2>

<form action="procesar_registro.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>

    <button type="submit">Registrar</button>
</form>
