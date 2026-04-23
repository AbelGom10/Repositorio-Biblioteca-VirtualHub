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

$id = $_GET['id'];

// Obtener préstamo
$result = $conexion->query("SELECT id_libro FROM prestamos WHERE id=$id");
$prestamo = $result->fetch_assoc();
$id_libro = $prestamo['id_libro'];

// Actualizar préstamo
$conexion->query("UPDATE prestamos 
SET estado='DEVUELTO', fecha_real_devolucion=CURDATE()
WHERE id=$id");

// Aumentar stock
$conexion->query("UPDATE libros SET stock = stock + 1 WHERE id=$id_libro");

echo "Libro devuelto correctamente";
?>