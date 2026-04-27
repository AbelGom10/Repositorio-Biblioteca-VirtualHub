<?php
$conexion = new mysqli("localhost", "root", "Abel555", "Biblioteca_VirtualHub");

if ($conexion->connect_error) {
    die("Error: " . $conexion->connect_error);
}
?>