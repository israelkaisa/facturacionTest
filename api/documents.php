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
            $action = $_GET['action'] ?? 'create';

            if ($action === 'create') {
                // Basic validation for creating a document
                if (empty($data['customer_id']) || empty($data['type']) || empty($data['items'])) {
                    http_response_code(400);
                    $response = ['status' => 'error', 'message' => 'Missing required fields for document creation.'];
                    break;
                }

                $newDocument = $document_model->create($data);

                if ($newDocument) {
                    http_response_code(201);
                    $response = [
                        'status' => 'success',
                        'message' => 'Document created successfully.',
                        'data' => $newDocument
                    ];
                } else {
                    http_response_code(500);
                    $response = ['status' => 'error', 'message' => 'Failed to create document due to a server error.'];
                }
            } elseif ($action === 'cancel') {
                // Validation for cancelling a document
                if (empty($data['id']) || empty($data['reason'])) {
                    http_response_code(400);
                    $response = ['status' => 'error', 'message' => 'Document ID and reason are required for cancellation.'];
                    break;
                }

                $id = intval($data['id']);
                $reason = trim($data['reason']);

                if ($document_model->cancel($id, $reason)) {
                    $response = ['status' => 'success', 'message' => 'Document cancelled successfully.'];
                } else {
                    http_response_code(500);
                    $response = ['status' => 'error', 'message' => 'Failed to cancel document.'];
                }
            } else {
                http_response_code(400);
                $response = ['status' => 'error', 'message' => 'Invalid action specified.'];
            }
            break;

        case 'DELETE':
            // Deprecated: Cancellation should be done via POST with action=cancel
            http_response_code(405); // Method Not Allowed
            $response = ['status' => 'error', 'message' => 'DELETE method is not supported for cancellation. Please use POST with action=cancel.'];
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
