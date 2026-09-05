<?php
include("conexion.php");

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$id_usuario = $_POST['id_usuario'];
$id_tecnico = $_POST['id_tecnico'];
$prioridad = $_POST['prioridad'];
$estado = $_POST['estado'];
$fecha = date('Y-m-d H:i:s');

$sql = "INSERT INTO ticket (id_usuario, id_tecnico, titulo, descripcion, fecha_creacion, estado, prioridad) 
        VALUES ('$id_usuario', $id_tecnico, '$titulo', '$descripcion', '$fecha', '$estado', '$prioridad')";

if(mysqli_query($conexion, $sql)){
    header("Location: tickets.php");
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>
