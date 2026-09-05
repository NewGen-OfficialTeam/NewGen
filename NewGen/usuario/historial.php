<?php
include("../conexion.php");

// Simulamos que el usuario logueado es el ID 1
$id_usuario_actual = 1;

$sql = "SELECT e.nombre_equipo, e.marca, e.modelo, h.fecha_asignacion, h.fecha_devolucion, h.descripcion
        FROM historial_equipo h
        INNER JOIN equipo e ON h.id_equipo = e.id_equipo
        WHERE h.id_usuario = $id_usuario_actual";

$resultado = @mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Historial de Equipos</title>
</head>
<body>
    <h2>Mi Historial de Equipos</h2>
    <table border="1">
        <tr>
            <th>Equipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Asignado</th>
            <th>Devuelto</th>
            <th>Descripción</th>
        </tr>
        <?php if($resultado && mysqli_num_rows($resultado) > 0) { ?>
            <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
            <tr>
                <td><?= $fila['nombre_equipo']; ?></td>
                <td><?= $fila['marca']; ?></td>
                <td><?= $fila['modelo']; ?></td>
                <td><?= $fila['fecha_asignacion']; ?></td>
                <td><?= $fila['fecha_devolucion']; ?></td>
                <td><?= $fila['descripcion']; ?></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">No hay historial o la conexión falló (datos simulados).</td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <a href="../index_usuario.html">Volver</a>
</body>
</html>