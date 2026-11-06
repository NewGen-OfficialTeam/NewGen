<?php
include("seguridad.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewGen - Editar Equipo</title>
    
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
            <a href="inventario.php" style="color: var(--top-bar-text); font-weight: 700; text-decoration: none;" data-i18n="back_to_inventory">Volver al inventario</a>
            
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

    <div class="container mt-5" style="max-width: 600px;">
        <div class="profile-card d-block p-4">
            <h2 class="mb-4 text-center" style="font-family: 'Montserrat', sans-serif; font-weight: 700; color: #C78FFC !important;">Editar equipo</h2>
            
            <form action="equipo_actualizar.php" method="POST">
                <input type="hidden" name="id_equipo" value="<?= $equipo['id_equipo'] ?>">
                
                <div class="mb-3">
                    <label class="form-label text-muted">Nombre del equipo:</label>
                    <input type="text" name="nombre_equipo" class="form-control bg-dark text-white border-secondary" value="<?= htmlspecialchars($equipo['nombre_equipo']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Categoría:</label>
                    <select name="id_categoria" class="form-select bg-dark text-white border-secondary" required>
                        <?php while($cat = mysqli_fetch_assoc($q_categorias)){ ?>
                            <option value="<?= $cat['id_categoria'] ?>" <?= $cat['id_categoria'] == $equipo['id_categoria'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['nombre']) ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">Marca:</label>
                    <select name="id_marca" class="form-select bg-dark text-white border-secondary" required>
                        <?php while($marca = mysqli_fetch_assoc($q_marcas)){ ?>
                            <option value="<?= $marca['id_marca'] ?>" <?= $marca['id_marca'] == $equipo['id_marca'] ? 'selected' : '' ?>><?= htmlspecialchars($marca['nombre']) ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label text-muted">Modelo:</label>
                        <select name="id_modelo" class="form-select bg-dark text-white border-secondary" required>
                            <?php while($modelo = mysqli_fetch_assoc($q_modelos)){ ?>
                                <option value="<?= $modelo['id_modelo'] ?>" <?= $modelo['id_modelo'] == $equipo['id_modelo'] ? 'selected' : '' ?>><?= htmlspecialchars($modelo['nombre']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted">Estado:</label>
                        <input type="text" name="estado" class="form-control bg-dark text-white border-secondary" value="<?= htmlspecialchars($equipo['estado']) ?>">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold" style="background-color: #8B5CF6; border: none; font-family: 'Montserrat', sans-serif; color: #FFFFFF !important;">Actualizar equipo</button>
            </form>
        </div>
    </div>
    
    <script src="theme.js"></script>
    <script src="lang.js"></script>
</body>
</html>
