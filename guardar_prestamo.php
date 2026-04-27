<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

$id_usuario = $_POST['id_usuario'];
$id_libro = $_POST['id_libro'];

$result = $conexion->query("SELECT stock FROM libros WHERE id=$id_libro");

if ($result->num_rows == 0) {
    echo "Libro no encontrado";
    exit();
}

$libro = $result->fetch_assoc();

if ($libro['stock'] > 0) {

    $sql = "INSERT INTO prestamos(id_usuario, id_libro, fecha_prestamo, fecha_devolucion, estado) 
            VALUES ($id_usuario, $id_libro, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'ACTIVO')";

    if ($conexion->query($sql)) {

        $conexion->query("UPDATE libros SET stock = stock - 1 WHERE id=$id_libro");

        echo "Préstamo registrado correctamente";

    } else {
        echo "Error al registrar préstamo: " . $conexion->error;
    }

} else {
    echo "No hay stock disponible";
}
?>