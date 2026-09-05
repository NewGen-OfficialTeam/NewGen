<?php
include("conexion.php");
$q_roles = mysqli_query($conexion, "SELECT * FROM rol");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Usuario</title>
</head>
<body>
    <a href="usuarios.php">Volver a Usuarios</a>
    <hr>
    <h2>Agregar Nuevo Usuario</h2>
    <form action="usuario_guardar.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Apellido:</label><br>
        <input type="text" name="apellido" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Rol:</label><br>
        <select name="id_rol" required>
            <option value="">Seleccione...</option>
            <?php while($rol = mysqli_fetch_assoc($q_roles)){ ?>
                <option value="<?= $rol['id_rol'] ?>"><?= $rol['nombre'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Estado:</label><br>
        <select name="estado">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
        </select><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
