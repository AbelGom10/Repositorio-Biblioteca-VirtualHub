<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT p.id, u.nombre, l.titulo, 
               p.fecha_prestamo, 
               p.fecha_devolucion,
               p.estado
        FROM prestamos p
        JOIN usuarios u ON p.id_usuario = u.id
        JOIN libros l ON p.id_libro = l.id";

$result = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Préstamos</title>

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

    <div class="card shadow-lg">

        <div class="card-header bg-dark text-white">
            <h4><i class="bi bi-journal-bookmark"></i> Lista de Préstamos</h4>
        </div>
        <div class="mb-3">
    <input type="text" id="buscadorPrestamos" class="form-control" placeholder="🔍 Buscar usuario, libro o estado...">
</div>

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle text-center" id="tablaPrestamos">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Libro</th>
                        <th>Fecha préstamo</th>
                        <th>Fecha límite</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>

                <tbody>

                <?php while ($row = $result->fetch_assoc()) { 

                    $hoy = date('Y-m-d');
                    $atrasado = ($row['estado'] == 'ACTIVO' && $row['fecha_devolucion'] < $hoy);

                ?>

                    <tr class="<?php echo $atrasado ? 'table-danger' : ''; ?>">

                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                        <td><?php echo $row['fecha_prestamo']; ?></td>
                        <td><?php echo $row['fecha_devolucion']; ?></td>

                        <!-- Estado -->
                        <td>
                            <?php if ($row['estado'] == 'ACTIVO') { ?>
                                <span class="badge bg-success">Activo</span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">Devuelto</span>
                            <?php } ?>

                            <?php if ($atrasado) { ?>
                                <span class="badge bg-danger">Atrasado</span>
                            <?php } ?>
                        </td>

                        <!-- Acción -->
                        <td>
                            <?php if ($row['estado'] == 'ACTIVO') { ?>
                                <a href="devolver_libro.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm btn-primary">
                                   <i class="bi bi-arrow-return-left"></i> Devolver
                                </a>
                            <?php } else { ?>
                                <span class="text-muted">—</span>
                            <?php } ?>
                        </td>

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
<script>
document.getElementById("buscadorPrestamos").addEventListener("keyup", function() {
    let filtro = this.value.toLowerCase();
    let filas = document.querySelectorAll("#tablaPrestamos tbody tr");

    filas.forEach(fila => {
        let texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(filtro) ? "" : "none";
    });
});
</script>
</body>
</html>