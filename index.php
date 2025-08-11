<?php
session_start();

// Include configuration
require_once 'src/config/config.php';

$page = $_GET['page'] ?? 'invoices'; // Default page is now invoices
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Handle logout action
if ($page === 'logout') {
    session_unset();
    session_destroy();
    header('Location: index.php?page=login');
    exit();
}

// If user is not logged in, they can only access the login page
if (!$is_logged_in && $page !== 'login') {
    header('Location: index.php?page=login');
    exit();
}

// If user is logged in, they cannot access the login page
if ($is_logged_in && $page === 'login') {
    header('Location: index.php?page=invoices');
    exit();
}


// Load templates
if ($page === 'login') {
    // The login page has its own self-contained template
    require_once 'templates/login.php';
} else {
    // All other pages use the standard header/footer
    require_once 'templates/header.php';

    // Special cases for specific views
    if ($page === 'document_view' && isset($_GET['id'])) {
        $file = 'templates/document_view.php';
    } elseif ($page === 'sat_catalog_view' && isset($_GET['name'])) {
        $file = 'templates/sat_catalog_view.php';
    } else {
        $file = 'templates/' . $page . '.php';
    }

    if (file_exists($file)) {
        require_once $file;
    } else {
        // A better 404 page for logged-in users
        echo '<h4>Página no encontrada</h4><p>La página que buscas no existe o ha sido movida.</p>';
    }

    require_once 'templates/footer.php';
}
?>
