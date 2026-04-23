<?php
include("conexion.php");

$sql = "SELECT p.id, u.nombre, l.titulo, 
               p.fecha_prestamo, 
               p.fecha_devolucion,
               p.estado
        FROM prestamos p
        JOIN usuarios u ON p.id_usuario = u.id
        JOIN libros l ON p.id_libro = l.id";

$result = $conexion->query($sql);

echo "<h2>Préstamos</h2>";

while ($row = $result->fetch_assoc()) {
    echo "ID: ".$row['id']." | ";
    echo "Usuario: ".$row['nombre']." | ";
    echo "Libro: ".$row['titulo']." | ";
    echo "Fecha: ".$row['fecha_prestamo']." | ";
    echo "Fecha límite: ".$row['fecha_devolucion']." | ";
    echo "Estado: ".$row['estado']." | ";
    

    if ($row['estado'] == 'ACTIVO' && $row['fecha_devolucion'] < date('Y-m-d')) {
    echo "⚠ ATRASADO";
    }
    if ($row['estado'] == 'ACTIVO') {
        echo "<a href='devolver_libro.php?id=".$row['id']."'>Devolver</a>";
    }

    echo "<br>";
}
?>