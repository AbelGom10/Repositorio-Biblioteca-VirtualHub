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

$titulo = $_POST['titulo'];
$autor = $_POST['autor'];
$genero = $_POST['genero'];
$isbn = $_POST['isbn'];
$stock = $_POST['stock'];

$sql = "INSERT INTO libros (titulo, autor, genero, isbn, stock)
        VALUES ('$titulo', '$autor', '$genero', '$isbn', $stock)";

$exito = false;
$error = "";

if ($conexion->query($sql)) {
    $exito = true;
} else {
    $error = $conexion->error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de libro</title>

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
                <h4>📚 Resultado del registro</h4>
            </div>

            <div class="card-body text-center p-4">

                <?php if ($exito) { ?>
                    <div class="alert alert-success">
                        ✅ Libro registrado correctamente
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger">
                        ❌ Error: <?php echo $error; ?>
                    </div>
                <?php } ?>

                <a href="Registrar_Libro.php" class="btn btn-primary mt-3">
                    ➕ Registrar otro libro
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