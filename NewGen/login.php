<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    
    // Buscar en tabla usuario
    $sql_user = "SELECT * FROM usuario WHERE email = '$email' AND contraseña = '$password'";
    $res_user = mysqli_query($conexion, $sql_user);
    if(mysqli_num_rows($res_user) > 0) {
        $user = mysqli_fetch_assoc($res_user);
        $_SESSION['id'] = $user['id_usuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['id_rol']; 
        $_SESSION['tipo'] = 'usuario';
        
        // Asumiendo que rol 1 es Admin
        if($user['id_rol'] == 1) {
            header("Location: index_admin.html");
        } else {
            header("Location: index_usuario.html");
        }
        exit;
    }
    
    // Buscar en tabla tecnico
    $sql_tec = "SELECT * FROM tecnico WHERE email = '$email' AND contraseña = '$password'";
    $res_tec = mysqli_query($conexion, $sql_tec);
    if(mysqli_num_rows($res_tec) > 0) {
        $tec = mysqli_fetch_assoc($res_tec);
        $_SESSION['id'] = $tec['id_tecnico'];
        $_SESSION['nombre'] = $tec['nombre'];
        $_SESSION['tipo'] = 'tecnico';
        header("Location: index_tecnico.html");
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
<title>Login - Sistema Gestión TI</title>
</head>

<body>

<h1>Sistema de Gestión de Recursos y Soporte TI</h1>

<hr>

<h2>Iniciar Sesión</h2>

<?php if(isset($error)) { echo "<p style='color:red; font-weight:bold;'>$error</p>"; } ?>

<form method="POST" action="login.php">

<label>Email</label><br>
<input type="email" name="email" required><br><br>

<label>Contraseña</label><br>
<input type="password" name="password" required><br><br>

<button type="submit">Ingresar</button>

</form>

<hr>

<p><em>Para probar el sistema por primera vez, deberás insertar un usuario en la base de datos (con Navicat) y usar su email y contraseña aquí.</em></p>

</body>
</html>
