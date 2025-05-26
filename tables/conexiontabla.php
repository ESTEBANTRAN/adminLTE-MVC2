<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = ""; // Cambia si tienes una contraseña
$basededatos = "ejemplo_tabla";

$conexion = new mysqli($servidor, $usuario, $contrasena, $basededatos);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
