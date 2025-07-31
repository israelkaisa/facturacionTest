<?php
header("Content-Type: application/json");

require_once '../src/config/config.php';

$catalogs = [
    'cfdi_uses' => SAT_USO_CFDI,
    'payment_methods' => SAT_METODO_PAGO
];

echo json_encode(['status' => 'success', 'data' => $catalogs]);
?>
