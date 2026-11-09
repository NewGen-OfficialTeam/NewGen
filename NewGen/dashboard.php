<?php
include("seguridad.php");
include("conexion.php");

// Datos de Usuario
$nombre_usuario = $_SESSION["nombre"] ?? "Admin";
$apellido_usuario = $_SESSION["apellido"] ?? "";
$nombre_completo = trim($nombre_usuario . " " . $apellido_usuario);
if(empty($nombre_completo)) {
    $nombre_completo = $nombre_usuario;
}
$email_usuario = $_SESSION["email"] ?? (strtolower($nombre_usuario) . "@newgen.com");
$id_usuario = $_SESSION["id"] ?? 1;

// Iniciales
if (function_exists('mb_substr')) {
    $iniciales = strtoupper(mb_substr($nombre_usuario, 0, 2, 'UTF-8'));
} else {
    $iniciales = strtoupper(substr($nombre_usuario, 0, 2));
}

// Determinar Rol
$rol_id = $_SESSION['rol'] ?? 1;
$rol_nombre = "Usuario";
if($rol_id == 1) $rol_nombre = "Admin";
if($rol_id == 2) $rol_nombre = "Técnico";
if($rol_id == 3) $rol_nombre = "Solicitante";

// Estadísticas de Base de Datos
$res_total = mysqli_query($conexion, "SELECT COUNT(*) as c FROM equipo");
$total_equipos = $res_total ? mysqli_fetch_assoc($res_total)["c"] : 0;
$total_display = max(142, $total_equipos);

$res_rep = mysqli_query($conexion, "SELECT COUNT(*) as c FROM equipo WHERE estado != 'Disponible'");
$equipos_uso = $res_rep ? mysqli_fetch_assoc($res_rep)["c"] : 0;
$stock_bajo_display = max(26, $equipos_uso);

$res_tickets = mysqli_query($conexion, "SELECT COUNT(*) as c FROM ticket WHERE estado != 'Resuelto' AND estado != 'Cerrado'");
$tickets_abiertos = $res_tickets ? mysqli_fetch_assoc($res_tickets)["c"] : 0;
$movimientos_display = 312 + $tickets_abiertos;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewGen - Dashboard</title>
    
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

    <!-- BARRA SUPERIOR -->
    <header class="top-bar">
        <a href="dashboard.php" class="logo-brand">
            <img src="logo.png" alt="NewGen Logo" style="height: 38px;">
            <span>NewGen</span>
        </a>

        <div class="d-flex gap-3 align-items-center">
            <!-- Badge de Rol Dinámico -->
            <span class="badge rounded-pill px-3 py-2" style="background-color: #8B5CF6; font-size: 0.88rem;">
                <?= htmlspecialchars($rol_nombre) ?>
            </span>

            <!-- Enlace al Sitio Corporativo -->
            <a href="/sitio/index.html" class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" style="border-radius: 20px; font-size: 0.82rem; font-weight: 600; text-decoration: none;" title="Ver sitio corporativo">
                🏢 <span class="d-none d-md-inline">Sitio Web</span>
            </a>

            <!-- Botón Selector de Idioma (ES / EN) -->
            <button class="btn btn-sm lang-toggle-btn" id="langToggle" title="Cambiar idioma / Switch language">
                🌐 ES
            </button>

            <!-- Botón Dark/Light Mode -->
            <button class="btn btn-sm theme-toggle-btn rounded-circle" id="themeToggle" style="width: 36px; height: 36px;" title="Cambiar tema">
                <svg id="themeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
                </svg>
            </button>
            
            <!-- Botón Salir -->
            <a href="logout.php" class="btn btn-sm btn-outline-danger" style="display:flex; align-items:center; justify-content:center; width:36px; height:36px;" title="Cerrar sesión">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
            </a>
        </div>
    </header>

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="dashboard-container">
        
        <!-- BIENVENIDA Y TARJETA DE PERFIL -->
        <section class="welcome-section">
            <div>
                <h1 class="welcome-title text-white"><span data-i18n="welcome_prefix">Bienvenido, </span><?= htmlspecialchars($nombre_usuario) ?></h1>
                <p class="welcome-desc" data-i18n="welcome_desc">Gestioná tus recursos de software desde un solo lugar.</p>
            </div>

            <!-- Profile Pill Card (Único avatar del usuario, diseño limpio sin botones redundantes) -->
            <div class="profile-pill-card">
                <div class="profile-avatar-circle">
                    <?= htmlspecialchars($iniciales) ?>
                </div>
                <div class="profile-info">
                    <span class="profile-name text-white"><?= htmlspecialchars($nombre_completo) ?></span>
                    <span class="profile-email"><?= htmlspecialchars($email_usuario) ?></span>
                    <div>
                        <span class="badge" style="background-color: #8B5CF6; font-size: 0.74rem; padding: 3px 10px;">
                            <?= htmlspecialchars($rol_nombre) ?>
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- FILA DE 6 BOTONES DE NAVEGACIÓN -->
        <section class="nav-cards-grid">
            <!-- 1. Inicio (Activo) -->
            <a href="dashboard.php" class="nav-card-item active">
                <div class="nav-card-content">
                    <div class="nav-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                            <path d="m8 3.293 6 6V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V9.293l6-6Z"/>
                        </svg>
                    </div>
                    <span class="nav-card-label" data-i18n="nav_home">Inicio</span>
                </div>
                <span class="nav-card-arrow">&gt;</span>
            </a>

            <!-- 2. Inventario -->
            <?php if($rol_id == 1 || $rol_id == 2) { ?>
            <a href="inventario.php" class="nav-card-item">
                <div class="nav-card-content">
                    <div class="nav-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                        </svg>
                    </div>
                    <span class="nav-card-label" data-i18n="nav_inventory">Inventario</span>
                </div>
                <span class="nav-card-arrow">&gt;</span>
            </a>
            <?php } ?>

            <!-- 3. Tickets -->
            <a href="tickets.php" class="nav-card-item">
                <div class="nav-card-content">
                    <div class="nav-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5ZM1.5 4a.5.5 0 0 0-.5.5v1.05a2.5 2.5 0 0 1 0 4.9v1.05a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-1.05a2.5 2.5 0 0 1 0-4.9V4.5a.5.5 0 0 0-.5-.5h-13Z"/>
                        </svg>
                    </div>
                    <span class="nav-card-label" data-i18n="nav_tickets">Tickets</span>
                </div>
                <span class="nav-card-arrow">&gt;</span>
            </a>

            <!-- 4. Mesa de ayuda -->
            <a href="ticket_nuevo.php" class="nav-card-item">
                <div class="nav-card-content">
                    <div class="nav-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 1a5 5 0 0 0-5 5v1h1a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a6 6 0 1 1 12 0v6a2.5 2.5 0 0 1-2.5 2.5H9.366a1 1 0 0 1-.866.5h-1a1 1 0 1 1 0-2h1a1 1 0 0 1 .866.5H11.5A1.5 1.5 0 0 0 13 12h-1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h1V6a5 5 0 0 0-5-5z"/>
                        </svg>
                    </div>
                    <span class="nav-card-label" data-i18n="nav_helpdesk">Mesa de ayuda</span>
                </div>
                <span class="nav-card-arrow">&gt;</span>
            </a>

            <!-- 5. Reportes -->
            <?php if($rol_id == 1) { ?>
            <a href="reportes.php" class="nav-card-item">
                <div class="nav-card-content">
                    <div class="nav-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm6-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V7zm6-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z"/>
                        </svg>
                    </div>
                    <span class="nav-card-label" data-i18n="nav_reports">Reportes</span>
                </div>
                <span class="nav-card-arrow">&gt;</span>
            </a>
            <?php } ?>

            <!-- 6. Usuario -->
            <?php if($rol_id == 1) { ?>
            <a href="usuarios.php" class="nav-card-item">
                <div class="nav-card-content">
                    <div class="nav-icon-box">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                    </div>
                    <span class="nav-card-label" data-i18n="nav_users">Usuario</span>
                </div>
                <span class="nav-card-arrow">&gt;</span>
            </a>
            <?php } ?>
        </section>

        <!-- SECCIÓN PRINCIPAL: ESTADÍSTICAS + GRÁFICO + MOVIMIENTOS -->
        <div class="row g-4">
            
            <!-- COLUMNA IZQUIERDA (Estadísticas y Gráfico) -->
            <div class="col-xl-8 col-lg-7">
                
                <!-- 3 TARJETAS DE ESTADÍSTICAS -->
                <div class="stat-cards-grid">
                    <!-- Stat 1: Productos en stock -->
                    <div class="stat-box-card">
                        <div class="stat-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label-text" data-i18n="stat_stock">Productos en stock</span>
                            <span class="stat-value-text text-white"><?= $total_display ?></span>
                            <span class="stat-trend-text stat-trend-green">&uarr; 8% <span data-i18n="stat_vs_month">vs. mes anterior</span></span>
                        </div>
                    </div>

                    <!-- Stat 2: Stock bajo -->
                    <div class="stat-box-card">
                        <div class="stat-icon-wrapper" style="color: #EC4899; background: rgba(236, 72, 153, 0.16); border-color: rgba(236, 72, 153, 0.35);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label-text" data-i18n="stat_stock_low">Stock bajo</span>
                            <span class="stat-value-text text-white"><?= $stock_bajo_display ?></span>
                            <span class="stat-trend-text stat-trend-pink">&uarr; 15% <span data-i18n="stat_vs_month">vs. mes anterior</span></span>
                        </div>
                    </div>

                    <!-- Stat 3: Movimientos del mes -->
                    <div class="stat-box-card">
                        <div class="stat-icon-wrapper" style="color: #38BDF8; background: rgba(56, 189, 248, 0.16); border-color: rgba(56, 189, 248, 0.35);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <span class="stat-label-text" data-i18n="stat_movements">Movimientos del mes</span>
                            <span class="stat-value-text text-white"><?= $movimientos_display ?></span>
                            <span class="stat-trend-text stat-trend-blue">&uarr; 22% <span data-i18n="stat_vs_month">vs. mes anterior</span></span>
                        </div>
                    </div>
                </div>

                <!-- GRÁFICO: EVOLUCIÓN DEL INVENTARIO -->
                <div class="chart-card-box">
                    <div class="chart-header">
                        <span class="chart-title text-white" data-i18n="chart_title">Evolución del inventario</span>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <span class="legend-dot-purple"></span>
                                <span class="text-white" data-i18n="chart_in">Entradas</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-dot-pink"></span>
                                <span class="text-white" data-i18n="chart_out">Salidas</span>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENEDOR DE GRÁFICO CON CUADRÍCULA RECTA Y EXACTA -->
                    <div class="chart-body-wrapper">
                        <!-- LÍNEAS DE GUÍA HORIZONTALES CON SU ETIQUETA Y (Alineadas pixel-perfect) -->
                        <div class="chart-grid-container">
                            <div class="chart-grid-row" style="top: 0%;">
                                <span class="chart-y-label">250</span>
                                <div class="chart-grid-line"></div>
                            </div>
                            <div class="chart-grid-row" style="top: 20%;">
                                <span class="chart-y-label">200</span>
                                <div class="chart-grid-line"></div>
                            </div>
                            <div class="chart-grid-row" style="top: 40%;">
                                <span class="chart-y-label">150</span>
                                <div class="chart-grid-line"></div>
                            </div>
                            <div class="chart-grid-row" style="top: 60%;">
                                <span class="chart-y-label">100</span>
                                <div class="chart-grid-line"></div>
                            </div>
                            <div class="chart-grid-row" style="top: 80%;">
                                <span class="chart-y-label">50</span>
                                <div class="chart-grid-line"></div>
                            </div>
                            <div class="chart-grid-row" style="top: 100%;">
                                <span class="chart-y-label">0</span>
                                <div class="chart-grid-line chart-grid-baseline"></div>
                            </div>
                        </div>

                        <!-- BARRAS DUALES DE 9 MESES (Abr a Dic) -->
                        <div class="chart-bars-container">
                            <!-- Abr 22 -->
                            <div class="chart-month-group">
                                <div class="chart-dual-bars">
                                    <div class="bar-purple" style="height: 32%;"></div>
                                    <div class="bar-pink" style="height: 25%;"></div>
                                </div>
                                <span class="chart-month-label">Abr 22</span>
                            </div>

                            <!-- May 22 -->
                            <div class="chart-month-group">
                                <div class="chart-dual-bars">
                                    <div class="bar-purple" style="height: 48%;"></div>
                                    <div class="bar-pink" style="height: 34%;"></div>
                                </div>
                                <span class="chart-month-label">May 22</span>
                            </div>

                            <!-- Jun 22 -->
                            <div class="chart-month-group">
                                <div class="chart-dual-bars">
                                    <div class="bar-purple" style="height: 52%;"></div>
                                    <div class="bar-pink" style="height: 42%;"></div>
                                </div>
                                <span class="chart-month-label">Jun 22</span>
                            </div>

                            <!-- Jul 22 -->
                            <div class="chart-month-group">
                                <div class="chart-dual-bars">
                                    <div class="bar-purple" style="height: 56%;"></div>
                                    <div class="bar-pink" style="height: 44%;"></div>
                                </div>
                                <span class="chart-month-label">Jul 22</span>
                            </div>

                            <!-- Ago 22 -->
                            <div class="chart-month-group">
                                <div class="chart-dual-bars">
                                    <div class="bar-purple" style="height: 64%;"></div>
                                    <div class="bar-pink" style="height: 50%;"></div>
                                </div>
                                <span class="chart-month-label">Ago 22</span>
                            </div>

                            <!-- Sep 22 -->
                            <div class="chart-month-group">
                                <div class="chart-dual-bars">
                                    <div class="bar-purple" style="height: 68%;"></div>
                                    <div class="bar-pink" style="height: 50%;"></div>
                                </div>
                                <span class="chart-month-label">Sep 22</span>
                            </div>

                            <!-- Oct 22 -->
                            <div class="chart-month-group">
                                <div class="chart-dual-bars">
                                    <div class="bar-purple" style="height: 74%;"></div>
                                    <div class="bar-pink" style="height: 55%;"></div>
                                </div>
                                <span class="chart-month-label">Oct 22</span>
                            </div>

                            <!-- Nov 22 -->
                            <div class="chart-month-group">
                                <div class="chart-dual-bars">
                                    <div class="bar-purple" style="height: 70%;"></div>
                                    <div class="bar-pink" style="height: 56%;"></div>
                                </div>
                                <span class="chart-month-label">Nov 22</span>
                            </div>

                            <!-- Dic 22 -->
                            <div class="chart-month-group">
                                <div class="chart-dual-bars">
                                    <div class="bar-purple" style="height: 80%;"></div>
                                    <div class="bar-pink" style="height: 64%;"></div>
                                </div>
                                <span class="chart-month-label">Dic 22</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: ÚLTIMOS MOVIMIENTOS DE INVENTARIO -->
            <div class="col-xl-4 col-lg-5">
                <div class="movements-card">
                    <div class="movements-header">
                        <span class="movements-title text-white" data-i18n="movements_title">Últimos movimientos de inventario</span>
                        <a href="inventario.php" class="movements-view-all"><span data-i18n="movements_view_all">Ver todos</span> &rarr;</a>
                    </div>

                    <div class="movements-list">
                        <!-- Item 1: Laptop Dell Inspiron 15 -->
                        <div class="movement-row">
                            <div class="movement-left">
                                <div class="movement-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="movement-title text-white">Laptop Dell Inspiron 15</div>
                                    <div class="movement-sub">Entrada de inventario</div>
                                </div>
                            </div>
                            <div class="movement-right">
                                <span class="movement-diff movement-diff-plus">+5</span>
                                <span class="movement-date">12 abr 2026 &middot; 09:24</span>
                            </div>
                        </div>

                        <!-- Item 2: Mouse Logitech M170 -->
                        <div class="movement-row">
                            <div class="movement-left">
                                <div class="movement-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="movement-title text-white">Mouse Logitech M170</div>
                                    <div class="movement-sub">Salida de inventario</div>
                                </div>
                            </div>
                            <div class="movement-right">
                                <span class="movement-diff movement-diff-minus">-10</span>
                                <span class="movement-date">11 abr 2026 &middot; 16:32</span>
                            </div>
                        </div>

                        <!-- Item 3: Teclado Logitech K120 -->
                        <div class="movement-row">
                            <div class="movement-left">
                                <div class="movement-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="movement-title text-white">Teclado Logitech K120</div>
                                    <div class="movement-sub">Entrada de inventario</div>
                                </div>
                            </div>
                            <div class="movement-right">
                                <span class="movement-diff movement-diff-plus">+8</span>
                                <span class="movement-date">10 abr 2026 &middot; 11:17</span>
                            </div>
                        </div>

                        <!-- Item 4: Monitor LG 24" -->
                        <div class="movement-row">
                            <div class="movement-left">
                                <div class="movement-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="movement-title text-white">Monitor LG 24&quot;</div>
                                    <div class="movement-sub">Salida de inventario</div>
                                </div>
                            </div>
                            <div class="movement-right">
                                <span class="movement-diff movement-diff-minus">-3</span>
                                <span class="movement-date">9 abr 2026 &middot; 14:50</span>
                            </div>
                        </div>

                        <!-- Item 5: SSD Kingston 480GB -->
                        <div class="movement-row">
                            <div class="movement-left">
                                <div class="movement-icon-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="movement-title text-white">SSD Kingston 480GB</div>
                                    <div class="movement-sub">Entrada de inventario</div>
                                </div>
                            </div>
                            <div class="movement-right">
                                <span class="movement-diff movement-diff-plus">+4</span>
                                <span class="movement-date">8 abr 2026 &middot; 10:12</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script src="theme.js"></script>
    <script src="lang.js"></script>
</body>
</html>
