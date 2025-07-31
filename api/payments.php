<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../src/config/config.php';
require_once '../src/models/Payment.php';
require_once '../src/models/Document.php';

$payment_model = new Payment();
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
            if (isset($_GET['invoice_id'])) {
                $invoiceId = intval($_GET['invoice_id']);
                $payments = $payment_model->getByInvoiceId($invoiceId);
                $response = ['status' => 'success', 'data' => $payments];
            } else {
                http_response_code(400);
                $response = ['status' => 'error', 'message' => 'Invoice ID not provided.'];
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['invoice_id']) || empty($data['amount']) || empty($data['payment_date'])) {
                 http_response_code(400);
                 $response = ['status' => 'error', 'message' => 'Missing required payment fields.'];
                 break;
            }

            $paymentId = $payment_model->create($data);

            if ($paymentId) {
                // After creating the payment, update the invoice status
                $document_model->updatePaymentStatus($data['invoice_id']);

                http_response_code(201);
                $response = [
                    'status' => 'success',
                    'message' => 'Payment recorded successfully.',
                    'data' => ['id' => $paymentId]
                ];
            } else {
                http_response_code(500);
                $response = ['status' => 'error', 'message' => 'Failed to record payment.'];
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
    error_log('Payments API Error: ' . $e->getMessage());
}

echo json_encode($response);
?>
