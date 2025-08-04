<?php
// A simple CLI script to seed the SAT catalog tables from the config file.
// Execute from the command line: php seed_sat_catalogs.php

require_once 'src/config/config.php';
require_once 'src/lib/Database.php';

echo "Iniciando siembra de catálogos del SAT...\n";

try {
    $db = new Database();

    // --- Seed CFDI Uses ---
    echo "Sembrando 'sat_cfdi_uses'...\n";
    $stmt = $db->dbh->prepare("INSERT INTO sat_cfdi_uses (`key`, `value`) VALUES (:key, :value) ON DUPLICATE KEY UPDATE `value` = :value");
    foreach (SAT_USO_CFDI as $key => $value) {
        $stmt->execute(['key' => $key, 'value' => $value]);
    }
    echo "OK.\n";

    // --- Seed Payment Methods ---
    echo "Sembrando 'sat_payment_methods'...\n";
    $stmt = $db->dbh->prepare("INSERT INTO sat_payment_methods (`key`, `value`) VALUES (:key, :value) ON DUPLICate KEY UPDATE `value` = :value");
    foreach (SAT_METODO_PAGO as $key => $value) {
        $stmt->execute(['key' => $key, 'value' => $value]);
    }
    echo "OK.\n";

    // --- Seed Payment Forms ---
    echo "Sembrando 'sat_payment_forms'...\n";
    $stmt = $db->dbh->prepare("INSERT INTO sat_payment_forms (`key`, `value`) VALUES (:key, :value) ON DUPLICATE KEY UPDATE `value` = :value");
    foreach (SAT_FORMA_PAGO as $key => $value) {
        $stmt->execute(['key' => $key, 'value' => $value]);
    }
    echo "OK.\n";

    echo "\n¡Siembra de catálogos completada con éxito!\n";

} catch (Exception $e) {
    echo "\nOcurrió un error crítico durante la siembra: " . $e->getMessage() . "\n";
}
?>
