<?php
include("conexion.php");

$sql = "SELECT u.id_usuario, u.nombre, u.apellido, u.email, u.estado, r.nombre AS rol 
        FROM usuario u 
        LEFT JOIN rol r ON u.id_rol = r.id_rol";
$resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
</head>
<body>
    <a href="index_admin.html">Volver al Panel</a>
    <hr>
    <h2>Lista de Usuarios</h2>
    <a href="usuario_nuevo.php">➕ Agregar Nuevo Usuario</a>
    <br><br>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estado</th>
        </tr>
        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
        <tr>
            <td><?= $fila['id_usuario']; ?></td>
            <td><?= $fila['nombre']; ?></td>
            <td><?= $fila['apellido']; ?></td>
            <td><?= $fila['email']; ?></td>
            <td><?= $fila['rol'] ? $fila['rol'] : "-"; ?></td>
            <td><?= $fila['estado']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
