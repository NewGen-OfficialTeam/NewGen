<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$password = md5($_POST['password']); // Encriptación MD5
$id_rol = $_POST['id_rol'];
$estado = $_POST['estado'];

$sql = "INSERT INTO usuario (id_rol, nombre, apellido, email, contraseña, estado) 
        VALUES ('$id_rol', '$nombre', '$apellido', '$email', '$password', '$estado')";

if(mysqli_query($conexion, $sql)){
    header("Location: usuarios.php");
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>
