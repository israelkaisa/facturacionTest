<?php
session_start();
header("Content-Type: application/json");

require_once '../src/config/config.php';
require_once '../src/models/User.php';

$response = ['status' => 'error', 'message' => 'Invalid action.'];
$action = $_GET['action'] ?? '';

if ($action === 'login') {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($username) || empty($password)) {
        http_response_code(400);
        $response = ['status' => 'error', 'message' => 'Usuario y contraseña son requeridos.'];
    } else {
        $user_model = new User();
        $user = $user_model->login($username, $password);

        if ($user) {
            // Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['logged_in'] = true;

            $response = ['status' => 'success', 'message' => 'Login successful.'];
        } else {
            http_response_code(401);
            $response = ['status' => 'error', 'message' => 'Credenciales inválidas.'];
        }
    }
}

echo json_encode($response);
?>
