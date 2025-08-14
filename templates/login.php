<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Facturación</title>
    <!-- CoreUI CSS -->
    <link rel="stylesheet" href="assets/coreui/css/coreui.min.css">
    <!-- CoreUI Icons -->
    <link rel="stylesheet" href="assets/coreui/css/coreui-icons.min.css">
    <style>
        .login-body {
            background-color: #f0f2f5;
        }
    </style>
</head>
<body class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="cil-wallet" style="font-size: 2rem;"></i>
                        <h1 class="h4">Sistema de Facturación</h1>
                    </div>
                    <form id="form-login">
                        <div class="input-group mb-3">
                            <span class="input-group-text">
                                <i class="cil-user"></i>
                            </span>
                            <input id="username" type="text" name="username" class="form-control" placeholder="Usuario" required>
                        </div>
                        <div class="input-group mb-4">
                             <span class="input-group-text">
                                <i class="cil-lock-locked"></i>
                            </span>
                            <input id="password" type="password" name="password" class="form-control" placeholder="Contraseña" required>
                        </div>
                        <div class="d-grid">
                             <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>
                    </form>
                    <div id="login-message" class="text-center text-danger mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- No external JS needed for this simple page, the script below is self-contained -->

<script>
// This is a simple, page-specific script.
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-login');
    const messageDiv = document.getElementById('login-message');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        messageDiv.textContent = ''; // Clear previous messages

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('api/auth.php?action=login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.status === 'success') {
                // Redirect to the main page on success
                window.location.href = 'index.php';
            } else {
                messageDiv.textContent = result.message || 'Error en el inicio de sesión.';
            }
        } catch (error) {
            console.error('Login error:', error);
            messageDiv.textContent = 'Ocurrió un error de conexión.';
        }
    });
});
</script>

</body>
</html>
