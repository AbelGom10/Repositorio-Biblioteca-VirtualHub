<?php
include("conexion.php");

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$stock = $_POST['stock'];

$sql = "UPDATE libros 
        SET titulo='$titulo', autor='$autor', stock=$stock 
        WHERE id=$id";

if ($conexion->query($sql)) {
    header("Location: ver_libros.php");
    exit();
} else {
    echo "Error: " . $conexion->error;
}
?>