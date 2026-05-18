<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] != 3) {
    echo "
    <div class='mensaje error'>
        <h2>⛔ Acceso denegado</h2>
        <p>No tienes permisos para entrar aquí.</p>
    </div>
    ";
    exit();
}

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Rol admin = 1
$rol = 1;

$sql = "INSERT INTO usuarios(nombre, correo, password, id_rol)
        VALUES ('$nombre', '$correo', '$password', $rol)";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Administrador</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }

        .contenedor{
            background:white;
            width:400px;
            padding:35px;
            border-radius:20px;
            text-align:center;
            box-shadow:0 10px 25px rgba(0,0,0,0.25);
            animation: aparecer 0.6s ease;
        }

        .icono{
            font-size:70px;
            margin-bottom:15px;
        }

        h1{
            color:#333;
            margin-bottom:10px;
        }

        p{
            color:#666;
            margin-bottom:25px;
            font-size:16px;
        }

        .success{
            color:#1b8a3d;
        }

        .error{
            color:#d62828;
        }

        .boton{
            display:inline-block;
            text-decoration:none;
            background:#2a5298;
            color:white;
            padding:12px 25px;
            border-radius:10px;
            transition:0.3s;
            font-weight:bold;
        }

        .boton:hover{
            background:#1e3c72;
            transform:scale(1.05);
        }

        @keyframes aparecer{
            from{
                opacity:0;
                transform:translateY(-20px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }
    </style>
</head>
<body>

<div class="contenedor">

<?php
if ($conexion->query($sql)) {
    echo "
        <div class='icono'>✅</div>
        <h1 class='success'>Administrador creado</h1>
        <p>El nuevo administrador fue registrado correctamente.</p>
        <a class='boton' href='panel_admin.php'>Volver al panel</a>
    ";
} else {
    echo "
        <div class='icono'>❌</div>
        <h1 class='error'>Ocurrió un error</h1>
        <p>" . $conexion->error . "</p>
        <a class='boton' href='javascript:history.back()'>Regresar</a>
    ";
}
?>

</div>

</body>
</html>