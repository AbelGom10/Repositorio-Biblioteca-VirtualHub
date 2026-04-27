<?php
session_start();
include("conexion.php");

$correo = $_POST['correo'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE correo='$correo'";
$result = $conexion->query($sql);

if ($result->num_rows == 1) {

    $usuario = $result->fetch_assoc();

    // 🔥 VALIDACIÓN CORRECTA
    if (password_verify($password, $usuario['password'])) {

        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['rol'] = intval($usuario['id_rol']);
        $_SESSION['id_usuario'] = $usuario['id'];
        //echo "ROL BD: " . $usuario['id_rol'] . "<br>";
        //echo "ROL SESION: " . intval($usuario['id_rol']);
        //exit();

        header("Location: dashboard.php");
        exit();

    } else {
        header("Location: login.php?error=1");
        exit();
    }

} else {
    header("Location: login.php?error=1");
    exit();
}
?>