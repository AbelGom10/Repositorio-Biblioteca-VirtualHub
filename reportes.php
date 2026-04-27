<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

include("conexion.php");

// 📚 Libro más prestado
$sql = "SELECT l.titulo, COUNT(p.id) as total
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id
        GROUP BY l.id
        ORDER BY total DESC
        LIMIT 1";
$libro = $conexion->query($sql)->fetch_assoc();

// 👤 Usuario con más préstamos
$sql = "SELECT u.nombre, COUNT(p.id) as total
        FROM prestamos p
        JOIN usuarios u ON p.id_usuario = u.id
        GROUP BY u.id
        ORDER BY total DESC
        LIMIT 1";
$usuario = $conexion->query($sql)->fetch_assoc();

// 📦 Préstamos activos
$sql = "SELECT COUNT(*) as activos FROM prestamos WHERE estado='ACTIVO'";
$activos = $conexion->query($sql)->fetch_assoc();

// ⚠ Atrasados
$sql = "SELECT l.titulo, u.nombre, p.fecha_devolucion
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id
        JOIN usuarios u ON p.id_usuario = u.id
        WHERE p.estado='ACTIVO' AND p.fecha_devolucion < CURDATE()";
$atrasados = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reportes</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: #f4f6f9;
}
.card {
    border-radius: 15px;
}
</style>

</head>

<body>

<div class="container mt-5">

    <h2 class="mb-4 text-center">📊 Reportes y Estadísticas</h2>

    <!-- 🔥 TARJETAS -->
    <div class="row text-center mb-4">

        <!-- Libro -->
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h5><i class="bi bi-book"></i> Libro más prestado</h5>
                    <p class="fw-bold">
                        <?php echo $libro ? $libro['titulo'] : "Sin datos"; ?>
                    </p>
                    <span class="badge bg-primary">
                        <?php echo $libro ? $libro['total'] : 0; ?> préstamos
                    </span>
                </div>
            </div>
        </div>

        <!-- Usuario -->
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h5><i class="bi bi-person"></i> Usuario top</h5>
                    <p class="fw-bold">
                        <?php echo $usuario ? $usuario['nombre'] : "Sin datos"; ?>
                    </p>
                    <span class="badge bg-success">
                        <?php echo $usuario ? $usuario['total'] : 0; ?> préstamos
                    </span>
                </div>
            </div>
        </div>

        <!-- Activos -->
        <div class="col-md-4 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h5><i class="bi bi-box"></i> Préstamos activos</h5>
                    <p class="display-6 fw-bold">
                        <?php echo $activos['activos']; ?>
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- ⚠ TABLA DE ATRASADOS -->
    <div class="card shadow-lg">

        <div class="card-header bg-danger text-white">
            <h5><i class="bi bi-exclamation-triangle"></i> Libros atrasados</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover text-center">

                <thead class="table-dark">
                    <tr>
                        <th>Libro</th>
                        <th>Usuario</th>
                        <th>Fecha límite</th>
                    </tr>
                </thead>

                <tbody>

                <?php if ($atrasados->num_rows > 0) { ?>
                    <?php while ($row = $atrasados->fetch_assoc()) { ?>
                        <tr class="table-danger">
                            <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo $row['fecha_devolucion']; ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3">No hay libros atrasados</td>
                    </tr>
                <?php } ?>

                </tbody>

            </table>

        </div>

        <div class="card-footer text-end">
            <a href="dashboard.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

    </div>

</div>

</body>
</html>