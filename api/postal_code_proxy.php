<?php
header("Content-Type: application/json");

// Use the central config and database class
require_once '../src/config/config.php';
require_once '../src/lib/Database.php';

if (!isset($_GET['cp']) || empty($_GET['cp'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'El código postal (cp) es obligatorio.']);
    exit();
}

$postal_code = trim($_GET['cp']);

if (!preg_match('/^[0-9]{5}$/', $postal_code)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Formato de código postal inválido.']);
    exit();
}

try {
    $db = new Database();
    $db->query("SELECT d_asenta as asentamiento, d_mnpio as municipio, d_estado as estado FROM postal_codes WHERE d_codigo = :cp ORDER BY d_asenta ASC");
    $db->bind(':cp', $postal_code);
    $results = $db->resultSet();

    // The frontend expects a 'success' status even if no results are found, just with empty data.
    if ($results) {
        echo json_encode(['status' => 'success', 'data' => $results]);
    } else {
        echo json_encode(['status' => 'success', 'data' => []]);
    }
} catch (Exception $e) {
    http_response_code(500);
    // In a production environment, you would log this error instead of echoing it.
    error_log('Postal Code API Error: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Error del servidor al buscar el código postal.']);
}
?>
