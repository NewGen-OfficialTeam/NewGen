<?php
include("conexion.php");
$id = intval($_GET['id']);

$q_equipo = mysqli_query($conexion, "SELECT * FROM equipo WHERE id_equipo = $id");
$equipo = mysqli_fetch_assoc($q_equipo);

$q_categorias = mysqli_query($conexion, "SELECT * FROM categoria");
$q_marcas = mysqli_query($conexion, "SELECT * FROM marca");
$q_modelos = mysqli_query($conexion, "SELECT * FROM modelo");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Equipo</title>
</head>
<body>
    <a href="inventario.php">Volver al Inventario</a>
    <hr>
    <h2>Editar Equipo</h2>
    <form action="equipo_actualizar.php" method="POST">
        <input type="hidden" name="id_equipo" value="<?= $equipo['id_equipo'] ?>">
        
        <label>Nombre del Equipo:</label><br>
        <input type="text" name="nombre_equipo" value="<?= $equipo['nombre_equipo'] ?>" required><br><br>

        <label>Categoría:</label><br>
        <select name="id_categoria" required>
            <?php while($cat = mysqli_fetch_assoc($q_categorias)){ ?>
                <option value="<?= $cat['id_categoria'] ?>" <?= $cat['id_categoria'] == $equipo['id_categoria'] ? 'selected' : '' ?>><?= $cat['nombre'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Marca:</label><br>
        <select name="id_marca">
            <option value="">Seleccione...</option>
            <?php while($marca = mysqli_fetch_assoc($q_marcas)){ ?>
                <option value="<?= $marca['id_marca'] ?>" <?= $marca['id_marca'] == $equipo['id_marca'] ? 'selected' : '' ?>><?= $marca['nombre'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Modelo:</label><br>
        <select name="id_modelo">
            <option value="">Seleccione...</option>
            <?php while($modelo = mysqli_fetch_assoc($q_modelos)){ ?>
                <option value="<?= $modelo['id_modelo'] ?>" <?= $modelo['id_modelo'] == $equipo['id_modelo'] ? 'selected' : '' ?>><?= $modelo['nombre'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Estado:</label><br>
        <input type="text" name="estado" value="<?= $equipo['estado'] ?>"><br><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
