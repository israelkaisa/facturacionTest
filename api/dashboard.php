<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../src/config/config.php';
require_once '../src/lib/Database.php';
require_once '../src/models/Customer.php';
require_once '../src/models/Product.php';
require_once '../src/models/Document.php';

// A simple session check for security
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(['status' => 'error', 'message' => 'Acceso no autorizado.']);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($method !== 'GET') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido.']);
    exit();
}

try {
    $customer_model = new Customer();
    $product_model = new Product();
    $document_model = new Document();

    // These methods will be implemented in the next steps
    $data = [
        'customer_count' => $customer_model->countAll(),
        'product_count' => $product_model->countAll(),
        'recent_documents' => $document_model->getRecent(5)
    ];

    $response = ['status' => 'success', 'data' => $data];
    http_response_code(200);

} catch (Exception $e) {
    http_response_code(500);
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);
?>
