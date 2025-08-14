<?php

function seed_sat_units(PDO $pdo) {
    $units = [
        ['key' => 'H87', 'value' => 'Pieza'],
        ['key' => 'EA', 'value' => 'Elemento'],
        ['key' => 'E48', 'value' => 'Unidad de servicio'],
        ['key' => 'ACT', 'value' => 'Actividad'],
        ['key' => 'KGM', 'value' => 'Kilogramo'],
        ['key' => 'E51', 'value' => 'Trabajo'],
        ['key' => 'A9', 'value' => 'Tarifa'],
        ['key' => 'MTR', 'value' => 'Metro'],
        ['key' => 'KT', 'value' => 'Kit'],
        ['key' => 'SET', 'value' => 'Conjunto'],
        ['key' => 'LTR', 'value' => 'Litro'],
        ['key' => 'XBX', 'value' => 'Caja'],
        ['key' => 'MON', 'value' => 'Mes'],
        ['key' => 'HUR', 'value' => 'Hora'],
        ['key' => 'MTK', 'value' => 'Metro cuadrado'],
        ['key' => 'MGM', 'value' => 'Miligramo'],
        ['key' => 'XPK', 'value' => 'Paquete'],
        ['key' => 'AS', 'value' => 'Variedad'],
        ['key' => 'GRM', 'value' => 'Gramo'],
        ['key' => 'PR', 'value' => 'Par'],
        ['key' => 'DAY', 'value' => 'Día'],
        ['key' => 'MLT', 'value' => 'Mililitro']
    ];

    $stmt = $pdo->prepare("INSERT INTO sat_units (`key`, `value`) VALUES (:key, :value) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");

    echo "Seeding SAT Units...\n";
    $count = 0;
    foreach ($units as $unit) {
        $stmt->execute($unit);
        $count++;
    }
    echo "Seeded {$count} SAT units.\n";
    echo "NOTE: This is a partial list of common units. The full catalog can be found in the official SAT documentation (catCFDI).\n";
}
