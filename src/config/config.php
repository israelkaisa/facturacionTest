<?php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'facturacion_db');

// SAT Catalogs - Placeholders for now
// These could be loaded from the database or files later
define('SAT_USO_CFDI', [
    'G01' => 'Adquisición de mercancías',
    'G02' => 'Devoluciones, descuentos o bonificaciones',
    'G03' => 'Gastos en general',
    'I01' => 'Construcciones',
    'I02' => 'Mobiliario y equipo de oficina por inversiones',
    'I03' => 'Equipo de transporte',
    'I04' => 'Equipo de computo y accesorios',
    'I05' => 'Dados, troqueles, moldes, matrices y herramental',
    'I06' => 'Comunicaciones telefónicas',
    'I07' => 'Comunicaciones satelitales',
    'I08' => 'Otra maquinaria y equipo',
    'D01' => 'Honorarios médicos, dentales y gastos hospitalarios.',
    'D02' => 'Gastos médicos por incapacidad o discapacidad',
    'D03' => 'Gastos funerales.',
    'D04' => 'Donativos.',
    'D05' => 'Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).',
    'D06' => 'Aportaciones voluntarias al SAR.',
    'D07' => 'Primas por seguros de gastos médicos.',
    'D08' => 'Gastos de transportación escolar obligatoria.',
    'D09' => 'Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.',
    'D10' => 'Pagos por servicios educativos (colegiaturas).',
    'P01' => 'Por definir'
]);

define('SAT_METODO_PAGO', [
    'PUE' => 'Pago en una sola exhibición',
    'PPD' => 'Pago en parcialidades o diferido'
]);

define('SAT_FORMA_PAGO', [
    '01' => 'Efectivo',
    '02' => 'Cheque nominativo',
    '03' => 'Transferencia electrónica de fondos',
    '04' => 'Tarjeta de crédito',
    '05' => 'Monedero electrónico',
    '06' => 'Dinero electrónico',
    '08' => 'Vales de despensa',
    '12' => 'Dación en pago',
    '13' => 'Pago por subrogación',
    '14' => 'Pago por consignación',
    '15' => 'Condonación',
    '17' => 'Compensación',
    '23' => 'Novación',
    '24' => 'Confusión',
    '25' => 'Remisión de deuda',
    '26' => 'Prescripción o caducidad',
    '27' => 'A satisfacción del acreedor',
    '28' => 'Tarjeta de débito',
    '29' => 'Tarjeta de servicios',
    '30' => 'Aplicación de anticipos',
    '31' => 'Intermediario pagos',
    '99' => 'Por definir'
]);

// Set timezone
date_default_timezone_set('America/Mexico_City');

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
