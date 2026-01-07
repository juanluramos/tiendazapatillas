<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$id = $_POST['id'] ?? null;
$estado = $_POST['estado'] ?? null;

$permitidos = ['pendiente','enviado','cancelado'];
if (!$id || !in_array($estado, $permitidos)) {
    die("Datos no válidos");
}

$q = $conexion->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
$q->bind_param("si", $estado, $id);
$q->execute();

header("Location: pedido_ver.php?id=$id");
exit;
