<?php
include("seguridad.php");
include("conexion.php");
$id = intval($_GET['id']);

// Iniciar la Transacción
mysqli_begin_transaction($conexion);

try {
    // 1. Borrar el historial asociado primero (para no violar foreign key)
    $sql1 = "DELETE FROM historial_equipo WHERE id_equipo = $id";
    mysqli_query($conexion, $sql1);

    // 2. Borrar el equipo
    $sql2 = "DELETE FROM equipo WHERE id_equipo = $id";
    mysqli_query($conexion, $sql2);

    // Si ambas consultas funcionaron, confirmamos los cambios (COMMIT)
    mysqli_commit($conexion);
    
    header("Location: inventario.php");
} catch (mysqli_sql_exception $exception) {
    // Si algo falló, deshacemos todos los cambios (ROLLBACK)
    mysqli_rollback($conexion);
    echo "Error al eliminar (Transacción cancelada): " . $exception->getMessage();
}
?>
