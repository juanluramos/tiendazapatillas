<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require_once "../includes/conexion.php";

if (!isset($_SESSION['usuario_id'])) {
    die("Debes iniciar sesión primero");
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "
SELECT 
    c.id,
    c.talla,
    c.cantidad,
    p.nombre,
    p.precio
FROM carrito c
JOIN productos p 
    ON p.id = c.id_producto
WHERE c.id_usuario = ?
";

$q = $conexion->prepare($sql);
$q->bind_param("i", $usuario_id);
$q->execute();

$res = $q->get_result();
?>

<h2>Tu carrito 🛒</h2>

<table border="1" cellpadding="8">
<tr>
    <th>Producto</th>
    <th>Talla</th>
    <th>Cantidad</th>
    <th>Precio</th>
    <th>Total</th>
</tr>

<?php
$total = 0;

while ($item = $res->fetch_assoc()):
    $linea = $item['cantidad'] * $item['precio'];
    $total += $linea;
?>


<tr>
    <td><?php echo $item['nombre']; ?></td>
    <td><?php echo $item['talla']; ?></td>
    <td><?php echo $item['cantidad']; ?></td>
    <td><?php echo number_format($item['precio'], 2); ?> €</td>
    <td><?php echo number_format($linea, 2); ?> €</td>
<th>Acción</th>
    <td>
        <a href="carrito_eliminar.php?id=<?php echo $item['id']; ?>">
            ❌ Eliminar
        </a>
    </td>
</tr>

<?php endwhile; ?>

</table>

<h3>Total: <?php echo number_format($total, 2); ?> €</h3>

<a href="productos.php">Seguir comprando</a>
