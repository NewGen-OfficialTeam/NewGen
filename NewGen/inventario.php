<?php
include("conexion.php");

$sql = "SELECT
            e.id_equipo,
            e.nombre_equipo,
            c.nombre AS categoria,
            m.nombre AS marca,
            mo.nombre AS modelo,
            e.estado,
            CONCAT(u.nombre, ' ', u.apellido) AS usuario_asignado
        FROM equipo e
        LEFT JOIN categoria c ON e.id_categoria = c.id_categoria
        LEFT JOIN marca m ON e.id_marca = m.id_marca
        LEFT JOIN modelo mo ON e.id_modelo = mo.id_modelo
        LEFT JOIN historial_equipo h ON e.id_equipo = h.id_equipo
        LEFT JOIN usuario u ON h.id_usuario = u.id_usuario";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
</head>
<body>

<a href="index_admin.html">Volver al Panel</a>
<hr>

<h2>Inventario de Equipos</h2>
<a href="equipo_nuevo.php">➕ Agregar Nuevo Equipo</a>
<br><br>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Equipo</th>
        <th>Categoría</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Estado</th>
        <th>Usuario Asignado</th>
        <th>Acciones</th>
    </tr>

    <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

    <tr>
        <td><?= $fila['id_equipo']; ?></td>
        <td><?= $fila['nombre_equipo']; ?></td>
        <td><?= $fila['categoria'] ? $fila['categoria'] : "-"; ?></td>
        <td><?= $fila['marca'] ? $fila['marca'] : "-"; ?></td>
        <td><?= $fila['modelo'] ? $fila['modelo'] : "-"; ?></td>
        <td><?= $fila['estado'] ? $fila['estado'] : "-"; ?></td>
        <td>
            <?= $fila['usuario_asignado'] ? $fila['usuario_asignado'] : "Sin asignar"; ?>
        </td>
        <td>
            <a href="equipo_editar.php?id=<?= $fila['id_equipo']; ?>">Editar</a> | 
            <a href="equipo_eliminar.php?id=<?= $fila['id_equipo']; ?>" onclick="return confirm('¿Estás seguro de eliminar este equipo?');">Eliminar</a>
        </td>
    </tr>

    <?php } ?>

</table>

</body>
</html>