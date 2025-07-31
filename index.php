<?php
// Include configuration
require_once 'src/config/config.php';

// Include header
require_once 'templates/header.php';

// Simple router
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $file = 'templates/' . $page . '.php';
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Show a 404 page or a default page
        echo '<h4>Página no encontrada</h4>';
    }
} else {
    // Default page
    echo '<h4>Bienvenido al Sistema de Facturación</h4>';
}

// Include footer
require_once 'templates/footer.php';
?>
