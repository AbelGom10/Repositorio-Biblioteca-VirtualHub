<?php
session_start();

if ( $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}
?>

<h2>Crear Administrador</h2>

<form action="crear_admin.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="email" name="correo" placeholder="Correo" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Crear Admin</button>
</form>