<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "<div class='alert alert-danger text-center mt-5'>Acceso denegado</div>";
    exit();
}

$id_usuario = $_POST['id_usuario'];
$id_libro = $_POST['id_libro'];

$mensaje = "";
$tipo = "danger"; // success | danger | warning

$result = $conexion->query("SELECT stock, titulo FROM libros WHERE id=$id_libro");

if ($result->num_rows == 0) {
    $mensaje = "❌ Libro no encontrado";
} else {

    $libro = $result->fetch_assoc();

    if ($libro['stock'] > 0) {

        $sql = "INSERT INTO prestamos(id_usuario, id_libro, fecha_prestamo, fecha_devolucion, estado) 
                VALUES ($id_usuario, $id_libro, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'ACTIVO')";

        if ($conexion->query($sql)) {

            $conexion->query("UPDATE libros SET stock = stock - 1 WHERE id=$id_libro");

            $mensaje = "✅ Préstamo registrado correctamente del libro: <strong>{$libro['titulo']}</strong>";
            $tipo = "success";

        } else {
            $mensaje = "❌ Error al registrar préstamo: " . $conexion->error;
        }

    } else {
        $mensaje = "⚠ No hay stock disponible";
        $tipo = "warning";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de préstamo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    height: 100vh;
}

.card {
    border-radius: 20px;
}
</style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="col-md-5">

        <div class="card shadow-lg border-0">

            <div class="card-header text-center text-white" style="background: #5a67d8;">
                <h4>📖 Resultado del préstamo</h4>
            </div>

            <div class="card-body text-center p-4">

                <div class="alert alert-<?php echo $tipo; ?>">
                    <?php echo $mensaje; ?>
                </div>

                <a href="registrar_prestamo.php" class="btn btn-success mt-3">
                    ➕ Registrar otro préstamo
                </a>

                <a href="dashboard.php" class="btn btn-dark mt-3">
                    ⬅ Volver al dashboard
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>