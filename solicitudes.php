<?php
session_start();
include("conexion.php");

if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

$sql = "SELECT p.id, u.nombre, l.titulo, p.fecha_prestamo
        FROM prestamos p
        JOIN usuarios u ON p.id_usuario = u.id
        JOIN libros l ON p.id_libro = l.id
        WHERE p.estado = 'PENDIENTE'";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Solicitudes de Préstamo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
}

.card {
    border-radius: 15px;
}

.table {
    border-radius: 10px;
    overflow: hidden;
}
</style>
</head>

<body>

<div class="container mt-5">

    <div class="card shadow-lg border-0">

        <div class="card-header bg-dark text-white text-center">
            <h4><i class="bi bi-clock-history"></i> Solicitudes Pendientes</h4>
        </div>

        <div class="card-body">

            <?php if ($result->num_rows > 0) { ?>

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">

                        <thead class="table-dark">
                            <tr>
                                <th>Usuario</th>
                                <th>Libro</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                                <td><?php echo $row['fecha_prestamo']; ?></td>

                                <td>
                                    <a href="aprobar.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-success btn-sm">
                                       <i class="bi bi-check-circle"></i> Aprobar
                                    </a>

                                    <a href="rechazar.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-danger btn-sm">
                                       <i class="bi bi-x-circle"></i> Rechazar
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div>

            <?php } else { ?>

                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> No hay solicitudes pendientes
                </div>

            <?php } ?>

        </div>

        <div class="card-footer text-center">
            <a href="dashboard.php" class="btn btn-outline-light">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>

    </div>

</div>

</body>
</html>