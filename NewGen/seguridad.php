<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit;
}
?>
