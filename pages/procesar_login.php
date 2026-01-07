<?php
session_start();
require_once "../includes/conexion.php";

$email    = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($email) || empty($password)) {
    header("Location: login.php?error=Faltan datos de acceso");
    exit;
}

// Traer usuario + rol
$sql = $conexion->prepare("
    SELECT id, nombre, password, rol 
    FROM usuarios 
    WHERE email = ?
");
$sql->bind_param("s", $email);
$sql->execute();
$resultado = $sql->get_result();

if ($usuario = $resultado->fetch_assoc()) {

    if (password_verify($password, $usuario['password'])) {

        // Guardar sesión
        $_SESSION['usuario_id']     = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol']    = $usuario['rol'];

        // Redirección según rol
        if ($usuario['rol'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: panel.php");
        }
        exit;

    } else {
        header("Location: login.php?error=Credenciales incorrectas");
        exit;
    }

} else {
    header("Location: login.php?error=No existe una cuenta con ese email");
    exit;
}
