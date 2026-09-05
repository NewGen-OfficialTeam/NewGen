<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "sistema_de_gestion";

$conexion = mysqli_connect($servidor, $usuario, $password, $baseDatos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>