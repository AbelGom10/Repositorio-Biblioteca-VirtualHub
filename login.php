<?php
session_start();

// 🔥 Si ya está logueado → lo mandamos al dashboard
if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Biblioteca</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .card {
            border-radius: 20px;
            transition: 0.3s;
        }

        .card:hover {
            transform: scale(1.02);
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="col-md-4">

        <div class="card shadow-lg border-0">

            <div class="card-header text-center text-white" style="background: #5a67d8;">
                <h4><i class="bi bi-person-circle"></i> Iniciar Sesión</h4>
            </div>

            <div class="card-body p-4">

                <!-- Mensaje de error -->
                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger text-center">
                        Usuario o contraseña incorrectos
                    </div>
                <?php } ?>

                <form action="validar_login.php" method="POST">

                    <!-- Correo -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-envelope"></i> Correo</label>
                        <input type="email" name="correo" class="form-control" placeholder="ejemplo@correo.com" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-lock"></i> Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <!-- Botón -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Entrar
                        </button>
                    </div>
                    <div class="text-center">
                         <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#registroModal">
                            <i class="bi bi-person-plus"></i> Crear cuenta
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center text-muted">
                Biblioteca VirtualHub 📚
            </div>

        </div>

    </div>

</div>
<!-- MODAL REGISTRO -->
<div class="modal fade" id="registroModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">
            <i class="bi bi-person-plus"></i> Crear cuenta
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form action="registro.php" method="POST">

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-success w-100">
                Registrarse
            </button>

        </form>

      </div>

    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>