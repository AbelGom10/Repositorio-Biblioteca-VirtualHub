<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    margin: 0;
    height: 100vh;
    background: url('fondo.jpg') no-repeat center center/cover;
}

.overlay {
    background: rgba(0,0,0,0.6);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.titulo {
    color: white;
    font-size: 3rem;
    font-family: 'Georgia', serif;
}

.card {
    border-radius: 20px;
    min-width: 300px;
}
</style>
</head>

<body>

<div class="overlay">

<div class="text-center">

<h1 class="titulo mb-4">📚 Biblioteca VirtualHub</h1>

<div class="card shadow p-4">

<!-- 🔥 ADMIN Y SUPERADMIN -->
<?php if ($rol == 1 || $rol == 3) { ?>

    <a href="Registrar_Libro.php" class="btn btn-primary w-100 mb-2">
        <i class="bi bi-book"></i> Registrar libro
    </a>

    <a href="registrar_prestamo.php" class="btn btn-success w-100 mb-2">
        <i class="bi bi-journal-plus"></i> Registrar préstamo
    </a>

    <a href="reportes.php" class="btn btn-dark w-100 mb-2">
        <i class="bi bi-bar-chart"></i> Ver reportes
    </a>

<?php } ?>

<!-- 🔥 SOLO SUPERADMIN -->
<?php if ($rol == 3) { ?>
    <button class="btn btn-dark w-100 mb-2" data-bs-toggle="modal" data-bs-target="#adminModal">
        <i class="bi bi-shield-lock"></i> Nuevo administrador
    </button>
<?php } ?>

<?php if ($rol == 1 || $rol == 3) { ?>
    <a href="solicitudes.php" class="btn btn-secondary w-100 mb-2">
        Ver solicitudes
    </a>
<?php } ?>

<!-- 🔥 TODOS -->
<a href="ConsultarLibros.php" class="btn btn-warning w-100 mb-2">
    <i class="bi bi-book-half"></i> Ver libros
</a>

<a href="ver_prestamos.php" class="btn btn-info w-100 mb-2">
    <i class="bi bi-arrow-left-right"></i> Ver préstamos
</a>

<a href="logout.php" class="btn btn-danger w-100">
    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
</a>

</div>

</div>

</div>

<!-- 🔥 MODAL SOLO SUPERADMIN -->
<?php if ($rol == 3) { ?>
<div class="modal fade" id="adminModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">
            <i class="bi bi-shield-lock"></i> Crear Administrador
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form action="crear_admin.php" method="POST">

            <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>
            <input type="email" name="correo" class="form-control mb-2" placeholder="Correo" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>

            <button class="btn btn-dark w-100">
                Crear administrador
            </button>

        </form>
      </div>

    </div>
  </div>
</div>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>