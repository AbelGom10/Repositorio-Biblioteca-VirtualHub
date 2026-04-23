<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

if ($_SESSION['rol'] != 1) {
    echo "Acceso denegado";
    exit();
}

include("conexion.php");
?>

<h1>Reportes y Estadísticas</h1>

<!-- 📚 Libro más prestado -->
<?php
$sql = "SELECT l.titulo, COUNT(p.id) as total
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id
        GROUP BY l.id
        ORDER BY total DESC
        LIMIT 1";

$result = $conexion->query($sql);

echo "<h3>📚 Libro más prestado:</h3>";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['titulo'] . " (" . $row['total'] . " préstamos)<br>";
} else {
    echo "No hay datos disponibles<br>";
}
?>

<!-- 👤 Usuario con más préstamos -->
<?php
$sql = "SELECT u.nombre, COUNT(p.id) as total
        FROM prestamos p
        JOIN usuarios u ON p.id_usuario = u.id
        GROUP BY u.id
        ORDER BY total DESC
        LIMIT 1";

$result = $conexion->query($sql);

echo "<h3>👤 Usuario con más préstamos:</h3>";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['nombre'] . " (" . $row['total'] . " préstamos)<br>";
} else {
    echo "No hay datos disponibles<br>";
}
?>

<!-- 📦 Préstamos activos -->
<?php
$sql = "SELECT COUNT(*) as activos FROM prestamos WHERE estado='ACTIVO'";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

echo "<h3>📦 Préstamos activos:</h3>";
echo $row['activos'] . "<br>";
?>

<!-- ⚠ Libros atrasados -->
<?php
$sql = "SELECT l.titulo, u.nombre, p.fecha_devolucion
        FROM prestamos p
        JOIN libros l ON p.id_libro = l.id
        JOIN usuarios u ON p.id_usuario = u.id
        WHERE p.estado='ACTIVO' AND p.fecha_devolucion < CURDATE()";

$result = $conexion->query($sql);

echo "<h3>⚠ Libros atrasados:</h3>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Libro: ".$row['titulo']." | Usuario: ".$row['nombre']." | Fecha límite: ".$row['fecha_devolucion']."<br>";
    }
} else {
    echo "No hay libros atrasados<br>";
}
?>