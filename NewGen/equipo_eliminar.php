<?php
include("conexion.php");
$id = intval($_GET['id']);

// Borrar el historial asociado primero si existe (para no violar foreign key)
mysqli_query($conexion, "DELETE FROM historial_equipo WHERE id_equipo = $id");

$sql = "DELETE FROM equipo WHERE id_equipo = $id";
if(mysqli_query($conexion, $sql)){
    header("Location: inventario.php");
} else {
    echo "Error al eliminar: " . mysqli_error($conexion);
}
?>
