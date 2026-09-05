<?php
include("conexion.php");

$sql = "SELECT t.id_ticket, t.titulo, t.descripcion, t.fecha_creacion, t.estado, t.prioridad, 
        CONCAT(u.nombre, ' ', u.apellido) AS usuario, 
        CONCAT(tec.nombre, ' ', tec.apellido) AS tecnico 
        FROM ticket t 
        LEFT JOIN usuario u ON t.id_usuario = u.id_usuario
        LEFT JOIN tecnico tec ON t.id_tecnico = tec.id_tecnico";
$resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tickets</title>
</head>
<body>
    <a href="index_admin.html">Volver al Panel</a>
    <hr>
    <h2>Gestión de Tickets</h2>
    <a href="ticket_nuevo.php">➕ Crear Nuevo Ticket</a>
    <br><br>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Estado</th>
            <th>Prioridad</th>
            <th>Usuario</th>
            <th>Técnico Asignado</th>
            <th>Fecha</th>
        </tr>
        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
        <tr>
            <td><?= $fila['id_ticket']; ?></td>
            <td><?= $fila['titulo']; ?></td>
            <td><?= $fila['estado']; ?></td>
            <td><?= $fila['prioridad']; ?></td>
            <td><?= $fila['usuario'] ? $fila['usuario'] : "-"; ?></td>
            <td><?= $fila['tecnico'] ? $fila['tecnico'] : "Sin asignar"; ?></td>
            <td><?= $fila['fecha_creacion']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
