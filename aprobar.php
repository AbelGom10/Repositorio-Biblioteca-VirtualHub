<?php
session_start();
include("conexion.php");

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

$id = intval($_GET['id']);

// 🔥 activar préstamo
$conexion->query("
    UPDATE prestamos 
    SET estado='ACTIVO', fecha_devolucion = DATE_ADD(CURDATE(), INTERVAL 7 DAY)
    WHERE id=$id
");

// 🔥 reducir stock
$conexion->query("
    UPDATE libros 
    SET stock = stock - 1 
    WHERE id = (SELECT id_libro FROM prestamos WHERE id=$id)
");

header("Location: solicitudes.php");
?>