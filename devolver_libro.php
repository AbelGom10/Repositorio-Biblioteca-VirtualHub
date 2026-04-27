<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

if (!isset($_GET['id'])) {
    die("ID no válido");
}

$id = intval($_GET['id']);

// Obtener préstamo
$result = $conexion->query("SELECT id_libro FROM prestamos WHERE id=$id");

if ($result->num_rows == 0) {
    die("Préstamo no encontrado");
}

$prestamo = $result->fetch_assoc();
$id_libro = $prestamo['id_libro'];

// Actualizar préstamo
$conexion->query("
    UPDATE prestamos 
    SET estado='DEVUELTO', fecha_real_devolucion=CURDATE()
    WHERE id=$id
");

// Aumentar stock
$conexion->query("
    UPDATE libros 
    SET stock = stock + 1 
    WHERE id=$id_libro
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Devolución</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    border-radius: 20px;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
</style>
</head>

<body>

<div class="card shadow-lg p-4 text-center">

    <h2 class="text-success">
        <i class="bi bi-check-circle-fill"></i> ¡Devolución exitosa!
    </h2>

    <p class="mt-3">
        El libro ha sido devuelto correctamente y el stock fue actualizado.
    </p>

    <a href="ver_prestamos.php" class="btn btn-success mt-3">
        <i class="bi bi-arrow-left"></i> Volver a préstamos
    </a>

</div>

</body>
</html>