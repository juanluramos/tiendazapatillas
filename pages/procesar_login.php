<?php
session_start();
require_once "../includes/conexion.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = $conexion->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
$sql->bind_param("s", $email);
$sql->execute();
$resultado = $sql->get_result();

if ($usuario = $resultado->fetch_assoc()) {

    if (password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];

        header("Location: panel.php");
exit;

    } else {
        echo "Contraseña incorrecta ❌";
    }

} else {
    echo "No existe una cuenta con ese email ❌";
}
