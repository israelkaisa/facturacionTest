<?php
header("Content-Type: application/json");

require_once '../src/config/config.php';
require_once '../src/models/SatCatalog.php';

$catalog_model = new SatCatalog();

try {
    $catalogs = [
        'cfdi_uses' => $catalog_model->getAll('sat_cfdi_uses'),
        'payment_methods' => $catalog_model->getAll('sat_payment_methods'),
        'payment_forms' => $catalog_model->getAll('sat_payment_forms'),
        'units' => $catalog_model->getAll('sat_units')
    ];

    echo json_encode(['status' => 'success', 'data' => $catalogs]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to load SAT catalogs from database.']);
    error_log('SAT Catalogs API Error: ' . $e->getMessage());
}
?>
