<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['rol'] != 1) {
    echo "Acceso denegado";
    exit();
}

$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$genero = $_POST['genero'];
$isbn = $_POST['isbn'];
$stock = $_POST['stock'];

$sql = "INSERT INTO libros (titulo, autor, genero, isbn, stock)
        VALUES ('$titulo', '$autor', '$genero', '$isbn', $stock)";

if ($conexion->query($sql)) {
    echo "Libro registrado correctamente";
} else {
    echo "Error: " . $conexion->error;
}
?>