<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../src/config/config.php';
require_once '../src/models/Product.php';

$product_model = new Product();

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
                $product = $product_model->getById($id);
                if ($product) {
                    $response = ['status' => 'success', 'data' => $product];
                } else {
                    http_response_code(404);
                    $response = ['status' => 'error', 'message' => 'Product not found.'];
                }
            } else {
                $products = $product_model->getAll();
                $response = ['status' => 'success', 'data' => $products];
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if ($product_model->findBySku($data['sku'])) {
                http_response_code(409); // Conflict
                $response = ['status' => 'error', 'message' => 'El SKU ya existe. Por favor, use uno diferente.'];
            } else {
                if ($product_model->create($data)) {
                    http_response_code(201);
                    $response = ['status' => 'success', 'message' => 'Producto creado con éxito.'];
                } else {
                    http_response_code(400);
                    $response = ['status' => 'error', 'message' => 'Error al crear el producto.'];
                }
            }
            break;

        case 'PUT':
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $data = json_decode(file_get_contents('php://input'), true);
                $existing_product = $product_model->findBySku($data['sku']);

                if ($existing_product && $existing_product['id'] != $id) {
                    http_response_code(409); // Conflict
                    $response = ['status' => 'error', 'message' => 'El SKU ya pertenece a otro producto.'];
                } else {
                    if ($product_model->update($id, $data)) {
                        $response = ['status' => 'success', 'message' => 'Producto actualizado con éxito.'];
                    } else {
                        http_response_code(400);
                        $response = ['status' => 'error', 'message' => 'Error al actualizar el producto.'];
                    }
                }
            } else {
                http_response_code(400);
                $response = ['status' => 'error', 'message' => 'Product ID not provided.'];
            }
            break;

        case 'DELETE':
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                if ($product_model->delete($id)) {
                    $response = ['status' => 'success', 'message' => 'Product deleted successfully.'];
                } else {
                    http_response_code(400);
                    $response = ['status' => 'error', 'message' => 'Failed to delete product.'];
                }
            } else {
                http_response_code(400);
                $response = ['status' => 'error', 'message' => 'Product ID not provided.'];
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
