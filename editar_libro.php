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

$id = intval($_GET['id']); // evita inyección básica

$result = $conexion->query("SELECT * FROM libros WHERE id=$id");
$libro = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Libro</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Libro</h4>
                </div>

                <div class="card-body">

                    <form action="actualizar_libro.php" method="POST">

                        <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Título</label>
                            <input type="text" name="titulo" class="form-control"
                                   value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Autor</label>
                            <input type="text" name="autor" class="form-control"
                                   value="<?php echo htmlspecialchars($libro['autor']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control"
                                   value="<?php echo $libro['stock']; ?>" min="0" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Actualizar
                        </button>

                        <a href="index.php" class="btn btn-secondary w-100 mt-2">
                            Cancelar
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>