<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// 🔥 Rol usuario = 2 (ajústalo según tu BD)
$rol = 2;

$sql = "INSERT INTO usuarios(nombre, correo, password, id_rol)
        VALUES ('$nombre', '$correo', '$password', $rol)";

if ($conexion->query($sql)) {
    header("Location: login.php?registro=ok");
} else {
    echo "Error: " . $conexion->error;
}
?>