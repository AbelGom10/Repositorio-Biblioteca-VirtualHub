<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['rol'] != 1) {
    echo "Acceso denegado";
    exit();
}
$id = $_GET['id'];

$sql = "DELETE FROM libros WHERE id=$id";

if ($conexion->query($sql)) {
    echo "Libro eliminado";
} else {
    echo "Error: " . $conexion->error;
}
?>