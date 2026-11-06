<?php
include("conexion.php");

// 1. Corregir descripción vacía de Admin en la tabla rol
$q1 = mysqli_query($conexion, "UPDATE rol SET descripcion = NULL WHERE id_rol = 1 AND (descripcion = '' OR descripcion = ' ')");

// 2. Verificar datos actuales de la tabla rol
$res = mysqli_query($conexion, "SELECT * FROM rol");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualización de Roles - NewGen</title>
    <style>
        body { font-family: sans-serif; background: #0B0917; color: #FFF; padding: 30px; }
        table { border-collapse: collapse; width: 100%; max-width: 600px; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 10px; text-align: left; }
        th { background: #8B5CF6; }
        .ok { color: #06D6A0; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Actualización de tabla 'rol'</h2>
    <p class="ok">&check; Se ha establecido la descripción de Admin como NULL (o ya estaba actualizada).</p>
    <table>
        <tr><th>ID Rol</th><th>Nombre</th><th>Descripción</th></tr>
        <?php while($r = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><?= $r['id_rol'] ?></td>
                <td><?= htmlspecialchars($r['nombre']) ?></td>
                <td><?= is_null($r['descripcion']) ? '<i>(NULL)</i>' : htmlspecialchars($r['descripcion']) ?></td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <a href="dashboard.php" style="color: #C78FFC;">&larr; Volver al Dashboard</a>
</body>
</html>
