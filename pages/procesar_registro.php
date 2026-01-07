<?php
require_once "../includes/conexion.php";

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = $_POST['password'];

// ciframos la contraseña
$password_segura = password_hash($password, PASSWORD_DEFAULT);

// comprobamos si ya existe
$consulta = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
$consulta->bind_param("s", $email);
$consulta->execute();
$consulta->store_result();

if ($consulta->num_rows > 0) {
    die("Ese email ya está registrado ❌");
}

// insertamos
$sql = $conexion->prepare(
    "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)"
);
$sql->bind_param("sss", $nombre, $email, $password_segura);

if ($sql->execute()) {
    echo "Registro correcto 🎯 <a href='login.php'>Iniciar sesión</a>";
} else {
    echo "Error: " . $conexion->error;
}
