<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
?>

<div class="container mt-5">

    <h1 class="mb-4">Bienvenido <?php echo $_SESSION['usuario']; ?></h1>

    <?php if ($_SESSION['rol'] == 1) { ?>
        <a href="Registrar_Libro.php" class="btn btn-success mb-2">Registrar libro</a><br>
        <a href="registrar_prestamo.php" class="btn btn-warning mb-2">Registrar préstamo</a><br>
    <?php } ?>

    <a href="ConsultarLibros.php" class="btn btn-primary mb-2">Ver libros</a><br>
    <a href="ver_prestamos.php" class="btn btn-secondary mb-2">Ver préstamos</a><br>
    <a href="reportes.php" class="btn btn-info mb-2">Ver reportes</a><br>

    <a href="logout.php" class="btn btn-danger mt-3">Cerrar sesión</a>

</div>

</body>
</html>