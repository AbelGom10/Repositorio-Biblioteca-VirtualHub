<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

// Obtener usuarios
$usuarios = $conexion->query("SELECT * FROM usuarios");

// Obtener libros disponibles
$libros = $conexion->query("SELECT * FROM libros WHERE stock > 0");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Préstamo</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #eef2f3, #dfe9f3);
        }
        .card {
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.01);
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="col-md-6">

        <div class="card shadow-lg border-0 rounded-4">

            <div class="card-header bg-success text-white text-center rounded-top-4">
                <h4><i class="bi bi-journal-plus"></i> Registrar Préstamo</h4>
            </div>

            <div class="card-body p-4">

                <form action="guardar_prestamo.php" method="POST">

                    <!-- Usuario -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person"></i> Usuario</label>
                        <select name="id_usuario" class="form-select" required>
                            <option value="">Selecciona un usuario</option>
                            <?php while($u = $usuarios->fetch_assoc()) { ?>
                                <option value="<?php echo $u['id']; ?>">
                                    <?php echo htmlspecialchars($u['nombre']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Libro -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-book"></i> Libro</label>
                        <select name="id_libro" class="form-select" required>
                            <option value="">Selecciona un libro</option>
                            <?php while($l = $libros->fetch_assoc()) { ?>
                                <option value="<?php echo $l['id']; ?>">
                                    <?php echo htmlspecialchars($l['titulo']); ?> (Stock: <?php echo $l['stock']; ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="d-grid gap-2 mt-4">

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Registrar Préstamo
                        </button>

                        <a href="dashboard.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>