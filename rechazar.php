<?php
session_start();
include("conexion.php");

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

$id = intval($_GET['id']);

$conexion->query("
    UPDATE prestamos 
    SET estado='RECHAZADO' 
    WHERE id=$id
");

header("Location: solicitudes.php");
?>