<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../src/config/config.php';
require_once '../src/models/Document.php';

$document_model = new Document();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$response = ['status' => 'error', 'message' => 'An error occurred.'];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                // Get a single document
                $id = intval($_GET['id']);
                $document = $document_model->getById($id);
                if ($document) {
                    $response = ['status' => 'success', 'data' => $document];
                } else {
                    http_response_code(404);
                    $response = ['status' => 'error', 'message' => 'Document not found.'];
                }
            } else {
                // Get all documents of a specific type (defaults to 'invoice')
                $type = isset($_GET['type']) ? $_GET['type'] : 'invoice';
                $documents = $document_model->getAll($type);
                $response = ['status' => 'success', 'data' => $documents];
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);

            // Basic validation
            if (empty($data['customer_id']) || empty($data['type']) || empty($data['items'])) {
                 http_response_code(400);
                 $response = ['status' => 'error', 'message' => 'Missing required fields.'];
                 break;
            }

            $documentId = $document_model->create($data);

            if ($documentId) {
                http_response_code(201);
                $response = [
                    'status' => 'success',
                    'message' => 'Document created successfully.',
                    'data' => ['id' => $documentId]
                ];
            } else {
                http_response_code(500);
                $response = ['status' => 'error', 'message' => 'Failed to create document due to a server error.'];
            }
            break;

        case 'DELETE':
             if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                // For now, we assume a simple cancellation without a reason from the user.
                if ($document_model->cancel($id)) {
                    $response = ['status' => 'success', 'message' => 'Document cancelled successfully.'];
                } else {
                    http_response_code(500);
                    $response = ['status' => 'error', 'message' => 'Failed to cancel document.'];
                }
            } else {
                http_response_code(400);
                $response = ['status' => 'error', 'message' => 'Document ID not provided.'];
            }
            break;

        default:
            http_response_code(405);
            $response = ['status' => 'error', 'message' => 'Method not allowed.'];
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    $response = ['status' => 'error', 'message' => $e->getMessage()];
    error_log('API Error: ' . $e->getMessage());
}

echo json_encode($response);
?>
