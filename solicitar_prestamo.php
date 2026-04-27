<?php
session_start();
include("conexion.php");

// 🔒 Validar sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// 🔒 Validar ID libro
if (!isset($_GET['id'])) {
    echo "ID de libro no válido";
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id_libro = intval($_GET['id']); // 🔥 seguridad básica

// 🔍 Verificar stock
$check = $conexion->query("SELECT stock FROM libros WHERE id = $id_libro");
$libro = $check->fetch_assoc();

if (!$libro) {
    echo "Libro no encontrado";
    exit();
}

if ($libro['stock'] <= 0) {
    echo "No hay stock disponible";
    exit();
}

// 🔥 Insertar solicitud
$sql = "INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, estado)
        VALUES ($id_usuario, $id_libro, CURDATE(), 'PENDIENTE')";

if ($conexion->query($sql)) {
    header("Location: ConsultarLibros.php?mensaje=solicitado");
    exit();
} else {
    echo "Error en SQL: " . $conexion->error; // 🔥 IMPORTANTE
}
?>