<style>
    body {
        background-color: #f0f2f5;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }
    .login-card {
        width: 400px;
    }
</style>

<div class="card login-card">
    <div class="card-content">
        <span class="card-title center-align">Iniciar Sesión</span>
        <form id="form-login">
            <div class="input-field">
                <input id="username" type="text" name="username" required>
                <label for="username">Usuario</label>
            </div>
            <div class="input-field">
                <input id="password" type="password" name="password" required>
                <label for="password">Contraseña</label>
            </div>
            <div class="center-align">
                 <button type="submit" class="btn waves-effect waves-light">Ingresar</button>
            </div>
        </form>
        <div id="login-message" class="center-align red-text" style="margin-top: 15px;"></div>
    </div>
</div>

<script>
// This is a simple, page-specific script.
// For a larger app, this would be in a separate JS file.
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
