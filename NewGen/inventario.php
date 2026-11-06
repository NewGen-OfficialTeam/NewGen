<?php
include("seguridad.php");
include("conexion.php");

$sql = "SELECT
            e.id_equipo,
            e.nombre_equipo,
            c.nombre AS categoria,
            m.nombre AS marca,
            mo.nombre AS modelo,
            e.estado,
            CONCAT(u.nombre, ' ', u.apellido) AS usuario_asignado
        FROM equipo e
        LEFT JOIN categoria c ON e.id_categoria = c.id_categoria
        LEFT JOIN marca m ON e.id_marca = m.id_marca
        LEFT JOIN modelo mo ON e.id_modelo = mo.id_modelo
        LEFT JOIN historial_equipo h ON e.id_equipo = h.id_equipo
        LEFT JOIN usuario u ON h.id_usuario = u.id_usuario";

$resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewGen - Inventario</title>
    
    <link rel="icon" type="image/png" href="favicon.png?v=4">
    <link rel="shortcut icon" type="image/png" href="favicon.png?v=4">

    <!-- Inicialización inmediata del tema para evitar parpadeos -->
    <script>
        (function() {
            var t = localStorage.getItem('newgen_theme') || localStorage.getItem('theme') || 'dark';
            if (t === 'light') {
                document.documentElement.classList.add('light-mode');
            } else {
                document.documentElement.classList.remove('light-mode');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header class="top-bar">
        <a href="dashboard.php" class="logo-brand">
            <img src="logo.png" alt="NewGen Logo" style="height: 38px;">
            <span>NewGen</span>
        </a>
        <div class="d-flex gap-3 align-items-center">
            <a href="dashboard.php" style="color: var(--top-bar-text); font-weight: 700; text-decoration: none;" data-i18n="back_to_dashboard">Volver al panel</a>
            
            <!-- Botón Selector de Idioma (ES / EN) -->
            <button class="btn btn-sm lang-toggle-btn" id="langToggle" title="Cambiar idioma / Switch language">
                🌐 ES
            </button>

            <button class="btn btn-sm theme-toggle-btn rounded-circle" id="themeToggle" style="width: 36px; height: 36px;" title="Cambiar tema">
                <svg id="themeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                </svg>
            </button>
            <a href="logout.php" class="btn btn-sm btn-outline-danger" style="display:flex; align-items:center; justify-content:center; width:36px; height:36px;" title="Cerrar sesión">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
            </a>
        </div>
    </header>

    <div class="dashboard-container">
        <div class="list-card">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h2 class="text-white m-0" style="font-family: 'Montserrat', sans-serif; font-weight: 700;" data-i18n="inv_title">Inventario de equipos</h2>
                <a href="equipo_nuevo.php" class="btn btn-primary fw-bold" style="background-color: #8B5CF6; border: none; font-family: 'Montserrat', sans-serif; color: #FFFFFF !important;" data-i18n="inv_add_btn">Agregar nuevo equipo</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom table-hover" style="background-color: transparent;">
                    <thead>
                        <tr>
                            <th data-i18n="inv_th_id">ID</th>
                            <th data-i18n="inv_th_name">Equipo</th>
                            <th data-i18n="inv_th_category">Categoría</th>
                            <th data-i18n="inv_th_brand">Marca</th>
                            <th data-i18n="inv_th_model">Modelo</th>
                            <th data-i18n="inv_th_status">Estado</th>
                            <th data-i18n="inv_th_user">Usuario asignado</th>
                            <th data-i18n="inv_th_actions">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($fila = mysqli_fetch_assoc($resultado)){ ?>
                        <tr>
                            <td><?= $fila['id_equipo']; ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($fila['nombre_equipo']); ?></td>
                            <td><?= htmlspecialchars($fila['categoria'] ? $fila['categoria'] : "-"); ?></td>
                            <td><?= htmlspecialchars($fila['marca'] ? $fila['marca'] : "-"); ?></td>
                            <td><?= htmlspecialchars($fila['modelo'] ? $fila['modelo'] : "-"); ?></td>
                            <td><span class="badge" style="background-color: #8B5CF6; color: #FFFFFF; font-weight: 600;"><?= htmlspecialchars($fila['estado'] ? $fila['estado'] : "-"); ?></span></td>
                            <td><?= htmlspecialchars($fila['usuario_asignado'] ? $fila['usuario_asignado'] : "Sin asignar"); ?></td>
                            <td>
                                <a href="equipo_editar.php?id=<?= $fila['id_equipo']; ?>" class="btn btn-sm btn-outline-custom me-1" data-i18n="inv_action_edit">Editar</a>
                                <a href="equipo_eliminar.php?id=<?= $fila['id_equipo']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar este equipo?');" data-i18n="inv_action_delete">Borrar</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="theme.js"></script>
    <script src="lang.js"></script>
</body>
</html>
