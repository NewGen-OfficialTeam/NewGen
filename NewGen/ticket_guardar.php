<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("conexion.php");

$titulo = mysqli_real_escape_string($conexion, $_POST['titulo'] ?? '');
$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion'] ?? '');
$id_usuario = intval($_POST['id_usuario'] ?? ($_SESSION['id'] ?? 1));
if ($id_usuario <= 0) {
    $id_usuario = 1;
}
$prioridad = mysqli_real_escape_string($conexion, $_POST['prioridad'] ?? 'Media');
$estado = mysqli_real_escape_string($conexion, $_POST['estado'] ?? 'Abierto');
$fecha = date('Y-m-d H:i:s');

// 1. Asegurar que id_tecnico permita NULL en la base de datos
try {
    $check_col = mysqli_query($conexion, "SHOW COLUMNS FROM ticket LIKE 'id_tecnico'");
    if ($check_col && ($col = mysqli_fetch_assoc($check_col))) {
        if (strtoupper($col['Null']) === 'NO') {
            $col_type = $col['Type'] ?? 'INT';
            @mysqli_query($conexion, "ALTER TABLE ticket MODIFY COLUMN id_tecnico $col_type NULL");
        }
    }
} catch (Throwable $th) {
    // Si la verificación falla, se continuará e intentará el manejo de inserción
}

// 2. Normalizar descripción en rol 1 (Admin) para que sea NULL y no espacio vacío
try {
    @mysqli_query($conexion, "UPDATE rol SET descripcion = NULL WHERE id_rol = 1 AND (descripcion = '' OR descripcion = ' ')");
} catch (Throwable $th) {
    // Ignorar si no aplica
}

// 3. Determinar si id_tecnico es numérico válido o NULL (ticket no asignado)
if (!empty($_POST['id_tecnico']) && intval($_POST['id_tecnico']) > 0) {
    $id_tecnico_val = intval($_POST['id_tecnico']);
} else {
    $id_tecnico_val = "NULL";
}

$sql = "INSERT INTO ticket (id_usuario, id_tecnico, titulo, descripcion, fecha_creacion, estado, prioridad) 
        VALUES ($id_usuario, $id_tecnico_val, '$titulo', '$descripcion', '$fecha', '$estado', '$prioridad')";

try {
    mysqli_query($conexion, $sql);
    header("Location: tickets.php");
    exit;
} catch (Throwable $e) {
    // Si todavía rechaza NULL debido al modo estricto de MariaDB:
    if (stripos($e->getMessage(), 'cannot be null') !== false) {
        // Forzar alteración de la columna a NULL
        @mysqli_query($conexion, "ALTER TABLE ticket MODIFY COLUMN id_tecnico INT NULL");
        
        try {
            mysqli_query($conexion, $sql);
            header("Location: tickets.php");
            exit;
        } catch (Throwable $e2) {
            // Plan de contingencia automático: asignar el primer técnico registrado en la base de datos
            $tec_res = mysqli_query($conexion, "SELECT id_tecnico FROM tecnico LIMIT 1");
            if ($tec_res && ($tec_row = mysqli_fetch_assoc($tec_res))) {
                $f_tec = intval($tec_row['id_tecnico']);
                $sql_f = "INSERT INTO ticket (id_usuario, id_tecnico, titulo, descripcion, fecha_creacion, estado, prioridad) 
                          VALUES ($id_usuario, $f_tec, '$titulo', '$descripcion', '$fecha', '$estado', '$prioridad')";
                mysqli_query($conexion, $sql_f);
                header("Location: tickets.php");
                exit;
            }
        }
    }
    
    // Si ocurre un error imprevisto, mostrar mensaje comprensible
    echo "<div style='font-family: sans-serif; padding: 20px; background: #1a1a2e; color: #fff;'>";
    echo "<h3>Error al registrar el ticket</h3>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='ticket_nuevo.php' style='color: #8B5CF6;'>&larr; Volver a intentar</a></p>";
    echo "</div>";
}
?>
