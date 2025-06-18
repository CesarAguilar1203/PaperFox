<?php
$conexion = new mysqli("localhost", "root", "", "papeleria");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>