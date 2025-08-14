<?php
// A self-contained CLI script to seed the SAT catalog tables.
// Execute from the command line: php seed.php

require_once 'src/config/config.php';
require_once 'src/lib/Database.php';
require_once 'seed_sat_units.php';
require_once 'seed_postal_codes.php'; // Include the new postal code seeder

// --- Data Definitions ---
const SAT_USO_CFDI_DATA = [
    'G01' => 'Adquisición de mercancías', 'G02' => 'Devoluciones, descuentos o bonificaciones', 'G03' => 'Gastos en general',
    'I01' => 'Construcciones', 'I02' => 'Mobiliario y equipo de oficina por inversiones', 'I03' => 'Equipo de transporte',
    'I04' => 'Equipo de computo y accesorios', 'I05' => 'Dados, troqueles, moldes, matrices y herramental', 'I06' => 'Comunicaciones telefónicas',
    'I07' => 'Comunicaciones satelitales', 'I08' => 'Otra maquinaria y equipo', 'D01' => 'Honorarios médicos, dentales y gastos hospitalarios.',
    'D02' => 'Gastos médicos por incapacidad o discapacidad', 'D03' => 'Gastos funerales.', 'D04' => 'Donativos.',
    'D05' => 'Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).', 'D06' => 'Aportaciones voluntarias al SAR.',
    'D07' => 'Primas por seguros de gastos médicos.', 'D08' => 'Gastos de transportación escolar obligatoria.',
    'D09' => 'Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.', 'D10' => 'Pagos por servicios educativos (colegiaturas).',
    'P01' => 'Por definir'
];

const SAT_METODO_PAGO_DATA = [
    'PUE' => 'Pago en una sola exhibición',
    'PPD' => 'Pago en parcialidades o diferido'
];

const SAT_FORMA_PAGO_DATA = [
    '01' => 'Efectivo', '02' => 'Cheque nominativo', '03' => 'Transferencia electrónica de fondos', '04' => 'Tarjeta de crédito',
    '05' => 'Monedero electrónico', '06' => 'Dinero electrónico', '08' => 'Vales de despensa', '12' => 'Dación en pago',
    '13' => 'Pago por subrogación', '14' => 'Pago por consignación', '15' => 'Condonación', '17' => 'Compensación',
    '23' => 'Novación', '24' => 'Confusión', '25' => 'Remisión de deuda', '26' => 'Prescripción o caducidad',
    '27' => 'A satisfacción del acreedor', '28' => 'Tarjeta de débito', '29' => 'Tarjeta de servicios',
    '30' => 'Aplicación de anticipos', '31' => 'Intermediario pagos', '99' => 'Por definir'
];

echo "Iniciando siembra de catálogos del SAT...\n";

try {
    $db = new Database();

    $catalogs = [
        'sat_cfdi_uses' => SAT_USO_CFDI_DATA,
        'sat_payment_methods' => SAT_METODO_PAGO_DATA,
        'sat_payment_forms' => SAT_FORMA_PAGO_DATA
    ];

    foreach ($catalogs as $tableName => $data) {
        echo "Sembrando '$tableName'...\n";
        // Use "INSERT IGNORE" to avoid errors if the key already exists.
        $stmt = $db->getDbh()->prepare("INSERT IGNORE INTO $tableName (`key`, `value`) VALUES (:key, :value)");
        foreach ($data as $key => $value) {
            $stmt->execute(['key' => $key, 'value' => $value]);
        }
        echo "OK.\n";
    }

    // Seed the new SAT units table
    seed_sat_units($db->getDbh());

    echo "\n¡Siembra de catálogos del SAT completada con éxito!\n";

    // Seed the postal codes table
    seed_postal_codes($db->getDbh());

    // --- Create Admin User ---
    echo "\nIntentando crear usuario administrador...\n";
    require_once 'src/models/User.php';
    $user_model = new User();
    $username = 'admin';
    if ($user_model->findByUsername($username)) {
        echo "El usuario '$username' ya existe. No se ha realizado ninguna acción.\n";
    } else {
        $data = ['username' => $username, 'password' => 'admin'];
        if ($user_model->register($data)) {
            echo "¡Éxito! Se ha creado el usuario administrador (usuario: admin, contraseña: admin).\n";
        } else {
            echo "Error: No se pudo crear el usuario administrador.\n";
        }
    }

} catch (Exception $e) {
    echo "\nOcurrió un error crítico durante la siembra: " . $e->getMessage() . "\n";
}
?>
