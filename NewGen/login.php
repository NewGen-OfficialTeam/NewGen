<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = md5($_POST['password']);
    
    // Buscar en tabla usuario
    $sql_user = "SELECT * FROM usuario WHERE email = '$email' AND contraseña = '$password'";
    $res_user = mysqli_query($conexion, $sql_user);
    if(mysqli_num_rows($res_user) > 0) {
        $user = mysqli_fetch_assoc($res_user);
        $_SESSION['id'] = $user['id_usuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['apellido'] = $user['apellido'] ?? '';
        $_SESSION['email'] = $user['email'];
        $_SESSION['rol'] = $user['id_rol']; 
        $_SESSION['tipo'] = 'usuario';
        
        header("Location: dashboard.php");
        exit;
    }
    
    // Buscar en tabla tecnico (si está registrada por separado)
    $sql_tec = "SELECT * FROM tecnico WHERE email = '$email' AND contraseña = '$password'";
    $res_tec = mysqli_query($conexion, $sql_tec);
    if(mysqli_num_rows($res_tec) > 0) {
        $tec = mysqli_fetch_assoc($res_tec);
        $_SESSION['id'] = $tec['id_tecnico'];
        $_SESSION['nombre'] = $tec['nombre'];
        $_SESSION['apellido'] = $tec['apellido'] ?? '';
        $_SESSION['email'] = $tec['email'] ?? 'tecnico@newgen.com';
        $_SESSION['rol'] = 2;
        $_SESSION['tipo'] = 'tecnico';
        
        header("Location: dashboard.php");
        exit;
    }
    
    $error = "Credenciales incorrectas. Verifique email y contraseña.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NewGen</title>
    
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
<body class="login-page d-flex align-items-center justify-content-center position-relative" style="min-height: 100vh;">

    <!-- Controles de cabecera: Idioma y Tema -->
    <div style="position: absolute; top: 18px; right: 24px; display: flex; gap: 10px; align-items: center; z-index: 10;">
        <button class="btn btn-sm lang-toggle-btn" id="langToggle" title="Cambiar idioma / Switch language">
            🌐 ES
        </button>
        <button class="btn btn-sm theme-toggle-btn rounded-circle" id="themeToggle" style="width: 36px; height: 36px;" title="Cambiar tema">
            <svg id="themeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
            </svg>
        </button>
    </div>

    <div class="profile-card login-card p-5 text-center" style="width: 100%; max-width: 420px;">
        <img src="logo_inicio.png" alt="NewGen Logo" style="height: 65px; margin-bottom: 20px;">
        <h3 class="text-white mb-4" style="font-family: 'Montserrat', sans-serif; font-weight: 700;" data-i18n="login_title">Iniciar sesión</h3>

        <?php if(isset($error)) { echo "<div class='alert alert-danger py-2' style='font-size: 0.9rem;'>$error</div>"; } ?>

        <form method="POST" action="login.php">
            <div class="mb-3 text-start">
                <label class="form-label text-muted" data-i18n="login_email">Correo electrónico</label>
                <input type="email" name="email" class="form-control login-input" placeholder="usuario@newgen.com" required>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label text-muted" data-i18n="login_password">Contraseña</label>
                <input type="password" name="password" class="form-control login-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="background-color: #8B5CF6; border: none; font-family: 'Montserrat', sans-serif; color: #FFFFFF !important;" data-i18n="login_submit">Ingresar</button>
        </form>

        <div class="mt-4">
            <a href="/sitio/index.html" class="text-muted" style="font-size: 0.88rem; text-decoration: none;" data-i18n="login_back_home">&larr; Volver al sitio corporativo</a>
        </div>
    </div>

    <script src="theme.js"></script>
    <script src="lang.js"></script>
</body>
</html>
