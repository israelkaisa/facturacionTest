<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Facturación</title>
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    <!-- Google Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom Login CSS -->
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body class="login-body">

<div class="card login-card">
    <div class="card-content">
        <span class="card-title">
            <i class="material-icons">inventory_2</i>
            Sistema de Facturación
        </span>
        <form id="form-login">
            <div class="input-field">
                <i class="material-icons prefix">person</i>
                <input id="username" type="text" name="username" required>
                <label for="username">Usuario</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input id="password" type="password" name="password" required>
                <label for="password">Contraseña</label>
            </div>
            <div class="center-align" style="margin-top: 30px;">
                 <button type="submit" class="btn login-btn waves-effect waves-light">Ingresar</button>
            </div>
        </form>
        <div id="login-message" class="center-align red-text" style="margin-top: 15px;"></div>
    </div>
</div>

<!-- Materialize JS -->
<script src="assets/js/materialize.min.js"></script>

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
