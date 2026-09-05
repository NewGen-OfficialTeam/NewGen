<?php
include("conexion.php");
$q_usuarios = mysqli_query($conexion, "SELECT * FROM usuario");
$q_tecnicos = mysqli_query($conexion, "SELECT * FROM tecnico");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Ticket</title>
</head>
<body>
    <a href="tickets.php">Volver a Tickets</a>
    <hr>
    <h2>Crear Nuevo Ticket</h2>
    <form action="ticket_guardar.php" method="POST">
        <label>Título del Problema:</label><br>
        <input type="text" name="titulo" required style="width: 300px;"><br><br>

        <label>Descripción detallada:</label><br>
        <textarea name="descripcion" required rows="4" cols="40"></textarea><br><br>

        <label>Usuario Solicitante:</label><br>
        <select name="id_usuario" required>
            <option value="">Seleccione...</option>
            <?php while($u = mysqli_fetch_assoc($q_usuarios)){ ?>
                <option value="<?= $u['id_usuario'] ?>"><?= $u['nombre'] . ' ' . $u['apellido'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Técnico Asignado:</label><br>
        <select name="id_tecnico">
            <option value="NULL">Sin asignar</option>
            <?php while($t = mysqli_fetch_assoc($q_tecnicos)){ ?>
                <option value="<?= $t['id_tecnico'] ?>"><?= $t['nombre'] . ' ' . $t['apellido'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Prioridad:</label><br>
        <select name="prioridad">
            <option value="Baja">Baja</option>
            <option value="Media">Media</option>
            <option value="Alta">Alta</option>
            <option value="Crítica">Crítica</option>
        </select><br><br>

        <label>Estado:</label><br>
        <select name="estado">
            <option value="Abierto">Abierto</option>
            <option value="En proceso">En proceso</option>
            <option value="Resuelto">Resuelto</option>
            <option value="Cerrado">Cerrado</option>
        </select><br><br>

        <button type="submit">Crear Ticket</button>
    </form>
</body>
</html>
