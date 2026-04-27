<?php
session_start();
include("conexion.php");

// Validar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

// Validar rol
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

// Validar POST
if (!isset($_POST['id'], $_POST['titulo'], $_POST['autor'], $_POST['stock'])) {
    echo "Error: datos incompletos";
    exit();
}

// Obtener datos
$id = intval($_POST['id']);
$titulo = $conexion->real_escape_string($_POST['titulo']);
$autor = $conexion->real_escape_string($_POST['autor']);
$stock = intval($_POST['stock']);

// Ejecutar query
$sql = "UPDATE libros 
        SET titulo='$titulo', autor='$autor', stock=$stock 
        WHERE id=$id";

if ($conexion->query($sql)) {

    // 🔥 Redirección con mensaje
    header("Location: ConsultarLibros.php?mensaje=actualizado");
    exit();

} else {
    echo "Error: " . $conexion->error;
}
?>