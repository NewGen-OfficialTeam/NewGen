<?php
include("../conexion.php");

// Simulamos que el usuario logueado es el ID 1
$id_usuario_actual = 1;

$sql = "SELECT id_ticket, titulo, descripcion, fecha_creacion, estado, prioridad 
        FROM ticket 
        WHERE id_usuario = $id_usuario_actual";

// Omitimos la ejecución real por si la BD no está configurada, pero dejamos el código listo.
$resultado = @mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Tickets</title>
</head>
<body>
    <h2>Mis Tickets</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Prioridad</th>
        </tr>
        
        <?php if($resultado && mysqli_num_rows($resultado) > 0) { ?>
            <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
            <tr>
                <td><?= $fila['id_ticket']; ?></td>
                <td><?= $fila['titulo']; ?></td>
                <td><?= $fila['descripcion']; ?></td>
                <td><?= $fila['fecha_creacion']; ?></td>
                <td><?= $fila['estado']; ?></td>
                <td><?= $fila['prioridad']; ?></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">No hay tickets o la conexión falló (datos simulados).</td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <a href="../index_usuario.html">Volver</a>
</body>
</html>
