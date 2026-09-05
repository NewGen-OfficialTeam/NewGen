<?php
include("conexion.php");

$q_categorias = mysqli_query($conexion, "SELECT * FROM categoria");
$q_marcas = mysqli_query($conexion, "SELECT * FROM marca");
$q_modelos = mysqli_query($conexion, "SELECT * FROM modelo");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Equipo</title>
</head>
<body>
    <a href="inventario.php">Volver al Inventario</a>
    <hr>
    <h2>Agregar Nuevo Equipo</h2>
    <form action="equipo_guardar.php" method="POST">
        <label>Nombre del Equipo:</label><br>
        <input type="text" name="nombre_equipo" required><br><br>

        <label>Categoría:</label><br>
        <select name="id_categoria" required>
            <option value="">Seleccione...</option>
            <?php while($cat = mysqli_fetch_assoc($q_categorias)){ ?>
                <option value="<?= $cat['id_categoria'] ?>"><?= $cat['nombre'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Marca:</label><br>
        <select name="id_marca">
            <option value="">Seleccione...</option>
            <?php while($marca = mysqli_fetch_assoc($q_marcas)){ ?>
                <option value="<?= $marca['id_marca'] ?>"><?= $marca['nombre'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Modelo:</label><br>
        <select name="id_modelo">
            <option value="">Seleccione...</option>
            <?php while($modelo = mysqli_fetch_assoc($q_modelos)){ ?>
                <option value="<?= $modelo['id_modelo'] ?>"><?= $modelo['nombre'] ?></option>
            <?php } ?>
        </select><br><br>

        <label>Estado:</label><br>
        <input type="text" name="estado"><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
