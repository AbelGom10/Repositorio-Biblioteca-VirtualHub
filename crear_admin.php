<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// 🔥 Rol admin = 1
$rol = 1;

$sql = "INSERT INTO usuarios(nombre, correo, password, id_rol)
        VALUES ('$nombre', '$correo', '$password', $rol)";

if ($conexion->query($sql)) {
    echo "Administrador creado correctamente";
} else {
    echo "Error: " . $conexion->error;
}
?>