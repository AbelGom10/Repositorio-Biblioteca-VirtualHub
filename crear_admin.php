<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] != 3) {
    echo "Acceso denegado";
    exit();
}

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$rol = 1;

// 🔍 Verificar si ya existe el correo
$verificar = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = $conexion->query($verificar);

if ($resultado->num_rows > 0) {

    echo "
    <div style='
        width:400px;
        margin:100px auto;
        padding:30px;
        border-radius:15px;
        text-align:center;
        background:white;
        box-shadow:0 5px 15px rgba(0,0,0,0.2);
        font-family:Arial;
    '>

        <h1 style='color:#d62828;'>⚠ Usuario duplicado</h1>

        <p>
            Ya existe un usuario registrado con el correo:
            <br><br>
            <b>$correo</b>
        </p>

        <a href='javascript:history.back()'
           style='
           display:inline-block;
           margin-top:15px;
           padding:10px 20px;
           background:#2a5298;
           color:white;
           text-decoration:none;
           border-radius:10px;
           '>
           Regresar
        </a>

    </div>
    ";

} else {

    // ✅ Insertar si no existe
    $sql = "INSERT INTO usuarios(nombre, correo, password, id_rol)
            VALUES ('$nombre', '$correo', '$password', $rol)";

    if ($conexion->query($sql)) {

        echo "
        <div style='
            width:400px;
            margin:100px auto;
            padding:30px;
            border-radius:15px;
            text-align:center;
            background:white;
            box-shadow:0 5px 15px rgba(0,0,0,0.2);
            font-family:Arial;
        '>

            <h1 style='color:#1b8a3d;'>✅ Administrador creado</h1>

            <p>El administrador fue registrado correctamente.</p>

            <a href='panel_admin.php'
               style='
               display:inline-block;
               margin-top:15px;
               padding:10px 20px;
               background:#2a5298;
               color:white;
               text-decoration:none;
               border-radius:10px;
               '>
               Volver al panel
            </a>

        </div>
        ";

    } else {

        echo "Error: " . $conexion->error;
    }
}
?>