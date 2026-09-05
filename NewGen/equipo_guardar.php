<?php
include("conexion.php");

$nombre = $_POST['nombre_equipo'];
$id_cat = $_POST['id_categoria'];
$id_marca = !empty($_POST['id_marca']) ? $_POST['id_marca'] : 'NULL';
$id_modelo = !empty($_POST['id_modelo']) ? $_POST['id_modelo'] : 'NULL';
$estado = $_POST['estado'];
$fecha = date('Y-m-d');

$sql = "INSERT INTO equipo (id_categoria, id_marca, id_modelo, nombre_equipo, estado, fecha_alta) 
        VALUES ('$id_cat', $id_marca, $id_modelo, '$nombre', '$estado', '$fecha')";

if(mysqli_query($conexion, $sql)){
    header("Location: inventario.php");
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>
