<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../src/config/config.php';
require_once '../src/models/Customer.php';

$customer_model = new Customer();

$method = $_SERVER['REQUEST_METHOD'];

// Handle preflight OPTIONS request
if ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$response = ['status' => 'error', 'message' => 'An error occurred.'];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $customer = $customer_model->getById($id);
                if ($customer) {
                    $response = ['status' => 'success', 'data' => $customer];
                } else {
                    http_response_code(404);
                    $response = ['status' => 'error', 'message' => 'Customer not found.'];
                }
            } else {
                $customers = $customer_model->getAll();
                $response = ['status' => 'success', 'data' => $customers];
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($customer_model->create($data)) {
                http_response_code(201);
                $response = ['status' => 'success', 'message' => 'Customer created successfully.'];
            } else {
                http_response_code(400);
                $response = ['status' => 'error', 'message' => 'Failed to create customer.'];
            }
            break;

        case 'PUT':
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $data = json_decode(file_get_contents('php://input'), true);
                if ($customer_model->update($id, $data)) {
                    $response = ['status' => 'success', 'message' => 'Customer updated successfully.'];
                } else {
                    http_response_code(400);
                    $response = ['status' => 'error', 'message' => 'Failed to update customer.'];
                }
            } else {
                http_response_code(400);
                $response = ['status' => 'error', 'message' => 'Customer ID not provided.'];
            }
            break;

        case 'DELETE':
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($customer_model->delete($id)) {
                    $response = ['status' => 'success', 'message' => 'Customer deleted successfully.'];
                } else {
                    http_response_code(400);
                    $response = ['status' => 'error', 'message' => 'Failed to delete customer.'];
                }
            } else {
                http_response_code(400);
                $response = ['status' => 'error', 'message' => 'Customer ID not provided.'];
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
}

echo json_encode($response);
?>
