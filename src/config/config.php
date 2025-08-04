<?php

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'facturacion_db');

// SAT Catalogs have been migrated to the database.
// They are now fetched via the SatCatalog model and api/sat_catalogs.php.
// The `seed_sat_catalogs.php` script should be run once during setup to populate them.

// Set timezone
date_default_timezone_set('America/Mexico_City');

// Error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
