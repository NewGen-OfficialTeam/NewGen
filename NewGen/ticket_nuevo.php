<?php
include("seguridad.php");
include("conexion.php");

$usr_res = mysqli_query($conexion, "SELECT * FROM usuario");
$tec_res = mysqli_query($conexion, "SELECT * FROM tecnico");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewGen - Nuevo Ticket</title>
    
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
            <a href="tickets.php" style="color: var(--top-bar-text); font-weight: 700; text-decoration: none;" data-i18n="back_to_tickets">Volver a tickets</a>
            
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
            <h2 class="mb-4 text-center" style="font-family: 'Montserrat', sans-serif; font-weight: 700; color: #C78FFC !important;" data-i18n="new_ticket_title">Crear nuevo ticket</h2>
            
            <form action="ticket_guardar.php" method="POST">
                <div class="mb-3">
                    <label class="form-label text-muted" data-i18n="new_ticket_problem">Título del problema:</label>
                    <input type="text" name="titulo" class="form-control bg-dark text-white border-secondary" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted" data-i18n="new_ticket_desc">Descripción detallada:</label>
                    <textarea name="descripcion" class="form-control bg-dark text-white border-secondary" rows="4" required></textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label text-muted" data-i18n="new_ticket_priority">Prioridad:</label>
                        <select name="prioridad" class="form-select bg-dark text-white border-secondary">
                            <option value="Baja" data-i18n="prio_low">Baja</option>
                            <option value="Media" selected data-i18n="prio_medium">Media</option>
                            <option value="Alta" data-i18n="prio_high">Alta</option>
                            <option value="Critica">Crítica</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted" data-i18n="tickets_th_status">Estado:</label>
                        <input type="text" name="estado" class="form-control bg-dark text-white border-secondary" value="Abierto" readonly>
                    </div>
                </div>

                <?php if($_SESSION['rol'] == 1){ ?>
                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label text-muted" data-i18n="new_ticket_user">Usuario solicitante:</label>
                        <select name="id_usuario" class="form-select bg-dark text-white border-secondary">
                            <?php while($u = mysqli_fetch_assoc($usr_res)){ ?>
                                <option value="<?= $u['id_usuario'] ?>"><?= htmlspecialchars($u['nombre']." ".$u['apellido']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted" data-i18n="new_ticket_tech">Técnico:</label>
                        <select name="id_tecnico" class="form-select bg-dark text-white border-secondary">
                            <option value="" data-i18n="tickets_unassigned_tech">Sin asignar</option>
                            <?php while($tec = mysqli_fetch_assoc($tec_res)){ ?>
                                <option value="<?= $tec['id_tecnico'] ?>"><?= htmlspecialchars($tec['nombre']." ".$tec['apellido']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } else { ?>
                    <input type="hidden" name="id_usuario" value="<?= $_SESSION['id'] ?>">
                    <input type="hidden" name="id_tecnico" value="">
                <?php } ?>

                <button type="submit" class="btn btn-primary w-100 fw-bold" style="background-color: #8B5CF6; border: none; font-family: 'Montserrat', sans-serif; color: #FFFFFF !important;" data-i18n="new_ticket_submit">Enviar solicitud</button>
            </form>
        </div>
    </div>
    
    <script src="theme.js"></script>
    <script src="lang.js"></script>
</body>
</html>
