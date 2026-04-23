<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
if ($_SESSION['rol'] != 1) {
    echo "Acceso denegado";
    exit();
}
?>

<h2>Registrar Libro</h2>

<form action="guardar_libro.php" method="POST">
    <input type="text" name="titulo" placeholder="Título" required>
    <input type="text" name="autor" placeholder="Autor" required>
    <input type="text" name="genero" placeholder="Género">
    <input type="text" name="isbn" placeholder="ISBN">
    <input type="number" name="stock" placeholder="Stock" required>

    <button type="submit">Guardar</button>
</form>

<a href="dashboard.php">Volver</a>