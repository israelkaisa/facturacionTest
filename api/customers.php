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

            // --- Input Validation ---
            $required_fields = ['name', 'rfc', 'address', 'postal_code', 'email'];
            foreach ($required_fields as $field) {
                if (empty($data[$field])) {
                    http_response_code(400); // Bad Request
                    $response = ['status' => 'error', 'message' => "El campo '$field' es obligatorio."];
                    echo json_encode($response);
                    exit();
                }
            }

            if ($customer_model->findByRfc($data['rfc'])) {
                http_response_code(409); // Conflict
                $response = ['status' => 'error', 'message' => 'El RFC ya existe. Por favor, use uno diferente.'];
            } elseif ($customer_model->findByEmail($data['email'])) {
                http_response_code(409); // Conflict
                $response = ['status' => 'error', 'message' => 'El correo electrónico ya está registrado.'];
            } else {
                if ($customer_model->create($data)) {
                    http_response_code(201);
                    $response = ['status' => 'success', 'message' => 'Cliente creado con éxito.'];
                } else {
                    http_response_code(500);
                    $response = ['status' => 'error', 'message' => 'Error en el servidor al crear el cliente.'];
                }
            }
            break;

        case 'PUT':
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $data = json_decode(file_get_contents('php://input'), true);

                // --- Input Validation ---
                $required_fields = ['name', 'rfc', 'address', 'postal_code', 'email'];
                foreach ($required_fields as $field) {
                    if (empty($data[$field])) {
                        http_response_code(400); // Bad Request
                        $response = ['status' => 'error', 'message' => "El campo '$field' es obligatorio."];
                        echo json_encode($response);
                        exit();
                    }
                }

                $existing_by_rfc = $customer_model->findByRfc($data['rfc']);
                if ($existing_by_rfc && $existing_by_rfc['id'] != $id) {
                    http_response_code(409); // Conflict
                    $response = ['status' => 'error', 'message' => 'El RFC ya pertenece a otro cliente.'];
                    break;
                }

                $existing_by_email = $customer_model->findByEmail($data['email']);
                if ($existing_by_email && $existing_by_email['id'] != $id) {
                    http_response_code(409); // Conflict
                    $response = ['status' => 'error', 'message' => 'El correo electrónico ya pertenece a otro cliente.'];
                } else {
                    if ($customer_model->update($id, $data)) {
                        $response = ['status' => 'success', 'message' => 'Cliente actualizado con éxito.'];
                    } else {
                        http_response_code(500);
                        $response = ['status' => 'error', 'message' => 'Error en el servidor al actualizar el cliente.'];
                    }
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
