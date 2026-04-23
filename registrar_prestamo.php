<?php
include("conexion.php");
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}
if ($_SESSION['rol'] != 1) {
    echo "Acceso denegado";
    exit();
}

// Obtener usuarios
$usuarios = $conexion->query("SELECT * FROM usuarios");

// Obtener libros disponibles
$libros = $conexion->query("SELECT * FROM libros WHERE stock > 0");

?>

<h2>Registrar Préstamo</h2>

<form action="guardar_prestamo.php" method="POST">

    <label>Usuario:</label>
    <select name="id_usuario">
        <?php while($u = $usuarios->fetch_assoc()) { ?>
            <option value="<?php echo $u['id']; ?>">
                <?php echo $u['nombre']; ?>
            </option>
        <?php } ?>
    </select><br>

    <label>Libro:</label>
    <select name="id_libro">
        <?php while($l = $libros->fetch_assoc()) { ?>
            <option value="<?php echo $l['id']; ?>">
                <?php echo $l['titulo']; ?>
            </option>
        <?php } ?>
    </select><br>

    <button type="submit">Registrar</button>
</form>