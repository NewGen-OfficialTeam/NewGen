<?php
include("conexion.php");

$id = $_POST['id_equipo'];
$nombre = $_POST['nombre_equipo'];
$id_cat = $_POST['id_categoria'];
$id_marca = !empty($_POST['id_marca']) ? $_POST['id_marca'] : 'NULL';
$id_modelo = !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : 'NULL';
$estado = $_POST['estado'];

$sql = "UPDATE equipo 
        SET id_categoria='$id_cat', id_marca=$id_marca, id_modelo=$id_modelo, nombre_equipo='$nombre', estado='$estado'
        WHERE id_equipo=$id";

if(mysqli_query($conexion, $sql)){
    header("Location: inventario.php");
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>
