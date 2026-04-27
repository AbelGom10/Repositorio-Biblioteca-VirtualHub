<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Libro</title>

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

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="col-md-6">

        <div class="card shadow-lg border-0 rounded-4">

            <div class="card-header bg-primary text-white text-center rounded-top-4">
                <h4><i class="bi bi-book-fill"></i> Registrar Libro</h4>
            </div>

            <div class="card-body p-4">

                <form action="guardar_libro.php" method="POST">

                    <!-- Título -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-journal-text"></i> Título</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej: El Principito" required>
                    </div>

                    <!-- Autor -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-person"></i> Autor</label>
                        <input type="text" name="autor" class="form-control" placeholder="Ej: Antoine de Saint-Exupéry" required>
                    </div>

                    <!-- Género -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-tags"></i> Género</label>
                        <input type="text" name="genero" class="form-control" placeholder="Ej: Ficción">
                    </div>

                    <!-- ISBN -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-upc-scan"></i> ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="Ej: 978-1234567890">
                    </div>

                    <!-- Stock -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-box"></i> Stock</label>
                        <input type="number" name="stock" class="form-control" min="1" required>
                    </div>

                    <!-- Botones -->
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Guardar Libro
                        </button>

                      <a href="dashboard.php" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>