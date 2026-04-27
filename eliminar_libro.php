<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}
$id = intval($_GET['id']);

// 🔍 Obtener stock
$result = $conexion->query("SELECT stock FROM libros WHERE id=$id");
$libro = $result->fetch_assoc();

if (!$libro) {
    echo "Libro no encontrado";
    exit();
}

$stock = $libro['stock'];

// 🟢 CASO 1: hay más de 1 → solo reducir
if ($stock > 1) {

    $conexion->query("UPDATE libros SET stock = stock - 1 WHERE id=$id");

    header("Location: /Repositorio-Biblioteca-VirtualHub/ConsultarLibros.php?mensaje=stock_reducido");
    exit();
}

// 🟡 CASO 2: stock = 1 → eliminar (con confirmación previa en botón)
if ($stock == 1) {

    // ❌ Validar préstamos activos
    $result = $conexion->query("
        SELECT * FROM prestamos 
        WHERE id_libro=$id AND estado='ACTIVO'
    ");

    if ($result->num_rows > 0) {
        echo "No puedes eliminar porque hay préstamos activos";
        exit();
    }

    // 🔥 eliminar historial
    $conexion->query("DELETE FROM prestamos WHERE id_libro=$id");

    // 🔥 eliminar libro
    $conexion->query("DELETE FROM libros WHERE id=$id");

    header("Location: /Repositorio-Biblioteca-VirtualHub/ConsultarLibros.php?mensaje=eliminado");
    exit();
}

// 🔴 CASO 3: stock = 0
echo "El libro ya no tiene stock disponible";
?>