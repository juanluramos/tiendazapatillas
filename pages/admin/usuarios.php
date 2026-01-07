<?php
require_once "../../includes/admin_guard.php";
require_once "../../includes/conexion.php";

$res = $conexion->query("
    SELECT id, nombre, email, rol
    FROM usuarios
    ORDER BY id
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin · Usuarios</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php require_once "../../includes/header.php"; ?>

<div class="container">
    <h2>Gestión de usuarios 👤</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acción</th>
        </tr>

        <?php while ($u = $res->fetch_assoc()): ?>
        <tr>
            <td><?= (int)$u['id'] ?></td>
            <td><?= htmlspecialchars($u['nombre']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td>
                <span class="badge badge-<?= $u['rol'] ?>">
                    <?= $u['rol'] ?>
                </span>
            </td>
            <td>
                <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
                    <form action="usuario_rol.php" method="POST" style="display:inline">
                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                        <input type="hidden" name="rol"
                               value="<?= $u['rol'] === 'admin' ? 'usuario' : 'admin' ?>">
                        <button class="btn btn-secondary" type="submit">
                            Cambiar a <?= $u['rol'] === 'admin' ? 'usuario' : 'admin' ?>
                        </button>
                    </form>
                <?php else: ?>
                    <em>(tú)</em>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="index.php">⬅ Volver al panel admin</a>
</div>

</body>
</html>
