<?php
include("conexion.php");
session_start();
$result = $conexion->query("SELECT * FROM libros WHERE activo = 1");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <h2 class="mb-4">Lista de libros</h2>
        <?php if (isset($_GET['mensaje'])) { ?>

    <?php if ($_GET['mensaje'] == 'actualizado') { ?>
        <div class="alert alert-success">
            Libro actualizado correctamente
        </div>
    <?php } ?>

    <?php if ($_GET['mensaje'] == 'eliminado') { ?>
        <div class="alert alert-danger">
            Libro eliminado junto con su historial
        </div>
    <?php } ?>

    <?php if ($_GET['mensaje'] == 'stock_reducido') { ?>
        <div class="alert alert-warning">
            Stock reducido correctamente
        </div>
    <?php } ?>

    <?php } ?>
    <div class="mb-3">
    <input type="text" id="buscador" class="form-control" placeholder="🔍 Buscar libro, autor o ID...">
</div>
    <table class="table table-bordered table-striped table-hover" id="tablaLibros">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
<?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['titulo']); ?></td>
        <td><?php echo htmlspecialchars($row['autor']); ?></td>
        <td><?php echo $row['stock']; ?></td>

        <td>
            <a href="editar_libro.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>

            <a href="eliminar_libro.php?id=<?php echo $row['id']; ?>" 
            class="btn btn-danger btn-sm"
            onclick="return confirmarEliminacion(<?php echo $row['stock']; ?>)">
            Eliminar</a>

            <!-- 🔥 BOTÓN PARA USUARIO -->
             <?php
             $id_usuario = $_SESSION['id_usuario'];
             $id_libro = $row['id'];
             $checkSolicitud = $conexion->query("SELECT estado FROM prestamos 
             WHERE id_usuario = $id_usuario AND id_libro = $id_libro AND estado IN ('PENDIENTE','ACTIVO')");
             $solicitud = $checkSolicitud->fetch_assoc();
             ?>
            <?php if ($_SESSION['rol'] == 2) { ?>
            <?php if ($solicitud) { ?>
            <?php if ($solicitud['estado'] == 'PENDIENTE') { ?>
            <span class="badge bg-warning">Pendiente</span>
            <?php } elseif ($solicitud['estado'] == 'ACTIVO') { ?>
            <span class="badge bg-success">Prestado</span>
            <?php } ?>
            <?php }else { ?>
            <?php if ($row['stock'] > 0) { ?>
            <a href="solicitar_prestamo.php?id=<?php echo $row['id']; ?>" 
            class="btn btn-primary btn-sm">
            Solicitar
            </a>
            <?php } else { ?>
            <span class="badge bg-secondary">Sin stock</span>
            <?php } ?>
            <?php } ?>
            <?php } ?>

        </td>
    </tr>
<?php } ?>
</tbody>
    </table>

</div>
<script>
function confirmarEliminacion(stock) {

    // 🟢 Si hay más de 1 → no preguntar
    if (stock > 1) {
        return true;
    }

    // 🟡 Si solo queda 1 → advertencia
    if (stock == 1) {
        return confirm("⚠ Si eliminas este libro también se eliminará su historial de préstamos. ¿Deseas continuar?");
    }

    // 🔴 Si no hay stock
    alert("Este libro ya no tiene stock disponible");
    return false;
}
</script>
<script>
document.getElementById("buscador").addEventListener("keyup", function() {
    let filtro = this.value.toLowerCase();
    let filas = document.querySelectorAll("#tablaLibros tbody tr");

    filas.forEach(fila => {
        let texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(filtro) ? "" : "none";
    });
});
</script>
</body>
</html>